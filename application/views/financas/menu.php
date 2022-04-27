<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('dashboard'); ?>" class="brand-link" style="text-decoration: none;">
    <img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $titulo ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url('pagina/credenciais'); ?>" style="text-decoration: none;" class="d-block"><?= strtoupper($user) ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard'); ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Cadastrar
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('financeiro/cadastro'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Funcionários</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('financeiro/cad_custo'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Custos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('pagina/contatos'); ?>" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Contatos
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('pagina/mensagens'); ?>" class="nav-link">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              Mensagens
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>