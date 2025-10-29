<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="row">
    <?php
    $boxes = [
        ['total' => $tot_Rahasia, 'label' => 'Rahasia', 'icon' => 'fa-lock', 'bg' => 'bg-pastel-pink'],
        ['total' => $tot_terbatas, 'label' => 'Terbatas', 'icon' => 'fa-shield', 'bg' => 'bg-pastel-yellow'],
        ['total' => $tot_Umum, 'label' => 'Umum', 'icon' => 'fa-users', 'bg' => 'bg-pastel-green'],
        ['total' => $tot_size, 'label' => 'Total Size Arsip', 'icon' => 'fa-database', 'bg' => 'bg-pastel-blue']
    ];
    ?>

    <?php foreach ($boxes as $box): ?>
        <div class="col-lg-3 col-xs-12">
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
    <!-- LEFT COLUMN -->
    <div class="col-md-7">
        <!-- LAST ACTIVITY -->
        <div class="box box-default rounded-lg shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Last Activity</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" id="refreshLastActivity">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="lastActivityBody">
                <div class="table-responsive">
                    <table class="table table-striped table-rounded">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody id="lastActivityTable">
                            <?php if (!empty($lastActivity)): ?>
                                <?php $no = 1;
                                foreach ($lastActivity as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($row['username']); ?></td>
                                        <td><?= esc($row['action']); ?></td>
                                        <td><?= esc($row['description']); ?></td>
                                        <td><?= esc($row['ip_address']); ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada aktivitas terbaru</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- DIAGRAM ARSIP PER DEPARTEMEN -->
        <div class="box box-default rounded-lg shadow-sm mt-3">
            <div class="box-header with-border bg-success text-white">
                <h3 class="box-title">Diagram Arsip per Departemen</h3>
            </div>
            <div class="box-body">
                <canvas id="chartDepartemenSuper" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="col-md-5">
        <div class="row">
            <!-- DIAGRAM ARSIP PER KATEGORI -->
            <div class="col-md-12">
                <div class="box box-default rounded-lg shadow-sm">
                    <div class="box-header with-border bg-primary text-white">
                        <h3 class="box-title">Diagram Arsip per Kategori</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="chartKategoriSuper" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- QUICK MENU -->
            <div class="col-md-12">
                <div class="box box-default rounded-lg shadow-sm">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quick Menu</h3>
                    </div>
                    <div class="box-body">
                        <a href="<?= base_url('user') ?>" class="quick-card rounded-lg bg-pastel-purple">
                            <div class="quick-icon"><i class="fa fa-users"></i></div>
                            <div class="quick-content">
                                <h4>User</h4>
                                <p>Jumlah: <?= $jumlahUser ?></p>
                            </div>
                        </a>
                        <a href="<?= base_url('arsip') ?>" class="quick-card rounded-lg bg-pastel-green">
                            <div class="quick-icon"><i class="fa fa-archive"></i></div>
                            <div class="quick-content">
                                <h4>Arsip</h4>
                                <p>Jumlah: <?= $jumlahFile ?></p>
                            </div>
                        </a>
                        <a href="<?= base_url('backupdb') ?>" class="quick-card rounded-lg bg-pastel-orange">
                            <div class="quick-icon"><i class="fa fa-database"></i></div>
                            <div class="quick-content">
                                <h4>Backup Database</h4>
                                <p>Download file SQL</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('template/custom/js/chart.umd.min.js') ?>" defer></script>
<script defer>
    window.addEventListener('load', function() {
        const departemenData = <?= json_encode($departemenChart) ?>;
        const kategoriData = <?= json_encode($kategoriChart) ?>;

        // DIAGRAM BAR - ARSIP PER DEPARTEMEN
        const depLabels = departemenData.map(d => d.nama_dep);
        const depValues = departemenData.map(d => parseInt(d.total) || 0);

        const depCanvas = document.getElementById('chartDepartemenSuper');
        if (depCanvas) {
            new Chart(depCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: depLabels,
                    datasets: [{
                        label: 'Jumlah Arsip',
                        data: depValues,
                        backgroundColor: '#28a745'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Jumlah Arsip per Departemen',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // DIAGRAM DONUT - KATEGORI PER DEPARTEMEN
        const katLabels = kategoriData.map(k => k.nama_kategori || "Tidak Ada Nama");
        const katValues = kategoriData.map(k => parseInt(k.total) || 0);

        const katCanvas = document.getElementById('chartKategoriSuper');
        if (katCanvas) {
            new Chart(katCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: katLabels,
                    datasets: [{
                        label: 'Jumlah Kategori',
                        data: katValues,
                        backgroundColor: [
                            '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0',
                            '#9966ff', '#ff9f40', '#6c757d', '#28a745',
                            '#dc3545', '#17a2b8'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Jumlah Kategori per Departemen',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>