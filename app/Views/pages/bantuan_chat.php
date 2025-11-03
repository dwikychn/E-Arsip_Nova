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
        <h4>
            <?= (session()->get('level') == 0) ? 'Daftar Admin' : 'Daftar Percakapan'; ?>
        </h4>

        <ul class="user-list">
            <?php foreach ($listSidebar as $sb): ?>
                <li class="<?= ($sb['id'] == $currentID || urldecode($sb['id']) == $currentSubjek) ? 'active' : '' ?>">
                    
                    <?php if (session()->get('level') == 0): ?>
                        <!-- Superadmin → klik berdasarkan ID admin -->
                        <a href="/bantuan/chat/<?= $sb['id'] ?>"
                           class="sidebar-item"
                           style="display:block; padding:8px;">
                            <?= $sb['label'] ?>
                        </a>

                    <?php else: ?>
                        <!-- ✅ Admin → klik berdasarkan subjek -->
                        <a href="/bantuan/chat/<?= $currentID ?>/<?= $sb['id'] ?>"
                           class="sidebar-item"
                           style="display:flex; justify-content:space-between; padding:8px;">
                            <span><?= $sb['label'] ?></span>

                            <?php if ($sb['status'] == 0): ?>
                                <span style="color:red; font-size:12px;">• Belum selesai</span>
                            <?php else: ?>
                                <span style="color:green; font-size:12px;">✓ Selesai</span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

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
        <div style="background: #fff3cd; padding: 15px; margin: 10px 0; border: 2px solid #ffc107; border-radius: 5px; font-size: 13px;">
        <strong>🔍 Debug Info:</strong><br>
        ID User Login: <?= session()->get('id_user') ?><br>
        Level: <?= session()->get('level') ?><br>
        Current ID Target: <?= $currentID ?><br>
        Current Subjek: <strong><?= $currentSubjek ?></strong><br>
        Total Chat: <strong><?= count($chat) ?></strong><br>
        
        <?php if(!empty($chat)): ?>
            <hr style="margin: 8px 0;">
            Chat pertama:<br>
            - ID Pengirim: <?= $chat[0]['id_pengirim'] ?><br>
            - ID Penerima: <?= $chat[0]['id_penerima'] ?><br>
            - Subjek: <?= $chat[0]['subjek'] ?><br>
            - Pesan: <?= $chat[0]['pesan'] ?>
        <?php else: ?>
            <hr style="margin: 8px 0;">
            <span style="color: red;">❌ Array chat kosong!</span>
        <?php endif; ?>
    </div>
    <!-- AKHIR DEBUG -->
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
            <?php 
            // ✅ PERBAIKAN: Pastikan id_tujuan selalu terisi
            $idTujuan = (session()->get('level') == 0) ? $currentID : $this->bantuanModel->getSuperadminID();
            ?>
            <input type="hidden" name="id_tujuan" value="<?= $idTujuan ?>">
            
            <!-- DEBUG - HAPUS NANTI -->
            <input type="hidden" name="debug_level" value="<?= session()->get('level') ?>">
            <input type="hidden" name="debug_current_id" value="<?= $currentID ?>">
            
            <input type="text" name="pesan" placeholder="Ketik pesan..." required>

        <?php if(session()->get('level') == 0): ?>
        <a href="/bantuan/closeSubjek?subjek=<?= urlencode($currentSubjek) ?>" class="btn btn-sm btn-success" style="margin-top:10px;">
            Tandai Selesai
        </a>
        <?php endif; ?>
    </div>
</div>
<script>
    const box = document.querySelector('.chat-messages');
    box.scrollTop = box.scrollHeight;
</script>

<?= $this->endSection() ?>