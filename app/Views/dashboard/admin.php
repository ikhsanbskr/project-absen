<div class="row">
    <div class="col-sm-12 mt-3">
        <h3 style="color: #4a4a4a;">Dashboard</h3>
        <hr>
        <?php if (\Config\Services::validation()->getErrors()) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= \Config\Services::validation()->getError('status'); ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success mt-3" role="alert">
                <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif ?>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3><?= $totalstaffma ?></h3>
                <p>Total Staff & Marketing</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a class="small-box-footer" id="total-user"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $totalabsen ?> </h3>
                <p>Kehadiran Staff Hari Ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-calendar"></i>
            </div>
            <a class="small-box-footer" id="absen-sekarang"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $totaltelat ?> </h3>
                <p>Staff Terlambat Hari Ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-clock"></i>
            </div>
            <a class="small-box-footer" id="absen-terlambat"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-lightblue">
            <div class="inner">
                <h3><?= $totalizin ?> </h3>
                <p>Jumlah Staff Izin Hari Ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-document-text"></i>
            </div>
            <a class="small-box-footer" id="absen-izin"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-sm-12 mt-2">
        <div class="card card-lightblue">
            <div class="card-header" style="max-height: 50px;">
                <h3 class="card-title">Statistik Absen Staff & Marketing</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="areaChart" style="min-height: 270px; height: 250px; max-height: 500px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Karyawan -->
<div class="modal fade" id="modalTotal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="table" style="height: 400px;">
                        <table class="table table-bordered table-striped text-nowrap text-center">
                            <thead class="bg-secondary">
                                <th>No</th>
                                <th>Nama Karyawan</th>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($karyawan as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Absen Staff Hari Ini -->
<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="table" style="max-height: 400px;">
                        <table class="table table-bordered table-striped text-nowrap text-center">
                            <thead class="bg-secondary">
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Jam Hadir</th>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php if ($kehadiran == NULL) : ?>
                                    <tr>
                                        <td colspan="3">Belum ada staff yang melakukan absen.</td>
                                    </tr>
                                <?php endif ?>
                                <?php foreach ($kehadiran as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
                                        <td><?= $row->checkin ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terlambat -->
<div class="modal fade" id="modalTerlambat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="table">
                        <table class="table table-bordered table-striped text-nowrap text-center">
                            <thead class="bg-secondary">
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Jam Hadir</th>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php if ($terlambat == NULL) : ?>
                                    <tr>
                                        <td colspan="3">Tidak ada staff yang terlambat.</td>
                                    </tr>
                                <?php endif ?>
                                <?php foreach ($terlambat as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
                                        <td><?= $row->checkin ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Izin -->
<div class="modal fade" id="modalIzin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="table">
                        <table class="table table-bordered table-striped text-nowrap text-center">
                            <thead class="bg-secondary">
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Keterangan</th>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php if ($izin == NULL) : ?>
                                    <tr>
                                        <td colspan="3">Tidak ada staff yang izin.</td>
                                    </tr>
                                <?php endif ?>
                                <?php foreach ($izin as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= implode(' ', array_slice(explode(' ', $row->nama), 0, 2)) ?></td>
                                        <td><?= $row->keterangan ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>


<?= $this->section('jsfunction'); ?>
<script>
    $('#total-user').click(function() {
        $('#modalTotal').modal('show');
    });

    $('#absen-sekarang').click(function() {
        $('#modalAbsen').modal('show');
    });

    $('#absen-terlambat').click(function() {
        $('#modalTerlambat').modal('show');
    });

    $('#absen-izin').click(function() {
        $('#modalIzin').modal('show');
    })
</script>
<script>
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
            label: 'Jumlah Kehadiran',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?= $statistik1 ?>, <?= $statistik2 ?>, <?= $statistik3 ?>, <?= $statistik4 ?>, <?= $statistik5 ?>, <?= $statistik6 ?>, <?= $statistik7 ?>, <?= $statistik8 ?>, <?= $statistik9 ?>, <?= $statistik10 ?>, <?= $statistik11 ?>, <?= $statistik12 ?>]
        }]
    }

    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                }
            }]
        }
    }

    new Chart(areaChartCanvas, {
        type: 'bar',
        data: areaChartData,
        options: areaChartOptions
    })
</script>
<?= $this->endSection(); ?>