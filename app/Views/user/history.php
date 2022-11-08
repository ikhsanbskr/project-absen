<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <span>Pilih Range Kehadiran</span>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/history" method="POST">
                            <?= csrf_field() ?>
                            <input type="text" id="min" name="min-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Dari Tanggal">
                            <input type="text" id="max" name="max-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Sampai Tanggal">

                            <select name="nama-karyawan" class="form-control mt-2 col-sm-3" style="display: inline;" readonly>
                                <option value="<?= user()->nama ?>"><?= implode(' ', array_slice(explode(' ', user()->nama), 0, 2)) ?></option>
                            </select>
                            <br>
                            <button class="btn mt-3" style="background-color: #4C5270; color: #f1f1f1;">Proses</button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>