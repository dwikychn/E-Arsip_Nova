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

.user-list {
    list-style: none;
    padding: 0;
    margin: 0 0 15px 0;
}

.user-list li {
    padding: 8px 10px;
    border-radius: 6px;
    margin-bottom: 4px;
}

.user-list li.active,
.user-list li:hover {
    background: #e6f1ff;
}

.user-list a {
    text-decoration: none;
    color: #333;
}

.btn-broadcast {
    display: block;
    width: 100%;
    text-align: center;
    background: #3a84c9;
    padding: 10px;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    margin-top: 10px;
}

/* CHAT BODY */
.chat-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 15px;
}

.chat-body h4 {
    margin-bottom: 14px;
    font-size: 16px;
    font-weight: bold;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding-right: 10px;
}

.message {
    margin-bottom: 12px;
    max-width: 60%;
}

.message.me {
    margin-left: auto;
    text-align: right;
}

.bubble {
    padding: 10px 14px;
    border-radius: 12px;
    background: #dfeafe;
}

.message.me .bubble {
    background: #b6e3ff;
}

.time {
    font-size: 11px;
    color: #666;
    margin-top: 2px;
}

/* INPUT */
.chat-input {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.chat-input button {
    background: #3a84c9;
    border: none;
    padding: 10px 18px;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

</style>

<div class="chat-container">

    <!-- SIDEBAR -->
    <div class="chat-sidebar">
        <h4>Daftar Admin</h4>
        <ul class="user-list">
            <?php foreach($listSidebar as $row): ?>
                <li class="<?= ($row['id'] == $currentID) ? 'active' : '' ?>">
                    <a href="<?= base_url('/bantuan/chat/' . $row['id']) ?>">
                        <?= $row['label'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if(session()->get('level') == 0): ?>
            <a href="<?= base_url('/bantuan/broadcast') ?>" class="btn-broadcast">Buat Pesan Broadcast</a>
        <?php endif; ?>
    </div>

    <!-- AREA CHAT -->
    <div class="chat-body">
        <h4><?= $currentSubjek ?: "Percakapan Baru" ?></h4>

        <div class="chat-messages">
            <?php if(!empty($chat)): ?>
                <?php foreach($chat as $c): ?>
                    <div class="message <?= ($c['id_pengirim'] == session()->get('id_user')) ? 'me' : 'you' ?>">
                        <div class="bubble"><?= $c['pesan'] ?></div>
                        <div class="time"><?= $c['created_at'] ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form action="<?= base_url('/bantuan/kirim') ?>" method="post" class="chat-input">
            <input type="hidden" name="penerima" value="<?= $currentID ?>">
            <input type="text" name="pesan" placeholder="Ketik pesan..." required>
            <button type="submit">Kirim</button>
        </form>

    </div>
</div>
<script>
// Scroll otomatis ke bawah
var box = document.getElementById('messages');
box.scrollTop = box.scrollHeight;
</script>

<?= $this->endSection() ?>
