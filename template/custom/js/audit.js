$(document).ready(function() {
  const $table = $('#tableAudit');

  // === Destroy DataTable lama jika ada ===
  if ($.fn.DataTable.isDataTable('#tableAudit')) {
    $('#tableAudit').DataTable().destroy();
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
    order: [[5, 'desc']], // Sort by Waktu (kolom ke-6) descending
    dom: 'l t p r',
    language: {
      paginate: {
        previous: "Previous",
        next: "Next"
      },
      lengthMenu: "Tampilkan _MENU_ data",
      info: ""
    },
    columnDefs: [
      { width: '50px', targets: 0 },
      { width: '150px', targets: 1 },
      { width: '150px', targets: 2 },
      { width: '300px', targets: 3 },
      { width: '120px', targets: 4 },
      { width: '150px', targets: 5 }
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

      console.log('✅ Filter per kolom audit berhasil ditambahkan!');
    }
  });
});