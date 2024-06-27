<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-bottom text-center">
        <!-- <li class="nav-item align-bottom text-center">
                    <h5 class="align-bottom text-center"><= session('profil') ?></h5>
                </li> -->
        <li class="nav-item">
            <!-- <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a> -->
            <a href="<?= base_url('logout') ?>" class="text-secondary">LOGOUT <i class="nav-icon fas fa-sign-out-alt"></i></a>
        </li>
    </ul>
</nav>