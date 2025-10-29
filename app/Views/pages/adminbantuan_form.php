<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box box-primary" style="max-width:600px;margin:auto;">
        <div class="box-header with-border">
            <h3 class="box-title">Kirim Pesan Bantuan ke Superadmin</h3>
        </div>
        <form action="<?= base_url('bantuan/kirim') ?>" method="post">
            <div class="box-body">
                <textarea name="pesan" class="form-control" rows="5" required placeholder="Tuliskan pesan bantuan..."></textarea>
            </div>
            <div class="box-footer" style="text-align:right;">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>

