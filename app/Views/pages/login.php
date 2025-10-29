<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-Arsip | Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('template/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('template/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('template/dist/css/AdminLTE.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('template/plugins/iCheck/square/blue.css') ?>">

  <style>
    body.login-page {
      background: linear-gradient(135deg, #6ba4ffff 0%, #0d1d38ff 100%);
      background-attachment: fixed;
    }

    .login-logo {
      margin-bottom: 30px;
      color: #fff;
    }

    .login-logo a {
      color: #fff;
      font-size: 35px;
      font-weight: 300;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .login-logo a b {
      font-weight: 700;
    }

    .login-logo .fa {
      font-size: 45px;
      display: block;
      margin-bottom: 10px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    .login-box {
      width: 400px;
      margin: 7% auto;
    }

    .login-box-body {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .login-box-msg {
      margin: 0;
      padding: 0 0 20px 0;
      text-align: center;
      font-size: 18px;
      color: #555;
      font-weight: 400;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-control {
      height: 45px;
      border-radius: 5px;
      border: 1px solid #d2d6de;
      box-shadow: none;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control-feedback {
      line-height: 45px;
      color: #999;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
      z-index: 99;
      background: white;
      padding: 0 5px;
    }

    .password-toggle:hover {
      color: #667eea;
    }

    .btn-primary {
      background-color: #1e293b;
      border-color: #1e293b;
      height: 45px;
      border-radius: 10px !important;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary:focus {
      background-color: #333e4e;
      border-color: #333e4e;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .checkbox {
      margin-top: 10px;
    }

    .checkbox label {
      padding-left: 0;
      font-weight: 400;
      color: #666;
    }

    .alert {
      border-radius: 5px;
      margin-bottom: 20px;
      border: none;
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-danger {
      background-color: #f2dede;
      color: #a94442;
      border-left: 4px solid #a94442;
    }

    .alert-success {
      background-color: #dff0d8;
      color: #3c763d;
      border-left: 4px solid #3c763d;
    }

    .alert .close {
      color: inherit;
      opacity: 0.5;
    }

    .login-footer {
      text-align: center;
      margin-top: 20px;
      color: #fff;
      font-size: 13px;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .login-footer a {
      color: #fff;
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-box {
        width: 90%;
        margin-top: 20px;
      }

      .login-logo a {
        font-size: 28px;
      }

      .login-logo .fa {
        font-size: 35px;
      }
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <i class="fa fa-archive"></i>
      <a href="#"><b>E-Arsip</b> Novapharin</a>
    </div>

    <div class="login-box-body">
      <p class="login-box-msg">Silahkan Login untuk Melanjutkan</p>

      <?php if ($error = session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= esc($error) ?>
        </div>
      <?php endif; ?>

      <?php if ($success = session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <?= esc($success) ?>
        </div>
      <?php endif; ?>

      <?= form_open('auth/login') ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username" required>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
        <span class="fa fa-eye password-toggle" id="toggleIcon" onclick="togglePassword()"></span>
      </div>

      <div class="row">
        <div class="col-xs-7">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="remember"> Remember Me
            </label>
          </div>
        </div>

        <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">
            <i class="fa fa-sign-in"></i> Login
          </button>
        </div>
      </div>
      <?= form_close() ?>
    </div>

    <div class="login-footer">
      <p>&copy; 2025 E-Arsip Novapharin.</p>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?= base_url('template/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
  <!-- iCheck -->
  <script src="<?= base_url('template/plugins/iCheck/icheck.min.js') ?>"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });

    function togglePassword() {
      var passwordField = document.getElementById('password');
      var toggleIcon = document.getElementById('toggleIcon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>

</html>