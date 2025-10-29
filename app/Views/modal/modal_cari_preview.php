<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:90%;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="previewLabel">Preview Dokumen</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <iframe id="previewIframe" src="" width="100%" height="600px" style="border:none;"></iframe>
                <div id="previewError" style="display:none;">
                    <p class="text-danger mt-3">Tidak dapat menampilkan preview untuk tipe file ini.</p>
                    <a id="downloadLink" href="#" target="_blank" class="btn btn-primary btn-sm mt-2">
                        <i class="fa fa-download"></i> Download File
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
