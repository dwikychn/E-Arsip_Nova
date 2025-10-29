<?php
if (!function_exists('renderOptionsModalEdit')) {
    function renderOptionsModalEdit($kategori, $excludeIds = [], $prefix = '', $currentId = null)
    {
        if (!is_array($kategori)) return;
        if (!is_array($excludeIds)) $excludeIds = [];

        foreach ($kategori as $row) {
            // Hindari parent diri sendiri
            if (in_array($row['id_kategori'], $excludeIds) || $row['id_kategori'] == $currentId) continue;

            // Selected jika parent-nya sama
            $selected = ($row['id_kategori'] == $currentId) ? 'selected' : '';

            echo '<option value="' . $row['id_kategori'] . '" ' . $selected . '>'
                . $prefix . esc($row['nama_kategori'])
                . '</option>';

            // Rekursif untuk anak-anak kategori
            if (!empty($row['children']) && is_array($row['children'])) {
                $newExclude = array_merge($excludeIds, [$row['id_kategori']]);
                renderOptionsModalEdit($row['children'], $newExclude, $prefix . '— ', $currentId);
            }
        }
    }
}
?>

<?php foreach ($kategori as $k): ?>
    <div class="modal fade" id="editKategori<?= $k['id_kategori'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <?= form_open('kategori/update/' . $k['id_kategori']) ?>

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                            value="<?= esc($k['nama_kategori']) ?>"
                            class="form-control" required>
                    </div>

                    <?php if (session()->get('level') == '0'): ?>
                        <div class="form-group">
                            <label>Departemen</label>
                            <select name="id_dep" class="form-control" required>
                                <?php foreach ($departemen as $d): ?>
                                    <option value="<?= $d['id_dep'] ?>"
                                        <?= $d['id_dep'] == $k['id_dep'] ? 'selected' : '' ?>>
                                        <?= esc($d['nama_dep']) ?>
                                    </option>
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
                            <?php renderOptionsModalEdit($kategoriTree ?? [], [], '', $k['parent_id'] ?? null); ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>