<div class="modal fade" id="modalAddArsip" tabindex="-1" aria-labelledby="modalAddArsipLabel" aria-hidden="true">
  <div class="modal-dialog modal-xxl"> <!-- diperlebar dari modal-xl ke modal-xxl -->
    <form id="formAddArsip" action="<?= base_url('arsip/addArsip') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalAddArsipLabel">
            <i class="fa fa-plus-circle"></i> Tambah Arsip
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">×</button>
        </div>

        <div class="modal-body">
          <!-- Tombol Pilih File -->
          <div class="mb-3 text-right">
            <button type="button" class="btn btn-sm btn-success" id="btnPilihFile">
              <i class="fa fa-file"></i> Pilih File Arsip
            </button>
            <input type="file" id="multiFileInput" name="file_multiple[]" multiple style="display:none;">
          </div>

          <small class="text-muted d-block mb-3">Kamu bisa pilih beberapa file sekaligus (Ctrl/Cmd + klik).</small>

          <!-- Container untuk form dinamis -->
          <div id="arsip-container"></div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan Semua
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
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