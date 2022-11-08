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
                                <option value="<?= user()->nama ?>" selected><?= implode(' ', array_slice(explode(' ', user()->nama), 0, 2)) ?></option>
                            </select>
                            <br>
                            <button class="btn mt-3" style="background-color: #4C5270; color: #f1f1f1;">Proses</button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h6>KEHADIRAN <?= strtoupper(user()->nama) ?></h6>
                    <h6>PERIODE <?= $min ?> - <?= $max ?></h6>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-1">
                        Toggle kolom: <a class="toggle-vis" data-column="8">Keterangan</a> - <a class="toggle-vis" data-column="6">Lokasi</a>
                    </div>
                    <div class="col-sm-6 text-right mb-2">
                        <?php if (in_groups('Staff')) : ?>
                            <form action="/history/laporan" method="POST">
                                <input type="hidden" name="min-tanggal" value="<?= $min ?>">
                                <input type="hidden" name="max-tanggal" value="<?= $max ?>">
                                <input type="hidden" name="nama-karyawan" value="<?= $nama ?>">
                                <button class="btn btn-md btn-secondary"><i class='fas fa-print'></i> Export Laporan</button>
                            </form>
                        <?php endif ?>
                        <?php if (in_groups('Marketing')) : ?>
                            <form action="/history/laporan-ma" method="POST">
                                <input type="hidden" name="min-tanggal" value="<?= $min ?>">
                                <input type="hidden" name="max-tanggal" value="<?= $max ?>">
                                <input type="hidden" name="nama-karyawan" value="<?= $nama ?>">
                                <button class="btn btn-secondary"><i class='fas fa-print'></i> Export Laporan</button>
                            </form>
                        <?php endif ?>
                    </div>
                </div>

                <?php if (in_groups('Staff')) : ?>
                    <table class="table table-hoover table-bordered text-center" id="tb_absen">
                        <thead>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Tanggal</th>
                            <th>Jam Hadir</th>
                            <th>Jam Pulang</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php foreach ($absenstaff as $row => $value) : ?>
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
                <?php endif ?>

                <?php if (in_groups('Marketing')) : ?>
                    <table class="table table-hoover table-bordered text-center" id="tb_absen">
                        <thead>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Tanggal</th>
                            <th>Jam Hadir</th>
                            <th>Jam Pulang</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php foreach ($absenma as $row => $value) : ?>
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
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>