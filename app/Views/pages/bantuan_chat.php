<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<style>
.chat-container { display: flex; height: 85vh; background: #f1f4f9; border-radius: 6px; overflow: hidden; }
.chat-sidebar { width: 260px; background: #fff; border-right: 1px solid #d9d9d9; padding: 15px; }
.chat-sidebar h4 { font-size: 16px; margin-bottom: 10px; font-weight: bold; }
.user-list { list-style: none; padding: 0; margin: 0; }
.user-list li { padding: 8px 10px; border-radius: 6px; margin-bottom: 4px; }
.user-list li.active, .user-list li:hover { background: #e6f1ff; }
.user-list a { text-decoration: none; color: #333; display:block; }

.chat-body { flex: 1; display: flex; flex-direction: column; padding: 15px; }
.chat-body h4 { margin-bottom: 14px; font-size: 16px; font-weight: bold; }

.chat-messages { flex: 1; overflow-y: auto; padding-right: 10px; }
.message { margin-bottom: 12px; max-width: 60%; }
.message.me { margin-left: auto; text-align: right; }

.bubble { padding: 10px 14px; border-radius: 12px; background: #dfeafe; }
.message.me .bubble { background: #b6e3ff; }
.time { font-size: 11px; color: #666; margin-top: 2px; }

.chat-input { display: flex; gap: 10px; margin-top: 10px; }
.chat-input input { flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
.chat-input button { background: #3a84c9; border: none; padding: 10px 18px; color: white; border-radius: 8px; cursor: pointer; }
</style>

<div class="chat-container">

    <!-- SIDEBAR -->
    <div class="chat-sidebar">
        <h4><?= (session()->get('level') == 0) ? 'Daftar Admin' : 'Chat Bantuan' ?></h4>

        <ul class="user-list">
            <?php foreach ($listSidebar as $u): ?>
                <li class="<?= ($u['id'] == $idTujuan) ? 'active' : '' ?>">
                    <a href="/bantuan/chat/<?= $u['id'] ?>">
                        <?= esc($u['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- CHAT AREA -->
    <div class="chat-body">
        <h4>Chat</h4>

        <div class="chat-messages" id="chat-box">
            <?php foreach ($messages as $c): ?>
                <div class="message <?= ($c['id_pengirim'] == session()->get('id_user')) ? 'me' : '' ?>">
                    <div class="bubble"><?= nl2br(esc($c['pesan'])) ?></div>
                    <div class="time"><?= $c['created_at'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="<?= base_url('/bantuan/kirim') ?>" method="post" class="chat-input">
            <input type="hidden" name="id_tujuan" value="<?= $currentID ?>">
            <input type="text" name="pesan" placeholder="Ketik pesan..." required>
            <button type="submit">Kirim</button>
        </form>
    </div>
</div>

<script>
function reloadChat() {
    $("#chat-box").load(location.href + " #chat-box>*");
}
setInterval(reloadChat, 1200);
document.getElementById("chat-box").scrollTop = document.getElementById("chat-box").scrollHeight;
</script>

<?= $this->endSection() ?>
