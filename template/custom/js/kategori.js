// === HANDLE TREE VIEW COLLAPSE/EXPAND ===
document.addEventListener("DOMContentLoaded", function () {
  // Handle toggle clicks
  const toggles = document.querySelectorAll(".tree-toggle:not(.no-children)");

  toggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.stopPropagation();

      const targetId = this.getAttribute("data-target");
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        // Toggle expanded class
        this.classList.toggle("expanded");
        targetElement.classList.toggle("expanded");
      }
    });
  });

  // === HANDLE FORM SUBMIT WITH AJAX ===
  const formTambah = document.getElementById("formTambahKategori");
  if (formTambah) {
    formTambah.addEventListener("submit", function (e) {
      e.preventDefault();

      const btnSimpan = document.getElementById("btnSimpanKategori");
      const alertContainer = document.getElementById("alert_container");

      // Disable button
      btnSimpan.disabled = true;
      btnSimpan.innerHTML =
        '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

      // Get form data
      const formData = new FormData(this);

      // Send AJAX request
      fetch(BASE_URL + "kategori/add", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success message
            alertContainer.innerHTML =
              '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle"></i> ' +
              data.message +
              "</div>";

            // Reload page after 1 second to show new category
            setTimeout(function () {
              window.location.reload();
            }, 1000);
          } else {
            // Show error
            let errorHtml =
              '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-triangle"></i> ';
            if (Array.isArray(data.errors)) {
              errorHtml +=
                '<ul style="margin: 5px 0 0 0; padding-left: 20px;">';
              data.errors.forEach((err) => {
                errorHtml += "<li>" + err + "</li>";
              });
              errorHtml += "</ul>";
            } else {
              errorHtml += data.message;
            }
            errorHtml += "</div>";
            alertContainer.innerHTML = errorHtml;

            // Re-enable button
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = '<i class="fa fa-save"></i> Simpan';
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alertContainer.innerHTML =
            '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-triangle"></i> Terjadi kesalahan saat menyimpan.</div>';

          // Re-enable button
          btnSimpan.disabled = false;
          btnSimpan.innerHTML = '<i class="fa fa-save"></i> Simpan';
        });
    });
  }
});

// === SET PARENT KATEGORI UNTUK MODAL ===
function setParentKategori(parentId, parentName) {
  document.getElementById("parent_id_modal").value = parentId;
  document.getElementById("parent_display_text").textContent = parentName;

  // Clear previous alerts and input
  document.getElementById("alert_container").innerHTML = "";
  document.getElementById("nama_kategori_modal").value = "";

  // Reset button
  const btnSimpan = document.getElementById("btnSimpanKategori");
  btnSimpan.disabled = false;
  btnSimpan.innerHTML = '<i class="fa fa-save"></i> Simpan';
}
