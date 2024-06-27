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
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-<?= session()->getFlashdata('pesan')[1] ?> alert-dismissible fade show" role="alert" style="opacity: 0.9;">
                            <?= session()->getFlashdata('pesan')[0] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12 bg-white">
                    <form method="post" action="kuis/kuis_jawaban_siswa">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <?php foreach ($kuis as $k => $v) : ?>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                                    <label class="col-form-label"><?= $v['soal'] ?></label><br>
                                    <?php foreach ($v['jawaban'] as $k2 => $v2) : ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="soal_<?= $v2['idSoal'] ?>" id="<?= $v2['id'] ?>" value="<?= $v2['kodeAlternatif'] ?>|<?= $v2['kodeKriteria'] ?>|<?= $v2['bobot'] ?>|<?= $v2['nama_alternatif'] ?>" required />
                                            <label class="form-check-label" for="<?= $v2['id'] ?>"><?= $v2['jawaban'] ?></label>
                                        </div><br>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mb-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<!-- Page specific script -->
<script>
    $(function() {
        $('#datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<?= $this->endSection(); ?>