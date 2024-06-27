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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Data Rank Siswa</h3>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 1;
                                    foreach ($data_siswa as $k => $v) : ?>
                                        <tr>
                                            <td class="text-center"><?= $x ?></td>
                                            <td class="text-center"><?= $k ?></td>
                                            <td class="text-center">
                                                <?php ?>
                                                <?php
                                                $y = 1;
                                                arsort($v);
                                                foreach ($v as $k2 => $v2) : ?>
                                                    <?php switch ($y) {
                                                        case 1:
                                                            $color = 'success';
                                                            break;


                                                        case 2:
                                                            $color = 'warning';
                                                            break;


                                                        default:
                                                            $color = 'danger';
                                                            break;
                                                    } ?>
                                                    <h6>
                                                        <?= $y . '. ' . $k2 ?> <span class="badge badge-<?= $color ?>"><?= $v2 ?></span>
                                                    </h6>
                                                <?php $y++;
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                    <?php $x++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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