<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-12">
        <div class="box box-no-border">
            <div class="box-body d-flex justify-content-between align-items-center">
                <button type="button" class="btn-action-primary" data-toggle="modal" data-target="#add">
                    <i class="fa fa-plus"></i> Tambah User
                </button>
                <div id="custom-search"></div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar User</h3>
    </div>
    <div class="box-body">
        <?php if (session()->getFlashdata('pesan_user')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('pesan_user') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error_user')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('error_user') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <table id="tableUser" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Departemen</th>
                    <th>Level</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $levelNames = [
                    0 => 'Superadmin',
                    1 => 'Admin',
                    2 => 'User'
                ];
                ?>

                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($u['nama_user']) ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><?= esc($u['nama_dep']) ?></td>
                        <td><?= $levelNames[$u['level']] ?? 'Unknown' ?></td>
                        <td>
                            <?php if ($u['id_user'] != session()->get('id_user')): ?>
                                <button class="btn btn-warning btn-xs"
                                    data-toggle="modal"
                                    data-target="#editUser<?= $u['id_user'] ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <a href="<?= base_url('user/delete/' . $u['id_user']) ?>"
                                    class="btn btn-danger btn-xs"
                                    onclick="return confirm('Yakin hapus user <?= esc($u['nama_user']) ?> ?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('modal/modal_user_add') ?>
<?= $this->include('modal/modal_user_edit') ?>
<?php if (session()->getFlashdata('error_user')): ?>
    <script>
        $(document).ready(function() {
            $('#add').modal('show');
        });
    </script>
<?php endif; ?>
<script>
    $(document).ready(function() {
        const table = $('#tableUser').DataTable({
            pageLength: 100,
            language: {
                info: ""
            }
        });
        $("#tableUser_filter").appendTo("#custom-search");
    });
</script>

<?= $this->endSection() ?>