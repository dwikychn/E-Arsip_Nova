<?php foreach ($arsip as $a): ?>
    <div class="modal fade" id="updateArsip<?= $a['id_arsip'] ?>" tabindex="-1" aria-labelledby="updateArsipLabel<?= $a['id_arsip'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formEditArsip<?= $a['id_arsip'] ?>" action="<?= base_url('arsip/updateArsip/' . $a['id_arsip']) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="updateArsipLabel<?= $a['id_arsip'] ?>">Edit Arsip</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="arsip-item p-3" data-id="<?= $a['id_arsip'] ?>">

                            <!-- Info Dasar Arsip -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="id_kategori" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $k): ?>
                                            <option value="<?= $k['id_kategori'] ?>" <?= $a['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                                <?= esc($k['nama_kategori']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Klasifikasi <span class="text-danger">*</span></label>
                                    <select name="klasifikasi" class="form-control klasifikasi-select" required>
                                        <option value="">-- Pilih Klasifikasi --</option>
                                        <option value="umum" <?= strtolower($a['klasifikasi']) == 'umum' ? 'selected' : '' ?>>Umum</option>
                                        <option value="terbatas" <?= strtolower($a['klasifikasi']) == 'terbatas' ? 'selected' : '' ?>>Terbatas</option>
                                        <option value="rahasia" <?= strtolower($a['klasifikasi']) == 'rahasia' ? 'selected' : '' ?>>Rahasia</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Ganti File</label>
                                    <input type="file" name="file_arsip" class="form-control-file">
                                    <small class="form-text text-muted text-truncate d-block" style="max-width: 100%;">
                                        File: <strong><?= esc($a['file_arsip']) ?></strong>
                                    </small>
                                </div>
                            </div>

                            <!-- Departemen (Level 0 Only) -->
                            <?php if (session()->get('level') == 0): ?>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Departemen <span class="text-danger">*</span></label>
                                        <select name="id_dep" class="form-control" required>
                                            <option value="">-- Pilih Departemen --</option>
                                            <?php foreach ($departemen as $d): ?>
                                                <option value="<?= $d['id_dep'] ?>" <?= $a['id_dep'] == $d['id_dep'] ? 'selected' : '' ?>>
                                                    <?= esc($d['nama_dep']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Akses User Global (Lintas Departemen) -->
                            <div class="akses-user-global mt-3 pt-3 border-top" style="<?= strtolower($a['klasifikasi']) == 'terbatas' ? '' : 'display:none;' ?>">
                                <label class="font-weight-bold">Akses User Spesifik (Lintas Departemen)</label>
                                <select name="akses_user_global[]" class="form-control user-global-select" multiple size="6">
                                    <?php
                                    $selectedUserGlobal = $a['akses_user_global'] ?? [];
                                    foreach ($users as $u):
                                    ?>
                                        <option value="<?= $u['id_user'] ?>" <?= in_array($u['id_user'], $selectedUserGlobal) ? 'selected' : '' ?>>
                                            <?= esc($u['nama_user']) ?> (<?= esc($u['nama_dep']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-muted">
                                    Pilih user tertentu tanpa perlu mencentang departemennya. Tekan Ctrl/Cmd + klik untuk memilih beberapa user.
                                </small>
                            </div>

                            <!-- Akses Container (Klasifikasi Terbatas) -->
                            <div class="akses-container mt-3 pt-3 border-top" style="<?= strtolower($a['klasifikasi']) == 'terbatas' ? '' : 'display:none;' ?>">
                                <h6 class="mb-3 font-weight-bold">Pengaturan Akses Departemen</h6>

                                <div class="row">
                                    <?php
                                    $selectedDeps = $a['akses_dep'] ?? [];
                                    foreach ($departemen as $dep):
                                    ?>
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="custom-control custom-checkbox p-2 border rounded">
                                                <input type="checkbox"
                                                    class="custom-control-input dep-checkbox"
                                                    id="dep-<?= $dep['id_dep'] ?>-edit-<?= $a['id_arsip'] ?>"
                                                    name="akses_dep[]"
                                                    value="<?= $dep['id_dep'] ?>"
                                                    <?= in_array($dep['id_dep'], $selectedDeps) ? 'checked' : '' ?>>
                                                <label class="custom-control-label text-truncate"
                                                    for="dep-<?= $dep['id_dep'] ?>-edit-<?= $a['id_arsip'] ?>"
                                                    title="<?= esc($dep['nama_dep']) ?>">
                                                    <?= esc($dep['nama_dep']) ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group mt-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Tambahkan deskripsi arsip (opsional)"><?= esc($a['deskripsi']) ?></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Arsip
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === Inisialisasi Select2 ===
        $('.user-global-select').each(function() {
            const modalId = $(this).closest('.modal').attr('id');
            $(this).select2({
                placeholder: 'Pilih user spesifik lintas departemen',
                width: '100%',
                dropdownParent: $('#' + modalId),
                allowClear: true
            });
        });

        // === Handler Klasifikasi Change ===
        function handleKlasifikasiChange(selectElement) {
            const arsipItem = selectElement.closest('.arsip-item');
            const aksesContainer = arsipItem.querySelector('.akses-container');
            const aksesUserGlobal = arsipItem.querySelector('.akses-user-global');

            if (selectElement.value === 'terbatas') {
                aksesContainer.style.display = 'block';
                aksesUserGlobal.style.display = 'block';
            } else {
                aksesContainer.style.display = 'none';
                aksesUserGlobal.style.display = 'none';
                arsipItem.querySelectorAll('.dep-checkbox').forEach(cb => cb.checked = false);
                $(arsipItem).find('.user-global-select').val(null).trigger('change');
            }
        }

        // Event listener untuk perubahan klasifikasi
        document.querySelectorAll('.klasifikasi-select').forEach(function(select) {
            select.addEventListener('change', function() {
                handleKlasifikasiChange(this);
            });
        });

        // Trigger saat modal dibuka
        $('.modal').on('shown.bs.modal', function() {
            const klasifikasiSelect = this.querySelector('.klasifikasi-select');
            if (klasifikasiSelect) handleKlasifikasiChange(klasifikasiSelect);
        });

        // === Validasi sebelum submit ===
        document.querySelectorAll('form[id^="formEditArsip"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const arsipItem = this.querySelector('.arsip-item');
                const klasifikasi = arsipItem.querySelector('.klasifikasi-select').value;

                if (klasifikasi === 'terbatas') {
                    const checkedDeps = arsipItem.querySelectorAll('.dep-checkbox:checked');
                    const selectedUsers = $(arsipItem).find('.user-global-select').val();
                    const hasUserGlobal = selectedUsers && selectedUsers.length > 0;

                    if (checkedDeps.length === 0 && !hasUserGlobal) {
                        e.preventDefault();
                        alert('Validasi Gagal:\n\nKlasifikasi "Terbatas" memerlukan minimal 1 departemen atau 1 user spesifik yang dipilih.');
                        return false;
                    }
                }
                return true;
            });
        });
    });
</script>