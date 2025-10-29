<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<?php
$boxes = [
    ['total' => $tot_Rahasia, 'label' => 'Rahasia',   'icon' => 'fa-lock',   'bg' => 'bg-pastel-pink'],
    ['total' => $tot_terbatas, 'label' => 'terbatas',  'icon' => 'fa-shield', 'bg' => 'bg-pastel-yellow'],
    ['total' => $tot_Umum,    'label' => 'Umum',      'icon' => 'fa-users',  'bg' => 'bg-pastel-green'],
];
?>

<!-- ========== 📦 SMALL BOXES ========== -->
<div class="row">
    <?php foreach ($boxes as $box): ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box <?= esc($box['bg']) ?>">
                <div class="inner">
                    <h3><?= esc($box['total']) ?></h3>
                    <p><?= esc($box['label']) ?></p>
                </div>
                <div class="icon"><i class="fa <?= esc($box['icon']) ?>"></i></div>
                <a href="<?= base_url('arsip') ?>" class="small-box-footer">
                    View Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div> <!-- /.row small boxes -->

<!-- ========== 📊 DIAGRAM & QUICK MENU ========== -->
<div class="row">
    <!-- Diagram Kategori -->
    <div class="col-lg-6 col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Distribusi Arsip per Kategori</h3>
            </div>
            <div class="box-body" style="height:350px;">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Menu -->
    <div class="col-lg-6 col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Quick Menu</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?= base_url('arsip') ?>" class="quick-card rounded-lg bg-pastel-green">
                            <div class="quick-icon"><i class="fa fa-archive"></i></div>
                            <div class="quick-content">
                                <h4>Arsip</h4>
                                <p>Jumlah: <?= esc($totalArsip) ?></p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Informasi Departemen -->
                <div class="row" style="margin-top: 20px;">
                    <?php foreach ($quickDept as $dept): ?>
                        <div class="col-md-12">
                            <div class="info-box bg-yellow">
                                <span class="info-box-icon"><i class="fa fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Informasi Departemen: <strong><?= esc($dept['nama_dep']) ?></strong>
                                    </span>
                                    <span class="info-box-number">
                                        Arsip: <strong><?= esc($dept['total_arsip']) ?></strong> |
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div> <!-- /.row diagram & quickmenu -->

<!-- ========== 🕒 LAST ACTIVITY ========== -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Aktivitas Terakhir Anda</h3>
            </div>
            <div class="box-body table-responsive">
                <?php if (!empty($lastActivity)): ?>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($lastActivity as $act): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($act['action']) ?></td>
                                    <td><?= esc($act['description']) ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($act['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center" style="padding:20px;">Belum ada aktivitas terbaru.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ========== 📈 CHARTJS SCRIPT ========== -->
<script src="<?= base_url('template/plugins/chartjs/chart.js') ?>"></script>
<script>
    const kategoriData = <?= json_encode($kategoriChart ?? []) ?>;

    if (!Array.isArray(kategoriData) || kategoriData.length === 0) {
        const canvasParent = document.getElementById('kategoriChart').parentNode;
        canvasParent.innerHTML = '<p class="text-center" style="padding:40px;">Tidak ada data kategori untuk departemen ini.</p>';
    } else {
        const labels = kategoriData.map(i => i.nama_kategori);
        const data = kategoriData.map(i => parseInt(i.total) || 0);
        const colors = ['#00a65a', '#3c8dbc', '#f39c12', '#f56954', '#00c0ef', '#d2d6de', '#9b59b6', '#e91e63'];

        const ctx = document.getElementById('kategoriChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors
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
    }
</script>

<?= $this->endSection() ?>