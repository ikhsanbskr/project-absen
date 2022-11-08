<body onload="getLocation();">
    <div class="row">
        <div class="col-sm-12 mt-3">
            <h3 style="color: #4a4a4a;">Dashboard Marketing</h3>
            <hr>
            <!-- Session validasi -->
            <?php if (\Config\Services::validation()->getErrors()) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= \Config\Services::validation()->listErrors(); ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('peringatan')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session('peringatan') ?>
                </div>
            <?php endif ?>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Daftar Absen Hari Ini</h3>
                </div>
                <div class="card-body">
                    <div>
                        Toggle kolom: <a class="toggle-vis" data-column="8">Keterangan</a> - <a class="toggle-vis" data-column="6">Lokasi</a>
                    </div>
                    <table class="table table-bordered table-hoover text-center" id="tb_dashboard">
                        <thead>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th style="width: 65px;">Tanggal</th>
                            <th>Jam Hadir</th>
                            <th>Jam Selesai</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php $no = 1;  ?>
                            <?php foreach ($marketing as $row => $value) : ?>
                                <?php $nama_lengkap = $value->nama; ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= implode(' ', array_slice(explode(' ', $nama_lengkap), 0, 2)) ?></td>
                                    <td><?= $value->tanggal ?></td>
                                    <td><?= $value->checkin ?></td>
                                    <td><?= $value->checkout ?></td>
                                    <td><?= $value->lokasi ?></td>
                                    <td>
                                        <?php switch ($value->absenstatus) {
                                            case "Hadir":
                                                echo "<span class='badge badge-success'>Hadir</span>";
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
            <div class="card">
                <div class="card-body">
                    <form class="formAbsen" action="checkin" method="POST" id="form-absen" style="display: inline;">
                        <input type="hidden" class="form-control col-sm-6" name="lastcheckout" value="<?= $lastinput->checkout ?>" readonly>
                        <input type="hidden" name="status" value="Hadir">
                        <input type="text" class="form-control col-sm-6" name="lokasi" placeholder="Loading posisi..." readonly>
                    </form>
                    <button type="submit" class="btn btn-success mt-3" data-toggle="modal" data-target="#modalCheckin">Check In</button>
                    <!-- Modal Checkin -->
                    <!-- Modal -->
                    <div class="modal fade" id="modalCheckin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Check In</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label>Keterangan Absen</label>
                                    <textarea name="keterangan" class="form-control" maxlength="31" rows="2" form="form-absen"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" form="form-absen">Konfirmasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal -->
                    <button type="submit" class="btn btn-secondary mt-3" data-toggle="modal" data-target="#checkout">Check Out</button>
                    <!-- Modal Checkout -->
                    <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="checkout/<?= $lastinput->id ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <input type="hidden" name='lokasi' id="lokasi-checkout">
                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin melakukan check out?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Modal -->
                </div>
            </div>
        </div>
    </div>
</body>

<?= $this->section('jsfunction'); ?>
<?= $this->include('jsfunction/getlokasi'); ?>
<script>
    <?php if (session()->getFlashdata('pesan')) : ?>
        Swal.fire(
            'Sukses',
            '<?= session('pesan') ?>',
            'success'
        )
    <?php endif ?>
</script>
<?= $this->endSection(); ?>