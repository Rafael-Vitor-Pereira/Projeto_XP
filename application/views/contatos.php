	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <center>
                  <h5><?= $h2 ?></h5>
                </center>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Telefone</th>
                      <th>E-mail</th>
                      <th>Ramal</th>
                      <th>Setor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $x = 1;
                    if ($lista != '') {
                      foreach ($lista as $linha) {
                        if ($linha->acesso == 'admin') {
                          $setor = 'Gerência';
                          $ramal = '0010';
                        } else if ($linha->acesso == 'chefe de RH') {
                          $setor = 'Recursos Humanos';
                          $ramal = '0011';
                        } else if ($linha->acesso == 'chefe de estoque') {
                          $setor = 'Estoque';
                          $ramal = '0012';
                        } else if ($linha->acesso == 'chefe de finanças') {
                          $setor = 'Finanças';
                          $ramal = '0013';
                        }
                        if ($linha->login != $logado && $linha->status == 1) {
                    ?>
                          <tr>
                            <td><?= $linha->nome ?></td>
                            <td><?= $linha->telefone ?></td>
                            <td><?= $linha->email ?></td>
                            <td><?= $ramal ?></td>
                            <td><?= $setor ?></td>
                          </tr>
                      <?php
                        }
                      }
                    } else {
                      ?>
                      <tr>
                        <td colspan="5">
                          <center>Não há contatos cadastrados</center>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Nome</th>
                      <th>Telefone</th>
                      <th>E-mail</th>
                      <th>Ramal</th>
                      <th>Setor</th>
                    </tr>
                  </tfoot>
                </table>
              </div><!-- /.card-body -->
            </div><!-- /.card -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
