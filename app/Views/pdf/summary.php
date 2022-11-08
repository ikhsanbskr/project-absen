<head>
  <title>Sumarry Kehadiran Semua Karyawan</title>
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
  <h2>SUMARRY KEHADIRAN <?= $nama == '' ? 'SEMUA KARYAWAN' : strtoupper($nama) ?></h2>
  <h2><?= strtoupper(format_id(date('Y-m-d', strtotime($min)))); ?> - <?= strtoupper(format_id(date('Y-m-d', strtotime($max)))); ?></h2>
  <hr>
</div>

<table>
  <thead>
    <th>No</th>
    <th>Nama Karyawan</th>
    <th>Jumlah Hadir</th>
    <th>Jumlah Terlambat</th>
    <th>Jumlah Izin</th>
    <th>Tanpa Keterangan</th>
  </thead>
  <tbody>
    <?php $no = 1 ?>
    <?php foreach ($karyawan as $row) : ?>
      <?php $userid = $row->usersid; ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
        <td><?= $sumarry->countSumarryAll($min, $max, $userid) ?> Hari</td>
        <td><?= $sumarry->countLateAll($min, $max, $userid) ?> Hari</td>
        <td><?= $sumarry->countPermitAll($min, $max, $userid) ?> Hari</td>
        <td><?= $sumarry->countNullAll($min, $max, $userid) ?> Hari</td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>