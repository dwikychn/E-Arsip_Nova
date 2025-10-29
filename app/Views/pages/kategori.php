<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12">

        <!-- TOMBOL TAMBAH KATEGORI -->
        <div class="box box-no-border">
            <div class="box-body">
                <button type="button" class="btn-action-primary" id="btnTambahKategori">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </button>
            </div>
        </div>

        <!-- FORM TAMBAH KATEGORI -->
        <div class="box box-primary" id="formTambahKategori" style="display: none;">
            <div class="box-body">
                <form action="<?= base_url('kategori/add') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent Kategori</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">-- Kategori Utama --</option>
                            <?php
                            function renderOptions($kategori, $prefix = '')
                            {
                                foreach ($kategori as $row) {
                                    echo '<option value="' . $row['id_kategori'] . '">' . $prefix . esc($row['nama_kategori']) . '</option>';
                                    if (!empty($row['children']) && is_array($row['children'])) {
                                        renderOptions($row['children'], $prefix . '— ');
                                    }
                                }
                            }
                            if (!empty($kategoriTree)) {
                                renderOptions($kategoriTree);
                            }
                            ?>
                        </select>
                    </div>

                    <?php if (session()->get('level') == '0'): ?>
                        <div class="form-group">
                            <label for="id_dep">Departemen</label>
                            <select name="id_dep" id="id_dep" class="form-control" required>
                                <option value="">-- Pilih Departemen --</option>
                                <?php foreach ($departemen as $d): ?>
                                    <option value="<?= $d['id_dep'] ?>"><?= esc($d['nama_dep']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="id_dep" value="<?= session()->get('id_dep') ?>">
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <!-- END FORM -->

        <!-- TABEL KATEGORI -->
        <div class="box box-primary spacer">
            <div class="box-header with-border">
                <h3 class="box-title">Data Kategori</h3>
            </div>
            <div class="box-body">
                <?php if (session()->getFlashdata('pesan_kat')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('pesan_kat') ?></div>
                <?php endif; ?>
                <?php if ($errors = session()->getFlashdata('error_kat')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="formHapusMultipleKat" method="post" action="<?= base_url('kategori/hapus_multiple') ?>">
                    <?= csrf_field() ?>

                    <table id="tableKat" class="table table-bordered table-striped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th width="30px"><input type="checkbox" id="selectAllKat"></th>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Parent Kategori</th>
                                <?php if (session()->get('level') == '0'): ?>
                                    <th>Departemen</th>
                                <?php endif; ?>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($kategoriList as $row): ?>
                                <tr>
                                    <td><input type="checkbox" class="checkboxKat" name="id_kategori[]" value="<?= $row['id_kategori'] ?>"></td>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['nama_kategori']) ?></td>
                                    <td><?= esc($row['parent_nama'] ?? '-') ?></td>
                                    <?php if (session()->get('level') == '0'): ?>
                                        <td><?= esc($row['nama_dep'] ?? '-') ?></td>
                                    <?php endif; ?>
                                    <td>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editKategori<?= $row['id_kategori'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                        <a href="<?= base_url('kategori/delete/' . $row['id_kategori']) ?>"
                                            class="btn btn-danger btn-xs"
                                            onclick="return confirm('Yakin hapus Kategori <?= esc($row['nama_kategori']) ?> ?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Tombol hapus multiple muncul saat ada checkbox terpilih -->
                    <div class="hapus-terpilih-bawah text-right" id="hapusContainerKat" style="display:none;">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori terpilih?')">
                            <i class="fa fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END TABEL -->
    </div>
</div>

<script>
    // === TAMPIL/SEMBUNYIKAN FORM TAMBAH KATEGORI ===
    document.getElementById('btnTambahKategori').addEventListener('click', function() {
        const form = document.getElementById('formTambahKategori');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });

    // === HANDLE CHECKBOX SELECT ALL DAN TAMPILKAN TOMBOL HAPUS ===
    const selectAllKat = document.getElementById('selectAllKat');
    const checkboxKat = document.querySelectorAll('.checkboxKat');
    const hapusContainerKat = document.getElementById('hapusContainerKat');

    selectAllKat.addEventListener('change', function() {
        checkboxKat.forEach(cb => cb.checked = this.checked);
        toggleHapusButton();
    });

    checkboxKat.forEach(cb => {
        cb.addEventListener('change', toggleHapusButton);
    });

    function toggleHapusButton() {
        const adaTerpilih = Array.from(checkboxKat).some(cb => cb.checked);
        hapusContainerKat.style.display = adaTerpilih ? 'block' : 'none';
    }
</script>

<?php
// Flatten kategori tree
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

<?= $this->endSection() ?>
