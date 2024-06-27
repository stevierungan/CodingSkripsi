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
                                    <h3 class="card-title">Data Nilai</h3>
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
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_siswa as $k => $v) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $v['nis'] ?></td>
                                            <td><?= $v['nama'] ?></td>
                                            <td class="d-flex justify-content-center">
                                                <button type="button" class="mx-2 btn btn-warning btn-xs btn-detail" data-toggle="modal" data-target="#detailModal" data-nis="<?= $v['nis'] ?>">
                                                    Ubah Nilai
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

            <!-- Ubah Nilai Modal -->
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Ubah Nilai
                                <!-- - <span class="badge badge-info" id="id-span"></span> -->
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="nilai_siswa/ubah_nilai">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <table class="table table-bordered" id="table-nilai">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                <button type="submit" class="btn btn-primary">Ubah Nilai</button>
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

    $(".btn-detail").click(function() {
        var nis = $(this).data('nis')

        $.ajax({
            url: "nilai_siswa/detail",
            type: 'POST',
            dataType: 'json',
            data: {
                nis: nis
            },
            success: function(result) {
                $("#table-nilai thead tr").remove()
                var obj = Object.keys(result);

                console.log(result)
                // console.log(obj)
                // console.log(result[obj[0]])

                $("#table-nilai thead").append(`
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kriteria</th>
                        <th colspan="4" style="vertical-align : middle;text-align:center;">Alternatif</th>
                    </tr>
                    <tr id="alternatif-header" class="text-center"></tr>
                `)

                jQuery.each(result, function(index, val) {
                    $("#table-nilai thead").append(`
                        <tr id="kategori-header${index}" class="text-center">
                            <th style="vertical-align : middle;text-align:center;">${index}</th>
                        </tr>
                    `)

                    // console.log(result)

                    jQuery.each(result[index], function(index2, val2) {
                        val2 == null ? val2 = {
                            'nilai': 0,
                            'nis': nis

                        } : val2['nilai'] = parseInt(val2['nilai'])

                        var btnWarna;
                        var jenis_kriteria;

                        val2['nilai'] > 0 ? btnWarna = 'success' : btnWarna = 'danger'
                        // val2['jenis_kriteria'] == 'Kuis' ? jenis_kriteria = 'disabled readonly' : jenis_kriteria = ''

                        $("#kategori-header" + index).append(`
                            <td>
                                <input name="nis" type="hidden" class="form-control" value="${val2['nis']}">
                                <div class="form-group">
                                    <input name="${index}/${index2}" type="number" class="form-control text-center bg-${btnWarna}" id="nilaiAkhir" aria-describedby="nilaiAkhirHelp" min="0" max="100" step="1" value="${val2['nilai']}"${jenis_kriteria}>
                                    <small>${val2['nama_kriteria']}- ${val2['nama_alternatif']}</small>
                                </div>
                            </td>
                        `)
                    })
                });

                jQuery.each(result[obj[0]], function(index, val) {
                    $("#alternatif-header").append(`
                        <th>` + index + `</th>
                    `)
                });
            },
            error: function(e) {
                console.error(e);
            }
        });
    });

    // $(".btn-edit").click(function() {
    //     var kode = $(this).data('kode')
    //     var nama = $(this).data('nama')
    //     var jenis = $(this).data('jenis')

    //     $('#edit-kode').val(kode)
    //     $('#edit-nama').val(nama)
    //     $('#edit-jenis').val(jenis)
    // });
</script>

<?= $this->endSection(); ?>