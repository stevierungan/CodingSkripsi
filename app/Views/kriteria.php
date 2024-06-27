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
                    <?php if (session()->getFlashdata('pesan1')) : ?>
                        <div class="alert alert-<?= session()->getFlashdata('pesan1')[1] ?> alert-dismissible fade show" role="alert" style="opacity: 0.9;">
                            <?= session()->getFlashdata('pesan1')[0] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('pesan2')) : ?>
                        <div class="alert alert-<?= session()->getFlashdata('pesan2')[1] ?> alert-dismissible fade show" role="alert" style="opacity: 0.9;">
                            <?= session()->getFlashdata('pesan2')[0] ?>
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
                                    <h3 class="card-title">Data Kriteria</h3>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Kriteria</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_kriteria as $k => $v) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $v['kode'] ?></td>
                                            <td><?= $v['nama'] ?></td>
                                            <td><?= $v['jenis'] ?></td>
                                            <td class="d-flex justify-content-center">
                                                <button type="button" class="mx-2 btn btn-warning btn-xs btn-edit" data-toggle="modal" data-target="#editModal" data-kode="<?= $v['kode'] ?>" data-nama="<?= $v['nama'] ?>" data-jenis="<?= $v['jenis'] ?>">
                                                    Ubah
                                                </button>
                                                <form action="kriteria/delete/<?= $v['kode'] ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Bobot Kriteria</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="20%">Pairwise Comparisons</th>
                                        <?php foreach ($data_kriteria as $k => $v) : ?>
                                            <th class="text-center"><?= $v['kode'] . '-' . $v['nama'] ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pairwise_comparison as $k => $v) : ?>
                                        <tr class="text-center">
                                            <th><?= $k . '-' . $pairwise_comparison[$k][$k]['nama'] ?></th>
                                            <?php foreach ($v as $k2 => $v2) : ?>
                                                <td>
                                                    <button type="button" class="btn btn-<?= $v2['nilai'] > 0 ? "success" : "danger" ?> btn-sm tambah-bobot" style='width:100%; height:100%; display:inline-block;' data-toggle="modal" data-target="#ubahBobotModal" data-bobotk1="<?= $k ?>" data-bobotk2="<?= $k2 ?>">
                                                        <?php if ($v2['nilai'] > 0) {
                                                            echo $v2['nilai'];
                                                        } else {
                                                            echo $v2['kode'];
                                                        } ?>
                                                    </button>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <th class="text-center">Jumlah</th>
                                        <?php foreach ($jumlah_pc as $k => $v) : ?>
                                            <td><?= array_sum($v) ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="<?= count($data_kriteria) + 1 ?>">
                                            Normalisasi
                                        </th>
                                        <th class="text-center">
                                            Jumlah
                                        </th>
                                        <th class="text-center">
                                            Bobot
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($normalisasi as $k => $v) : ?>
                                        <tr>
                                            <th class="text-center"><?= $k ?></th>
                                            <?php foreach ($v as $k2 => $v2) : ?>
                                                <td><?= $v2 ?></td>
                                            <?php endforeach; ?>
                                            <td><?= array_sum($v) ?></td>
                                            <td><?= array_sum($v) / 4 ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <hr>
                        <div class="card-body">
                            <table id="datatable" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="">Lamda Maks</th>
                                        <th class="text-center" width="">CI</th>
                                        <th class="text-center" width="">CR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td><?= $lamda_maks ?></td>
                                        <td><?= $ci ?></td>
                                        <td><?= $cr ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tambah Kriteria Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="kriteria/tambah">
                        <?= csrf_field(); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Tambah Kriteria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="kode">Kode</label>
                                    <input type="text" class="form-control" name="kode" id="kode" aria-describedby="kodeHelp" placeholder="Nomor Induk Kriteria">
                                    <!-- <small id="kodeHelp" class="form-text text-danger font-italic">kode hanya bisa berupa angka</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" aria-describedby="namaHelp" placeholder="Nama Kriteria">
                                </div>
                                <div class="form-group">
                                    <label for="jenisSelect">Jenis</label>
                                    <select class="form-control" name="jenis" id="jenisSelect">
                                        <option value="Kuis">Kuis</option>
                                        <option value="Non Kuis">Non Kuis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ubah Bobot Kriteria Modal -->
            <div class="modal fade" id="ubahBobotModal" tabindex="-1" aria-labelledby="ubahBobotModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="kriteria/ubah_bobot_kriteria">
                        <?= csrf_field(); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ubahBobotModalLabel">Bobot Kriteria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="bobotKriteria1">Kriteria 1</label>
                                    <input type="text" class="form-control" name="bobot_kriteria1" id="bobotKriteria1" aria-describedby="bobotKriteria1Help" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="bobotNilai">Nilai</label>
                                    <select class="form-control" name="bobot_nilai" id="bobotNilai">
                                        <option value="1">Sama Penting : 1</option>
                                        <option value="3">Sedikit Lebih Penting : 3</option>
                                        <option value="5">Lebih Penting : 5</option>
                                        <option value="7">Mutlak Lebih Penting : 7</option>
                                        <option value="9">Mutlak Penting : 9</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="bobotNilai">Nilai</label>
                                    <input type="number" class="form-control" name="bobot_nilai" id="bobotNilai" min="0" max="9" step="0.001" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="bobotKriteria2">Kriteria 2</label>
                                    <input type="text" class="form-control" name="bobot_kriteria2" id="bobotKriteria2" aria-describedby="bobotKriteria2Help" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="kriteria/edit">
                        <?= csrf_field(); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data Kriteria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit-kode">Kode</label>
                                    <input type="text" class="form-control" name="kode" id="edit-kode" aria-describedby="kodeHelp" placeholder="KODE Kriteria" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="edit-nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="edit-nama" aria-describedby="namaHelp" placeholder="Nama Kriteria">
                                </div>
                                <div class="form-group">
                                    <label for="edit-jenis">Jenis</label>
                                    <select class="form-control" name="jenis" id="edit-jenis">
                                        <option value="Kuis">Kuis</option>
                                        <option value="Non Kuis">Non Kuis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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

    $(".btn-edit").click(function() {
        var kode = $(this).data('kode')
        var nama = $(this).data('nama')
        var jenis = $(this).data('jenis')

        $('#edit-kode').val(kode)
        $('#edit-nama').val(nama)
        $('#edit-jenis').val(jenis)
    });

    $(".tambah-bobot").click(function() {
        var bobotKriteria1 = $(this).data('bobotk1')
        var bobotKriteria2 = $(this).data('bobotk2')

        $('#bobotKriteria1').val(bobotKriteria1)
        $('#bobotKriteria2').val(bobotKriteria2)
    });
</script>

<?= $this->endSection(); ?>