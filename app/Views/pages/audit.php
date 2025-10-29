<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Cari Arsip</h3>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan_audit')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pesan_audit') ?>
                </div>
            <?php endif; ?>
            <table id="tableAudit" class="table table-bordered table-striped">
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
                <tbody>
                    <?php $no = 1;
                        foreach ($audits as $a): 
                            $color = 'black'; // default user biasa
                            if ($a['level'] == 0) $color = 'red';       // superadmin
                            elseif ($a['level'] == 1) $color = 'blue';  // admin
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="color: <?= $color ?>; font-weight:bold;">
                                <?= esc($a['username']) ?>
                            </td>
                            <td><?= esc($a['action']) ?></td>
                            <td><?= esc($a['description']) ?></td>
                            <td><?= esc($a['ip_address']) ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($a['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Inisialisasi DataTable -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (!$.fn.DataTable.isDataTable('#tableAudit')) {
                $('#tableAudit').DataTable({
                    "pageLength": 100,
                    "lengthMenu": [
                        [10, 25, 50, 100, 200],
                        [10, 25, 50, 100, 200]
                    ]
                });
            }
        });
    </script>
</section>

<?= $this->endSection() ?>