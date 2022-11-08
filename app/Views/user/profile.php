<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12 mt-4">
        <h2 style="color: #4a4a4a;">Profile</h2>
        <hr>

        <?php if (\Config\Services::validation()->getErrors()) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= \Config\Services::validation()->listErrors(); ?>
            </div>
        <?php endif ?>

        <div class="card card-outline card-success">
            <div class="row">
                <div class="col-sm-5 text-center mt-4">
                    <img id='gambarfoto' src="/uploads/foto-profile/<?= user()->foto_profile ?>" style="width: 200px;">
                    <div class="col-sm-12 mt-3">
                        <label for="upload_image">
                            <span class="btn btn-primary">Ganti Foto Profile</span>
                            <input type="file" name="image" class="image" accept="image/*" id="upload_image" style="display: none;" />
                        </label>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editProfile">
                            Edit Profile
                        </button>
                    </div>
                </div>
                <div class="col-sm-7 mt-4">
                    <div class="table-responsive">
                        <table class="table table-hoover">
                            <tr>
                                <th>Username</th>
                                <td>:</td>
                                <td><?= user()->username ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>:</td>
                                <td><?= user()->nama ?></td>
                            </tr>
                            <tr>
                                <?php
                                if (user()->tgl_lahir == "" || user()->tgl_lahir == "0000-00-00") {
                                    $convert_tgl = 'Belum diisi';
                                } else {
                                    $tgl_lahir = user()->tgl_lahir;
                                    $convert_tgl = format_id(date('Y-m-d', strtotime($tgl_lahir)));
                                }
                                ?>
                                <th>Tanggal Lahir</th>
                                <td>:</td>
                                <td><?= $convert_tgl ?></td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>:</td>
                                <td><?= user()->nik == '' ? 'Belum diisi' : user()->nik ?></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>:</td>
                                <td><?= user()->jabatan ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/profile/edit" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Username</label>
                            <input type="text" class="form-control" name="username" value="<?= user()->username ?>">
                        </div>
                        <div class="col-sm-12 mt-3">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= user()->nama ?>">
                        </div>
                        <div class="col-sm-12 mt-3">
                            <label>NIK</label>
                            <input type="text" class="form-control" name="nik" value="<?= user()->nik ?>">
                        </div>
                        <div class="col-sm-12 mt-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tgl_lahir" value="<?= user()->tgl_lahir ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal -->

<!-- Modal Foto Profile -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Foto Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/profile/savefoto" method="POST" id="uploadprofile" style="display: inline;">
                    <div class="img-container">
                        <img src="" id="previewfoto" style="display: block; max-width: 100%;">
                    </div>
                    <input type="hidden" name="cropfoto" id="cropfoto"></input>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="crop" class="btn btn-primary">Selesai</button>
            </div>
        </div>
    </div>
</div>
<!-- /Modal -->
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
<?= $this->include('jsfunction/cropfoto'); ?>
<?= $this->endSection(); ?>