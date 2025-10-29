<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- ALERT & TOMBOL TAMBAH -->
<div class="box box-no-border">
    <?php if (session()->getFlashdata('error_upload')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error_upload') ?>
        </div>
    <?php endif; ?>

    <?php if ($errors = session()->getFlashdata('error_arsip')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
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

    <div class="box-body">
        <button type="button" class="btn-action-primary" data-toggle="modal" data-target="#modalAddArsip">
            <i class="fa fa-plus"></i> Tambah Arsip
        </button>
    </div>
</div>

<!-- TABEL DAFTAR ARSIP -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Arsip</h3>
    </div>
    <div class="box-body">
        <?php if (session()->getFlashdata('pesan_arsip')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session()->getFlashdata('pesan_arsip') ?>
            </div>
        <?php endif; ?>

        <form id="formHapusMultiple" method="post" action="<?= base_url('arsip/hapus_multiple') ?>">
            <?= csrf_field() ?>

            <div class="table-responsive">
                <table id="tableArsip" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" id="selectAll"></th>
                            <th width="40">No</th>
                            <th>Nama File</th>
                            <th>Kategori</th>
                            <th width="80">Klasifikasi</th>
                            <th>User Upload</th>
                            <th>Tgl. Upload</th>
                            <th>Tgl. Update</th>
                            <th width="80">Ukuran</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($arsip)): ?>
                            <?php $no = 1;
                            foreach ($arsip as $a): ?>
                                <tr>
                                    <td><input type="checkbox" class="checkboxArsip" name="id_arsip[]" value="<?= $a['id_arsip'] ?>"></td>
                                    <td><?= $no++ ?>.</td>
                                    <td>
                                        <a href="#" class="preview-link text-primary"
                                            data-file="<?= base_url('uploads/' . $a['nama_dep'] . '/' . $a['file_arsip']) ?>"
                                            data-nama="<?= esc($a['file_arsip']) ?>">
                                            <?= esc($a['file_arsip']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($a['nama_kategori']) ?></td>
                                    <td>
                                        <?php
                                        $klasifikasi = [
                                            'umum' => ['label' => 'success', 'text' => 'U'],
                                            'terbatas' => ['label' => 'warning', 'text' => 'T'],
                                            'rahasia' => ['label' => 'danger', 'text' => 'R']
                                        ];
                                        $k = $klasifikasi[$a['klasifikasi']] ?? ['label' => 'default', 'text' => '-'];
                                        ?>
                                        <span class="label label-<?= $k['label'] ?>"><?= $k['text'] ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $displayName = $a['nama_user'] ?? $a['nama_user_upload'] ?? '-';
                                        $isDeleted = empty($a['nama_user']) && !empty($a['nama_user_upload']);
                                        ?>
                                        <?php if ($isDeleted): ?>
                                            <span class="text-muted">
                                                <i><?= esc($displayName) ?> (Dihapus)</i>
                                            </span>
                                        <?php else: ?>
                                            <?= esc($displayName) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($a['tgl_upload']) ?></td>
                                    <td><?= $a['tgl_update'] ? esc($a['tgl_update']) : '-' ?></td>
                                    <td><?= formatSize($a['ukuran_arsip']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-toggle="modal"
                                            data-target="#updateArsip<?= $a['id_arsip'] ?>"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('arsip/deleteArsip/' . $a['id_arsip']) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus arsip ini?')"
                                            title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data arsip</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="hapusContainer" class="text-right" style="display:none; margin-top: 15px;">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus semua arsip yang dipilih?')">
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