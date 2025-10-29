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

<style>
  /* === Ukuran Modal === */
  #modalAddArsip .modal-dialog {
    width: 55% !important;
    max-width: 55% !important;
  }

  /* === Arsip Item Box === */
  .arsip-item {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px 15px 10px 15px;
    margin-bottom: 15px;
    background: #fff;
  }

  /* Hapus garis putus-putus antar arsip */
  .arsip-item:not(:last-child) {
    border-bottom: none;
  }

  /* === Label dan Input === */
  #modalAddArsip label {
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 4px;
    display: block;
  }

  #modalAddArsip .form-control {
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 13px;
    padding: 6px 8px;
  }

  #modalAddArsip .form-control:focus {
    border-color: #3c8dbc;
  }

  /* === File Arsip dan Tombol Hapus === */
  .file-arsip-container {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .file-arsip-container input {
    flex: 1;
  }

  .btn-remove-arsip {
    flex-shrink: 0;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* === Tombol dan Modal Footer === */
  #modalAddArsip .modal-footer {
    border-top: 1px solid #eee;
  }

  #modalAddArsip .btn {
    border-radius: 5px;
  }
</style>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btnPilihFile = document.getElementById('btnPilihFile');
    const inputMulti = document.getElementById('multiFileInput');
    const container = document.getElementById('arsip-container');

    btnPilihFile.addEventListener('click', () => inputMulti.click());

    inputMulti.addEventListener('change', function() {
      container.innerHTML = '';
      const files = Array.from(this.files);
      if (!files.length) return;

      files.forEach((file, index) => {
        const html = `
        <div class="arsip-item"> 
          <div class="row align-items-end">
            <?php if (session()->get('level') == 0): ?>
            <div class="col-md-3">
              <label>Kategori <span class="text-danger">*</span></label>
              <select name="id_kategori[]" class="form-control input-sm" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($kategori as $k): ?>
                  <option value="<?= $k['id_kategori'] ?>"><?= esc($k['nama_kategori']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label>Klasifikasi <span class="text-danger">*</span></label>
              <select name="klasifikasi[]" class="form-control input-sm klasifikasi-select" required>
                <option value="">-- Pilih --</option>
                <option value="umum">Umum</option>
                <option value="terbatas">Terbatas</option>
                <option value="rahasia">Rahasia</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Departemen <span class="text-danger">*</span></label>
              <select name="id_dep[]" class="form-control input-sm" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($departemen as $d): ?>
                  <option value="<?= $d['id_dep'] ?>"><?= esc($d['nama_dep']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label>File Arsip</label>
              <div class="file-arsip-container">
                <input type="text" readonly class="form-control input-sm" value="${file.name}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-arsip">
                  <i class="fa fa-trash"></i>
              </button>
            </div>
            <?php else: ?>
            <div class="col-md-4">
              <label>Kategori <span class="text-danger">*</span></label>
              <select name="id_kategori[]" class="form-control input-sm" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($kategori as $k): ?>
                  <option value="<?= $k['id_kategori'] ?>"><?= esc($k['nama_kategori']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label>Klasifikasi <span class="text-danger">*</span></label>
              <select name="klasifikasi[]" class="form-control input-sm klasifikasi-select" required>
                <option value="">-- Pilih --</option>
                <option value="umum">Umum</option>
                <option value="terbatas">Terbatas</option>
                <option value="rahasia">Rahasia</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>File Arsip</label>
              <div class="file-arsip-container">
                <input type="text" readonly class="form-control input-sm" value="${file.name}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-arsip">
                  <i class="fa fa-trash"></i>
              </button>
            </div>
          <?php endif; ?>
          </div>
          <input type="hidden" name="file_arsip_names[]" value="${file.name}">

          <div class="form-group mt-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi[]" class="form-control" rows="2"></textarea>
          </div>

          <div class="akses-container" style="display:none;">
            <label class="font-weight-bold mb-2">Akses Departemen & User</label>
            <div class="row">
              <?php foreach ($departemen as $dep): ?>
              <div class="col-md-4 mb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input dep-checkbox"
                         id="dep-<?= $dep['id_dep'] ?>-${index}"
                         name="akses_dep[${index}][]"
                         value="<?= $dep['id_dep'] ?>">
                  <label class="custom-control-label" for="dep-<?= $dep['id_dep'] ?>-${index}">
                    <?= esc($dep['nama_dep']) ?>
                  </label>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="mt-3">
              <label>User Spesifik</label>
              <select name="akses_user_global[${index}][]" class="form-control" multiple size="5">
                <?php foreach ($users as $u): ?>
                  <option value="<?= $u['id_user'] ?>">
                    <?= esc($u['nama_user']) ?> (<?= esc($u['nama_dep']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
      });

      // Event toggle akses terbatas
      container.querySelectorAll('.klasifikasi-select').forEach(select => {
        select.addEventListener('change', function() {
          const parent = this.closest('.arsip-item');
          const akses = parent.querySelector('.akses-container');
          akses.style.display = (this.value === 'terbatas') ? 'block' : 'none';
        });
      });

      // Event hapus arsip
      container.querySelectorAll('.btn-remove-arsip').forEach(btn => {
        btn.addEventListener('click', function() {
          this.closest('.arsip-item').remove();
        });
      });
    });
  });
</script>