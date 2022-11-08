<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <div class="col-sm-12 mt-4">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <span>Pilih Range Laporan</span>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <form action="/absen-marketing/filter" method="POST">
              <?= csrf_field() ?>
              <input type="text" id="min" name="min-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Dari Tanggal" value="<?= $min ?>">
              <input type="text" id="max" name="max-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Sampai Tanggal" value="<?= $max ?>">

              <select name="nama-karyawan" class="form-control mt-2 col-sm-3" style="display: inline;">
                <option value="">Semua Marketing</option>
                <?php foreach ($karyawan as $row) : ?>
                  <option value="<?= $row->nama ?>" <?= ($row->nama == $nama) ? 'selected' : '' ?>><?= $row->nama ?></option>
                <?php endforeach ?>
              </select>
              <br>
              <button class="btn btn-info mt-2">Proses</button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="text-center">
          <h6>LAPORAN KEHADIRAN <?= $nama == '' ? 'SEMUA MARKETING' : strtoupper($nama) ?></h6>
          <h6>PERIODE <?= $min ?> - <?= $max ?></h6>
          <hr>
        </div>
        <div class="row">
          <div class="col-sm-6 mb-1">
            Toggle kolom: <a class="toggle-vis" data-column="8">Keterangan</a> - <a class="toggle-vis" data-column="6">Lokasi</a>
          </div>
          <div class="col-sm-6 text-right mb-2">
            <?php if ($nama == '') : ?>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class='fas fa-print'></i> Export PDF
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <button class="dropdown-item" onclick="this.form.target='_blank'; return true;" type="submit" form="laporan-pdf">Laporan Absen</button>
                  <button class="dropdown-item" onclick="this.form.target='_blank'; return true;" type="submit" form="summary-pdf">Summary Absen</button>
                </div>
              </div>
            <?php endif ?>
            <?php if ($nama != '') : ?>
              <form action="/absen-marketing/filter/laporan" method="POST">
                <input type="hidden" name="min-tanggal" value="<?= $min ?>">
                <input type="hidden" name="max-tanggal" value="<?= $max ?>">
                <input type="hidden" name="nama-karyawan" value="<?= $nama ?>">
                <button class="btn btn-secondary" onclick="this.form.target='_blank'; return true;"><i class='fas fa-print'></i> Export Laporan</button>
              </form>
            <?php endif ?>
            <form action="/absen-marketing/filter/laporan-semua" method="POST" id="laporan-pdf">
              <input type="hidden" name="min-tanggal" value="<?= $min ?>">
              <input type="hidden" name="max-tanggal" value="<?= $max ?>">
              <input type="hidden" name="nama-karyawan" value="<?= $nama ?>">
            </form>
            <form action="/absen-marketing/filter/sumarry" method="POST" id="summary-pdf">
              <input type="hidden" name="min-tanggal" value="<?= $min ?>">
              <input type="hidden" name="max-tanggal" value="<?= $max ?>">
              <input type="hidden" name="nama-karyawan" value="<?= $nama ?>">
            </form>
          </div>
        </div>

        <table class="table table-hoover table-bordered text-center" id="tb_absen">
          <thead>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Tanggal</th>
            <th>Jam Hadir</th>
            <th>Jam Pulang</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Keterangan</th>
          </thead>
          <tbody>
            <?php foreach ($absen as $row => $value) : ?>
              <tr>
                <td></td>
                <td><?= implode(' ', array_slice(explode(' ', $value->nama), 0, 2)) ?></td>
                <td><?= $value->jabatan ?></td>
                <td class="text-nowrap"><?= $value->tanggal ?></td>
                <td><?= $value->checkin ?></td>
                <td><?= $value->checkout ?></td>
                <td><?= $value->lokasi ?></td>
                <td> <?php switch ($value->absenstatus) {
                        case "Hadir":
                          echo "<span class='badge badge-success'>Hadir</span>";
                          break;
                        case "Terlambat":
                          echo "<span class='badge badge-warning'>Terlambat</span>";
                          break;
                        case "Kosong":
                          echo "<span class='badge badge-secondary'>Kosong</span>";
                          break;
                      } ?>
                </td>
                <td><?= $value->keterangan ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<?= $this->endSection(); ?>