<div class="col-sm-6 mt-5">
  <div class="card">
    <div class="card-header bg-secondary">
      <h3 class="card-title"><i class="far fa-calendar-times"></i> Staff Tanpa Keterangan</h3>
    </div>

    <div class="card-body table-responsive p-0" style="height: 200px;">
      <table class="table table-bordered table-head-fixed text-nowrap text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1 ?>
          <?php if ($konfirmasi == NULL) : ?>
            <tr>
              <td colspan="3">Tidak ada data yang tersedia.</td>
            </tr>
          <?php endif ?>
          <?php foreach ($konfirmasi as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
              <td><button name="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#konfirmasiModal<?= $no ?>"><i class="fas fa-eye"></i> Detail</button></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<?php $no = 2 ?>
<?php foreach ($konfirmasi as $row) : ?>
  <div class="modal fade" id="konfirmasiModal<?= $no++ ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/konfirmasi/<?= $row->userid ?>" method="POST">
          <div class="modal-body table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama</th>
                  <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
                </tr>
                <tr>
                  <th>Jabatan</th>
                  <td><?= $row->jabatan ?></td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td><input type="text" name="tanggal" readonly value="<?= $row->tanggal ?>" style="border-style: none;"></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                    <select name="status" class="form-control">
                      <option disabled selected>-- Pilih Status --</option>
                      <option value="Alpa">Alpa</option>
                      <option value="Libur">Libur</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Keterangan</th>
                  <td><textarea name="keterangan" class="form-control" maxlength="31" rows="2"></textarea></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Konfirmasi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>