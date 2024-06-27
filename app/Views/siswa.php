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
                                    <h3 class="card-title">Data Siswa</h3>
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
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Asal Sekolah</th>
                                        <th>Email</th>
                                        <!-- <th>Jurusan</th> -->
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
                                            <td><?= $v['jenis_kelamin'] ?></td>
                                            <td><?= $v['asal_sekolah'] ?></td>
                                            <td><?= $v['email'] ?></td>
                                            <!-- <td>
                                                <php
                                                if ($i % 2 == 0) {
                                                    echo "<span class='badge badge-span badge-success'>MIPA</span>";
                                                } else {
                                                    echo "<span class='badge badge-span badge-danger'>belum mengisi kuis</span>";
                                                } ?>
                                            </td> -->
                                            <td class="d-flex justify-content-center">
                                                <!-- <a class="mx-2 btn btn-info btn-xs" href="<= base_url('siswa/detail/' . $v['nis']) ?>">
                                                    Detail
                                                </a> -->
                                                <button type="button" class="mx-2 btn btn-warning btn-xs btn-edit" data-toggle="modal" data-target="#editModal" data-nis="<?= $v['nis'] ?>" data-nama="<?= $v['nama'] ?>" data-jeniskelamin="<?= $v['jenis_kelamin'] ?>" data-asalsekolah="<?= $v['asal_sekolah'] ?>" data-email="<?= $v['email'] ?>">
                                                    Ubah
                                                </button>
                                                <form action="siswa/delete/<?= $v['nis'] ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</button>
                                                </form>
                                                <!-- <a class="mx-2 btn btn-danger btn-xs" href="<= base_url('siswa/delete/' . $v['nis']) ?>">
                                                    Hapus
                                                </a> -->
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
            </div>
            <!-- /.row -->

            <!-- Tambah Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="siswa/tambah">
                        <?= csrf_field(); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Tambah Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" name="nis" id="nis" aria-describedby="nisHelp" placeholder="Nomor Induk Siswa">
                                    <!-- <small id="nisHelp" class="form-text text-danger font-italic">NIS hanya bisa berupa angka</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" aria-describedby="namaHelp" placeholder="Nama Lengkap">
                                </div>
                                <div class="form-group">
                                    <label for="jenisKelaminSelect">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" id="jenisKelaminSelect">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="asalSekolah">Asal Sekolah</label>
                                    <input type="text" class="form-control" name="asal_sekolah" id="asalSekolah" aria-describedby="asalSekolahHelp" placeholder="Sekolah Menengah Pertama">
                                </div>
                                <div class="form-group">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
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
                    <form method="post" action="siswa/edit">
                        <?= csrf_field(); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit-nis">NIS</label>
                                    <input type="text" class="form-control" name="nis" id="edit-nis" aria-describedby="nisHelp" placeholder="Nomor Induk Siswa" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="edit-nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="edit-nama" aria-describedby="namaHelp" placeholder="Nama Lengkap">
                                </div>
                                <div class="form-group">
                                    <label for="edit-jenisKelamin">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" id="edit-jenisKelamin">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit-asalSekolah">Asal Sekolah</label>
                                    <input type="text" class="form-control" name="asal_sekolah" id="edit-asalSekolah" aria-describedby="asalSekolahHelp" placeholder="Sekolah Menengah Pertama">
                                </div>
                                <div class="form-group">
                                    <label for="edit-email">Alamat Email</label>
                                    <input type="email" class="form-control" name="email" id="edit-email" placeholder="name@example.com">
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
        var nis = $(this).data('nis')
        var nama = $(this).data('nama')
        var jenis_kelamin = $(this).data('jeniskelamin')
        var asal_sekolah = $(this).data('asalsekolah')
        var email = $(this).data('email')

        $('#edit-nis').val(nis)
        $('#edit-nama').val(nama)
        $('#edit-jenisKelamin').val(jenis_kelamin)
        $('#edit-asalSekolah').val(asal_sekolah)
        $('#edit-email').val(email)
    });
</script>

<?= $this->endSection(); ?>