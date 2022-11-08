<head>
  <title>Laporan Kehadiran Semua Marketing</title>
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
  <h2>LAPORAN KEHADIRAN SEMUA MARKETING</h2>
  <h2><?= strtoupper(format_id(date('Y-m-d'))) ?></h2>
  <hr>
</div>

<table>
  <thead>
    <th>No</th>
    <th>Nama Karyawan</th>
    <th>Jabatan</th>
    <th style="width: 100px;">Tanggal</th>
    <th>Jam Hadir</th>
    <th>Jam Pulang</th>
    <th>Lokasi</th>
    <th>Status</th>
    <th>Keterangan</th>
  </thead>
  <tbody>
    <?php $no = 1 ?>
    <?php if ($absen == NULL) : ?>
      <tr>
        <td colspan="9">Tidak ada data yang tersedia.</td>
      </tr>
    <?php endif ?>
    <?php foreach ($absen as $row) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
        <td><?= $row->jabatan ?></td>
        <td><?= $row->tanggal ?></td>
        <td><?= $row->checkin ?></td>
        <td><?= $row->checkout ?></td>
        <td><?= $row->lokasi ?></td>
        <td><?= $row->absenstatus ?></td>
        <td><?= $row->keterangan ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>