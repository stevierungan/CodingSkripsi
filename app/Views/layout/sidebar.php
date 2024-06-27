<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="../../../adminLTE_3.2.0/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SPK-SMA N 1 TENGA
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel d-flex mt-2 justify-content-center">
            <!-- <div class="info"> -->
            <h4 class="lead text-white" style="opacity: 0.8;">Welcome, <i><b><?= session('profil') ?></b></i></h4>
            <!-- </div> -->
        </div>

        <!-- Sidebar Menu -->
        <nav class=" mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (session('role') == 1 || session('role') == 2) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('home') ?>" class="nav-link <?= $title == 'Home' ? 'active' : '' ?>">
                            <i class="fas fa-home nav-icon"></i>
                            <p>Home</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('siswa') ?>" class="nav-link <?= $title == 'Siswa' ? 'active' : '' ?>">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Siswa</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('kriteria') ?>" class="nav-link <?= $title == 'Kriteria' ? 'active' : '' ?>">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Kriteria</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('alternatif') ?>" class="nav-link <?= $title == 'Alternatif' ? 'active' : '' ?>">
                            <i class="fas fa-arrows-alt nav-icon"></i>
                            <p>Alternatif</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('nilai_siswa') ?>" class="nav-link <?= $title == 'Nilai Siswa' ? 'active' : '' ?>">
                            <i class="fas fa-keyboard nav-icon"></i>
                            <p>Nilai Siswa</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('perhitungan') ?>" class="nav-link <?= $title == 'Perhitungan' ? 'active' : '' ?>">
                            <i class="fas fa-calculator nav-icon"></i>
                            <p>Perhitungan</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1 || session('role') == 2) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('kuis') ?>" class="nav-link <?= $title == 'Kuis' ? 'active' : '' ?>">
                            <i class="fas fa-question-circle nav-icon"></i>
                            <p>Kuis</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 2) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('hasil') ?>" class="nav-link <?= $title == 'Hasil' ? 'active' : '' ?>">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Hasil</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (session('role') == 1 || session('role') == 2) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('change_password') ?>" class="nav-link <?= $title == 'Change Password' ? 'active' : '' ?>">
                            <i class="fas fa-key nav-icon"></i>
                            <p>Password</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>