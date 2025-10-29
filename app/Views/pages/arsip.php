<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- TOMBOL TAMBAH ARSIP -->
<div class="box box-no-border">
    <?php if (session()->getFlashdata('error_upload')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error_upload') ?>
        </div>
    <?php endif; ?>
    <?php if ($errors = session()->getFlashdata('error_arsip')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php if (is_array($errors)): ?>
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><?= esc($errors) ?></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="box box-no-border">
        <div class="box-body">
            <button type="button" class="btn-action-primary" data-toggle="modal" data-target="#modalAddArsip">
                <i class="fa fa-plus"></i> Tambah Arsip
            </button>
        </div>
    </div>
    <input type="file" id="inputFileArsip" multiple style="display:none;">
</div>

<!-- TABEL DAFTAR ARSIP -->
<div class="box box-primary spacer">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Arsip</h3>
    </div>
    <div class="box-body">
        <?php if (session()->getFlashdata('pesan_arsip')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('pesan_arsip') ?></div>
        <?php endif; ?>

        <form id="formHapusMultiple" method="post" action="<?= base_url('arsip/hapus_multiple') ?>">
            <?= csrf_field() ?>

            <table id="tableArsip" class="table table-bordered table-striped" style="margin-top:10px;">
                <thead>
                    <tr>
                        <th width="30px"><input type="checkbox" id="selectAll"></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Klasifikasi</th>
                        <th>User</th>
                        <th>Tgl. Upload</th>
                        <th>Tgl. Update</th>
                        <th>Ukuran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($arsip as $a): ?>
                        <tr>
                            <td><input type="checkbox" class="checkboxArsip" name="id_arsip[]" value="<?= $a['id_arsip'] ?>"></td>
                            <td><?= $no++ ?></td>
                            <td>
                                <a href="#" class="preview-link text-primary"
                                    data-file="<?= base_url('uploads/' . $a['nama_dep'] . '/' . $a['file_arsip']) ?>"
                                    data-nama="<?= esc($a['file_arsip']) ?>">
                                    <?= esc($a['file_arsip']) ?>
                                </a>
                            </td>

                            <td><?= esc($a['nama_kategori']) ?></td>
                            <td>
                                <?php if ($a['klasifikasi'] === 'umum'): ?>
                                    <span class="label label-success">U</span>
                                <?php elseif ($a['klasifikasi'] === 'terbatas'): ?>
                                    <span class="label label-warning">T</span>
                                <?php elseif ($a['klasifikasi'] === 'rahasia'): ?>
                                    <span class="label label-danger">R</span>
                                <?php else: ?>
                                    <span class="label label-default">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $displayName = $a['nama_user'] ?? null;
                                if (empty($displayName) && !empty($a['nama_user_upload'])) {
                                    $displayName = $a['nama_user_upload'] . ' (User Dihapus)';
                                }
                                ?>
                                <?php if (strpos($displayName ?? '', '(User Dihapus)') !== false): ?>
                                    <span style="color: gray; font-style: italic;">
                                        <?= esc($displayName) ?>
                                    </span>
                                <?php else: ?>
                                    <?= esc($displayName ?? '-') ?>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($a['tgl_upload']) ?></td>
                            <td><?= $a['tgl_update'] ? esc($a['tgl_update']) : '-' ?></td>
                            <td><?= formatSize($a['ukuran_arsip']); ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateArsip<?= $a['id_arsip'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="<?= base_url('arsip/deleteArsip/' . $a['id_arsip']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus arsip ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hapus-terpilih-bawah text-right" id="hapusContainer" style="display:none;">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const BASE_URL = "<?= base_url() ?>";
    const kategoriList = <?= json_encode($kategori) ?>;
    const departemenList = <?= json_encode($departemen) ?>;
</script>

<?= $this->include('modal/modal_arsip_add') ?>
<?= $this->include('modal/modal_cari_preview') ?>
<?= $this->include('modal/modal_arsip_edit') ?>
<?= $this->endSection() ?>