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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Data Kuis</h3>
                                </div>
                                <!-- <div class="col-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah</button>
                                </div> -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Jawaban</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_kuis['soal'] as $k => $v) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $v['soal'] ?></td>
                                            <td>
                                                <ol type="a">
                                                    <?php foreach ($data_kuis['jawaban'][$v['id']] as $k2 => $v2) : ?>
                                                        <li>
                                                            <?= $v2['jawaban'] ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ol>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <button type="button" class="mx-2 btn btn-warning btn-xs btn-edit" data-toggle="modal" data-target="#editModal" data-idsoal="<?= $v['id'] ?>">
                                                    Ubah
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tambah Kuis Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">
                                Ubah Kuis
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="kuis/tambah_kuis">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ubah Kuis Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Ubah Kuis
                                <!-- - <span class="badge badge-info" id="id-span"></span> -->
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="kuis/edit_kuis">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div id="form-edit-kuis"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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

    $(".btn-edit").click(function() {
        var id_soal = $(this).data('idsoal')

        $.ajax({
            url: "kuis/get_soal_ajax",
            type: 'POST',
            dataType: 'json',
            data: {
                id_soal: id_soal
            },
            success: function(result) {
                $('#editModal form #form-edit-kuis').children().remove()

                $('#form-edit-kuis').append(`
                        <h3 class="text-center">Soal</h3>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id_soal" value="${result[0].idSoal}">
                            <label>Kriteria-${result[0].nama_kriteria}</label>
                            <input type="text" class="form-control" name="soal" value="${result[0].soal}">
                        </div>
                    `)

                $('#form-edit-kuis').append(`<h3 class="text-center mt-5">Jawaban</h3>`)

                result.forEach(
                    func_li_edit
                )

                function func_li_edit(item, index, arr) {
                    console.log(item)
                    $('#form-edit-kuis').append(`
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="jawaban[${index}][id]" value="${item.id}">
                            <label>Alternatif-${item.nama_alternatif ? item.nama_alternatif : 'SEMUA'}</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control" name="jawaban[${index}][jawaban]" value="${item.jawaban}">
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" name="jawaban[${index}][bobot]" value="${item.bobot}" min="0" max="100">
                                    <small class="form-text">Bobot nilai</small>
                                </div>
                            </div>
                        </div>
                    `)
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    })
</script>

<?= $this->endSection(); ?>