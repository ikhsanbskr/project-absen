<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-sm-12 mt-2">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <span>Pilih Tanggal</span>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <form action="/laporan-activity/filter" method="GET">
              <input type="text" id="min" name="select-tanggal" class="form-control mt-2 col-sm-12" style="display:inline;" placeholder="Masukkan tanggal..">
              <br>
              <button class="btn mt-3" style="background-color: #4C5270; color: #f1f1f1;">Proses</button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="col-sm-12 text-center">
          <h6>DAILY REPORT ACTIVITY</h6>
          <h6>TANGGAL <?= strtoupper($tanggal) ?></h6>
          <hr>
        </div>
        <div class="col-sm-12 text-right mb-2">
          <form action="/laporan-activity/filter/export" method="POST">
            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
            <button class="btn btn-md btn-secondary" onclick="this.form.target='_blank'; return true;"><i class='fas fa-print'></i> Export PDF</button>
          </form>
        </div>
        <div class="col-sm-12">
          <div class="table table-responsive">
            <table class="table table-hover table-bordered text-center" id="tb_lap_activity">
              <thead class="table-dark">
                <th>No</th>
                <th>Nama</th>
                <th>Keterangan</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Aktifitas</th>
                <th>Lokasi</th>
                <th>Last Update</th>
              </thead>
              <tbody class="table-success">
                <?php $no = 1 ?>
                <?php foreach ($laporan as $row) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td><?= $row->checkin ?></td>
                    <td><?= $row->checkout ?></td>
                    <td><?= $row->aktifitas ?></td>
                    <td><?= $row->lokasi ?></td>
                    <td><?= $row->last_update ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>