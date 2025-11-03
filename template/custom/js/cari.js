  $(function() {
    const $table = $('#tableCari');

    // === Setup DataTable tanpa scrollX ===
    $table.find('thead tr').clone(true).addClass('filters').appendTo($table.find('thead'));
    const table = $table.DataTable({
      orderCellsTop: true,
      fixedHeader: false,
      scrollX: false, // Matikan scrollX
      autoWidth: false, // Matikan autoWidth
      pageLength: 25,
      dom: 'l t p r',
      language: {
        paginate: {
          previous: "Previous",
          next: "Next"
        },
        info: ""
      },
      columnDefs: [{
          width: '40px',
          targets: 0,
          orderable: false
        },
        {
          width: '50px',
          targets: 1
        },
        {
          width: '250px',
          targets: 2
        },
        {
          width: '200px',
          targets: 3
        },
        {
          width: '150px',
          targets: 4
        },
        {
          width: '150px',
          targets: 5
        },
        {
          width: '100px',
          targets: 6
        },
        {
          width: '120px',
          targets: 7
        },
        {
          width: '120px',
          targets: 8
        }
      ],
      initComplete: function() {
        const api = this.api();

        api.columns().eq(0).each(function(colIdx) {
          const cell = $('.filters th').eq(colIdx);
          if (colIdx === 0 || colIdx === 1) return $(cell).empty();

          $(cell).html('<input type="text" placeholder="Cari" style="width:100%; font-size:12px;">');
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

    // === Checkbox Select All ===
    $('#selectAll').on('click', function() {
      $('.checkboxArsip:not(:disabled)').prop('checked', this.checked).trigger('change');
    });

    // === Tampilkan Tombol Aksi ===
    $(document).on('change', '.checkboxArsip', function() {
      $('#actionContainer').toggle($('.checkboxArsip:checked').length > 0);
    });

    // === Download Selected ===
    $('#btnDownloadSelected').on('click', function() {
      const files = $('.checkboxArsip:checked').map(function() {
        return $(this).data('file');
      }).get();

      if (files.length) {
        files.forEach(f => {
          const a = document.createElement('a');
          a.href = f;
          a.download = f.split('/').pop();
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
        });
      } else {
        alert('Tidak ada arsip yang bisa diunduh.');
      }
    });

    // === Delete Selected ===
    $('#btnDeleteSelected').on('click', function() {
      if (confirm('Yakin ingin menghapus arsip terpilih?')) {
        $('#formHapusMultiple').submit();
      }
    });

    // === Preview File ===
$(document).off('click', '.preview-link');
$(document).on('click', '.preview-link', function (e) {
  e.preventDefault();
  e.stopPropagation(); // penting, biar gak trigger event lain

  const fileUrl = $(this).data('file');
  if (!fileUrl) return alert('⚠️ File tidak ditemukan, Cak.');

  // Buka tab baru langsung, tanpa fetch dulu
  // Supaya browser anggep ini aksi user, bukan popup liar
  const win = window.open('', '_blank');
  if (!win) {
    alert('🚫 Popup diblokir! Izinkan pop-up untuk situs ini.');
    return;
  }

  // Isikan konten HTML sederhana di tab baru (preview fullscreen)
  win.document.write(`
    <html>
      <head>
        <title>Preview Arsip</title>
        <style>
          html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            background: #000;
          }
          iframe {
            border: none;
            width: 100%;
            height: 100%;
          }
        </style>
      </head>
      <body>
        <iframe src="${fileUrl}" allowfullscreen></iframe>
      </body>
    </html>
  `);
  win.document.close();
});

});