<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        E-Arsip |
        <?= isset($page)
            ? ucfirst($page)
            : (isset($title) ? esc($title) : 'Dashboard') ?>
    </title>
    <link rel="icon" type="image/png" sizes="150x150" href="<?= base_url('template/dist/img/Logo-Nova.png') ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('template/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('template/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('template/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('template/dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/dist/css/skins/_all-skins.min.css') ?>">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?= base_url('template/bower_components/morris.js/morris.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/bower_components/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/custom/css/widget.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/custom/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/custom/css/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/custom/css/table.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/custom/css/tombol.css') ?>">
</head>