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
        <div class="container text-center">
            <div class="col">
                <h1 class="display-4">Selamat Datang!</h1>
                <h4 class="lead"> Di Sistem Pendukung Keputusan Pemilihan Jurusan <b>SMA Negeri 1 Tenga</b></h4>
                <hr class="my-5">
                <div id="carouselExampleInterval" class="carousel slide carousel-fade mt-3" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="2000">
                            <img src="<?= base_url('assets/cv_1.jpeg') ?>" height="400" class="d-block w-100" alt="image 1">
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <img src="<?= base_url('assets/cv_2.jpeg') ?>" height="400" class="d-block w-100" alt="image 2">
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <img src="<?= base_url('assets/cv_3.jpeg') ?>" height="400" class="d-block w-100" alt="image 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleInterval" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleInterval" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
                <!-- </div>
            <div class="col"> -->
                <div class="jumbotron mt-5">
                    <div class="row d-flex justify-content-between">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h1 class="display-6">VISI</h1>
                            <hr class="my-2">
                            <p class="lead">Mewujudkan warga sekolah berkarakter, cerdas dan unggul dalam prestasi serta berwawasan lingkungan.</p>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h1 class="display-6">MISI</h1>
                            <hr class="my-2">
                            <p class="lead">- Mendidik dan  membentuk peserta didik berkarakter yaitu religious, nasionalis, berintegritas, gotong royong dan mandiri.
<br> - Membina peserta untuk cerdas spiritual, cerdas intelektual, cerdas sosial dan cerdas emosional.
<br> - Unggul dalam prestasi, kritis berpikir dan tepat bertindak, kreatif, inovatif dalam ilmu dan teknologi.
<br> - Menciptakan lingkungan yang sehat, aman, nyaman dan tertib, serta membuktikan rasa cinta tanah air
</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>