$(document).ready(function() {
    // === Toggle akses terbatas saat klasifikasi berubah (EDIT) ===
    $(document).on('change', '.klasifikasi-select-edit', function() {
        const arsipId = $(this).data('arsip-id');
        const aksesContainer = $(`#akses-edit-${arsipId}`);
        
        if ($(this).val() === 'terbatas') {
            aksesContainer.slideDown(200);
            // Expand departemen yang sudah dicentang
            aksesContainer.find('.dep-checkbox:checked').each(function() {
                const depId = $(this).val();
                $(`#user-container-edit-${arsipId}-${depId}`).slideDown();
            });
        } else {
            aksesContainer.slideUp(200);
        }
    });

    // === Klik departemen untuk toggle user (EDIT) ===
    $(document).on('click', '.dep-item-inline label', function(e) {
        if ($(e.target).is('input')) return;
        
        const depItem = $(this).closest('.dep-item-inline');
        const depId = depItem.data('dep');
        
        // Cari arsipId dari container terdekat
        const modal = $(this).closest('.modal');
        const arsipId = modal.attr('id').replace('updateArsip', '');
        
        const userContainer = $(`#user-container-edit-${arsipId}-${depId}`);
        userContainer.slideToggle();
    });

    // === Pilih semua user dalam departemen (EDIT) ===
    $(document).on('change', '.semua-user-edit', function() {
        const arsipId = $(this).data('arsip-id');
        const depId = $(this).data('dep');
        const checked = $(this).is(':checked');
        $(`.user-checkbox-edit-${arsipId}-${depId}`).prop('checked', checked);
    });

    // === Trigger klasifikasi change saat modal dibuka ===
    $('.modal[id^="updateArsip"]').on('shown.bs.modal', function() {
        const arsipId = $(this).attr('id').replace('updateArsip', '');
        const klasifikasi = $(this).find('.klasifikasi-select-edit').val();
        
        if (klasifikasi === 'terbatas') {
            $(`#akses-edit-${arsipId}`).show();
            // Expand departemen yang sudah dicentang
            $(`#akses-edit-${arsipId}`).find('.dep-checkbox:checked').each(function() {
                const depId = $(this).val();
                $(`#user-container-edit-${arsipId}-${depId}`).show();
            });
        }
    });

    // === Form Validation ===
    $('form[id^="formEditArsip"]').on('submit', function(e) {
        const klasifikasi = $(this).find('.klasifikasi-select-edit').val();
        
        if (klasifikasi === 'terbatas') {
            const hasCheckedDeps = $(this).find('.dep-checkbox:checked').length > 0;
            const hasCheckedUsers = $(this).find('input[name="akses_user_global[]"]:checked').length > 0;
            
            if (!hasCheckedDeps && !hasCheckedUsers) {
                e.preventDefault();
                alert('Validasi Gagal:\n\nKlasifikasi "Terbatas" memerlukan minimal 1 departemen atau 1 user spesifik yang dipilih.');
                return false;
            }
        }
        return true;
    });
});