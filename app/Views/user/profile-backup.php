<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Profile Karyawan / Detail</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="pl-5">
                            <img src="/template/dist/img/default.svg" style="width: 200px;">
                            <div class="col-sm-12 mt-3">
                                <input type="file">
                            </div>
                            <?= $this->include('/user/modalFoto'); ?>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <table class="table table-hoover" id="tb-profile">
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td><?= user()->email ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>:</td>
                                <td><?= user()->nama ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>:</td>
                                <td>07 Juli 2005</td>
                            </tr>
                            <tr>
                                <th>Nomor Induk Karyawan</th>
                                <td>:</td>
                                <td><?= user()->nik == '' ? 'Belum diisi' : user()->nik ?></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>:</td>
                                <td><?= user()->jabatan ?></td>
                            </tr>
                        </table>
                        <button class="btn btn-primary">Edit Profile</button>
                        <button class="btn btn-warning">Ganti Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>