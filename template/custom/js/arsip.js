$(document).ready(function() {
    // === HAPUS DataTable lama jika ada ===
    if ($.fn.DataTable.isDataTable('#tableArsip')) {
        $('#tableArsip').DataTable().destroy();
    }

    // === HAPUS baris filter lama jika sudah ada (prevent duplicate) ===
    $('#tableArsip thead .filters').remove();

    // === TAMBAH baris filter baru ===
    $('#tableArsip thead tr').clone(true).addClass('filters').appendTo('#tableArsip thead');

    // === INITIALIZE DataTable ===
    const table = $('#tableArsip').DataTable({
        orderCellsTop: true,
        fixedHeader: false,
        pageLength: 25,
        scrollX: false,
        autoWidth: false,
        language: {
            paginate: { previous: "Sebelumnya", next: "Selanjutnya" },
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: ""
        },
        columnDefs: [
            { width: '30px', targets: 0, orderable: false },
            { width: '50px', targets: 1 },
            { width: '300px', targets: 2 },
            { width: '150px', targets: 3 },
            { width: '80px', targets: 4 },
            { width: '150px', targets: 5 },
            { width: '120px', targets: 6 },
            { width: '120px', targets: 7 },
            { width: '80px', targets: 8 },
            { width: '100px', targets: 9, orderable: false }
        ],
        initComplete: function() {
            const api = this.api();

            // Loop setiap kolom untuk tambahkan input filter
            api.columns().eq(0).each(function(colIdx) {
                const cell = $('#tableArsip thead .filters th').eq(colIdx);

                // Skip kolom checkbox (0), no (1), dan aksi (9)
                if (colIdx === 0 || colIdx === 1 || colIdx === 9) {
                    cell.html('');
                    return;
                }

                // Buat input filter
                const input = $('<input type="text" placeholder="Cari..." />')
                    .css({
                        'width': '100%',
                        'padding': '4px 6px',
                        'font-size': '12px',
                        'box-sizing': 'border-box',
                        'border': '1px solid #ccc',
                        'border-radius': '3px'
                    })
                    .appendTo(cell.empty())
                    .on('keyup change', function() {
                        if (api.column(colIdx).search() !== this.value) {
                            api.column(colIdx).search(this.value).draw();
                        }
                    });
            });

            console.log('✅ Filter per kolom berhasil ditambahkan!');
        }
    });

    // === Checkbox Select All ===
    $('#selectAll').on('change', function() {
        $('.checkboxArsip').prop('checked', this.checked);
        updateButtonVisibility();
    });

    $('.checkboxArsip').on('change', function() {
        updateButtonVisibility();
    });

    function updateButtonVisibility() {
        const checked = $('.checkboxArsip:checked').length > 0;
        $('#hapusContainer').toggle(checked);
    }

    // === Tambah Arsip ===
    const inputFile = $('#inputFileArsip');
    const btnTambah = $('#btnTambahArsip');

    if (btnTambah.length && inputFile.length) {
        btnTambah.on('click', function(e) {
            e.preventDefault();
            inputFile.click();
        });

        inputFile.on('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                const modalFileInput = $('#modalAddArsip input[name="file_arsip[]"]')[0];
                
                if (modalFileInput) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    modalFileInput.files = dt.files;
                }
                
                $('#modalAddArsip').modal('show');
                this.value = '';
            }
        });
    }

    // === Toggle Akses Terbatas ===
    $(document).on('change', '#klasifikasi', function() {
        const aksesContainer = $('.akses-container');
        if ($(this).val() === 'terbatas') {
            aksesContainer.slideDown(200);
            loadDepartemenList();
        } else {
            aksesContainer.slideUp(200).empty();
        }
    });

    function loadDepartemenList() {
        $.get(BASE_URL + '/departemen/all', function(departemenList) {
            let html = '<label>Pilih Departemen:</label><div class="dep-wrapper">';
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
            html += '</div>';
            $('.akses-container').html(html);
        }, 'json');
    }

    $(document).on('click', '.dep-item label', function(e) {
        e.stopPropagation();
        const depId = $(this).closest('.dep-item').data('dep');
        const userContainer = $(`#user-container-${depId}`);

        if (userContainer.is(':visible')) {
            userContainer.slideUp();
            return;
        }

        if (userContainer.text().trim() === '') {
            userContainer.html('<em>Memuat user...</em>');
            $.get(BASE_URL + '/user/byDepartemen/' + depId, function(users) {
                let html = `<label><input type="checkbox" class="semua-user" data-dep="${depId}"> Semua user</label><br>`;
                users.forEach(u => {
                    html += `<label><input type="checkbox" name="akses_user[${depId}][]" value="${u.id_user}"> ${u.nama_user}</label><br>`;
                });
                userContainer.hide().html(html).slideDown();
            }, 'json');
        } else {
            userContainer.slideDown();
        }
    });

    $(document).on('change', '.semua-user', function() {
        const depId = $(this).data('dep');
        const checked = $(this).is(':checked');
        $(`#user-container-${depId} input[type=checkbox]`).prop('checked', checked);
    });

    // === Reset Modal ===
    $('#modalAddArsip').on('hidden.bs.modal', function() {
        const form = $(this).find('form')[0];
        if (form) {
            $(form).find('input[type="text"], textarea').val('');
            $(form).find('select').prop('selectedIndex', 0);
            $(form).find('input[type="file"]').val('');
        }
    });

  // === Preview File ===
  $(document).off('click', '.preview-link');
  $(document).on('click', '.preview-link', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const fileUrl = $(this).data('file');
    const fileName = $(this).data('nama');
    
    if (!fileUrl) {
      alert('⚠️ File tidak ditemukan.');
      return;
    }

    const ext = fileName.split('.').pop().toLowerCase();

    // ✅ PDF & Gambar: Buka langsung di tab baru
    if (['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(ext)) {
      window.open(fileUrl, '_blank');
      return;
    }

    // ⚠️ File Office (Excel, Word, PowerPoint): Tampilkan peringatan
    if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
      const pesan = `File ${ext.toUpperCase()} tidak dapat di-preview langsung di browser.\n\n` +
                    `Silakan:\n` +
                    `1. Download file terlebih dahulu\n` +
                    `2. Buka dengan Microsoft Office atau LibreOffice\n\n` +
                    `Klik OK untuk download file.`;
      
      if (confirm(pesan)) {
        window.location.href = fileUrl;
      }
      return;
    }

    // 📄 File teks lainnya
    if (['txt', 'csv', 'log', 'json', 'xml'].includes(ext)) {
      window.open(fileUrl, '_blank');
      return;
    }

    // 📦 File lain: Langsung download
    window.location.href = fileUrl;
    });
});