<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<?php
$boxes = [
    ['total' => $tot_Rahasia, 'label' => 'Rahasia', 'icon' => 'fa-lock', 'bg' => 'bg-pastel-pink'],
    ['total' => $tot_terbatas, 'label' => 'Terbatas', 'icon' => 'fa-shield', 'bg' => 'bg-pastel-yellow'],
    ['total' => $tot_Umum, 'label' => 'Umum', 'icon' => 'fa-users', 'bg' => 'bg-pastel-green'],
];
?>

<!-- SMALL BOXES -->
<div class="row">
    <?php foreach ($boxes as $box): ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box <?= esc($box['bg']) ?> rounded-lg shadow-sm">
                <div class="inner">
                    <h3><?= esc($box['total']) ?></h3>
                    <p><?= esc($box['label']) ?></p>
                </div>
                <div class="icon">
                    <i class="fa <?= esc($box['icon']) ?>"></i>
                </div>
                <a href="<?= base_url('arsip') ?>" class="small-box-footer rounded-bottom">
                    View Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- DIAGRAM & QUICK MENU -->
<div class="row">
    <!-- DIAGRAM KATEGORI -->
    <div class="col-lg-6 col-md-12">
        <div class="box box-warning rounded-lg shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Distribusi Arsip per Kategori</h3>
            </div>
            <div class="box-body">
                <canvas id="kategoriChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- QUICK MENU & INFO DEPARTEMEN -->
    <div class="col-lg-6 col-md-12">
        <div class="box box-success rounded-lg shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Quick Menu</h3>
            </div>
            <div class="box-body">
                <!-- QUICK MENU ARSIP -->
                <a href="<?= base_url('arsip') ?>" class="quick-card rounded-lg bg-pastel-green">
                    <div class="quick-icon"><i class="fa fa-archive"></i></div>
                    <div class="quick-content">
                        <h4>Arsip</h4>
                        <p>Jumlah: <?= esc($totalArsip) ?></p>
                    </div>
                </a>

                <!-- INFORMASI DEPARTEMEN -->
                <?php if (!empty($quickDept)): ?>
                    <div style="margin-top: 20px;">
                        <?php foreach ($quickDept as $dept): ?>
                            <div class="info-box bg-yellow">
                                <span class="info-box-icon"><i class="fa fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Departemen: <strong><?= esc($dept['nama_dep']) ?></strong>
                                    </span>
                                    <span class="info-box-number">
                                        Total Arsip: <strong><?= esc($dept['total_arsip']) ?></strong>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- AKTIVITAS TERAKHIR -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning rounded-lg shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Aktivitas Terakhir Anda</h3>
            </div>
            <div class="box-body table-responsive">
                <?php if (!empty($lastActivity)): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($lastActivity as $act): ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td><?= esc($act['action']) ?></td>
                                    <td><?= esc($act['description']) ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($act['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center" style="padding: 40px;">Belum ada aktivitas terbaru</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('template/plugins/chartjs/chart.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriData = <?= json_encode($kategoriChart ?? []) ?>;
        const canvas = document.getElementById('kategoriChart');

        if (!canvas) return;

        if (!Array.isArray(kategoriData) || kategoriData.length === 0) {
            canvas.parentNode.innerHTML = '<p class="text-center" style="padding: 40px;">Tidak ada data kategori untuk departemen ini</p>';
            return;
        }

        const labels = kategoriData.map(i => i.nama_kategori);
        const data = kategoriData.map(i => parseInt(i.total) || 0);

        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#00a65a', '#3c8dbc', '#f39c12', '#f56954',
                        '#00c0ef', '#d2d6de', '#9b59b6', '#e91e63'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>