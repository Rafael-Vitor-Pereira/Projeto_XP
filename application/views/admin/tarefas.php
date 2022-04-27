<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">
    <div id="simple-msg"></div>
    <!-- TO DO List -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="ion ion-clipboard mr-1"></i>
          A fazeres de hoje
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <ul class="todo-list" data-widget="todo-list">
          <?php $x = 1;
          if ($tarefas != '') {
            foreach ($tarefas as $linha) {
              if ($linha->data == date('Y-m-d') && $linha->id_usuario == $this->session->userdata('user_id')) { ?>
                <li>
                  <!-- drag handle -->
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <!-- checkbox -->
                  <div class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo<?= $x ?>" id="todoCheck<?= $x ?>">
                    <label for="todoCheck<?= $x ?>"></label>
                  </div>
                  <!-- todo text -->
                  <span class="text"><?= $linha->descricao ?></span>
                </li>
          <?php $x++;
              }
            }
            if ($x == 1) {
              echo "<span>Não há tarefas para hoje no momento</span>";
            }
          } else {
            echo "<span>Não há tarefas para hoje no momento</span>";
          }
          ?>
        </ul>
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">
          <i class="fas fa-plus"></i>Add Item
        </button>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="ajaxform" name="ajaxform" action="<?= base_url('admin/inserirTarefa') ?>" method="POST">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Adicionar tarefa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="descricao">Descrição</label>
                  <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Tarefa a ser realizada">
                </div>
                <div class="form-group">
                  <label for="data">Data para essa tarefa</label>
                  <input type="date" class="form-control" id="data" name="data" placeholder="Data dessa tarefa">
                </div>
                <div class="form-group">
                  <label for="setor">Setor</label>
                  <select name="setor" id="setor" class="form-control">
                    <option value="0"> ----------- </option>
                    <option value="1">Para mim</option>
                    <option value="2">Setor de RH</option>
                    <option value="3">Setor de Estoque</option>
                    <option value="4">Setor de Finanças</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="gravar" class="btn btn-primary">Adicionar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </section>
  <!-- /.Left col -->
</div>