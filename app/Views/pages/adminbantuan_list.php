<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Daftar Admin</h3>
  </div>

  <div class="box-body">
    <table class="table table-bordered table-striped">
      <tr>
        <th>Nama Admin</th>
        <th style="width: 150px;">Chat</th>
      </tr>

      <?php foreach ($adminList as $row): ?>
      <tr>
        <td><?= $row['nama_user'] ?></td>
        <td>
          <a href="<?= base_url('bantuan/chat/' . $row['id_user']) ?>" class="btn btn-primary btn-sm">
            Chat
            <?php if ($row['unread'] > 0): ?>
              <span class="badge bg-red"><?= $row['unread'] ?></span>
            <?php endif; ?>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
