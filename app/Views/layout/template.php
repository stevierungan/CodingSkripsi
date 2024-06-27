<?php
if (session('logged_in') !== true) {
    header('Location: /login');
    exit;
}

$uri = new \CodeIgniter\HTTP\URI('http://www.example.com/some/path#first-heading');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK | SMAN 1 Tenga</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('adminLTE_3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('adminLTE_3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?> ">
    <link rel="stylesheet" href="<?= base_url('adminLTE_3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?> ">
    <link rel="stylesheet" href="<?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?> ">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('adminLTE_3.2.0/dist/css/adminlte.min.css') ?> ">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php include 'navbar.php' ?>

        <?php include 'sidebar.php' ?>

        <?= $this->renderSection('content'); ?>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright 2022 <a href="https://google.com">DC</a>.</strong> SMA NEGERI 1 TENGA.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url('adminLTE_3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('adminLTE_3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('adminLTE_3.2.0/dist/js/adminlte.min.js') ?>"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('adminLTE_3.2.0/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('adminLTE_3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('adminLTE_3.2.0/plugins/jszip/jszip.min.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/pdfmake/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('adminLTE_3.2.0/plugins/pdfmake/vfs_fonts.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
    <script src=" <?= base_url('adminLTE_3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>

    <?= $this->renderSection('js'); ?>

    <script>
        $(".nav>li").each(function() {
            var navItem = $(this);
            if (navItem.find("a").attr("href") == location.pathname) {
                navItem.addClass("active");
            }
        });
    </script>

</body>

</html>