<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php if (in_groups('Admin')) : ?>
    <?= $this->include('dashboard/admin'); ?>
<?php endif ?>

<?php if (in_groups('Staff') | in_groups('Staff Admin')) : ?>
    <?= $this->include('dashboard/staff'); ?>
<?php endif ?>

<?php if (in_groups('Marketing')) : ?>
    <?= $this->include('dashboard/marketing'); ?>
<?php endif ?>

<?php if (in_groups('Unverified')) : ?>
    <div class="pt-2">
        <p>Akun belum diverifikasi, silahkan hubungi Admin untuk memverifikasi akun ini.</p>
    </div>
<?php endif ?>
<?= $this->endSection(); ?>