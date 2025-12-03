<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <!-- HEADER -->
        <div class="box box-primary">
            <div class="box-body">
                <div class="tree-header">
                    <div>
                        <h3 style="margin: 0;"><i class="fa fa-folder-open"></i> Struktur Kategori</h3>
                    </div>
                </div>

                <!-- FLASH MESSAGES -->
                <?php if (session()->getFlashdata('pesan_kat')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('pesan_kat') ?>
                    </div>
                <?php endif; ?>
                <?php if ($errors = session()->getFlashdata('error_kat')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i>
                        <ul style="margin: 10px 0 0 0;">
                            <?php foreach ($errors as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- TREE VIEW -->
                <div class="tree-container">
                    <?php if (empty($kategoriList)): ?>
                        <div class="empty-state">
                            <i class="fa fa-folder-open-o"></i>
                            <h4>Belum ada kategori</h4>
                            <p>Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
                        </div>
                    <?php else: ?>
                        <?php
                        function renderTreeList($kategoriTree, $level = 0, $parentName = null, $departemen = [], $parentId = '')
                        {
                            static $counter = 0;

                            foreach ($kategoriTree as $item) {
                                $counter++;
                                $uniqueId = 'tree-' . $counter;
                                $hasChildren = !empty($item['children']);

                                echo '<div class="tree-item-wrapper">';
                                echo '<div class="tree-item-row level-' . $level . '">';
                                echo '<div class="tree-item-content">';

                                // Toggle arrow
                                if ($hasChildren) {
                                    echo '<span class="tree-toggle" data-target="' . $uniqueId . '">';
                                    echo '<i class="fa fa-chevron-right"></i>';
                                    echo '</span>';
                                } else {
                                    echo '<span class="tree-toggle no-children"></span>';
                                }

                                // Icon folder - semua sama
                                echo '<i class="fa fa-folder tree-icon"></i>';
                                echo '<span class="tree-item-name">' . esc($item['nama_kategori']) . '</span>';

                                echo '</div>';

                                echo '<div class="tree-actions">';

                                // Tombol Tambah Sub-Kategori
                                echo '<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalTambahSub" onclick="setParentKategori(' . $item['id_kategori'] . ', \'' . addslashes(esc($item['nama_kategori'])) . '\')" title="Tambah Sub-Kategori">';
                                echo '<i class="fa fa-plus"></i>';
                                echo '</button>';

                                // Tombol Edit
                                echo '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editKategori' . $item['id_kategori'] . '" title="Edit">';
                                echo '<i class="fa fa-edit"></i>';
                                echo '</button>';

                                // Tombol Hapus
                                echo '<a href="' . base_url('kategori/delete/' . $item['id_kategori']) . '" ';
                                echo 'class="btn btn-danger btn-xs" ';
                                echo 'onclick="return confirm(\'Yakin hapus kategori ' . esc($item['nama_kategori']) . '?\')" ';
                                echo 'title="Hapus">';
                                echo '<i class="fa fa-trash"></i>';
                                echo '</a>';
                                echo '</div>';

                                echo '</div>';

                                // Render children recursively with wrapper
                                if ($hasChildren) {
                                    echo '<div class="tree-children" id="' . $uniqueId . '">';
                                    renderTreeList($item['children'], $level + 1, $item['nama_kategori'], $departemen, $uniqueId);
                                    echo '</div>';
                                }

                                echo '</div>';
                            }
                        }

                        renderTreeList($kategoriTree, 0, null, $departemen);
                        ?>
                    <?php endif; ?>
                </div>

                <!-- INFO -->
                <div style="margin-top: 20px; padding: 15px; background: #f0f8ff; border-left: 4px solid #3c8dbc; border-radius: 4px; display: none;">
                    <h5 style="margin: 0 0 10px 0;"><i class="fa fa-info-circle"></i> Informasi</h5>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><strong>Kategori Level 0</strong> = Kategori utama (root)</li>
                        <li><strong>Indentasi ke kanan</strong> = Menunjukkan sub-kategori</li>
                        <li><strong>Klik panah (▶)</strong> = Expand/collapse sub-kategori</li>
                        <li><strong>Tombol hijau (+)</strong> = Tambah sub-kategori di dalam folder</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SUB-KATEGORI -->
<div class="modal fade" id="modalTambahSub">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Sub-Kategori</h4>
            </div>
            <form action="<?= base_url('kategori/add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Parent Kategori:</strong>
                        <span id="parent_display_text">-</span>
                    </div>

                    <div class="form-group">
                        <label for="nama_kategori_modal"><i class="fa fa-tag"></i> Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori_modal" class="form-control" required placeholder="Masukkan nama kategori...">
                    </div>

                    <?php if (session()->get('level') == '0'): ?>
                        <div class="form-group">
                            <label for="id_dep_modal"><i class="fa fa-building"></i> Departemen</label>
                            <select name="id_dep" id="id_dep_modal" class="form-control" required>
                                <option value="">-- Pilih Departemen --</option>
                                <?php foreach ($departemen as $d): ?>
                                    <option value="<?= $d['id_dep'] ?>"><?= esc($d['nama_dep']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="id_dep" value="<?= session()->get('id_dep') ?>">
                    <?php endif; ?>

                    <!-- Hidden input untuk parent_id -->
                    <input type="hidden" name="parent_id" id="parent_id_modal" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Flatten kategori tree for edit modals
function flattenKategori($tree)
{
    $flat = [];
    foreach ($tree as $k) {
        $flat[] = $k;
        if (!empty($k['children']) && is_array($k['children'])) {
            $flat = array_merge($flat, flattenKategori($k['children']));
        }
    }
    return $flat;
}
$kategori = flattenKategori($kategoriTree);
?>

<?= view('modal/modal_kategori_edit', [
    'kategori' => $kategori,
    'departemen' => $departemen,
    'kategoriTree' => $kategoriTree
]) ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('template/custom/css/kategori.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const BASE_URL = "<?= base_url(); ?>";
</script>
<script src="<?= base_url('template/custom/js/kategori.js') ?>"></script>
<?= $this->endSection() ?>


<?= $this->endSection() ?>