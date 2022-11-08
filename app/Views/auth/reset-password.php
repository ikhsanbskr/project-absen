<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/template/dist/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-image: url('/template/dist/img/login-background.jpg');">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block" style="background-image: url('/template/dist/img/login-card.svg');"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900">Reset Password</h1>
                                <p class="mb-4">Cek emailmu dan klik pada token link yang anda terima pada email</p>
                            </div>
                            <?= view('Myth\Auth\Views\_message_block') ?>
                            <form class="user" action="<?= url_to('reset-password') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" placeholder="Token" value="<?= old('token', $token ?? '') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.token') ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" aria-describedby="emailHelp" name="email" placeholder="Alamat email" value="<?= old('email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="Password Baru">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Ulang Password Baru" autocomplete="off">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= session('errors.pass_confirm') ?>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Reset Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/template/plugins/jquery/jquery.min.js"></script>
    <script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="template/plugins/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/template/dist/js/sb-admin-2.min.js"></script>

</body>

</html>