<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="row">
    <?php
    $boxes = [
        ['total' => $tot_Rahasia, 'label' => 'Rahasia', 'icon' => 'fa-lock', 'bg' => 'bg-pastel-pink'],
        ['total' => $tot_terbatas, 'label' => 'terbatas', 'icon' => 'fa-shield', 'bg' => 'bg-pastel-yellow'],
        ['total' => $tot_Umum, 'label' => 'Umum', 'icon' => 'fa-users', 'bg' => 'bg-pastel-green'],
    ];
    ?>

    <?php foreach ($boxes as $box): ?>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box <?= $box['bg'] ?> rounded-lg shadow-sm">
                <div class="inner">
                    <h3><?= $box['total'] ?></h3>
                    <p><?= $box['label'] ?></p>
                </div>
                <div class="icon">
                    <i class="fa <?= $box['icon'] ?>"></i>
                </div>
                <a href="<?= base_url('arsip') ?>" class="small-box-footer rounded-bottom">
                    View Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Distribusi Arsip per Kategori</h3>
            </div>
            <div class="box-body">
                <!-- Pastikan id canvas sudah benar -->
                <canvas id="kategoriChart" style="min-height:250px; max-height:300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Quick Menu</h3>
            </div>

            <div class="box-body">
                <!-- QUICK MENU -->
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?= base_url('user') ?>" class="quick-card rounded-lg bg-pastel-purple">
                            <div class="quick-icon"><i class="fa fa-users"></i></div>
                            <div class="quick-content">
                                <h4>User</h4>
                                <p>Jumlah: <?= esc($totalUser) ?></p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-12">
                        <a href="<?= base_url('arsip') ?>" class="quick-card rounded-lg bg-pastel-green">
                            <div class="quick-icon"><i class="fa fa-archive"></i></div>
                            <div class="quick-content">
                                <h4>Arsip</h4>
                                <p>Jumlah: <?= esc($totalArsip) ?></p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- INFORMASI DEPARTEMEN -->
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
                                        User: <strong><?= esc($dept['total_user']) ?></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Aktivitas Terakhir Departemen (10 Log)</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($lastActivity as $row): ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= esc($row['username']) ?></td>
                                <td><?= esc($row['action']) ?></td>
                                <td><?= esc($row['description']) ?></td>
                                <td><?= esc($row['ip_address']) ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php if (empty($lastActivity)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada aktivitas terbaru yang tercatat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kategoriData = <?= json_encode($kategoriChart ?? []) ?>;
        console.log("kategoriData:", kategoriData);

        if (!Array.isArray(kategoriData) || kategoriData.length === 0) {
            document.getElementById('kategoriChart').parentNode.innerHTML =
                '<p class="text-center" style="padding:40px;">Tidak ada data kategori untuk departemen ini.</p>';
            return;
        }

        const labels = kategoriData.map(i => i.nama_kategori);
        const data = kategoriData.map(i => parseInt(i.total) || 0);

        const ctx = document.getElementById('kategoriChart');
        if (!ctx) {
            console.error("Canvas #kategoriChart tidak ditemukan!");
            return;
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#00a65a', '#3c8dbc', '#f39c12', '#f56954', '#00c0ef', '#d2d6de', '#9b59b6', '#e91e63']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>