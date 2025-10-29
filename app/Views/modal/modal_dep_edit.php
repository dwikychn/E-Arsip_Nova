<div class="modal fade" id="editDep<?= $d['id_dep'] ?>">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Departemen</h4>
            </div>
            <div class="modal-body">
                <?= form_open('departemen/editDep/' . $d['id_dep']) ?>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_dep" value="<?= $d['nama_dep'] ?>" class="form-control" required>
                </div>
                 <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>