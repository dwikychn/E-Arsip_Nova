<div class="modal fade" id="modalAddKategori" tabindex="-1" aria-labelledby="modalAddKategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <h4 class="modal-title">Tambah Kategori</h4>
            </div>
            <form action="<?= base_url('kategori/add') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>

                    <?php if (session()->get('level') == '0'): ?>
                        <div class="form-group">
                            <label>Pilih Departemen</label>
                            <select name="id_dep" class="form-control" required>
                                <option value="">-- Pilih Departemen --</option>
                                <?php foreach ($departemen as $d): ?>
                                    <option value="<?= $d['id_dep'] ?>"><?= esc($d['nama_dep']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="id_dep" value="<?= session()->get('id_dep') ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Parent Kategori</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Kategori Utama --</option>
                            <?php
                            function renderOptionsAdd($kategori, $prefix = '')
                            {
                                if (!is_array($kategori)) return;
                                foreach ($kategori as $row) {
                                    echo '<option value="' . $row['id_kategori'] . '">' . $prefix . esc($row['nama_kategori']) . '</option>';
                                    if (!empty($row['children'])) {
                                        renderOptionsAdd($row['children'], $prefix . '— ');
                                    }
                                }
                            }
                            renderOptionsAdd($kategoriTree ?? []);
                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>