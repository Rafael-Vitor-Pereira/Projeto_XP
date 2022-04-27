<div class="col-md-3">
  <a href="<?= base_url('pagina/escrever') ?>" class="btn btn-primary btn-block mb-3" style="color: white;">Escrever Mensagem</a>
  <br>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Pastas</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a href="<?= base_url('pagina/mensagens') ?>" class="nav-link">
            <i class="fas fa-inbox"></i> Caixa de entrada
            <span class="badge bg-primary float-right"></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('pagina/enviadas') ?>" class="nav-link">
            <i class="far fa-envelope"></i> Enviado
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('pagina/rascunhos') ?>" class="nav-link">
            <i class="far fa-file-alt"></i> Rascunhos
          </a>
        </li>
        <li class="nav-item active">
          <a href="<?= base_url('pagina/lixeira') ?>" class="nav-link">
            <i class="far fa-trash-alt"></i> Lixeira
          </a>
        </li>
      </ul>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.col -->