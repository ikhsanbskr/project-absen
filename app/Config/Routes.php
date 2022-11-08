<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Admin
$routes->get('/karyawan', 'Admin::karyawan', ['filter' => 'role:Admin']);
$routes->get('/karyawan/tambah', 'Admin::tambah', ['filter' => 'role:Admin']);
$routes->post('/karyawan/simpan', 'Admin::simpanKaryawan', ['filter' => 'role:Admin']);
$routes->delete('/karyawan/hapus/(:num)', 'Admin::deleteKaryawan/$1', ['filter' => 'role:Admin']);
$routes->post('/karyawan/edit/(:num)', 'Admin::editKaryawan/$1', ['filter' => 'role:Admin']);
$routes->post('/karyawan/ganti-password/(:num)', 'Admin::gantiPassword/$1');
$routes->get('/kelola-absen', 'Admin::dataAbsen');
$routes->get('/kelola-absen/filter', 'Admin::dataAbsenFilter');
$routes->post('/kelola-absen/edit/(:num)', 'Admin::editAbsen/$1');
$routes->get('/absen', 'Admin::absen', ['filter' => 'role:Admin']);
$routes->post('/absen/laporan', 'Admin::laporanToday');
$routes->post('/absen/filter', 'Admin::filter');
$routes->post('/absen/filter/laporan', 'Admin::laporan');
$routes->post('/absen/filter/laporan-semua', 'Admin::laporanSemua');
$routes->post('/absen/filter/summary', 'Admin::summarypdf');
$routes->get('/absen-marketing', 'Admin::absenMarketing', ['filter' => 'role:Admin']);
$routes->post('/absen-marketing/laporan',  'Admin::laporanMarketingToday');
$routes->post('/absen-marketing/filter', 'Admin::filterMarketing');
$routes->post('/absen-marketing/filter/laporan', 'Admin::laporanMA');
$routes->post('/absen-marketing/filter/laporan-semua', 'Admin::laporanSemuaMA');
$routes->post('/absen-marketing/filter/sumarry', 'Admin::sumarrypdfMA');

// User
$routes->get('/profile', 'User::index');
$routes->post('/profile/savefoto', 'User::saveFoto');
$routes->post('/profile/edit', 'User::editProfile');
$routes->get('/history', 'User::historyAbsen');
$routes->post('/history', 'User::filterAbsen');
$routes->post('/history/laporan', 'Admin::laporan');
$routes->post('/history/laporan-ma', 'Admin::laporanMA');

// Dashboard Absen & Admin
$routes->get('/', 'Dashboard::index');
$routes->post('/checkin', 'Dashboard::checkin');
$routes->post('/checkout/(:num)', 'Dashboard::checkout/$1');
$routes->post('/izin', 'Dashboard::izin');
$routes->post('/konfirmasi/(:num)', 'Dashboard::konfirmasi/$1');
// $routes->get('/absenform', 'Absensi::index');

// Scan Kantor
$routes->get('/scan/', 'ScanKantor::index');
$routes->post('/scan/checkin', 'ScanKantor::checkIn');
$routes->post('/scan/checkout/(:num)', 'ScanKantor::checkout/$1');

// Daily Activity
$routes->get('/activity', 'Activity::index');
$routes->post('/activity/tambah', 'Activity::tambahActivity');
$routes->post('/activity/edit/(:num)', 'Activity::editActivity/$1');
$routes->post('/activity/hapus/(:num)', 'Activity::hapusActivity/$1');
$routes->get('/activity/filter', 'Activity::filterActivity');
$routes->post('/activity/filter/tambah', 'Activity::tambahActivityFilter');
$routes->post('/activity/filter/edit/(:num)', 'Activity::editActivityFilter/$1');
$routes->post('/activity/filter/hapus/(:num)', 'Activity::hapusActivityFilter/$1');
$routes->get('/laporan-activity', 'Activity::laporanActivity');
$routes->post('/laporan-activity/export', 'Activity::exportLaporanToday');
$routes->get('/laporan-activity/filter', 'Activity::laporanActivityFilter');
$routes->post('/laporan-activity/filter/export', 'Activity::exportLaporanFilter');

// Cron Job
$routes->get('/cronjob/stafftanpaketerangan', 'Dashboard::staffTanpaKeterangan');
$routes->get('/cronjob/marketingtanpaketerangan', 'Dashboard::marketingTanpaKeterangan');
$routes->get('/cronjob/pakrickotelat', 'Dashboard::PakRickoTelat');
$routes->get('/cronjob/pakrickorecovery', 'Dashboard::PakRickoRecovery');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
