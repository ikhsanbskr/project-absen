<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12 mt-3">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus pr-2"></i>Tambah Karyawan</h3>
            </div>

            <form action="/karyawan/simpan" method="POST">
                <div class="card-body">
                    <?php
                    $huruf = 'abcdefghijklmnopqrstuvwxyz';
                    $hurufrand = substr(str_shuffle($huruf), 0, 10);
                    ?>
                    <input type="hidden" name="email" value="<?= $hurufrand ?>@default.com">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan username..." value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.username') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control <?php if (session('errors.nama')) : ?>is-invalid<?php endif ?>" value="<?= old('nama') ?>" placeholder="Masukkan nama...">
                        <div class="invalid-feedback">
                            <?= session('errors.nama') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control <?php if (session('errors.jabatan')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan jabatan..." value="<?= old('jabatan') ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.jabatan') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option selected disabled>-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Unverified">Unverified</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan password..." autocomplete="off">
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Ulangi Password</label>
                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Ulangi password..." autocomplete="off">
                            <div class="invalid-feedback">
                                <?= session('errors.pass_confirm') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>