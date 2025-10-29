<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>

            <!-- Selalu tampil -->
            <li class="<?= (uri_string() == 'home') ? 'active' : '' ?>">
                <a href="<?= base_url('home') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Menu hanya untuk Superadmin -->
            <?php if (session()->get('level') == 0): ?>
                <li class="treeview <?= (uri_string() == 'user' || uri_string() == 'departemen') ? 'active' : '' ?>">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Manajemen User </span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?= (uri_string() == 'user') ? 'active' : '' ?>">
                            <a href="<?= base_url('user') ?>"><i class="fa fa-circle-o"></i>User</a>
                        </li>
                        <li class="<?= (uri_string() == 'departemen') ? 'active' : '' ?>">
                            <a href="<?= base_url('departemen') ?>"><i class="fa fa-circle-o"></i>Departemen</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (session()->get('level') == 1): ?>
                <li class="<?= (uri_string() == 'user') ? 'active' : '' ?>">
                    <a href="<?= base_url('user') ?>">
                        <i class="fa fa-users"></i> <span>Manajemen User</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array(session()->get('level'), [0, 1])): ?>
                <li class="treeview <?= (uri_string() == 'arsip' || uri_string() == 'kategori') ? 'active' : '' ?>">
                    <a href="#">
                        <i class="fa fa-archive"></i> <span>Manajemen Arsip</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?= (uri_string() == 'arsip') ? 'active' : '' ?>">
                            <a href="<?= base_url('arsip') ?>"><i class="fa fa-circle-o"></i> Data Arsip</a>
                        </li>
                        <li class="<?= (uri_string() == 'kategori') ? 'active' : '' ?>">
                            <a href="<?= base_url('kategori') ?>"><i class="fa fa-circle-o"></i> Kategori Arsip</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (session()->get('level') == 2): ?>
                <li class="<?= (uri_string() == 'arsip') ? 'active' : '' ?>">
                    <a href="<?= base_url('arsip') ?>">
                        <i class="fa fa-archive"></i> <span>Manajemen Arsip</span>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Menu untuk semua level -->
            <li class="<?= (uri_string() == 'cari') ? 'active' : '' ?>">
                <a href="<?= base_url('cari') ?>">
                    <i class="fa fa-search"></i> <span>Cari Arsip</span>
                </a>
            </li>

            <!-- Audit trail hanya untuk Superadmin -->
            <?php if (session()->get('level') != 2): ?>
                <li class="<?= (uri_string() == 'audit') ? 'active' : '' ?>">
                    <a href="<?= base_url('audit') ?>">
                        <i class="fa fa-history"></i> <span>Audit Trail</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Bantuan tampil untuk semua -->
            <li class="<?= (uri_string() == 'bantuan') ? 'active' : '' ?>">
                <a href="<?= base_url('bantuan') ?>">
                    <i class="fa fa-question-circle"></i> <span>Bantuan</span>
                </a>
            </li>
        </ul>
    </section>
</aside>