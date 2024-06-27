<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container d-flex justify-content-center">
            <form method="post" action="change_password/user_ubah_pw">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="changePassword">New Password</label>
                    <input type="number" class="form-control" id="changePassword" min="0" max="99999999" name="password">
                    <small id="passwordHelp" class="form-text text-danger">Passwword maksimal 8 angka</small>
                </div>
                <button type="submit" class="btn btn-secondary" onclick="alert('Yakin ubah password?')">Ubah Password</button>
            </form>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>