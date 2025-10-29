<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Donut Chart Kategori
        var ctx = document.getElementById("donutChart").getContext("2d");
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [<?= implode(',', array_map(fn($k) => '"' . esc($k['nama_kategori']) . '"', $kategoriChart)) ?>],
                datasets: [{
                    data: [<?= implode(',', array_map(fn($k) => $k['total'], $kategoriChart)) ?>],
                    backgroundColor: [
                        <?php
                        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#9b59b6', '#e91e63'];
                        foreach ($kategoriChart as $i => $kat) {
                            echo '"' . $colors[$i % count($colors)] . '",';
                        }
                        ?>
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }, // legend bawaan dimatikan
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Departemen Chart
        var ctxDept = document.getElementById("deptChart").getContext("2d");
        new Chart(ctxDept, {
            type: 'bar',
            data: {
                labels: [<?= implode(',', array_map(fn($d) => '"' . esc($d['nama_dep']) . '"', $departemenChart)) ?>],
                datasets: [{
                    label: 'Jumlah Arsip',
                    data: [<?= implode(',', array_map(fn($d) => $d['total'], $departemenChart)) ?>],
                    backgroundColor: '#42a5f5'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    } // legend bar chart juga dimatikan
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
<section class="content">


    <div class="row">
        <!-- SMALL BOXES -->
        <?php
        $boxes = [
            ['total' => $tot_rahasia, 'label' => 'Rahasia', 'icon' => 'fa-lock', 'bg' => 'bg-red'],
            ['total' => $tot_terbatas, 'label' => 'terbatas', 'icon' => 'fa-shield', 'bg' => 'bg-yellow'],
            ['total' => $tot_umum, 'label' => 'Umum', 'icon' => 'fa-users', 'bg' => 'bg-green'],
            ['total' => $tot_size, 'label' => 'Total Size Arsip', 'icon' => 'fa-database', 'bg' => 'bg-blue']
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
        <!-- LAST ACTIVITY -->
        <div class="col-md-7">
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

            <!-- DEPARTEMEN CHART -->
            <div class="box box-default rounded-lg shadow-sm">
                <div class="box-header with-border">
                    <h3 class="box-title">Departemen</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-6">
                            <canvas id="deptChart" style="height:275px; width:100%;"></canvas>
                        </div>
                        <div class="col-md-5 col-sm-6">
                            <ul class="chart-legend clearfix">
                                <?php
                                $deptColors = [
                                    '#e53935',
                                    '#1e88e5',
                                    '#43a047',
                                    '#fb8c00',
                                    '#8e24aa',
                                    '#00acc1',
                                    '#fdd835',
                                    '#6d4c41',
                                    '#3949ab'
                                ];
                                $j = 0;
                                foreach ($departemenChart as $dep): ?>
                                    <li>
                                        <i class="fa fa-circle-o" style="color: <?= $deptColors[$j % count($deptColors)] ?>"></i>
                                        <?= esc($dep['nama_dep']) ?> (<?= $dep['total'] ?>)
                                    </li>
                                <?php $j++;
                                endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KATEGORI CHART -->
        <div class="col-md-5">
            <div class="box box-default rounded-lg shadow-sm">
                <div class="box-header with-border">
                    <h3 class="box-title">Kategori</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="donutChart" style="height:245px; width:100%;"></canvas>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <?php
                                $colors = [
                                    '#f56954',
                                    '#00a65a',
                                    '#f39c12',
                                    '#00c0ef',
                                    '#3c8dbc',
                                    '#d2d6de',
                                    '#9b59b6',
                                    '#e91e63'
                                ];
                                $i = 0;
                                foreach ($kategoriChart as $kat): ?>
                                    <li>
                                        <i class="fa fa-circle-o" style="color: <?= $colors[$i % count($colors)] ?>"></i>
                                        <?= esc($kat['nama_kategori']) ?> (<?= $kat['total'] ?>)
                                    </li>
                                <?php $i++;
                                endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QUICK MENU -->
            <div class="box box-default rounded-lg shadow-sm">
                <div class="box-header with-border">
                    <h3 class="box-title">Quick Menu</h3>
                </div>
                <div class="box-body">
                    <!-- User -->
                    <a href="<?= base_url('user') ?>" class="quick-card rounded-lg">
                        <div class="quick-icon bg-light-blue">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="quick-content">
                            <h4>User</h4>
                            <p>Jumlah: <?= $jumlahUser ?></p>
                        </div>
                    </a>

                    <!-- Arsip -->
                    <a href="<?= base_url('arsip') ?>" class="quick-card rounded-lg">
                        <div class="quick-icon bg-light-green">
                            <i class="fa fa-archive"></i>
                        </div>
                        <div class="quick-content">
                            <h4>Arsip</h4>
                            <p>Jumlah: <?= $jumlahFile ?></p>
                        </div>
                    </a>

                    <!-- Backup Database -->
                    <a href="<?= base_url('backupdb') ?>" class="quick-card rounded-lg">
                        <div class="quick-icon bg-light-orange">
                            <i class="fa fa-database"></i>
                        </div>
                        <div class="quick-content">
                            <h4>Backup Database</h4>
                            <p>Download file SQL</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- STYLES -->
    <style>
        .box {
            border-radius: 12px !important;
        }

        .small-box {
            border-radius: 12px !important;
            overflow: hidden;
        }

        .small-box-footer {
            border-radius: 0 0 12px 12px !important;
        }

        .table-rounded {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-rounded th:first-child {
            border-top-left-radius: 10px;
        }

        .table-rounded th:last-child {
            border-top-right-radius: 10px;
        }

        .table-rounded tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .table-rounded tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        .quick-card {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 12px;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .quick-card:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .quick-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            margin-right: 15px;
        }

        .quick-content h4 {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }

        .quick-content p {
            margin: 0;
            font-size: 13px;
            color: #666;
        }

        .bg-light-blue {
            background-color: #42a5f5;
        }

        .bg-light-green {
            background-color: #66bb6a;
        }

        .bg-light-orange {
            background-color: #ffa726;
        }
    </style>
</section>

<?= $this->endSection() ?>