<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div style="max-width:600px;margin:auto;">
    <h4>Percakapan</h4>

    <!-- ✅ Chat container -->
    <div id="chat-box" style="border:1px solid #ddd;padding:10px;height:350px;overflow-y:scroll;">
        <?php foreach($chat as $c): ?>
            <?php if($c['id_pengirim'] == session()->get('id_user')): ?>
                <div style="text-align:right;margin:5px;">
                    <span style="background:#d1ffd1;padding:5px 10px;border-radius:8px;display:inline-block;">
                        <?= esc($c['pesan']) ?>
                    </span>
                </div>
            <?php else: ?>
                <div style="text-align:left;margin:5px;">
                    <span style="background:#fff;padding:5px 10px;border-radius:8px;border:1px solid #ccc;display:inline-block;">
                        <?= esc($c['pesan']) ?>
                    </span>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <form action="<?= base_url('bantuan/kirim') ?>" method="post" style="margin-top:10px;">
        <input type="hidden" name="id_tujuan" value="<?= $id_admin ?>">
        <textarea name="pesan" class="form-control" required></textarea>
        <button class="btn btn-primary btn-block" style="margin-top:5px;">Kirim</button>
    </form>
</div>


<!-- ✅ Script Realtime TANPA FILE TAMBAHAN -->
<script>
// Auto scroll ke bawah setelah load
function autoScroll() {
    var box = document.getElementById('chat-box');
    box.scrollTop = box.scrollHeight;
}

// Realtime per 2 detik, reload isi chat dari halaman yang sama
setInterval(function() {
    $("#chat-box").load(location.href + " #chat-box > *", function() {
        autoScroll();
    });
}, 2000);

autoScroll(); // scroll saat pertama kali buka
</script>

<?= $this->endSection() ?>
