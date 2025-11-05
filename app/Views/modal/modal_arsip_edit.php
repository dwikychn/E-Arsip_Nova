<?php
$isSuper = session()->get('level') == 0;
?>

<?php foreach ($arsip as $a):
    $arsipId = $a['id_arsip'];
    $klasifikasi = strtolower($a['klasifikasi']);
    $isTerbatas = $klasifikasi === 'terbatas';
    $selectedUserGlobal = $a['akses_user_global'] ?? [];
    $selectedDeps = $a['akses_dep'] ?? [];
    $selectedUsers = $a['akses_user'] ?? [];
?>
    <div class="modal fade" id="updateArsip<?= $arsipId ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="width: 75% !important; max-width: 1800px !important; margin: 20px auto;">
            <form id="formEditArsip<?= $arsipId ?>" action="<?= base_url('arsip/updateArsip/' . $arsipId) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-edit"></i> Edit Arsip
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableArsipEdit">
                                <thead>
                                    <tr>
                                        <th width="180">File</th>
                                        <th width="180">Nama Arsip</th>
                                        <?php if ($isSuper): ?>
                                        <th width="150">Departemen</th>
                                        <?php endif; ?>
                                        <th width="180">Kategori</th>
                                        <th width="200">Deskripsi</th>
                                        <th width="250">Klasifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- File Column -->
                                        <td>
                                            <div class="file-column-container">
                                                <button type="button" class="btn btn-sm btn-default btn-file" disabled title="<?= esc($a['file_arsip']) ?>">
                                                    <i class="fa fa-file"></i> <?= esc(strlen($a['file_arsip']) > 15 ? substr($a['file_arsip'], 0, 12) . '...' : $a['file_arsip']) ?>
                                                </button>
                                                <label class="btn btn-sm btn-warning btn-change-file mb-0">
                                                    <i class="fa fa-refresh"></i> Ganti File
                                                    <input type="file" name="file_arsip" style="display:none;" onchange="updateFileName<?= $arsipId ?>(this)">
                                                </label>
                                            </div>
                                        </td>

                                        <!-- Nama Arsip -->
                                        <td>
                                            <input type="text" name="nama_arsip" class="form-control" placeholder="Opsional (akan pakai nama file jika kosong)">
                                        </td>

                                        <!-- Departemen (Super Admin Only) -->
                                        <?php if ($isSuper): ?>
                                        <td>
                                            <select name="id_dep" class="form-control" required>
                                                <option value="">Pilih Departemen</option>
                                                <?php foreach ($departemen as $d): ?>
                                                    <option value="<?= $d['id_dep'] ?>" <?= $a['id_dep'] == $d['id_dep'] ? 'selected' : '' ?>>
                                                        <?= esc($d['nama_dep']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <?php endif; ?>

                                        <!-- Kategori -->
                                        <td>
                                            <select name="id_kategori" class="form-control" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php foreach ($kategori as $k): ?>
                                                    <option value="<?= $k['id_kategori'] ?>" <?= $a['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                                        <?= esc($k['nama_kategori']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <!-- Deskripsi -->
                                        <td>
                                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Deskripsi (opsional)"><?= esc($a['deskripsi']) ?></textarea>
                                        </td>

                                        <!-- Klasifikasi -->
                                        <td class="klasifikasi-cell">
                                            <select name="klasifikasi" class="form-control klasifikasi-select-edit" data-arsip-id="<?= $arsipId ?>" required>
                                                <option value="">Pilih Klasifikasi</option>
                                                <option value="umum" <?= $klasifikasi == 'umum' ? 'selected' : '' ?>>Umum</option>
                                                <option value="terbatas" <?= $klasifikasi == 'terbatas' ? 'selected' : '' ?>>Terbatas</option>
                                                <option value="rahasia" <?= $klasifikasi == 'rahasia' ? 'selected' : '' ?>>Rahasia</option>
                                            </select>

                                            <!-- Container Akses Terbatas -->
                                            <div class="akses-terbatas-container" id="akses-edit-<?= $arsipId ?>" style="<?= $isTerbatas ? '' : 'display:none;' ?>">
                                                <strong style="font-size:12px; color:#333;">Akses Terbatas:</strong>
                                                <div class="akses-content-edit">
                                                    <!-- Departemen -->
                                                    <small class="text-muted" style="font-size:11px; display:block; margin-bottom:8px;">Pilih departemen yang boleh akses:</small>
                                                    <div class="dep-wrapper">
                                                        <?php foreach ($departemen as $dep): ?>
                                                            <div class="dep-item-inline" data-dep="<?= $dep['id_dep'] ?>">
                                                                <label style="font-weight:normal; margin-bottom:0; cursor:pointer;">
                                                                    <input type="checkbox" class="dep-checkbox" name="akses_dep[]" value="<?= $dep['id_dep'] ?>" <?= in_array($dep['id_dep'], $selectedDeps) ? 'checked' : '' ?>>
                                                                    <?= esc($dep['nama_dep']) ?>
                                                                </label>
                                                                <div class="user-container-inline" id="user-container-edit-<?= $arsipId ?>-<?= $dep['id_dep'] ?>" style="<?= in_array($dep['id_dep'], $selectedDeps) ? '' : 'display:none;' ?>">
                                                                    <label style="font-weight:normal; font-size:11px;">
                                                                        <input type="checkbox" class="semua-user-edit" data-arsip-id="<?= $arsipId ?>" data-dep="<?= $dep['id_dep'] ?>"> 
                                                                        <small>Semua user</small>
                                                                    </label>
                                                                    <br>
                                                                    <?php 
                                                                    $usersInDep = array_filter($users, function($u) use ($dep) {
                                                                        return $u['id_dep'] == $dep['id_dep'];
                                                                    });
                                                                    foreach ($usersInDep as $u): 
                                                                        $isChecked = isset($selectedUsers[$dep['id_dep']]) && in_array($u['id_user'], $selectedUsers[$dep['id_dep']]);
                                                                    ?>
                                                                        <label style="font-weight:normal; display:block; font-size:11px;">
                                                                            <input type="checkbox" class="user-checkbox-edit-<?= $arsipId ?>-<?= $dep['id_dep'] ?>" name="akses_user[<?= $dep['id_dep'] ?>][]" value="<?= $u['id_user'] ?>" <?= $isChecked ? 'checked' : '' ?>>
                                                                            <small><?= esc($u['nama_user']) ?></small>
                                                                        </label>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>

                                                    <!-- User Global -->
                                                    <hr style="margin:10px 0;">
                                                    <small class="text-muted" style="font-size:11px; display:block; margin-bottom:8px;">Atau pilih user global:</small>
                                                    <div id="user-global-edit-<?= $arsipId ?>" style="max-height:150px; overflow-y:auto;">
                                                        <?php foreach ($users as $u): ?>
                                                            <label style="font-weight:normal; display:block; margin-bottom:5px; font-size:11px;">
                                                                <input type="checkbox" name="akses_user_global[]" value="<?= $u['id_user'] ?>" <?= in_array($u['id_user'], $selectedUserGlobal) ? 'checked' : '' ?>>
                                                                <?= esc($u['nama_user']) ?> <span class="text-muted">(<?= esc($u['nama_dep']) ?>)</span>
                                                            </label>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
    // Update nama file saat ganti file
    function updateFileName<?= $arsipId ?>(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const btn = $(input).closest('.file-column-container').find('.btn-file');
            const truncated = fileName.length > 15 ? fileName.substring(0, 12) + '...' : fileName;
            btn.attr('title', fileName).html('<i class="fa fa-file"></i> ' + truncated);
        }
    }
    </script>
<?php endforeach; ?>