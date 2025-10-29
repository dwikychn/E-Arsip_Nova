$(function () {
    // === DataTable ===
    if ($.fn.DataTable.isDataTable('#tableArsip')) $('#tableArsip').DataTable().destroy();
    $('#tableArsip').DataTable({ pageLength: 100, language: { info: "" } });

    // === Checkbox & Tombol hapus terpilih ===
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.checkboxArsip');
    const hapusContainer = document.getElementById('hapusContainer');

    function updateButtonVisibility() {
        const adaYangDicentang = Array.from(checkboxes).some(cb => cb.checked);
        if (hapusContainer) hapusContainer.style.display = adaYangDicentang ? 'block' : 'none';
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateButtonVisibility();
        });
    }
    checkboxes.forEach(cb => cb.addEventListener('change', updateButtonVisibility));

    // === Tambah Arsip (Versi B) ===
    const inputFile = document.getElementById("inputFileArsip");
    const btnTambah = document.getElementById("btnTambahArsip");
    const modal = $("#modalAddArsip");

    if (btnTambah && inputFile) {
        btnTambah.addEventListener("click", e => {
            e.preventDefault();
            inputFile.click();
        });

        inputFile.addEventListener("change", function () {
            if (this.files.length === 0) return;
            const file = this.files[0];
            const modalFileInput = modal.find('input[name="file_arsip[]"]')[0];
            if (modalFileInput) {
                const dt = new DataTransfer();
                dt.items.add(file);
                modalFileInput.files = dt.files;
            }
            modal.modal("show");
            this.value = "";
        });
    }

    // === Toggle akses terbatas ===
    $(document).on("change", "#klasifikasi", function () {
        const aksesContainer = $(".akses-container");
        if ($(this).val() === "terbatas") {
            aksesContainer.slideDown(200);
            loadDepartemenList(); // panggil untuk generate daftar dep saat buka
        } else {
            aksesContainer.slideUp(200).empty();
        }
    });

    // === Load daftar departemen ===
    function loadDepartemenList() {
        $.get(`${BASE_URL}/departemen/all`, function (departemenList) {
            let html = "<label>Pilih Departemen:</label><div class='dep-wrapper'>";
            departemenList.forEach(dep => {
                html += `
                    <div class="dep-item" data-dep="${dep.id_dep}" style="border:1px solid #ccc; padding:6px; margin:4px; border-radius:6px;">
                        <label>
                            <input type="checkbox" class="dep-checkbox" name="akses_dep[]" value="${dep.id_dep}">
                            ${dep.nama_dep}
                        </label>
                        <div class="user-container" id="user-container-${dep.id_dep}" style="margin-left:10px; display:none;"></div>
                    </div>
                `;
            });
            html += "</div>";
            $(".akses-container").html(html);
        }, 'json');
    }

    // === Klik departemen untuk load user-nya ===
    $(document).on('click', '.dep-item label', function (e) {
        e.stopPropagation();
        const depId = $(this).closest('.dep-item').data('dep');
        const userContainer = $(`#user-container-${depId}`);

        if (userContainer.is(':visible')) {
            userContainer.slideUp();
            return;
        }

        if (userContainer.text().trim() === "") {
            userContainer.html("<em>Memuat user...</em>");
            $.get(`${BASE_URL}/user/byDepartemen/${depId}`, function (users) {
                let html = `
                    <label><input type="checkbox" class="semua-user" data-dep="${depId}"> Semua user</label><br>
                `;
                users.forEach(u => {
                    html += `
                        <label>
                            <input type="checkbox" name="akses_user[${depId}][]" value="${u.id_user}">
                            ${u.nama_user}
                        </label><br>
                    `;
                });
                userContainer.hide().html(html).slideDown();
            }, 'json');
        } else {
            userContainer.slideDown();
        }
    });

    // === Pilih semua user dalam satu departemen ===
    $(document).on('change', '.semua-user', function () {
        const depId = $(this).data('dep');  
        const checked = $(this).is(':checked');
        $(`#user-container-${depId} input[type=checkbox]`).prop('checked', checked);
    });

    // Reset form saat modal ditutup
    $("#modalAddArsip").on("hidden.bs.modal", function () {
    const form = $(this).find("form")[0];
    if (form) {
        form.querySelectorAll("input[type='text'], textarea").forEach(el => el.value = "");
        form.querySelectorAll("select").forEach(el => el.selectedIndex = 0);
        form.querySelectorAll("input[type='file']").forEach(el => el.value = "");
    }

    });


    // === Preview file ===
$(document).on('click', '.preview-link', function(e) {
  e.preventDefault();

  const fileUrl = $(this).data('file');
  const fileName = $(this).data('nama');
  const ext = fileName.split('.').pop().toLowerCase();

  let viewerUrl = '';

  // --- PDF & gambar: langsung tampil di tab baru (dengan toolbar bawaan browser)
  if (['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'].includes(ext)) {
    viewerUrl = `${fileUrl}#toolbar=1`;
  }

  // --- Dokumen office: lewat Google Docs Viewer biar tampil embed
  else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf'].includes(ext)) {
    viewerUrl = `https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true`;
  }

  // --- File aneh: langsung download
  else {
    window.location.href = fileUrl;
    return;
  }

  // --- Buka di tab baru
  const newTab = window.open();
  if (newTab) {
    newTab.document.write(`
      <html>
        <head>
          <title>Preview: ${fileName}</title>
          <style>
            html, body { height: 100%; margin: 0; background: #111; color: #ccc; display: flex; justify-content: center; align-items: center; }
            iframe { border: none; width: 100%; height: 100%; }
          </style>
        </head>
        <body>
          <iframe src="${viewerUrl}" allow="autoplay; fullscreen"></iframe>
        </body>
      </html>
    `);
    newTab.document.close();
  } else {
    alert("Pop-up diblokir! Izinkan pop-up untuk melihat preview.");
  }
});

});
