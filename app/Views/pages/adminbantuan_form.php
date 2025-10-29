<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($title) ?></h3>
        </div>

        <div class="box-body">
            <form method="post" action="<?= base_url('bantuan/kirim') ?>">
                <textarea name="pesan" class="form-control" required rows="4" placeholder="Tulis pesan kamu..."></textarea>
                <br>
                <button class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
