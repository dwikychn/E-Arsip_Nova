$(document).ready(function() {
    let arsipCounter = 0;
    let filesArray = [];

    // === Auto-trigger file picker saat modal dibuka ===
    $('#modalAddArsip').on('shown.bs.modal', function() {
        // Auto-trigger file picker jika belum ada file
        if (filesArray.length === 0) {
            setTimeout(function() {
                $('#multiFileInput').click();
            }, 300);
        }
    });

    // === Tombol Pilih File ===
    $('#btnPilihFile').on('click', function() {
        $('#multiFileInput').click();
    });

    // === Saat file dipilih ===
    $('#multiFileInput').on('change', function() {
        const files = Array.from(this.files);
        
        if (files.length > 0) {
            files.forEach(file => {
                filesArray.push(file);
                addArsipRow(file);
            });
            toggleEmptyState();
        }
        
        this.value = '';
    });

    // === Function tambah baris arsip ===
    function addArsipRow(file) {
        arsipCounter++;
        const fileName = file ? file.name : '';
        const fileIndex = filesArray.length - 1;
        
        const isSuper = (typeof userLevel !== 'undefined' && userLevel == 0);
        
        let departemenCol = '';
        if (isSuper) {
            departemenCol = `
                <td>
                    <select name="id_dep[${fileIndex}]" class="form-control" required>
                        <option value="">Pilih Departemen</option>
                        ${getDepartemenOptions()}
                    </select>
                </td>
            `;
        }
        
        const row = `
            <tr data-index="${arsipCounter}" data-file-index="${fileIndex}">
                <td class="text-center">${arsipCounter}</td>
                <td>
                    <div class="file-column-container">
                        <button type="button" class="btn btn-sm btn-default btn-file" disabled title="${fileName}">
                            <i class="fa fa-file"></i> ${truncateFileName(fileName, 15)}
                        </button>
                        <button type="button" class="btn btn-sm btn-warning btn-change-file" data-file-index="${fileIndex}">
                            <i class="fa fa-refresh"></i> Ganti File
                        </button>
                        <input type="file" class="file-input-hidden" data-file-index="${fileIndex}" style="display:none;">
                    </div>
                </td>
                <td>
                    <input type="text" name="nama_arsip[${fileIndex}]" class="form-control" placeholder="Opsional (akan pakai nama file jika kosong)">
                </td>
                ${departemenCol}
                <td>
                    <select name="id_kategori[${fileIndex}]" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        ${getKategoriOptions()}
                    </select>
                </td>
                <td>
                    <textarea name="deskripsi[${fileIndex}]" class="form-control" rows="2" placeholder="Deskripsi (opsional)"></textarea>
                </td>
                <td class="klasifikasi-cell">
                    <select name="klasifikasi[${fileIndex}]" class="form-control klasifikasi-select" data-file-index="${fileIndex}" required>
                        <option value="">Pilih Klasifikasi</option>
                        <option value="umum">Umum</option>
                        <option value="terbatas">Terbatas</option>
                        <option value="rahasia">Rahasia</option>
                    </select>
                    
                    <div class="akses-terbatas-container" id="akses-${fileIndex}" style="display:none;">
                        <strong style="font-size:12px; color:#333;">Akses Terbatas:</strong>
                        <div class="akses-content"></div>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-remove" onclick="removeArsipRow(${arsipCounter}, ${fileIndex})">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#arsip-container').append(row);
    }

    // === Tombol Ganti File ===
    $(document).on('click', '.btn-change-file', function() {
        const fileIndex = $(this).data('file-index');
        $(`.file-input-hidden[data-file-index="${fileIndex}"]`).click();
    });

    // === Saat file diganti ===
    $(document).on('change', '.file-input-hidden', function() {
        const fileIndex = $(this).data('file-index');
        const newFile = this.files[0];
        
        if (newFile) {
            // Update file di array
            filesArray[fileIndex] = newFile;
            
            // Update tampilan nama file
            const row = $(`tr[data-file-index="${fileIndex}"]`);
            const fileName = newFile.name;
            row.find('.btn-file').attr('title', fileName).html(`<i class="fa fa-file"></i> ${truncateFileName(fileName, 15)}`);
            
            // Reset input
            this.value = '';
        }
    });

    // === Truncate file name ===
    function truncateFileName(name, maxLength) {
        if (name.length <= maxLength) return name;
        const ext = name.split('.').pop();
        const nameWithoutExt = name.substring(0, name.lastIndexOf('.'));
        const truncated = nameWithoutExt.substring(0, maxLength - ext.length - 4) + '...' + ext;
        return truncated;
    }

    // === Toggle akses terbatas saat klasifikasi berubah ===
    $(document).on('change', '.klasifikasi-select', function() {
        const fileIndex = $(this).data('file-index');
        const aksesContainer = $(`#akses-${fileIndex}`);
        
        if ($(this).val() === 'terbatas') {
            aksesContainer.slideDown(200);
            if (aksesContainer.find('.akses-content').is(':empty')) {
                loadDepartemenForFile(fileIndex);
            }
        } else {
            aksesContainer.slideUp(200);
        }
    });

    // === Load departemen untuk file tertentu ===
    function loadDepartemenForFile(fileIndex) {
        const container = $(`#akses-${fileIndex} .akses-content`);
        
        if (typeof departemenList !== 'undefined' && departemenList.length > 0) {
            let html = '<small class="text-muted" style="font-size:11px; display:block; margin-bottom:8px;">Pilih departemen yang boleh akses:</small>';
            html += '<div class="dep-wrapper">';
            
            departemenList.forEach(dep => {
                html += `
                    <div class="dep-item-inline" data-dep="${dep.id_dep}">
                        <label style="font-weight:normal; margin-bottom:0; cursor:pointer;">
                            <input type="checkbox" class="dep-checkbox" name="akses_dep[${fileIndex}][]" value="${dep.id_dep}">
                            ${dep.nama_dep}
                        </label>
                        <div class="user-container-inline" id="user-container-${fileIndex}-${dep.id_dep}" style="display:none;"></div>
                    </div>
                `;
            });
            
            html += '</div>';
            html += '<hr style="margin:10px 0;">';
            html += '<small class="text-muted" style="font-size:11px; display:block; margin-bottom:8px;">Atau pilih user global:</small>';
            html += `<div id="user-global-${fileIndex}" style="max-height:150px; overflow-y:auto;"></div>`;
            
            container.html(html);
            loadUsersGlobal(fileIndex);
        }
    }

    // === Load users global ===
    function loadUsersGlobal(fileIndex) {
        const container = $(`#user-global-${fileIndex}`);
        
        if (typeof usersList !== 'undefined' && usersList.length > 0) {
            let html = '';
            usersList.forEach(u => {
                html += `
                    <label style="font-weight:normal; display:block; margin-bottom:5px; font-size:11px;">
                        <input type="checkbox" name="akses_user_global[${fileIndex}][]" value="${u.id_user}">
                        ${u.nama_user} <span class="text-muted">(${u.nama_dep || 'N/A'})</span>
                    </label>
                `;
            });
            container.html(html);
        } else {
            container.html('<em style="font-size:11px; color:#999;">Tidak ada user tersedia</em>');
        }
    }

    // === Klik departemen untuk load user ===
    $(document).on('click', '.dep-item-inline label', function(e) {
        if ($(e.target).is('input')) return;
        
        const depItem = $(this).closest('.dep-item-inline');
        const depId = depItem.data('dep');
        const checkbox = depItem.find('.dep-checkbox');
        const match = checkbox.attr('name').match(/akses_dep\[(\d+)\]/);
        
        if (!match) return;
        const fileIndex = match[1];
        
        const userContainer = $(`#user-container-${fileIndex}-${depId}`);
        
        if (userContainer.is(':visible')) {
            userContainer.slideUp();
            return;
        }
        
        if (userContainer.text().trim() === '') {
            userContainer.html('<em style="font-size:11px;">Memuat user...</em>');
            
            if (typeof usersList !== 'undefined') {
                const usersInDep = usersList.filter(u => u.id_dep == depId);
                let html = `<label style="font-weight:normal; font-size:11px;"><input type="checkbox" class="semua-user" data-file-index="${fileIndex}" data-dep="${depId}"> <small>Semua user</small></label><br>`;
                
                usersInDep.forEach(u => {
                    html += `
                        <label style="font-weight:normal; display:block; font-size:11px;">
                            <input type="checkbox" class="user-checkbox-${fileIndex}-${depId}" name="akses_user[${fileIndex}][${depId}][]" value="${u.id_user}">
                            <small>${u.nama_user}</small>
                        </label>
                    `;
                });
                
                userContainer.hide().html(html).slideDown();
            }
        } else {
            userContainer.slideDown();
        }
    });

    // === Pilih semua user dalam departemen ===
    $(document).on('change', '.semua-user', function() {
        const fileIndex = $(this).data('file-index');
        const depId = $(this).data('dep');
        const checked = $(this).is(':checked');
        $(`.user-checkbox-${fileIndex}-${depId}`).prop('checked', checked);
    });

    // === Function hapus baris ===
    window.removeArsipRow = function(rowIndex, fileIndex) {
        $(`tr[data-index="${rowIndex}"]`).remove();
        filesArray[fileIndex] = null;
        updateRowNumbers();
        toggleEmptyState();
    };

    // === Update nomor urut setelah hapus ===
    function updateRowNumbers() {
        $('#arsip-container tr').each(function(idx) {
            $(this).find('td:first').text(idx + 1);
        });
    }

    // === Toggle empty state ===
    function toggleEmptyState() {
        const rowCount = $('#arsip-container tr').length;
        if (rowCount === 0) {
            $('#emptyState').addClass('show');
            $('#tableArsipAdd').hide();
        } else {
            $('#emptyState').removeClass('show');
            $('#tableArsipAdd').show();
        }
    }

    // === Get kategori options ===
    function getKategoriOptions() {
        let options = '';
        
        if (typeof kategoriList !== 'undefined' && kategoriList.length > 0) {
            kategoriList.forEach(kat => {
                const indent = '&nbsp;'.repeat((kat.level || 0) * 4);
                options += `<option value="${kat.id_kategori}">${indent}${kat.nama_kategori}</option>`;
            });
        }
        
        return options;
    }

    // === Get departemen options (untuk super admin) ===
    function getDepartemenOptions() {
        let options = '';
        
        if (typeof departemenList !== 'undefined' && departemenList.length > 0) {
            departemenList.forEach(dep => {
                options += `<option value="${dep.id_dep}">${dep.nama_dep}</option>`;
            });
        }
        
        return options;
    }

    // === Submit form dengan FormData ===
    $('#formAddArsip').on('submit', function(e) {
        e.preventDefault();
        
        const rowCount = $('#arsip-container tr').length;
        if (rowCount === 0) {
            alert('Silakan tambahkan minimal 1 file arsip!');
            return false;
        }

        const formData = new FormData(this);
        formData.delete('file_multiple[]');
        
        filesArray.forEach((file, index) => {
            if (file !== null) {
                formData.append('file_multiple[]', file);
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalAddArsip').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat upload. Silakan coba lagi.');
                console.error(xhr);
            }
        });
    });

    // === Reset modal saat ditutup ===
    $('#modalAddArsip').on('hidden.bs.modal', function() {
        $('#arsip-container').empty();
        filesArray = [];
        arsipCounter = 0;
        toggleEmptyState();
        $('#formAddArsip')[0].reset();
    });

    toggleEmptyState();
});