<div class="modal fade" id="modalAddArsip" tabindex="-1" aria-labelledby="modalAddArsipLabel" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <form id="formAddArsip" action="<?= base_url('arsip/addArsip') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      
      <!-- Tambahkan id_dep untuk super admin -->
      <?php if (session()->get('level') == 0): ?>
      <input type="hidden" name="id_dep_dummy" value="0">
      <?php endif; ?>
      
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalAddArsipLabel">
            <i class="fa fa-plus-circle"></i> Tambah Arsip
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Hidden file input -->
          <input type="file" id="multiFileInput" name="file_multiple[]" multiple style="display:none;">

          <!-- Tabel Arsip -->
          <div class="table-responsive">
            <table class="table table-bordered" id="tableArsipAdd">
              <thead>
                <tr>
                  <th width="40" class="text-center">No</th>
                  <th width="180">File</th>
                  <th width="180">Nama Arsip</th>
                  <?php if (session()->get('level') == 0): ?>
                  <th width="120">Departemen</th>
                  <?php endif; ?>
                  <th width="180">Kategori</th>
                  <th width="200">Deskripsi</th>
                  <th width="180">Klasifikasi</th>
                  <th width="60" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody id="arsip-container">
                <!-- Rows akan ditambahkan via JavaScript -->
              </tbody>
            </table>
          </div>

          <div id="emptyState" class="text-center text-muted py-4">
            <i class="fa fa-inbox fa-3x mb-2"></i>
            <p>Belum ada file yang dipilih. Klik tombol "Tambah Arsip" untuk memulai.</p>
          </div>
        </div>

        <div class="modal-footer">
          <!-- Tombol Tambah Arsip dipindah ke sini -->
          <button type="button" class="btn btn-success" id="btnPilihFile">
            <i class="fa fa-plus"></i> Tambah Arsip
          </button>
          
          <div style="flex: 1;"></div> <!-- Spacer -->
          
          <button type="submit" class="btn btn-primary" id="btnSimpanArsip">
            <i class="fa fa-save"></i> Simpan
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i> Batal
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<link rel="stylesheet" href="<?= base_url('template/custom/css/modal_add_arsip.css') ?>">

<?= $this->section('scripts') ?>
<script src="<?= base_url('template/custom/js/modal_add_arsip.js') ?>"></script>
<?= $this->endSection() ?>