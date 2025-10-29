<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Kotak Bantuan</h3>
    </div>

    <div class="box-body">

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/bantuan/kirim') ?>" method="post">
            <div class="input-group">
                <textarea name="pesan" class="form-control" placeholder="Tulis pesan..." required></textarea>
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Kirim</button>
                </span>
            </div>
        </form>

        <hr>

        <?php foreach ($pesan as $p): ?>
            <div class="callout callout-info">
                <b><?= $p['nama_pengirim'] ?></b> <small><?= $p['created_at'] ?></small><br>
                <?= nl2br($p['pesan']) ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?= $this->endSection() ?>
