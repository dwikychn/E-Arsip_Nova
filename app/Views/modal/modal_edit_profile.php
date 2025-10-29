<?php if (session()->get('id_user')): ?>
    <div class="modal fade" id="editProfile" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Profile</h4>
                </div>
                <div class="modal-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ((array) session()->getFlashdata('error') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/update-profile/' . session()->get('id_user')) ?>" method="post">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama_user" class="form-control nama-user"
                                value="<?= esc(session()->get('nama_user')) ?>" required>
                        </div>

                        <input type="hidden" name="id_dep" value="<?= esc(session()->get('id_dep')) ?>">
                        <input type="hidden" class="dep-lama" value="<?= esc(session()->get('nama_dep')) ?>">

                        <div class="form-group">
                            <label>Username (otomatis)</label>
                            <input type="text" name="username" class="form-control username"
                                value="<?= esc(session()->get('username')) ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Password Baru <small>(kosongkan jika tidak ingin ganti)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" class="form-control">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.nama-user').forEach(function(namaInput) {
                const form = namaInput.closest('form');
                const usernameInput = form.querySelector('.username');
                const depInput = form.querySelector('.dep-lama');

                function generateUsername() {
                    const nama = namaInput.value.trim().split(' ')[0].toLowerCase();
                    const depText = depInput.tagName === 'SELECT' ?
                        depInput.options[depInput.selectedIndex].text :
                        depInput.value;

                    const depSingkat = depText ? depText.trim().toLowerCase().split(' ')[0] : "";

                    if (nama && depSingkat) {
                        usernameInput.value = `${nama}_${depSingkat}`;
                    } else {
                        usernameInput.value = nama; // fallback tanpa "_"
                    }
                }

                namaInput.addEventListener('input', generateUsername);
                if (depInput.tagName === 'SELECT') {
                    depInput.addEventListener('change', generateUsername);
                }
                generateUsername(); // pertama kali
            });
        });
    </script>
<?php endif; ?>