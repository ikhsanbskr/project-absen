<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <span>Pilih Range Laporan</span>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" id="min" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Dari Tanggal">
                        <input type="text" id="max" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Sampai Tanggal">

                        <select id="select-nama" class="form-control mt-2 col-sm-3" style="display: inline;">
                            <option value="">Semua Karyawan</option>
                            <?php foreach ($karyawan as $row) : ?>
                                <option value="<?= $row->nama ?>"><?= $row->nama ?></option>
                            <?php endforeach ?>
                        </select>
                        <br>
                        <button class="btn btn-info mt-2" id="filter">Proses</button>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6>Laporan Absensi Karyawan</h6>
                <hr>
                <table class="table table-hoover table-bordered text-center" id="tb_absen">
                    <thead>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($absen as $row => $value) : ?>
                            <tr>
                                <td></td>
                                <td><?= implode(' ', array_slice(explode(' ', $value->nama), 0, 2)) ?></td>
                                <td><?= $value->jabatan ?></td>
                                <td><?= $value->tanggal ?></td>
                                <td><?= $value->lokasi ?></td>
                                <td><?= $value->checkin ?></td>
                                <td><?= $value->checkout ?></td>
                                <td><?= $value->status ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>