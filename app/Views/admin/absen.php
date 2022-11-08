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
                        <form action="/absen/filter" method="POST">
                            <?= csrf_field() ?>
                            <input type="text" id="min" name="min-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Dari Tanggal">
                            <input type="text" id="max" name="max-tanggal" class="form-control mt-2 col-sm-3" style="display:inline;" placeholder="Sampai Tanggal">

                            <select name="nama-karyawan" class="form-control mt-2 col-sm-3" style="display: inline;">
                                <option value="">Semua Karyawan</option>
                                <?php foreach ($karyawan as $row) : ?>
                                    <option value="<?= $row->nama ?>"><?= $row->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <br>
                            <button class="btn mt-2" style="background-color: #4C5270; color: #f1f1f1;">Proses</button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12 text-center">
                    <h6>LAPORAN KEHADIRAN SEMUA KARYAWAN</h6>
                    <h6><?= date('d-m-Y') ?> (HARI INI)</h6>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-1">
                        Toggle kolom: <a class="toggle-vis" data-column="8">Keterangan</a> - <a class="toggle-vis" data-column="6">Lokasi</a>
                    </div>
                    <div class="col-sm-6 text-right mb-2">
                        <form action="/absen/laporan" method="POST">
                            <button class="btn btn-md btn-secondary" onclick="this.form.target='_blank'; return true;"><i class='fas fa-print'></i> Export PDF</button>
                        </form>
                    </div>
                </div>
                <table class="table table-hoover table-bordered text-center" id="tb_absen">
                    <thead>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th style="width: 63px;">Tanggal</th>
                        <th>Jam Hadir</th>
                        <th>Jam Pulang</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </thead>
                    <tbody>
                        <?php foreach ($absen as $row => $value) : ?>
                            <tr>
                                <td></td>
                                <td><?= implode(' ', array_slice(explode(' ', $value->nama), 0, 2)) ?></td>
                                <td><?= $value->jabatan ?></td>
                                <td class="text-nowrap"><?= $value->tanggal ?></td>
                                <td><?= $value->checkin ?></td>
                                <td><?= $value->checkout ?></td>
                                <td><?= $value->lokasi ?></td>
                                <td> <?php switch ($value->absenstatus) {
                                            case "Hadir":
                                                echo "<span class='badge badge-success'>Hadir</span>";
                                                break;
                                            case "Terlambat":
                                                echo "<span class='badge badge-warning'>Terlambat</span>";
                                                break;
                                            case "Izin":
                                                echo "<span class='badge badge-info'>Izin</span>";
                                                break;
                                            case "Kosong":
                                                echo "<span class='badge badge-secondary'>Kosong</span>";
                                                break;
                                        } ?>
                                </td>
                                <td><?= $value->keterangan ?></td>
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