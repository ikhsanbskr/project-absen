<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login C21 Absen</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>/favicon.ico" type="image/gif">

    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="/template/dist/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body style="padding-top: 20px; background-image: url('/template/dist/img/login-background-compressed.jpg'); background-size:cover; background-position-y: 100%;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block" style="background-image: url('/template/dist/img/login-card2.svg');"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login C21 Prima Group</h1>
                                    </div>
                                    <?= view('Myth\Auth\Views\_message_block') ?>
                                    <form action="<?= url_to('login') ?>" method="post" class="user">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="Masukkan Username...">
                                            <div class="invalid-feedback">
                                                <?= session('errors.login') ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="Password">
                                            <div class="invalid-feedback">
                                                <?= session('errors.password') ?>
                                            </div>
                                        </div>

                                        <?php if ($config->allowRemembering) : ?>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" name="remember" id="customCheck" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                                    <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
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
    <script src="/template/dist/js/sb-admin-2.min.js"></script>


</body>

</html>