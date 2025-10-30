<?php $page = 'cari'; ?>
<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
      <h3 class="box-title">Cari Arsip</h3>
    </div>

    <div class="box-body">
      <?php if (session()->getFlashdata('error_cari')): ?>
        <div class="alert alert-danger">
          <?= implode('<br>', (array) session()->getFlashdata('error_cari')) ?>
        </div>
      <?php endif; ?>

      <form id="formHapusMultiple" method="post" action="<?= base_url('cari/hapus_multiple') ?>">
        <?= csrf_field() ?>

        <div class="table-responsive">
          <table id="tableCari" class="table table-bordered table-striped table-hover" style="width:100%">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>No</th>
                <th>Nama Dokumen</th>
                <th>Deskripsi</th>
                <th>Departemen</th>
                <th>Kategori</th>
                <th>Klasifikasi</th>
                <th>Tgl. Upload</th>
                <th>Tgl. Update</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $no      = 1;
              $db      = \Config\Database::connect();
              $id_dep  = (int) session()->get('id_dep');
              $id_user = (int) session()->get('id_user');
              $level   = (int) session()->get('level');

              foreach ($arsip as $a):
                // 🔒 Akses arsip
                $allowed = false;
                $klasifikasi = strtolower($a['klasifikasi']);

                if ($level === 0) {
                  $allowed = true;
                } elseif ($klasifikasi === 'umum') {
                  $allowed = true;
                } elseif ($klasifikasi === 'rahasia' && $a['id_dep'] == $id_dep) {
                  $allowed = true;
                } elseif ($klasifikasi === 'terbatas') {
                  if ($a['id_user'] == $id_user) {
                    $allowed = true;
                  } else {
                    $cek = $db->table('tbl_arsip_akses')
                      ->where('id_arsip', $a['id_arsip'])
                      ->groupStart()
                      ->groupStart()
                      ->where('tipe_akses', 'departemen')
                      ->where('id_dep', $id_dep)
                      ->groupEnd()
                      ->orGroupStart()
                      ->where('tipe_akses', 'user')
                      ->where('id_user', $id_user)
                      ->groupEnd()
                      ->groupEnd()
                      ->countAllResults();
                    $allowed = ($cek > 0);
                  }
                }

                $cleanPath = preg_replace('#^uploads/#', '', $a['path_arsip']);
                $pathFile  = base_url('uploads/' . $cleanPath . '/' . $a['file_arsip']);
              ?>
                <tr>
                  <td class="text-center">
                    <?php if ($allowed): ?>
                      <input type="checkbox" class="checkboxArsip" name="id_arsip[]" value="<?= $a['id_arsip'] ?>" data-file="<?= $pathFile ?>">
                    <?php else: ?>
                      <input type="checkbox" disabled title="Akses dibatasi">
                    <?php endif; ?>
                  </td>

                  <td class="text-center"><?= $no++ ?></td>

                  <td>
                    <?php if ($allowed): ?>
                      <a href="#" class="preview-link text-primary fw-semibold"
                        data-file="<?= $pathFile ?>"
                        data-nama="<?= esc($a['file_arsip']) ?>"
                        title="<?= esc($a['file_arsip']) ?>"> <!-- tooltip -->
                        <?= esc($a['file_arsip']) ?>
                      </a>

                    <?php else: ?>
                      <span class="text-muted"><?= esc($a['file_arsip']) ?></span>
                      <small class="badge bg-danger">Terbatas</small>
                    <?php endif; ?>
                  </td>

                  <td title="<?= esc($a['deskripsi']) ?>"><?= esc($a['deskripsi']) ?></td>
                  <td><?= esc($a['nama_dep']) ?></td>
                  <td><?= esc($a['nama_kategori']) ?></td>

                  <td class="text-center">
                    <?php
                    $labelMap = [
                      'umum'     => ['U', 'success'],
                      'terbatas' => ['T', 'warning'],
                      'rahasia'  => ['R', 'danger']
                    ];
                    if (isset($labelMap[$klasifikasi])) {
                      [$labelText, $labelColor] = $labelMap[$klasifikasi];
                      echo "<span class='label label-{$labelColor}' style='font-size:14px;'>{$labelText}</span>";
                    } else {
                      echo "<span class='label label-default'>" . esc($a['klasifikasi']) . "</span>";
                    }
                    ?>
                  </td>

                  <td><?= esc($a['tgl_upload']) ?></td>
                  <td><?= esc($a['tgl_update']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div id="actionContainer" class="text-right mt-3" style="display:none;">
          <button type="button" id="btnDownloadSelected" class="btn btn-success btn-sm">
            <i class="fa fa-download"></i> Download Terpilih
          </button>
          <button type="button" id="btnDeleteSelected" class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i> Hapus Terpilih
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<link rel="stylesheet" href="<?= base_url('template/custom/css/cari.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('template/custom/js/cari.js') ?>"></script>
<?= $this->endSection() ?>