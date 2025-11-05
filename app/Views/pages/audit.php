<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Audit Trail</h3>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan_audit')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan_audit') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="tableAudit" class="table table-bordered table-striped table-hover">
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
                        <?php 
                        $no = 1;
                        foreach ($audits as $a): 
                            // Tentukan class berdasarkan level
                            $userClass = 'user-regular';
                            if ($a['level'] == 0) {
                                $userClass = 'user-superadmin';
                            } elseif ($a['level'] == 1) {
                                $userClass = 'user-admin';
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="<?= $userClass ?>">
                                    <?= esc($a['username']) ?>
                                </td>
                                <td><?= esc($a['action']) ?></td>
                                <td title="<?= esc($a['description']) ?>">
                                    <?= esc($a['description']) ?>
                                </td>
                                <td class="text-center"><?= esc($a['ip_address']) ?></td>
                                <td class="text-center">
                                    <?= date('d-m-Y H:i:s', strtotime($a['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('template/custom/css/audit.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('template/custom/js/audit.js') ?>"></script>
<?= $this->endSection() ?>