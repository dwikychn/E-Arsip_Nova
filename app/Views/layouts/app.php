<!DOCTYPE html>
<html>

<?= view('layouts/v_head'); ?>

<body class="hold-transition skin-blue sidebar-mini 
<?php
$level = session()->get('level');
echo ($level == 0) ? 'superadmin' : (($level == 1) ? 'admin' : 'user');
?>">

  <?= view('layouts/v_wrapper'); ?>

  <!-- ========================================================= -->
  <!-- 🧩 Core JS dan plugin utama -->
  <!-- ========================================================= -->
  <script src="<?= base_url('template/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <script src="<?= base_url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/raphael/raphael.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/morris.js/morris.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>"></script>
  <script src="<?= base_url('template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
  <script src="<?= base_url('template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/moment/min/moment.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
  <script src="<?= base_url('template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/fastclick/lib/fastclick.js') ?>"></script>
  <script src="<?= base_url('template/dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url('template/dist/js/demo.js') ?>"></script>

  <!-- ========================================================= -->
  <!-- 🧩 DataTables & Chart.js -->
  <!-- ========================================================= -->
  <script src="<?= base_url('template/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>

  <script src="<?= base_url('template/plugins/chartjs/Chart.min.js') ?>"></script>
  <script src="<?= base_url('template/plugins/chartjs/chart.js') ?>"></script>

  <!-- ========================================================= -->
  <!-- 🧩 Custom JS -->
  <!-- ========================================================= -->
  <script src="<?= base_url('template/custom/js/arsip.js') ?>"></script>

  <script>
    // === Inisialisasi tabel global (non-page specific)
    $(document).ready(function() {
      const globalTables = ["#tableUser", "#tableDep", "#tableKat", "#tableArsip", "#tableAudit", "#tableHome"];
      globalTables.forEach(id => {
        if ($(id).length && !$.fn.DataTable.isDataTable(id)) {
          $(id).DataTable({
            "pageLength": 25
          });
        }
      });

      // === Fade out alert otomatis ===
      window.setTimeout(function() {
        $('.alert').fadeTo(500, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 3000);
    });

    // === Fungsi preview file ===
    function previewFile(fileName) {
      document.getElementById('previewIframe').src = "<?= base_url('preview') ?>/" + fileName;
      $('#previewModal').modal('show');
    }
  </script>

  <!-- ========================================================= -->
  <!-- 🧩 Script tambahan khusus halaman (misal: cari.php) -->
  <!-- ========================================================= -->
  <?= $this->renderSection('scripts') ?>

  <!-- ========================================================= -->
  <!-- 🧩 Script kecil tambahan UI (sidebar hover, dll.) -->
  <!-- ========================================================= -->
  <script>
    $(function() {
      // === Posisi submenu mengikuti item yang dihover ===
      $('.main-sidebar .treeview').on('mouseenter', function() {
        if ($('body').hasClass('sidebar-collapse')) {
          const sidebarScroll = $('.main-sidebar').scrollTop();
          const offsetTop = $(this).position().top - sidebarScroll;
          $(this).find('.treeview-menu').css('top', offsetTop + 'px');
        }
      });
    });
  </script>

</body>
</html>
