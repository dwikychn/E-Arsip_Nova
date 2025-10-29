<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah User</h4>
            </div>
            <div class="modal-body">
                <?php if (session()->getFlashdata('error_user')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ((array) session()->getFlashdata('error_user') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php echo form_open('user/store') ?>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_user" id="nama_user" class="form-control" placeholder="Masukkan nama" required>
                </div>
                <div class="form-group">
                    <label for="id_dep">Departemen</label>
                    <?php if (session()->get('level') == 0): ?>
                        <!-- Superadmin bisa pilih departemen -->
                        <select name="id_dep" id="departemen" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- Pilih Departemen --</option>
                            <?php foreach ($departemen as $d) : ?>
                                <option value="<?= $d['id_dep'] ?>" data-nama="<?= $d['nama_dep'] ?>">
                                    <?= $d['nama_dep'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <!-- Admin otomatis departemen sesuai session -->
                        <input type="hidden" name="id_dep" value="<?= session()->get('id_dep') ?>">
                        <input type="text" class="form-control" value="<?php
                                                                        $id_dep_session = session()->get('id_dep');
                                                                        $nama_dep = '';
                                                                        foreach ($departemen as $d) {
                                                                            if ($d['id_dep'] == $id_dep_session) {
                                                                                $nama_dep = $d['nama_dep'];
                                                                                break;
                                                                            }
                                                                        }
                                                                        echo $nama_dep;
                                                                        ?>" readonly>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required readonly>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <?php if (session()->get('level') == 0): ?>
                        <select name="level" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        <?php elseif (session()->get('level') == 1): ?>
                            <input type="hidden" name="level" value="2">
                            <input type="text" class="form-control" value="User" readonly>
                        <?php endif; ?>
                        </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const namaInput = document.querySelector('#add input[name="nama_user"]');
        const departemenSelect = document.querySelector('#add select[name="id_dep"]');
        const departemenHidden = document.querySelector('#add input[name="id_dep"][type="hidden"]');
        const usernameInput = document.querySelector('#add input[name="username"]');

        if (namaInput && usernameInput) {
            namaInput.addEventListener('input', generateUsername);
            if (departemenSelect) {
                departemenSelect.addEventListener('change', generateUsername);
            }

            function generateUsername() {
                const nama = namaInput.value.trim().split(' ')[0].toLowerCase(); // ambil nama depan
                let depSingkat = "";

                if (departemenSelect) {
                    // untuk superadmin
                    const selectedOption = departemenSelect.options[departemenSelect.selectedIndex];
                    const namaDep = selectedOption ? selectedOption.text : "";
                    depSingkat = namaDep ? namaDep.split(' ')[0].toLowerCase() : "";
                } else if (departemenHidden) {
                    // untuk admin
                    const namaDep = document.querySelector('#add input[readonly]').value;
                    depSingkat = namaDep ? namaDep.split(' ')[0].toLowerCase() : "";
                }

                if (nama && depSingkat) {
                    usernameInput.value = `${nama}_${depSingkat}`;
                } else {
                    usernameInput.value = '';
                }
            }
        }
    });
</script>