<?php

namespace App\Controllers;

use \App\Models\ModelAbsensi;
use App\Models\ModelKonfirmasi;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Dompdf\Dompdf;

class Admin extends BaseController
{
    public function __construct()
    {
        // $this->modelKaryawan = new ModelKaryawan();
        $this->config = config('Auth');
        $this->modelUser = new \Myth\Auth\Models\UserModel();
        $this->modelGroup = new GroupModel();
        $this->modelAbsensi = new ModelAbsensi();
        $this->modelKonfimasi = new ModelKonfirmasi();
    }

    public function karyawan()
    {
        $data = [
            'title' => 'Data Karyawan',
            'segment' => $this->request->uri->getSegment(1),
            'karyawan' => $this->modelUser->getAll(),
            // 'validation' => \Config\Services::validation()
        ];

        return view('admin/karyawan', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'segment' => $this->request->uri->getSegment(1)
        ];

        return view('admin/tambah_karyawan', $data);
    }

    public function simpanKaryawan()
    {
        $users = model(UserModel::class);
        $rules = config('Validation')->registrationRules ?? [
            // 'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username dengan nama yang sama sudah terdaftar.'
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_numeric_punct|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => 'Nama Lengkap wajib diisi.',
                    'alpha_numeric_punct' => 'Nama tidak boleh mengandung simbol.',
                    'min_length' => 'Nama tidak boleh kurang dari 3 kata.',
                    'max_length' => 'Nama tidak boleh lebih dari 200 kata.'
                ]
            ],
            'jabatan' => [
                'rules' => 'required|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'alpha_numeric_punct' => 'Jabatan tidak boleh mengandung simbol.',
                    'max_length' => 'Jabatan tidak boleh mengandung lebih dari 100 kata.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                ]
            ],
            'pass_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Ulang Password wajib diisi.',
                    'matches' => ''
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan User
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        $role = $this->request->getVar('role');

        // Menetapkan group karyawan
        if (empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($role);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent      = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            return redirect()->to('/karyawan')->with('message', lang('Auth.activationSuccess'));
        }

        session()->setFlashdata('pesan', 'Karyawan berhasil ditambah.');
        return redirect()->to('/karyawan');
    }

    public function editKaryawan($userId)
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.'
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_numeric_punct|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => 'Kolom nama tidak boleh kosong.',
                    'alpha_numeric_punct' => 'Kolom nama tidak boleh mengandung simbol.',
                    'min_length' => 'Kolom nama tidak boleh kurang dari 3 kata.',
                    'max_length' => 'Kolom nama tidak boleh lebih dari 200 kata.'
                ]
            ],
            'jabatan' => [
                'rules' => 'required|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'required' => 'Kolom jabatan wajib diisi.',
                    'alpha_numeric_punct' => 'Kolom jabatan tidak boleh mengandung simbol.',
                    'max_length' => 'Kolom jabatan tidak boleh mengandung lebih dari 100 kata.'
                ]
            ]
        ])) {
            return redirect()->to('/karyawan')->withInput();
        }


        $groupID = $this->request->getVar('role');
        $data = [
            // 'nik' => $this->request->getVar('nik'),
            'id' => $userId,
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'jam_terlambat' => $this->request->getPost('jam_terlambat')
        ];

        if ($groupID != null) {
            $this->modelGroup->removeUserFromAllGroups($userId);
            $this->modelGroup->addUserToGroup($userId, $groupID);
        }

        $this->modelUser->save($data);

        session()->setFlashdata('pesan', 'Data Berhasil Diedit');
        return redirect()->to('/karyawan');
    }

    public function gantiPassword($id)
    {
        if (!$this->validate([
            'password_baru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong.'
                ]
            ]
        ])) {
            return redirect()->to('/karyawan')->withInput();
        }

        $entity = new User();
        $password_baru = $this->request->getVar('password_baru');

        $entity->setPassword($password_baru);
        $hash = $entity->password_hash;
        $this->modelUser->update($id, ['password_hash' => $hash]);

        session()->setFlashdata('pesan', 'Password Berhasil Diganti');
        return redirect()->to('/karyawan');
    }

    public function deleteKaryawan($id)
    {
        $this->modelUser->hapus($id);

        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('/karyawan');
    }

    public function dataAbsen()
    {
        $data = [
            'title' => 'Data Absen',
            'segment' => $this->request->uri->getSegment(1)
        ];

        return view('admin/kelola_absen', $data);
    }

    public function dataAbsenFilter()
    {
        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $data = [
            'title' => 'Data Absen',
            'min' => $min,
            'max' => $max,
            'segment' => $this->request->uri->getSegment(1),
            'absen' => $this->modelAbsensi->getDate($min, $max)
        ];

        return view('admin/kelola_absen', $data);
    }

    public function editAbsen($id)
    {
        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');

        if (!$this->validate([
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus dipilih.'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong'
                ]
            ]
        ])) {
            return redirect()->to('/kelola-absen/filter?min-tanggal=' . $min . '&max-tanggal=' . $max . '')->withInput();
        }

        $data = [
            'id' => $id,
            'status' => $this->request->getVar('status'),
            'tanggal' => $this->request->getVar('tanggal'),
            'keterangan' => $this->request->getVar('keterangan'),
            'checkin' => $this->request->getVar('checkin'),
            'checkout' => $this->request->getVar('checkout')
        ];
        $this->modelAbsensi->save($data);

        session()->setFlashdata('pesan', 'Absen berhasil diedit.');
        return redirect()->to('/kelola-absen/filter?min-tanggal=' . $min . '&max-tanggal=' . $max . '');
    }

    public function absen()
    {
        $data = [
            'title' => 'Laporan Staff',
            'segment' => $this->request->uri->getSegment(1),
            'absen' => $this->modelAbsensi->getStaffToday(),
            'karyawan' => $this->modelUser->getStaff()
        ];

        return view('/admin/absen', $data);
    }

    public function laporanToday()
    {
        $dompdf = new Dompdf();
        $data = [
            'title' => 'Laporan Staff',
            'absen' => $this->modelAbsensi->getStaffToday()
        ];
        $html = view('/pdf/laporan_sekarang', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function filter()
    {
        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Laporan Staff',
            'segment' => $this->request->uri->getSegment(1),
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'karyawan' => $this->modelUser->getStaff()
        ];

        return view('/admin/absen_filter', $data);
    }

    public function laporan()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'karyawan' => $this->modelUser->getStaff(),
            'sumarry' => $this->modelAbsensi
        ];

        $html = view('/pdf/laporan', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function laporanSemua()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'karyawan' => $this->modelUser->getStaff()
        ];
        $html = view('/pdf/laporan_semua', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function summarypdf()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'karyawan' => $this->modelUser->getStaff(),
            'sumarry' => $this->modelAbsensi
        ];
        $html = view('/pdf/summary', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function absenMarketing()
    {
        $data = [
            'title' => 'Laporan Marketing',
            'segment' => $this->request->uri->getSegment(1),
            'absen' => $this->modelAbsensi->getMarketingToday(),
            'karyawan' => $this->modelUser->getMarketing()
        ];

        return view('/admin/absen_marketing', $data);
    }

    public function laporanMarketingToday()
    {
        $dompdf = new Dompdf();
        $data = [
            'title' => 'Laporan Marketing',
            'absen' => $this->modelAbsensi->getMarketingToday(),
        ];

        $html = view('/pdf/laporan_sekarang_ma', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function filterMarketing()
    {
        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Laporan Marketing',
            'segment' => $this->request->uri->getSegment(1),
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateMarketing($min, $max, $nama),
            'karyawan' => $this->modelUser->getMarketing()
        ];

        return view('/admin/absen_filter_ma', $data);
    }

    public function laporanMA()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateMarketing($min, $max, $nama),
            'karyawan' => $this->modelUser->getMarketing(),
            'sumarry' => $this->modelAbsensi
        ];

        $html = view('/pdf/laporan_ma', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function laporanSemuaMA()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateMarketing($min, $max, $nama)
        ];
        $html = view('/pdf/laporan_semua_ma', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }

    public function sumarrypdfMA()
    {
        $dompdf = new Dompdf();

        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absen' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'karyawan' => $this->modelUser->getMarketing(),
            'sumarry' => $this->modelAbsensi
        ];

        $html = view('/pdf/sumarry_ma', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan.pdf', array(
            'Attachment' => false
        ));
        exit;
    }
}
