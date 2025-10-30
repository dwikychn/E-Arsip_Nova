document.addEventListener('DOMContentLoaded', function () {
  const btnPilihFile = document.getElementById('btnPilihFile');
  const inputMulti = document.getElementById('multiFileInput');
  const container = document.getElementById('arsip-container');

  if (!btnPilihFile || !inputMulti || !container) return;

  btnPilihFile.addEventListener('click', () => inputMulti.click());

  inputMulti.addEventListener('change', function () {
    container.innerHTML = '';
    const files = Array.from(this.files);
    if (!files.length) return;

    files.forEach((file, index) => {
      // generate opsi dropdown dari data global
      const kategoriOptions = kategoriList
        .map(k => `<option value="${k.id_kategori}">${k.nama_kategori}</option>`)
        .join('');
      const depOptions = departemenList
        .map(d => `<option value="${d.id_dep}">${d.nama_dep}</option>`)
        .join('');
      const userOptions = (typeof usersList !== 'undefined' ? usersList : [])
        .map(u => `<option value="${u.id_user}">${u.nama_user} (${u.nama_dep})</option>`)
        .join('');

      const fileInputHTML = `
      <div class="arsip-item">
        <div class="row align-items-end">
          ${userLevel == 0
            ? `
            <div class="col-md-3">
              <label>Kategori <span class="text-danger">*</span></label>
              <select name="id_kategori[]" class="form-control input-sm" required>
                <option value="">-- Pilih --</option>
                ${kategoriOptions}
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
                ${depOptions}
              </select>
            </div>
            <div class="col-md-3">
              <label>File Arsip</label>
              <div class="file-arsip-container d-flex">
                <input type="text" readonly class="form-control input-sm" value="${file.name}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-arsip ml-2">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </div>`
            : `
            <div class="col-md-4">
              <label>Kategori <span class="text-danger">*</span></label>
              <select name="id_kategori[]" class="form-control input-sm" required>
                <option value="">-- Pilih --</option>
                ${kategoriOptions}
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
              <div class="file-arsip-container d-flex">
                <input type="text" readonly class="form-control input-sm" value="${file.name}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-arsip ml-2">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </div>`
          }
        </div>

        <input type="hidden" name="file_arsip_names[]" value="${file.name}">

        <div class="form-group mt-3">
          <label>Nama Arsip</label>
          <input type="text" name="nama_arsip[]" class="form-control" placeholder="Masukkan nama arsip (opsional)">
        </div>
        <div class="form-group mt-3">
          <label>Deskripsi</label>
          <textarea name="deskripsi[]" class="form-control" rows="2"></textarea>
        </div>

        <div class="akses-container" style="display:none;">
          <label class="font-weight-bold mb-2">Akses Departemen & User</label>
          <div class="row">
            ${departemenList.map(dep => `
              <div class="col-md-4 mb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input dep-checkbox"
                         id="dep-${dep.id_dep}-${index}"
                         name="akses_dep[${index}][]"
                         value="${dep.id_dep}">
                  <label class="custom-control-label" for="dep-${dep.id_dep}-${index}">
                    ${dep.nama_dep}
                  </label>
                </div>
              </div>`).join('')}
          </div>

          <div class="mt-3">
            <label>User Spesifik</label>
            <select name="akses_user_global[${index}][]" class="form-control" multiple size="5">
              ${userOptions}
            </select>
          </div>
        </div>
      </div>`;

      container.insertAdjacentHTML('beforeend', fileInputHTML);
    });

    // === Event handler dinamis ===
    container.querySelectorAll('.klasifikasi-select').forEach(select => {
      select.addEventListener('change', function () {
        const parent = this.closest('.arsip-item');
        const akses = parent.querySelector('.akses-container');
        akses.style.display = (this.value === 'terbatas') ? 'block' : 'none';
      });
    });

    container.querySelectorAll('.btn-remove-arsip').forEach(btn => {
      btn.addEventListener('click', function () {
        this.closest('.arsip-item').remove();
      });
    });
  });
});
