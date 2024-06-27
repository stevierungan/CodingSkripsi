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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <?php foreach ($data_siswa[session('username')] as $k => $v) : ?>
                                            <th>
                                                <?= $k == 'A01' ? 'MIPA' : ($k == 'A02' ? 'IPS' : 'BAHASA') ?>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        $i = 0;
                                        $ds = $data_siswa[session('username')]; foreach($ds as $k => $v) : ?>
                                            <?php $i++; ?>
                                            <td class="<?= $i == 1 ? 'bg-success' : ($i == 2 ? 'bg-warning' : 'bg-danger') ?>">
                                                <?= $v ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <h3 class="text-center text-bold">Selamat <i><?= session('profil') ?></i> anda Lulus di Jurusan <?= array_key_first($data_siswa[session('username')]) == 'A01' ? 'MIPA' : ($k == 'A02' ? 'IPS' : 'BAHASA') ?>!</h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                </div>
                <!-- <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <?php foreach ($data_alternatif as $key => $value) : ?>
                                <h1><?= $value['kodeAlternatif'] . ': ' . $value['nama'] ?></h1>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <?php $y = 1;
                        foreach ($data_siswa as $k => $v) : ?>
                            <div class="card-body text-center">
                                <?php arsort($v);
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
                                    <h1>
                                        <?= $k2 ?> <span class="badge badge-<?= $color ?>"><?= $v2 ?></span>
                                    </h1>
                                <?php $y++;
                                endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div> -->
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