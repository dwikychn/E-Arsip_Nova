<?php foreach ($users as $u): ?>
    <div class="modal fade" id="editUser<?= $u['id_user'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?= form_open('user/update/' . $u['id_user']) ?>
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_user" class="form-control nama-user"
                            value="<?= esc($u['nama_user']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control username"
                            value="<?= esc($u['username']) ?>" readonly required>
                    </div>

                    <input type="hidden" name="id_dep" value="<?= esc($u['id_dep']) ?>">
                    <input type="hidden" class="dep-nama" value="<?= esc($u['nama_dep']) ?>">

                    <div class="form-group">
                        <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ganti password">
                    </div>

                    <?php if (session()->get('level') == 0): ?>
                        <div class="form-group">
                            <label>Level</label>
                            <select name="level" class="form-control" required>
                                <option value="1" <?= $u['level'] == 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= $u['level'] == 2 ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label>Level</label>
                            <input type="hidden" name="level" value="<?= $u['level'] ?>">
                            <input type="text" class="form-control"
                                value="<?= $u['level'] == 0 ? 'Super Admin' : ($u['level'] == 1 ? 'Admin' : 'User') ?>"
                                readonly>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.nama-user').forEach(function(namaInput) {
            const form = namaInput.closest('form');
            const usernameInput = form.querySelector('.username');
            const departemenSelect = form.querySelector('.id-dep'); // kalau superadmin pakai select
            const depNamaHidden = form.querySelector('.dep-nama'); // untuk admin/user

            function generateUsername() {
                const nama = namaInput.value.trim().split(' ')[0].toLowerCase();
                let depSingkat = "";

                if (departemenSelect) {
                    const selectedOption = departemenSelect.options[departemenSelect.selectedIndex];
                    const namaDep = selectedOption ? selectedOption.text : "";
                    depSingkat = namaDep ? namaDep.split(' ')[0].toLowerCase() : "";
                } else if (depNamaHidden) {
                    const namaDep = depNamaHidden.value;
                    depSingkat = namaDep ? namaDep.split(' ')[0].toLowerCase() : "";
                }

                if (nama && depSingkat) {
                    usernameInput.value = `${nama}_${depSingkat}`;
                }
            }

            namaInput.addEventListener('input', generateUsername);
            if (departemenSelect) {
                departemenSelect.addEventListener('change', generateUsername);
            }
        });
    });
</script>