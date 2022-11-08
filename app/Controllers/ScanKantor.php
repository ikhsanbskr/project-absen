<?php

namespace App\Controllers;

use \App\Models\ModelAbsensi;

class ScanKantor extends BaseController
{
    public function __construct()
    {
        $this->modelAbsensi = new ModelAbsensi();
    }

    public function index()
    {
        $data = [
            'title' => 'Scan Kantor',
            'lastinput' => $this->modelAbsensi->getLast(),
            'segment' => $this->request->uri->getSegment(1),
        ];

        return view('/scan/scankantor', $data);
    }

    public function checkIn()
    {
        $lastcheckout = $this->request->getVar('lastcheckout');
        $lokasikantor = $this->request->getVar('lokasiKantor');
        $hasilqr = $this->request->getVar('hasilqr');

        $qrkantor = 'WRySgPJBg6l2mwePh9+3faRN2949vxEzHQU4dp7gORY=';

        if ($this->modelAbsensi->countStaffToday() >= 1) {
            session()->setFlashdata('peringatan', 'Anda sudah melakukan absen hari ini, harap absen kembali pada besok hari.');
            return redirect()->to('/');
        } elseif ($lokasikantor == '') {
            session()->setFlashdata('peringatan', 'Lokasi tidak ditemukan.');
            return redirect()->to('/');
        }

        if ($hasilqr != $qrkantor) {
            session()->setFlashdata('peringatan', 'Anda hanya dapat check in menggunakan QR yang telah disediakan.');
            return redirect()->to('/');
        }

        if ($lokasikantor == 'Kantor Arcade 1' || $lokasikantor == 'Kantor Century 21 Prima' && $hasilqr == $qrkantor) {
            $this->modelAbsensi->insert([
                'tanggal' => date('Y-m-d'),
                'checkin' => date('H:i:s'),
                'checkout' => '00:00:00',
                'userid' => user()->id,
                'lokasi' => $lokasikantor,
                'status' => $this->request->getVar('status'),
                'keterangan' => '-'
            ]);

            session()->setFlashdata('pesan', 'Checkin berhasil dilakukan.');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('peringatan', 'Lokasi anda bukan dikantor.');
            return redirect()->to('/');
        }
    }

    public function checkOut($lastinput)
    {
        $absen = $this->modelAbsensi->selectLast($lastinput);
        $hasilqr = $this->request->getVar('hasilqr');
        $qrkantor = 'WRySgPJBg6l2mwePh9+3faRN2949vxEzHQU4dp7gORY=';
        $checkout = $this->modelAbsensi->getLast();

        $data = [
            'checkout' => date('H:i:s')
        ];

        if ($lastinput == '0') {
            session()->setFlashdata('peringatan', 'Anda belum melakukan check in, harap check out terlebih dahulu untuk melakukan check in kembali.');
            return redirect()->to('/');
        }

        if ($absen->checkout == '00:00:00' && $hasilqr == $qrkantor) {
            $this->modelAbsensi->update($lastinput, $data);
            session()->setFlashdata('pesan', 'Checkout berhasil dilakukan.');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('peringatan', 'Anda sudah melakukan check out, harap check in terlebih dahulu untuk melakukan check out.');
            return redirect()->to('/');
        }
    }

    // public function getFoto()
    // {
    //     $img = $this->request->getVar('photo');
    //     list($type, $data) = explode(';', $img);
    //     list(, $data)      = explode(',', $data);
    //     $data = base64_decode($data);
    //     file_put_contents(FCPATH . '/uploads/scanfoto/IMG-' . time() . '.jpg', $data);
    // }
}
