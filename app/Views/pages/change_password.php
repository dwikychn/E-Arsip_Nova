<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Ganti Password</h3>
    </div>
    <div class="box-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('error') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('user/change-password') ?>" method="post">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>