<?php
$isSuper = session()->get('level') == 0;
$selectedUserGlobal = [];
$selectedDeps = [];
?>

<?php foreach ($arsip as $a):
    $arsipId = $a['id_arsip'];
    $klasifikasi = strtolower($a['klasifikasi']);
    $isTerbatas = $klasifikasi === 'terbatas';
    $selectedUserGlobal = $a['akses_user_global'] ?? [];
    $selectedDeps = $a['akses_dep'] ?? [];
?>
    <div class="modal fade" id="updateArsip<?= $arsipId ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formEditArsip<?= $arsipId ?>" action="<?= base_url('arsip/updateArsip/' . $arsipId) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-edit"></i> Edit Arsip
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="arsip-item" data-id="<?= $arsipId ?>">

                            <!-- Info Dasar -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
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
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Klasifikasi <span class="text-danger">*</span></label>
                                        <select name="klasifikasi" class="form-control klasifikasi-select" required>
                                            <option value="">-- Pilih Klasifikasi --</option>
                                            <?php foreach (['umum' => 'Umum', 'terbatas' => 'Terbatas', 'rahasia' => 'Rahasia'] as $val => $label): ?>
                                                <option value="<?= $val ?>" <?= $klasifikasi == $val ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ganti File</label>
                                        <input type="file" name="file_arsip" class="form-control-file">
                                        <small class="form-text text-muted text-truncate">
                                            Saat ini: <strong><?= esc($a['file_arsip']) ?></strong>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Departemen (Super Admin Only) -->
                            <?php if ($isSuper): ?>
                                <div class="form-group">
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
                            <?php endif; ?>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tambahkan deskripsi arsip (opsional)"><?= esc($a['deskripsi']) ?></textarea>
                            </div>

                            <!-- Akses User Global -->
                            <div class="akses-user-global mt-4 pt-3 border-top" style="<?= $isTerbatas ? '' : 'display:none;' ?>">
                                <label class="font-weight-bold">
                                    <i class="fa fa-user"></i> Akses User Spesifik (Lintas Departemen)
                                </label>
                                <select name="akses_user_global[]" class="form-control user-global-select" multiple>
                                    <?php foreach ($users as $u): ?>
                                        <option value="<?= $u['id_user'] ?>" <?= in_array($u['id_user'], $selectedUserGlobal) ? 'selected' : '' ?>>
                                            <?= esc($u['nama_user']) ?> (<?= esc($u['nama_dep']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fa fa-info-circle"></i> Pilih user tertentu tanpa perlu mencentang departemennya. Tekan Ctrl/Cmd + klik untuk memilih beberapa.
                                </small>
                            </div>

                            <!-- Akses Departemen -->
                            <div class="akses-container mt-4 pt-3 border-top" style="<?= $isTerbatas ? '' : 'display:none;' ?>">
                                <label class="font-weight-bold mb-3">
                                    <i class="fa fa-building"></i> Pengaturan Akses Departemen
                                </label>
                                <div class="row">
                                    <?php foreach ($departemen as $dep):
                                        $depId = $dep['id_dep'];
                                        $checkId = "dep-{$depId}-edit-{$arsipId}";
                                    ?>
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="custom-control custom-checkbox p-2 border rounded">
                                                <input type="checkbox" class="custom-control-input dep-checkbox"
                                                    id="<?= $checkId ?>" name="akses_dep[]" value="<?= $depId ?>"
                                                    <?= in_array($depId, $selectedDeps) ? 'checked' : '' ?>>
                                                <label class="custom-control-label text-truncate" for="<?= $checkId ?>" title="<?= esc($dep['nama_dep']) ?>">
                                                    <?= esc($dep['nama_dep']) ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Arsip
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('template/custom/js/arsip.js') ?>"></script>
<?= $this->endSection() ?>