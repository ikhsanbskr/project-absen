<?php

namespace App\Controllers;

use \App\Models\ModelAbsensi;
use \App\Helpers\custom_helper;
use App\Models\ModelKonfirmasi;

class Dashboard extends BaseController
{
    protected $helpers = ['custom'];

    public function __construct()
    {
        $this->userModel = new \Myth\Auth\Models\UserModel();
        $this->modelAbsensi = new ModelAbsensi();
        $this->modelKonfirmasi = new ModelKonfirmasi();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Absensi',
            'segment' => $this->request->uri->getSegment(1),
            'staff' => $this->modelAbsensi->getStaffToday(),
            'getstaff' => $this->userModel->getStaff(),
            'marketing' => $this->modelAbsensi->getMarketingToday(),
            'lastinput' => $this->modelAbsensi->getLast(),
            'konfirmasi' => $this->modelKonfirmasi->getAll(),
            'karyawan' => $this->userModel->getStaffMA(),
            'kehadiran' => $this->modelAbsensi->getPresenceToday(),
            'terlambat' => $this->modelAbsensi->getLateToday(),
            'izin' => $this->modelAbsensi->getPermitToday(),
            'totalabsen' => $this->modelAbsensi->countAllStaffToday(),
            'totaltelat' => $this->modelAbsensi->countLateToday(),
            'totalizin' => $this->modelAbsensi->countPermitToday(),
            'totalstaffma' => $this->userModel->countStaffMA(),
            'statistik1' => $this->modelAbsensi->countStatistic('' . date('Y') . '-01-01', '' . date('Y') . '-01-31'),
            'statistik2' => $this->modelAbsensi->countStatistic('' . date('Y') . '-02-01', '' . date('Y') . '-02-31'),
            'statistik3' => $this->modelAbsensi->countStatistic('' . date('Y') . '-03-01', '' . date('Y') . '-03-31'),
            'statistik4' => $this->modelAbsensi->countStatistic('' . date('Y') . '-04-01', '' . date('Y') . '-04-31'),
            'statistik5' => $this->modelAbsensi->countStatistic('' . date('Y') . '-05-01', '' . date('Y') . '-05-31'),
            'statistik6' => $this->modelAbsensi->countStatistic('' . date('Y') . '-06-01', '' . date('Y') . '-06-31'),
            'statistik7' => $this->modelAbsensi->countStatistic('' . date('Y') . '-07-01', '' . date('Y') . '-07-31'),
            'statistik8' => $this->modelAbsensi->countStatistic('' . date('Y') . '-08-01', '' . date('Y') . '-08-31'),
            'statistik9' => $this->modelAbsensi->countStatistic('' . date('Y') . '-09-01', '' . date('Y') . '-09-31'),
            'statistik10' => $this->modelAbsensi->countStatistic('' . date('Y') . '-10-01', '' . date('Y') . '-10-31'),
            'statistik11' => $this->modelAbsensi->countStatistic('' . date('Y') . '-11-01', '' . date('Y') . '-11-31'),
            'statistik12' => $this->modelAbsensi->countStatistic('' . date('Y') . '-12-01', '' . date('Y') . '-12-31'),
        ];

        return view('dashboard', $data);
    }

    public function checkin()
    {
        if (!$this->validate([
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi tidak ditemukan.'
                ]
            ]
        ])) {
            return redirect()->to('/')->withInput();
        }

        $lastcheckout = $this->request->getVar('lastcheckout');
        $lokasi = $this->request->getVar('lokasi');

        if ($this->request->getVar('keterangan') == '') {
            $keterangan = '-';
        } else {
            $keterangan = $this->request->getVar('keterangan');
        }

        if ($this->modelAbsensi->countStaffToday() >= 1) {
            session()->setFlashdata('peringatan', 'Anda sudah melakukan absen hari ini, harap absen kembali pada besok hari.');
            return redirect()->to('/');
        } elseif ($lastcheckout == '00:00:00' && user()->jabatan == 'Marketing') {
            session()->setFlashdata('peringatan', 'Anda belum melakukan check out, harap check out terlebih dahulu untuk melakukan check in kembali.');
            return redirect()->to('/');
        }

        if ($lokasi == 'Kantor Arcade 1' && user()->jabatan != 'Marketing') {
            session()->setFlashdata('peringatan', 'Lokasi anda sedang dikantor Prima Arcade 1, harap absen menggunakan fitur scan yang telah disediakan.');
            return redirect()->to('/');
        } else if ($lokasi == 'Kantor Century 21 Prima' && user()->jabatan != 'Marketing') {
            session()->setFlashdata('peringatan', 'Lokasi Anda sedang dikantor Prima, harap absen menggunakan fitur scan yang telah disediakan.');
            return redirect()->to('/');
        } else {
            $this->modelAbsensi->insert([
                'tanggal' => date('Y-m-d'),
                'checkin' => date('H:i:s'),
                'checkout' => '00:00:00',
                'userid' => user()->id,
                'lokasi' => $this->request->getPost('lokasi'),
                'status' => $this->request->getPost('status'),
                'keterangan' => $keterangan
            ]);

            session()->setFlashdata('pesan', 'Check In berhasil dilakukan.');
            return redirect()->to('/');
        }
    }

    // public function alpha()
    // {
    //     if (ModelAbsensi->userid ==  )
    // }

    public function checkout($lastinput)
    {
        if (!$this->validate([
            'lokasi' => [
                'rules' => ['required'],
                'errors' => [
                    'required' => 'Lokasi tidak ditemukan.'
                ]
            ]
        ])) {
            return redirect()->to('/')->withInput();
        }

        $absen = $this->modelAbsensi->selectLast($lastinput);
        $lokasi = $this->request->getVar('lokasi');

        if ($lastinput == '0') {
            session()->setFlashdata('peringatan', 'Harap check in terlebih dahulu untuk melakukan check out.');
            return redirect()->to('/');
        }

        if ($lokasi == 'Kantor Arcade 1' && user()->jabatan != 'Marketing') {
            session()->setFlashdata('peringatan', 'Lokasi anda sedang dikantor Prima Arcade 1, harap check out menggunakan fitur scan yang telah disediakan.');
            return redirect()->to('/');
        } else if ($lokasi == 'Kantor Century 21 Prima' && user()->jabatan != 'Marketing') {
            session()->setFlashdata('peringatan', 'Lokasi anda sedang dikantor Prima, harap check out menggunakan fitur scan yang telah disediakan.');
            return redirect()->to('/');
        }


        if ($absen->keterangan == '-') {
            $keterangan = 'Lokasi checkout di ' . $lokasi . '';
        } else {
            $keterangan = $absen->keterangan . ' - Lokasi check out di ' . $lokasi . '';
        }

        $data = [
            'checkout' => date('H:i:s'),
            'keterangan' => $keterangan
        ];

        if ($absen->checkout == '00:00:00') {
            $this->modelAbsensi->update($lastinput, $data);
            session()->setFlashdata('pesan', 'Checkout berhasil dilakukan.');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('peringatan', 'Anda sudah melakukan check out, harap check in terlebih dahulu untuk melakukan check out kembali.');
            return redirect()->to('/');
        }
    }

    public function staffTanpaKeterangan()
    {
        $staff = $this->userModel->getStaff();

        foreach ($staff as $row) {
            $usersid = $row->usersid;
            $count = $this->modelAbsensi->countStaffNull($usersid);

            if ($count < 1) {
                echo $row->nama;
                // $this->modelAbsensi->insert([
                //     'tanggal' => date('Y-m-d'),
                //     'checkin' => NULL,
                //     'checkout' => NULL,
                //     'userid' => $row->usersid,
                //     'lokasi' => '-',
                //     'status' => 'Kosong',
                //     'keterangan' => '-'
                // ]);
                // // $this->modelKonfirmasi->insert([
                // //     'tanggal' => date('Y-m-d'),
                // //     'userid' => $row->usersid
                // // ]);
            }

            // $this->modelAbsensi->insert([
            //     'tanggal' => date('Y-m-d'),
            //     'checkin' => NULL,
            //     'checkout' => NULL,
            //     'userid' => $row->usersid,
            //     'lokasi' => '-',
            //     'status' => '-',
            //     'keterangan' => '-'
            // ]);
        }
    }

    public function marketingTanpaKeterangan()
    {
        $marketing = $this->userModel->getMarketing();

        foreach ($marketing as $row) {
            $usersid = $row->usersid;
            $count = $this->modelAbsensi->countStaffNull($usersid);

            if ($count < 1) {
                $this->modelAbsensi->insert([
                    'tanggal' => date('Y-m-d'),
                    'checkin' => NULL,
                    'checkout' => NULL,
                    'userid' => $row->usersid,
                    'lokasi' => '-',
                    'status' => 'Kosong',
                    'keterangan' => '-'
                ]);
            }
        }
    }

    public function izin()
    {
        if (!$this->validate([
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi tidak ditemukan.'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan izin harap diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/')->withInput();
        }

        if ($this->modelAbsensi->countStaffToday() >= 1) {
            session()->setFlashdata('peringatan', 'Anda sudah melakukan izin hari ini, harap melakukan check in kembali pada besok hari.');
            return redirect()->to('/');
        }

        $this->modelAbsensi->insert([
            'userid' => user()->id,
            'tanggal' => date('Y-m-d'),
            'checkin' => NULL,
            'checkout' => NULL,
            'lokasi' => $this->request->getVar('lokasi'),
            'status' => 'Izin',
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        session()->setFlashdata('pesan', 'Izin berhasil dilakukan');
        return redirect()->to('/');
    }

    public function konfirmasi($userid)
    {
        if (!$this->validate([
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status kehadiran tidak boleh kosong.'
                ]
            ]
        ])) {
            return redirect()->to('/')->withInput();
        }

        if ($this->request->getVar('keterangan') == '') {
            $keterangan = '-';
        } else {
            $keterangan = $this->request->getVar('keterangan');
        }

        $this->modelAbsensi->insert([
            'userid' => $userid,
            'tanggal' => $this->request->getVar('tanggal'),
            'checkin' => NULL,
            'checkout' => NULL,
            'lokasi' => '-',
            'status' => $this->request->getVar('status'),
            'keterangan' => $keterangan
        ]);

        $this->modelKonfirmasi->deleteData($userid);

        session()->setFlashdata('pesan', 'Konfirmasi staff berhasil.');
        return redirect()->to('/');
    }

    public function PakRickoTelat()
    {
        $id = 2;
        $data = [
            'jam_terlambat' => '09:00:00'
        ];

        $this->userModel->update($id, $data);
    }

    public function PakRickoRecovery()
    {
        $id = 2;
        $data = [
            'jam_terlambat' => '08:00:00'
        ];

        $this->userModel->update($id, $data);
    }

    // public function formAbsensi()
    // {
    //     $data = [
    //         'title' => 'Form Absensi'
    //     ];

    //     return view('user/absensi', $data);
    // }
}
