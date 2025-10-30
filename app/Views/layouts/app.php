<!DOCTYPE html>
<html>

<?= view('layouts/v_head'); ?>

<body class="hold-transition skin-blue sidebar-mini <?= ['superadmin', 'admin', 'user'][session()->get('level') ?? 2] ?>">

  <?= view('layouts/v_wrapper'); ?>

  <!-- Core JavaScript -->
  <script src="<?= base_url('template/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>

  <script src="<?= base_url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/moment/min/moment.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/fastclick/lib/fastclick.js') ?>"></script>
  <script src="<?= base_url('template/dist/js/adminlte.min.js') ?>"></script>

  <!-- DataTables -->
  <script src="<?= base_url('template/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>

  <!-- Chart.js (hanya jika digunakan) -->
  <?php if (in_array($page ?? '', ['home', 'dashboard'])): ?>
    <script src="<?= base_url('template/plugins/chartjs/Chart.min.js') ?>"></script>
  <?php endif; ?>

  <!-- Custom Scripts -->
  <script src="<?= base_url('template/custom/js/arsip.js') ?>"></script>

  <script>
    $(function() {
      // Auto-initialize DataTables
      const tables = ['#tableUser', '#tableDep', '#tableKat', '#tableArsip', '#tableAudit', '#tableHome'];
      tables.forEach(id => {
        if ($(id).length && !$.fn.DataTable.isDataTable(id)) {
          $(id).DataTable({
            pageLength: 25
          });
        }
      });

      // Auto-dismiss alerts
      setTimeout(() => {
        $('.alert').fadeTo(500, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 3000);

      // Sidebar submenu positioning
      $('.main-sidebar .treeview').on('mouseenter', function() {
        if ($('body').hasClass('sidebar-collapse')) {
          const offsetTop = $(this).position().top - $('.main-sidebar').scrollTop();
          $(this).find('.treeview-menu').css('top', offsetTop + 'px');
        }
      });
    });

    // Preview file function
    function previewFile(fileName) {
      $('#previewIframe').attr('src', '<?= base_url('preview') ?>/' + fileName);
      $('#previewModal').modal('show');
    }
  </script>

  <!-- Page-specific scripts -->
  <?= $this->renderSection('scripts') ?>

</body>

</html>