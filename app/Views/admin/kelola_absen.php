<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-sm-12 mt-3">
    <h3 style="color: #4a4a4a;">Kelola Absensi</h3>
    <hr>
    <?php if (\Config\Services::validation()->getErrors()) : ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?= \Config\Services::validation()->listErrors(); ?>
      </div>
    <?php endif ?>
    <div class="card card-outline card-dark">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <span>Pilih Range Absen</span>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <form action="/kelola-absen/filter" method="GET">
              <input type="text" id="min" name="min-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Dari Tanggal" value="<?= isset($absen) ? $min : '' ?>">
              <input type="text" id="max" name="max-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Sampai Tanggal" value="<?= isset($absen) ? $max : '' ?>">
              <br>
              <button class="btn mt-2" style="background-color: #4C5270; color: #f1f1f1;">Proses</button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-outline card-dark mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-12">
            <h3 class="card-title">Data Absensi C21 Arcade</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table id="tb_kelola_absen" class="table table-bordered table-striped text-center">
          <thead>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </thead>
          <tbody>
            <?php if (isset($absen)) : ?>
              <?php $no = 1 ?>
              <?php foreach ($absen as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->nama ?></td>
                  <td><?= $row->jabatan ?></td>
                  <td><?= $row->tanggal ?></td>
                  <td><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?= $no ?>"><i class="fas fa-edit"></i>Edit</button></td>
                </tr>
                <!-- Modal Edit-->
                <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Absensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="/kelola-absen/edit/<?= $row->absenid ?>" method="POST">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12">
                              <input type="hidden" name="min-tanggal" value="<?= $min ?>">
                              <input type="hidden" name="max-tanggal" value="<?= $max ?>">
                              <label>Status</label>
                              <select name="status" class="form-control">
                                <option selected disabled>-- Pilih Status --</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Kosong">Kosong</option>
                              </select>
                            </div>
                            <div class="col-sm-6 mt-2">
                              <label>Tanggal</label>
                              <input type="date" class="form-control" name="tanggal" value="<?= $row->tanggal ?>">
                            </div>
                            <div class="col-sm-6 mt-2">
                              <label>Keterangan</label>
                              <input type="text" class="form-control" name="keterangan" value="<?= $row->keterangan ?>">
                            </div>
                            <div class="col-sm-6 mt-2">
                              <label>Check In</label>
                              <input type="time" class="form-control" name="checkin" value="<?= $row->checkin ?>">
                            </div>
                            <div class="col-sm-6 mt-2">
                              <label>Check Out</label>
                              <input type="time" class="form-control" name="checkout" value="<?= $row->checkout ?>">
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('jsfunction'); ?>
<script>
  <?php if (session()->getFlashdata('pesan')) : ?>
    Swal.fire(
      'Sukses',
      '<?= session('pesan') ?>',
      'success'
    )
  <?php endif ?>
</script>
<?= $this->endSection(); ?>