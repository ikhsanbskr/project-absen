<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<body onload="getLocation();">
    <div class="row">
        <div class="col-sm-12 mt-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Absensi</h3>
                </div>
                <div class="card-body">
                    <form class="myForm" action="" method="POST">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nama">Nama Karyawan</label>
                                <select name="nama" id="" class="form-control" disabled>
                                    <option value="">Muhammad Ikhsan Trianda Baskara</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="jabatan">Jabatan Karyawan</label>
                                <select name="jabatan" id="" class="form-control" disabled>
                                    <option value="">Magang</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label for="">Latitude</label>
                                <input type="text" name="latitude" class="form-control" disabled>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label for="">Longitude</label>
                                <input type="text" name="longitude" class="form-control" disabled>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label for="lokasi">Lokasi Absen</label>
                                <textarea name="posisi" id="lokasi" class="form-control"></textarea>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label for="keterangan">Keterangan Absen</label>
                                <textarea name="" id="" class="form-control" placeholder="Masukkan keterangan absen"></textarea>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end mt-5">
                                <button class="btn btn-secondary mr-1">Reset</button>
                                <button class="btn btn-primary">Absen</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?= $this->endSection(); ?>