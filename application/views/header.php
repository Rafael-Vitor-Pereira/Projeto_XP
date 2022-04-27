  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php $titulo ?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <?php
  if ($this->session->userdata('user_acess') == 'admin') {
    $rota = 'admin';
  } else if ($this->session->userdata('user_acess') == 'chefe de RH') {
    $rota = 'rh';
  } else if ($this->session->userdata('user_acess') == 'chefe de estoque') {
    $rota = 'estoque';
  } else if ($this->session->userdata('user_acess') == 'chefe de finanças') {
    $rota = 'financeiro';
  }
  ?>

  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url($rota) ?>" class="nav-link">Home</a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('logout') ?>" role="button" data-toggle="tooltip" data-placement="right" title="Fazer Logout">
              <img src="<?= base_url('assets/img/door-open-fill.svg'); ?>" alt="logout" width="20px" style='padding-top: 10px;'>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->