<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12 mt-3">
        <h3 style="color: #4a4a4a;">Data Karyawan</h3>
        <hr>
        <?php if (session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success mt-2" role="alert">
                <?= session('pesan') ?>
            </div>
        <?php endif ?>

        <?php if (\Config\Services::validation()->getErrors()) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= \Config\Services::validation()->listErrors(); ?>
            </div>
        <?php endif ?>
        <div class="card card-outline card-dark mt-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="card-title">Data Karyawan C21 Arcade</h3>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <a href="/karyawan/tambah">
                            <button type="button" class="btn btn-secondary"><i class="fa fa-plus pr-1"></i> Tambah Karyawan</button>
                        </a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="tb_karyawan" class="table table-bordered table-striped text-center">
                    <thead>
                        <th>No</th>
                        <th>Foto Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Role</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                        <th>Autentikasi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($karyawan as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="/uploads/foto-profile/<?= $row->foto_profile ?>" class="shadow-lg" width="65" style="border-radius: 50%;"></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->name ?></td>
                                <td><?= $row->jabatan ?></td>
                                <td style="min-width: 200px;">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $no ?>">
                                        <i class="fas fa-edit"></i>Edit
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusModal<?= $no ?>">
                                        <i class="fas fa-user-times"></i> Hapus
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#passwordModal<?= $no ?>"><i class="fas fa-key"></i> Password</button>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="/karyawan/edit/<?= $row->usersid ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Karyawan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control" name="username" value="<?= $row->username ?>">
                                                    </div>
                                                    <div class="col-sm-12 mt-3">
                                                        <label>Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="nama" value="<?= $row->nama ?>">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label>Jabatan</label>
                                                        <input type="text" class="form-control" name="jabatan" value="<?= $row->jabatan ?>">
                                                    </div>
                                                    <div class="col-sm-6 mt-3">
                                                        <label>Jam Terlambat</label>
                                                        <input type="time" class="form-control" name="jam_terlambat" value="<?= $row->jam_terlambat ?>">
                                                    </div>
                                                    <div class="col-sm-12 mt-3">
                                                        <label>Role</label>
                                                        <select name="role" class="form-control">
                                                            <option value="1" <?= ($row->name == 'Admin') ? 'selected' : '' ?>>Admin</option>
                                                            <option value="2" <?= ($row->name == 'Staff') ? 'selected' : '' ?>>Staff</option>
                                                            <option value="3" <?= ($row->name == 'Marketing') ? 'selected' : '' ?>>Marketing</option>
                                                            <option value="4">Staff Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus -->
                            <div class="modal fade" id="hapusModal<?= $no ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data <?= $row->nama ?>
                                        </div>
                                        <form action="karyawan/hapus/<?= $row->usersid ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ganti Password -->
                            <div class="modal fade" id="passwordModal<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/karyawan/ganti-password/<?= $row->usersid ?>" method="POST">
                                            <div class="modal-body">
                                                <label>Password Baru</label>
                                                <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru...">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<?= $this->endSection(); ?>