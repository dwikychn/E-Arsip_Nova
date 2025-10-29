<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<section class="content" style="text-align:center; padding:50px;">
    <div class="box" style="
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 3px 8px rgba(0,0,0,0.2);
        display: inline-block;
    ">
        <img src="<?= base_url('template/dist/img/maintenance.png') ?>" alt="Maintenance" style="width:200px; margin-bottom:20px;">
        <h1 style="color:#ff6600; margin-bottom:10px;">Maaf, Halaman Bantuan Dalam Perbaikan</h1>
        <p style="color:#555;">Sedang kami siapkan, mohon bantuan doanya 🙏</p>
    </div>
</section>
<?= $this->endSection() ?>





<!----------------------------------------------------------Batas------------------------------------------------------->