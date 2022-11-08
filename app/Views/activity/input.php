<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <div class="col-sm-12 mt-3">
    <?php if (\Config\Services::validation()->getErrors()) : ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?= \Config\Services::validation()->getError('activity_edit'); ?>
        <?= \Config\Services::validation()->getError('activity'); ?>
      </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="alert alert-success" role="alert">
        <?= session('pesan') ?>
      </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('peringatan')) : ?>
      <div class="alert alert-danger" role="alert">
        <?= session('peringatan') ?>
      </div>
    <?php endif ?>

    <div class="card collapsed-card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <span>Pilih Tanggal</span>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <form action="/activity/filter" method="GET">
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
        <div class="text-center">
          <h6>DAILY ACTIVITY <?= strtoupper(user()->nama) ?></h6>
          <h6>TANGGAL <?= ($tanggal == NULL ? '-' : strtoupper(format_id(date('Y-m-d', strtotime($tanggal)))))  ?></h6>
          <hr>
        </div>
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
              <thead class="table-dark">
                <th>Aktifitas</th>
                <th style="min-width: 107px;">Terakhir Diubah</th>
              </thead>
              <tbody class="table-success nowrap">
                <?php $no_id = 1; ?>
                <?php $no = 1; ?>
                <?php if ($activity == NULL) : ?>
                  <tr>
                    <td colspan="3">Tidak ada data yang tersedia.</td>
                  </tr>
                <?php endif ?>
                <?php foreach ($activity as $row) : ?>
                  <?php $no_id++ ?>
                  <tr data-toggle="modal" data-target="#editModal<?= $no_id ?>">
                    <?php $no++ ?>
                    <td><?= $row->aktifitas ?></td>
                    <td style="color:#646464"><?= $row->last_update ?></td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Aktifitas</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/activity/edit/<?= $row->activityid ?>" method="POST" id="form-edit<?= $no ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="tanggal" value="<?= $row->tanggal_activity ?>">
                            <textarea name="activity_edit" class="form-control"><?= $row->aktifitas ?></textarea>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary" form="form-edit<?= $no ?>"><i class="fas fa-save"></i> Konfirmasi</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
              <i class="fas fa-plus-circle"></i> Tambah Aktifitas
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Activity -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Aktifitas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/activity/tambah" method="POST">
        <div class="modal-body">
          <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
          <textarea name="activity" class="form-control" placeholder="Aktifitas 1, Aktifitas 2, Aktifitas 3..." rows="5"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>