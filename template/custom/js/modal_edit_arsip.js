$(function() {
  // Initialize Select2
  initSelect2();

  // Event Handlers
  $(document).on('change', '.klasifikasi-select', handleKlasifikasiChange);
  $('.modal').on('shown.bs.modal', function() {
    const select = $(this).find('.klasifikasi-select')[0];
    if (select) handleKlasifikasiChange.call(select);
  });

  // Form Validation
  $('form[id^="formEditArsip"]').on('submit', validateForm);

  // === Functions ===
  function initSelect2() {
    $('.user-global-select').each(function() {
      const modalId = $(this).closest('.modal').attr('id');
      $(this).select2({
        placeholder: 'Pilih user spesifik lintas departemen',
        width: '100%',
        dropdownParent: $('#' + modalId),
        allowClear: true
      });
    });
  }

  function handleKlasifikasiChange() {
    const $item = $(this).closest('.arsip-item');
    const isTerbatas = this.value === 'terbatas';

    $item.find('.akses-container, .akses-user-global').toggle(isTerbatas);

    if (!isTerbatas) {
      $item.find('.dep-checkbox').prop('checked', false);
      $item.find('.user-global-select').val(null).trigger('change');
    }
  }

  function validateForm(e) {
    const $item = $(this).find('.arsip-item');
    const klasifikasi = $item.find('.klasifikasi-select').val();

    if (klasifikasi === 'terbatas') {
      const hasCheckedDeps = $item.find('.dep-checkbox:checked').length > 0;
      const hasSelectedUsers = ($item.find('.user-global-select').val() || []).length > 0;

      if (!hasCheckedDeps && !hasSelectedUsers) {
        e.preventDefault();
        alert('Validasi Gagal:\n\nKlasifikasi "Terbatas" memerlukan minimal 1 departemen atau 1 user spesifik yang dipilih.');
        return false;
      }
    }
    return true;
  }
});