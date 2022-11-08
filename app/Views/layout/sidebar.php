<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center" style="background-color: #40413F;">
        <img src="<?= base_url() ?>/template/dist/img/centurylogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold" style="color: #bdba9d;">Absensi Arcade</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <?php if (!in_groups('Unverified')) : ?>
            <!-- Sidebar Profile -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= base_url() ?>/uploads/foto-profile/<?= user()->foto_profile ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <?php $nama_lengkap = user()->nama; ?>
                    <a href="/profile" class="d-block"><?= implode(' ', array_slice(explode(' ', $nama_lengkap), 0, 2)) ?></a>
                </div>
            </div>
        <?php endif ?>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/" class="nav-link <?= ($segment == '') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-laptop"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <?php if (in_groups('Admin')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($segment == 'karyawan' || $segment == 'kelola-absen') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Kelola Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item menu open">
                                <a href="/karyawan" class="nav-link <?= ($segment == 'karyawan') ? 'active' : '' ?>">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Data Karyawan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/kelola-absen" class="nav-link <?= ($segment == 'kelola-absen') ? 'active' : '' ?>">
                                    <i class="fas fa-calendar-alt nav-icon"></i>
                                    <p>Data Absen</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($segment == 'absen' || $segment == 'absen-marketing') ? 'active' : '' ?>">
                            <i class="fa fa-list nav-icon"></i>
                            <p>
                                Laporan Absen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item menu open">
                                <a href="/absen" class="nav-link <?= ($segment == 'absen') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Karyawan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/absen-marketing" class="nav-link <?= ($segment == 'absen-marketing') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marketing</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                <!-- <ul class="nav nav-treeview">

                </ul> -->
                <?php if (in_groups('Staff') | in_groups('Staff Admin')) : ?>
                    <li class="nav-item">
                        <a href="/scan" class="nav-link <?= ($segment == 'scan') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>
                                Scan Kantor
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($segment == 'activity' || $segment == 'laporan-activity') ? 'active' : '' ?>">
                            <i class="fa fa-tasks nav-icon"></i>
                            <p>
                                Daily Activity
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item menu open">
                                <a href="/activity" class="nav-link <?= ($segment == 'activity') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Activity Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/laporan-activity" class="nav-link <?= ($segment == 'laporan-activity') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Activity</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="/history" class="nav-link <?= ($segment == 'history') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                History Absensi
                            </p>
                        </a>
                    </li>
                <?php endif ?>
                <?php if (in_groups('Staff Admin')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($segment == 'absen' || $segment == 'absen-marketing') ? 'active' : '' ?>">
                            <i class="fa fa-list nav-icon"></i>
                            <p>
                                Laporan Absen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item menu open">
                                <a href="/absen" class="nav-link <?= ($segment == 'absen') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Karyawan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/absen-marketing" class="nav-link <?= ($segment == 'absen-marketing') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marketing</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                <?php if (in_groups('Marketing')) : ?>
                    <li class="nav-item">
                        <a href="/history" class="nav-link <?= ($segment == 'history') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>History Absensi</p>
                        </a>
                    </li>
                <?php endif ?>
                <li class="nav-item">
                    <a id="logout1" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>