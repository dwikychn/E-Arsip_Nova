<header class="main-header">
    <a href="<?= base_url('home') ?>" class="logo">
        <span class="logo-mini">
            <img src="<?= base_url('template/dist/img/Logo-Nova-Putih.png') ?>" alt="Logo" style="height:40px;">
        </span>
        <span class="logo-lg"><b>E</b>-Arsip Novapharin</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php 
                    $db = \Config\Database::connect();

                    // Hitung jumlah pesan baru
                    $idUser = session()->get('id_user');

                    $jmlPesanBaru = $db->table('pesan_bantuan')
                        ->where('id_penerima', $idUser)
                        ->where('status', 'baru')
                        ->countAllResults();

                    // Ambil 5 pesan terbaru
                   $pesanBaru = $db->table('pesan_bantuan')
                        ->join('tbl_user', 'tbl_user.id_user = pesan_bantuan.id_pengirim')
                        ->where('pesan_bantuan.id_penerima', $idUser)
                        ->orderBy('id_pesan', 'DESC')
                        ->limit(5)
                        ->get()
                        ->getResultArray();
                    ?>

                <?php if (session()->get('level') === '0'): ?>
                    <li class="dropdown messages-menu">
                        <a href="<?= base_url() ?>" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <?php if($jmlPesanBaru > 0): ?>
                        <span class="label label-success"><?= $jmlPesanBaru ?></span>
                        <?php endif; ?>

                        </a>
                       <ul class="dropdown-menu">
                            <li class="header">Anda memiliki <?= $jmlPesanBaru ?> pesan baru</li>
                            <li>
                                <ul class="menu">
                                    <?php foreach($pesanBaru as $p): ?>
                                    <li>
                                        <a href="<?= base_url('pesanmasuk') ?>">
                                            <div class="pull-left">
                                                <img src="<?= base_url('template/dist/img/gambar_user.png') ?>" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                <?= $p['nama_user'] ?>
                                                <small><i class="fa fa-clock-o"></i> <?= date('H:i d/m/Y', strtotime($p['created_at'])) ?></small>
                                            </h4>
                                            <p><?= character_limiter($p['pesan'], 30) ?></p>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="footer"><a href="<?= base_url('bantuan') ?>">Lihat semua pesan</a></li>
                        </ul>
            </li>
        <?php endif; ?>
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs"><?= session()->get('nama_user') ?></span>
            </a>
            <ul class="dropdown-menu">
                <style>
                    .user-header {
                        text-align: center;
                        padding: 10px 0 10px 0 !important;
                        height: auto !important;
                        min-height: unset !important;
                    }

                    .user-header p {
                        margin: 0;
                        line-height: 1.4;
                    }
                </style>
                <li class="user-header">
                    <p>
                        <?php
                        $levelNames = [
                            0 => 'Superadmin',
                            1 => 'Admin',
                            2 => 'User'
                        ];
                        ?>
                        <?= strtoupper(session()->get('nama_user')) ?> - <?= $levelNames[session()->get('level')] ?? 'Unknown' ?>
                        <small><?= date('d-M-Y') ?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <!-- <li class="user-body">
          <div class="row">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </div>
        </li> -->
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#editProfile">Edit Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
                    </div>
                </li>
            </ul>
        </li>
        </ul>
        </div>
    </nav>
</header>