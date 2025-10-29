<!-- Widget Last Activity Upload -->
<div class="card mb-4">
    <div class="card-header">
        <b>Latest Uploads</b>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Departemen</th>
                        <th>Kategori</th>
                        <th>Nama File</th>
                        <th>Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($last_uploads)): ?>
                        <?php foreach ($last_uploads as $row): ?>
                            <tr>
                                <td><?= esc($row['nama_user']) ?></td>
                                <td><?= esc($row['nama_dep']) ?></td>
                                <td><?= esc($row['nama_kategori']) ?></td>
                                <td><?= esc($row['file_arsip']) ?></td>
                                <td><?= esc($row['tgl_upload']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada upload arsip.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Tambahkan elemen canvas untuk grafik -->
<div class="card mt-4">
    <div class="card-header">
        Grafik Arsip Masuk per Bulan
    </div>
    <div class="card-body">
        <canvas id="arsipChart" width="400" height="150"></canvas>
    </div>
</div>

<!-- Tambahkan CDN Chart.js dan script inisialisasi grafik sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dummy untuk grafik
    const ctx = document.getElementById('arsipChart').getContext('2d');
    const arsipChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Jumlah Arsip',
                data: [12, 19, 7, 15, 10, 17],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>