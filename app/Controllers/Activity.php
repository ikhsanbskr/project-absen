<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelActivity;
use App\Models\ModelAbsensi;
use Dompdf\Dompdf;

class Activity extends BaseController
{
  public function __construct()
  {
    $this->modelActivity = new ModelActivity();
    $this->modelAbsensi = new ModelAbsensi();
    $this->modelUser = new \Myth\Auth\Models\UserModel();
  }

  public function index()
  {
    $tanggal = date('Y-m-d');
    $userid = user()->id;

    $data = [
      'title' => 'Daily Input Activity',
      'segment' => $this->request->uri->getSegment(1),
      'tanggal' => $tanggal,
      'activity' => $this->modelActivity->getActivity($tanggal, $userid)
    ];

    return view('/activity/input', $data);
  }

  public function tambahActivity()
  {
    $tanggal = $this->request->getVar('tanggal');
    $userid = user()->id;
    $countActivity = $this->modelActivity->countActivityToday($userid, $tanggal);

    if (!$this->validate([
      'activity' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Aktifitas tidak boleh kosong.'
        ]
      ]
    ])) {
      return redirect()->to('/activity/')->withInput();
    }

    if ($countActivity >= 1) {
      session()->setFlashdata('peringatan', 'Anda sudah menambahkan baris aktifitas hari ini.');
      return redirect()->to('/activity');
    }

    $data = [
      'tanggal_activity' => $tanggal,
      'aktifitas' => $this->request->getVar('activity'),
      'last_update' => date('Y-m-d H:i:s'),
      'userid' => user()->id
    ];
    $this->modelActivity->insert($data);

    session()->setFlashdata('pesan', 'Aktifitas berhasil ditambahkan.');
    return redirect()->to('/activity');
  }

  public function editActivity($id)
  {
    if (!$this->validate([
      'activity_edit' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Aktifitas tidak boleh kosong.'
        ]
      ]
    ])) {
      return redirect()->to('/activity')->withInput();
    }

    $data = [
      'aktifitas' => $this->request->getVar('activity_edit'),
      'last_update' => date('Y-m-d H:i:s')
    ];
    $this->modelActivity->update($id, $data);

    session()->setFlashdata('pesan', 'Aktifitas berhasil diedit.');
    return redirect()->to('/activity');
  }

  public function filterActivity()
  {
    $tanggal = $this->request->getVar('select-tanggal');
    if ($tanggal == NULL) {
      return redirect()->to('/activity');
    }

    $userid = user()->id;
    $data = [
      'title' => 'Daily Input Activity',
      'segment' => $this->request->uri->getSegment(1),
      'tanggal' => $tanggal,
      'activity' => $this->modelActivity->getActivity($tanggal, $userid)
    ];

    return view('/activity/input_filter', $data);
  }

  public function tambahActivityFilter()
  {
    $tanggal = $this->request->getVar('tanggal');
    $userid = user()->id;
    $countActivity = $this->modelActivity->countActivityToday($userid, $tanggal);

    if (!$this->validate([
      'activity' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Aktifitas tidak boleh kosong.'
        ]
      ]
    ])) {
      return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '')->withInput();
    }

    if ($countActivity >= 1) {
      session()->setFlashdata('peringatan', 'Anda sudah menambahkan baris aktifitas pada tanggal ini.');
      return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '')->withInput();
    } elseif ($tanggal > date('Y-m-d')) {
      session()->setFlashdata('peringatan', 'Anda tidak dapat menambahkan activity untuk hari kedepan.');
      return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '')->withInput();
    }

    $data = [
      'tanggal_activity' => $tanggal,
      'aktifitas' => $this->request->getVar('activity'),
      'last_update' => date('Y-m-d H:i:s'),
      'userid' => user()->id
    ];
    $this->modelActivity->insert($data);

    session()->setFlashdata('pesan', 'Aktifitas berhasil ditambahkan.');
    return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '');
  }

  public function editActivityFilter($id)
  {
    $tanggal = $this->request->getVar('tanggal');

    if (!$this->validate([
      'activity_edit' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Aktifitas tidak boleh kosong.'
        ]
      ]
    ])) {
      return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '')->withInput();
    }

    $data = [
      'aktifitas' => $this->request->getVar('activity_edit'),
      'last_update' => date('Y-m-d H:i:s')
    ];
    $this->modelActivity->update($id, $data);

    session()->setFlashdata('pesan', 'Aktifitas berhasil diedit.');
    return redirect()->to('/activity/filter?select-tanggal=' . $tanggal . '');
  }

  public function laporanActivity()
  {
    $tanggal = date('Y-m-d');
    $data = [
      'title' => 'Daily Report Activity',
      'segment' => $this->request->uri->getSegment(1),
      'laporan' => $this->modelActivity->getReport($tanggal),
    ];

    return view('/activity/laporan', $data);
  }

  public function exportLaporanToday()
  {
    $dompdf = new Dompdf();
    $tanggal = date('Y-m-d');
    $data = [
      'title' => 'Laporan Daily Activity',
      'laporan' => $this->modelActivity->getReport($tanggal),
    ];

    $html = view('/pdf/laporan_daily_activity', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('Laporan Daily Activity.pdf', array('Attachment' => false));
    exit;
  }

  public function laporanActivityFilter()
  {
    $tanggal = $this->request->getVar('select-tanggal');

    $data = [
      'title' => 'Daily Input Activity',
      'segment' => $this->request->uri->getSegment(1),
      'tanggal' => $tanggal,
      'laporan' => $this->modelActivity->getReport($tanggal)
    ];

    return view('/activity/laporan_filter.php', $data);
  }

  public function exportLaporanFilter()
  {
    $dompdf = new Dompdf();
    $tanggal = $this->request->getVar('tanggal');
    $data = [
      'title' => 'Laporan Daily Activity',
      'tanggal' => $tanggal,
      'laporan' => $this->modelActivity->getReport($tanggal),
    ];

    $html = view('/pdf/laporan_activity_filter', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('Laporan Daily Activity.pdf', array('Attachment' => false));
    exit;
  }
}
