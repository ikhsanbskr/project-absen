<head>
  <title>Laporan Kehadiran Semua Karyawan</title>
</head>

<style>
  table,
  td,
  th {
    border: 1px solid #333;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  td,
  th {
    text-align: center;
  }

  th {
    background-color: #ccc;
  }

  .header {
    text-align: center;
  }
</style>

<div class="header">
  <span>CENTURY 21 PRIMA ARCADE 1</span>
  <hr style="width: 30%;">
  <h2>LAPORAN DAILY ACTIVITY</h2>
  <h2><?= strtoupper(format_id(date('Y-m-d'))) ?></h2>
  <hr>
</div>

<table>
  <thead>
    <th>No</th>
    <th>Nama</th>
    <th>Keterangan</th>
    <th>Check In</th>
    <th>Check Out</th>
    <th>Aktifitas</th>
    <th>Lokasi</th>
    <th>Last Update</th>
  </thead>
  <tbody>
    <?php $no = 1 ?>
    <?php if ($laporan == NULL) : ?>
      <tr>
        <td colspan="9">Tidak ada data yang tersedia.</td>
      </tr>
    <?php endif ?>
    <?php foreach ($laporan as $row) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row->nama ?></td>
        <td><?= $row->keterangan ?></td>
        <td><?= $row->checkin ?></td>
        <td><?= $row->checkout ?></td>
        <td><?= $row->aktifitas ?></td>
        <td style="height: 50px;"><?= $row->lokasi ?></td>
        <td><?= $row->last_update ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>