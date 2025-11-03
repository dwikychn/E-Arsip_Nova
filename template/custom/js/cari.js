$(document).ready(function() {
  const $table = $('#tableCari');

  // === Destroy DataTable lama jika ada ===
  if ($.fn.DataTable.isDataTable('#tableCari')) {
    $('#tableCari').DataTable().destroy();
  }

  // === Hapus baris filter lama (prevent duplicate) ===
  $table.find('thead .filters').remove();

  // === Clone header untuk filter row ===
  $table.find('thead tr').clone(true).addClass('filters').appendTo($table.find('thead'));

  // === Setup DataTable ===
  const table = $table.DataTable({
    orderCellsTop: true,
    fixedHeader: false,
    scrollX: false,
    autoWidth: false,
    pageLength: 25,
    dom: 'l t p r',
    language: {
      paginate: {
        previous: "Previous",
        next: "Next"
      },
      info: ""
    },
    columnDefs: [
      { width: '50px', targets: 0 },
      { width: '300px', targets: 1 },
      { width: '200px', targets: 2 },
      { width: '80px', targets: 3 },
      { width: '150px', targets: 4 },
      { width: '80px', targets: 5 },
      { width: '120px', targets: 6 },
      { width: '120px', targets: 7 }
    ],
    initComplete: function() {
      const api = this.api();

      api.columns().eq(0).each(function(colIdx) {
        const cell = $('.filters th').eq(colIdx);
        
        // Skip kolom No (0)
        if (colIdx === 0) {
          return $(cell).empty();
        }

        $(cell).html('<input type="text" placeholder="Cari..." style="width:100%; font-size:12px;">');
        $('input', cell).on('keyup change clear', function() {
          if (api.column(colIdx).search() !== this.value) {
            api.column(colIdx).search(this.value).draw();
          }
        });
      });

      // Force adjust setelah rendering selesai
      setTimeout(function() {
        api.columns.adjust();
      }, 50);
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