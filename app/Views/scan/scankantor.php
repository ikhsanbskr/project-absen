<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<body onload="getLocation();">
    <div class="row">
        <div class="col-sm-12 mt-3">
            <h3 style="color: #4a4a4a;">Scan Kantor</h3>
            <hr>
        </div>
        <div class="col-sm-12">
            <div class="form-check-inline mb-2">
                <input class="form-check-input" type="radio" name="radio_check" id="radio-checkin">
                <label class="form-check-label" for="radio-checkin">
                    Check In
                </label>
            </div>
            <div class="form-check-inline">
                <input class="form-check-input" type="radio" name="radio_check" id="radio-checkout">
                <label class="form-check-label" for="radio-checkout">
                    Check Out
                </label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="ganti-kamera">
                <label class="custom-control-label" for="ganti-kamera">Ganti Kamera</label>
            </div>
            <form action="/scan/checkin" method="POST" id="scancheckin" class="pb-2 mt-2">
                <?= csrf_field() ?>
                <input type="hidden" class="form-control col-sm-6" name="lastcheckout" value="<?= $lastinput->checkout ?>">
                <input type="hidden" name="status" value="<?= date('H:i:s') >= '08:00:00' ? 'Terlambat' : 'Hadir' ?>">
                <input type="hidden" name="hasilqr" id="qr">
                <input type="text" class="form-control col-sm-6" name="lokasiKantor" id="lokasiKantor" placeholder="Loading posisi..." readonly>
            </form>
            <form action="/scan/checkout/<?= ($lastinput->id == '') ? '0' : $lastinput->id ?>" method="POST" id="scancheckout">
                <input type="hidden" name="hasilqr" id="qr-checkout">
                <?= csrf_field() ?>
            </form>
            <button class="btn btn-primary" id="buka-kamera">Buka kamera</button>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="preview-container">
                <video id="preview"></video>
                <!-- <canvas id="canvas" width="640" height="480" style="display: none;"></canvas> -->
            </div>
        </div>
    </div>
    </div>
</body>
<?= $this->endSection(); ?>

<?= $this->section('jsfunction'); ?>

<?= $this->include('jsfunction/getlokasi'); ?>
<?= $this->include('jsfunction/absenqr'); ?>

<?= $this->endSection(); ?>