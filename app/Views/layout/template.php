<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url() ?>/favicon.ico" type="image/gif">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/dist/css/adminlte.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- Cropper JS -->
  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">

  <style>
    /* Mengatur Crop Profile Menjadi Bulat */
    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }

    /* Container Kamera (Responsive) */
    .preview-container {
      flex-direction: column;
      align-items: center;
      justify-content: center;
      display: flex;
      width: 100%;
      height: 50%;
      overflow: hidden;
    }

    /* Datatable Responsive */
    .dataTables_scrollHeadInner,
    .table {
      width: 100% !important
    }

    @media screen and (max-width: 450px) {
      li.paginate_button.previous {
        display: inline;
      }

      li.paginate_button.next {
        display: inline;
      }

      li.paginate_button {
        display: none;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-dark" style="background-color: #40413F;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <span class="pl-3" style="color: #bdba9d; font:icon;">C21 Prima Arcade</span>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <img src="/uploads/foto-profile/<?= user()->foto_profile ?>" class="shadow-lg" width="35" height="35">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <span class="dropdown-item dropdown-header">Hai, <?= implode(' ', array_slice(explode(' ', user()->nama), 0, 2)) ?></span>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= base_url() ?>/profile">User Profile</a>
            <div class="dropdown-divider"></div>
            <button id="logout" class="dropdown-item" href="">Logout</button>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <?= $this->include('layout/sidebar'); ?>

    <!-- Container Content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <?= $this->renderSection('content'); ?>
        </div>
      </div>
      <!-- /Main Content -->
    </div>
    <!-- /Container Content -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- Baris kanan -->
      <div class="float-right d-none d-sm-inline">
        Developed by <a href="https://linktr.ee/ikhsanbskr" target="_blank">Muhammad Ikhsan T.B</a>.
      </div>
      <!-- Baris kiri -->
      <strong>Copyright &copy; 2022 - <?= date('Y', time()) ?> Century 21 Prima | SMK Al Amanah.</strong> All rights reserved.
    </footer>
  </div>
  <!-- /Container -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="<?= base_url() ?>/template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>/template/dist/js/adminlte.min.js"></script>
  <!-- Cropper JS -->
  <script src="/template/plugins/cropper.js"></script>
  <!-- Instascan -->
  <script src="<?= base_url() ?>/template/plugins/instascan-fix/instascan.min.js"></script>
  <!-- Sweet Alert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Chart JS -->
  <script src="/template/plugins/chart.js/Chart.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url() ?>/template/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url() ?>/template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

  <!-- /Require Script -->

  <!-- JS Function -->
  <?= $this->renderSection('jsfunction'); ?>

  <!-- Sweetalert  -->
  <script>
    <?php if (session()->getFlashdata('login')) : ?>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      })

      Toast.fire({
        icon: 'success',
        title: '<?= session('login') ?>!',
        didOpen: (toast) => {
          toast.addEventListener('click', Swal.close);
        }
      })
    <?php endif ?>

    $('#logout, #logout1').click(function() {
      Swal.fire({
        icon: 'warning',
        title: 'Apakah Anda yakin ingin logout?',
        showCancelButton: true,
        confirmButtonText: 'Konfirmasi',
        cancelButtonText: `Batal`,
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '/logout';
        }
      })
    });
  </script>

  <!-- Data Table -->
  <?= $this->include('jsfunction/datatable'); ?>
</body>

</html>