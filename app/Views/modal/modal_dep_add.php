<div class="modal fade" id="addDep">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Departemen</h4>
            </div>
            <form action="<?= base_url('departemen/addDep') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Departemen</label>
                        <input type="text" name="nama_dep" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>