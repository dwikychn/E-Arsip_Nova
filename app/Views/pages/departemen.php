<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-no-border">
            <div class="box-body">
                <button type="button" class="btn-action-primary" data-toggle="modal" data-target="#addDep">
                    <i class="fa fa-plus"></i> Tambah Departemen
                </button>
            </div>
        </div>
        <div id="custom-search">
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Departemen</h3>
            </div>

            <div class="box-body">

                <!-- ✅ Pesan Sukses -->
                <?php if (session()->getFlashdata('pesan_dep')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('pesan_dep') ?>
                    </div>
                <?php endif; ?>

                <!-- ⚠️ Pesan Error -->
                <?php if (session()->getFlashdata('error_dep')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('error_dep') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- 📋 Tabel Daftar Departemen -->
                <table id="tableDep" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Departemen</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($departemen as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($d['nama_dep']) ?></td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button
                                        class="btn btn-warning btn-xs"
                                        data-toggle="modal"
                                        data-target="#editDep<?= $d['id_dep'] ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <a
                                        href="<?= base_url('departemen/delete/' . $d['id_dep']) ?>"
                                        class="btn btn-danger btn-xs"
                                        onclick="return confirm('Yakin hapus Departemen <?= esc($d['nama_dep']) ?> ?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit Departemen -->
                            <?= view('modal/modal_dep_edit', ['d' => $d]) ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ========================= -->
<!-- 🔹 Modal Tambah Departemen -->
<!-- ========================= -->
<?= $this->include('modal/modal_dep_add') ?>

<!-- ========================= -->
<!-- 🔹 Script JavaScript -->
<!-- ========================= -->
<?php if (session()->getFlashdata('error_dep')): ?>
    <script>
        $(document).ready(function() {
            $('#addDep').modal('show');
        });
    </script>
<?php endif; ?>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        const table = $('#tableDep').DataTable({
            pageLength: 100,
            language: {
                info: ""
            }
        });

        // Pindahkan kolom search ke toolbar kanan
        $("#tableDep_filter").appendTo("#custom-search");
    });
</script>

<?= $this->endSection() ?>