<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<style>
.chat-container {
    display: flex;
    height: 85vh;
    background: #f1f4f9;
    border-radius: 6px;
    overflow: hidden;
}

/* SIDEBAR */
.chat-sidebar {
    width: 260px;
    background: #fff;
    border-right: 1px solid #d9d9d9;
    padding: 15px;
}

.chat-sidebar h4 {
    font-size: 16px;
    margin-bottom: 10px;
    font-weight: bold;
}

.user-list { list-style: none; padding: 0; margin: 0 0 15px 0; }
.user-list li { padding: 8px 10px; border-radius: 6px; margin-bottom: 4px; }
.user-list li.active, .user-list li:hover { background: #e6f1ff; }
.user-list a { text-decoration: none; color: #333; }

.btn-broadcast {
    display: block; width: 100%; text-align: center;
    background: #3a84c9; padding: 10px; border-radius: 6px;
    color: white; text-decoration: none; margin-top: 10px;
}

/* CHAT */
.chat-body { flex: 1; display: flex; flex-direction: column; padding: 15px; }
.chat-body h4 { margin-bottom: 14px; font-size: 16px; font-weight: bold; }

.chat-messages { flex: 1; overflow-y: auto; padding-right: 10px; }

.message { margin-bottom: 12px; max-width: 60%; }
.message.me { margin-left: auto; text-align: right; }

.bubble {
    padding: 10px 14px; border-radius: 12px; background: #dfeafe;
}
.message.me .bubble { background: #b6e3ff; }

.time { font-size: 11px; color: #666; margin-top: 2px; }

.chat-input { display: flex; gap: 10px; margin-top: 10px; }
.chat-input input { flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
.chat-input button {
    background: #3a84c9; border: none; padding: 10px 18px;
    color: white; border-radius: 8px; cursor: pointer;
}
</style>

<div class="chat-container">

    <!-- SIDEBAR -->
           <div class="chat-sidebar">
                <h4><?= (session()->get('level') == 0) ? 'Daftar Admin' : 'Daftar Percakapan'; ?></h4>

                <?php if(session()->get('level') == 1): ?>
                    <!-- Form Buat Subjek Baru -->
                    <form action="/bantuan/buatSubjek" method="post" style="margin-top:15px;">
                        <input type="text" name="subjek" class="form-control" placeholder="Subjek baru..." required>
                        <button type="submit" class="btn btn-primary" style="margin-top:5px; width:100%;">+ Pesan Baru</button>
                    </form>
                <?php endif; ?>

                <ul class="user-list">

                    <?php foreach ($listSidebar as $sb): ?>

                        <!-- SUPERADMIN MODE -->
                        <?php if(session()->get('level') == 0): ?>
                            <li class="<?= ($sb['id'] == $currentID) ? 'active' : '' ?>">
                                <a href="/bantuan/chat/<?= $sb['id'] ?>" style="display:block; padding:8px;">
                                    <?= esc($sb['label']) ?>
                                </a>
                            </li>

                        <!-- ADMIN MODE -->
                        <?php else: ?>
                            <li class="<?= ($sb['subjek'] == $currentSubjek) ? 'active' : '' ?>">

                                <a href="/bantuan/chat/<?= $idTujuan ?>/<?= urlencode($sb['subjek']) ?>"
                                style="display:flex; justify-content:space-between; padding:8px;">

                                    <span><?= esc($sb['subjek']) ?></span>

                                    <?php if ($sb['is_closed'] == 0): ?>
                                        <span style="color:red; font-size:12px;">• Belum selesai</span>
                                    <?php else: ?>
                                        <span style="color:green; font-size:12px;">✓ Selesai</span>
                                    <?php endif; ?>
                                </a>

                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </ul>

                <?php if(session()->get('level') == 0): ?>
                    <a href="<?= base_url('/bantuan/broadcast') ?>" class="btn-broadcast">Buat Pesan Broadcast</a>
                <?php endif; ?>
            </div>


    <!-- CHAT AREA -->
    <div class="chat-body">
        <h4><?= $currentSubjek ?: "Percakapan Baru" ?></h4>

       <div class="chat-messages" id="chat-box">
            <?php foreach ($chat as $c): ?>
                <div class="message <?= ($c['id_pengirim'] == session()->get('id_user')) ? 'me' : '' ?>">
                    <div class="bubble"><?= nl2br(esc($c['pesan'])) ?></div>
                    <div class="time"><?= $c['created_at'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>


        <form action="<?= base_url('/bantuan/kirim') ?>" method="post" class="chat-input">
            <input type="hidden" name="id_tujuan" value="<?= $idTujuan ?>">
            <input type="hidden" name="subjek" value="<?= $currentSubjek ?>">
            <input type="text" name="pesan" placeholder="Ketik pesan..." required>
            <button type="submit">Kirim</button>
        </form>

        <?php if(session()->get('level') == 0): ?>
        <a href="/bantuan/closeSubjek?subjek=<?= urlencode($currentSubjek) ?>" class="btn btn-sm btn-success" style="margin-top:10px;">
            Tandai Selesai
        </a>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function reloadChat() {
    let box = document.getElementById("chat-box");
    let shouldScroll = box.scrollHeight - box.scrollTop - box.clientHeight < 30;

    $("#chat-box").load(location.href + " #chat-box>*", function() {
        if (shouldScroll) box.scrollTop = box.scrollHeight;
    });
}

setInterval(reloadChat, 1200);
</script>

<script>
const chatBox = document.getElementById("chat-box");

// Scroll otomatis ke bawah saat halaman pertama kali dibuka
chatBox.scrollTop = chatBox.scrollHeight;

// Scroll otomatis setelah submit pesan
document.querySelector(".chat-input").addEventListener("submit", function() {
    setTimeout(function() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }, 300);
});
</script>



<?= $this->endSection() ?>
