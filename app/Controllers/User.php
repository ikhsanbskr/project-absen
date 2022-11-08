<?php

namespace App\Controllers;

use \App\Models\ModelAbsensi;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    public function __construct()
    {
        $this->modelAbsensi = new ModelAbsensi();
        $this->modelUser = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profile',
            'segment' => $this->request->uri->getSegment(1)
        ];

        return view('user/profile', $data);
    }

    public function saveFoto()
    {
        $data = [
            'id' => user()->id,
            'foto_profile' => user()->nama . '.png'
        ];

        $this->modelUser->save($data);

        $data = $this->request->getVar('cropfoto');;
        $image_array_1 = explode(';', $data);
        $image_array_2 = explode(',', $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);

        file_put_contents(FCPATH . '/uploads/foto-profile/' . user()->nama . '.png', $data);

        session()->setFlashdata('pesan', 'Foto berhasil diganti');
        return redirect()->to('/profile');
        exit;


        // $foto = $this->request->getVar('cropfoto');
        // list($type, $data) = explode(';', $foto);
        // list(, $data) = explode(',', $data);

        // $data = base64_decode($data);
        // file_put_contents(FCPATH . '/uploads/foto-profile/' . user()->nama . '.png', $data);

        // session()->setFlashdata('pesan', 'Foto berhasil diganti');
        // return redirect()->to('/profile');
    }

    public function editProfile()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username tidak boleh kosong.',
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => 'Nama lengkap tidak boleh kosong.',
                    'alpha_numeric_punct' => 'Nama tidak boleh mengandung simbol.'
                ]
            ]
        ])) {
            return redirect()->to('/profile')->withInput();
        }

        $data = [
            'id' => user()->id,
            'username' => $this->request->getVar('username'),
            'nama' => $this->request->getVar('nama'),
            'nik' => $this->request->getVar('nik'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir')
        ];
        $this->modelUser->save($data);

        session()->setFlashdata('pesan', 'Profile berhasil diedit.');
        return redirect()->to('/profile');
    }

    // History Absen
    public function historyAbsen()
    {
        $data = [
            'title' => 'Data Absensi Karyawan',
            'segment' => $this->request->uri->getSegment(1)
        ];

        return view('/user/history', $data);
    }

    public function filterAbsen()
    {
        $min = $this->request->getVar('min-tanggal');
        $max = $this->request->getVar('max-tanggal');
        $nama = $this->request->getVar('nama-karyawan');

        $data = [
            'title' => 'Data Absensi',
            'segment' => $this->request->uri->getSegment(1),
            'min' => $min,
            'max' => $max,
            'nama' => $nama,
            'absenstaff' => $this->modelAbsensi->getDateStaff($min, $max, $nama),
            'absenma' => $this->modelAbsensi->getDateMarketing($min, $max, $nama),
            'karyawan' => $this->modelUser->findAll()
        ];

        return view('/user/history_filter', $data);
    }
}
