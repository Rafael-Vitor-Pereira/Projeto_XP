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
                      <th>Setor</th>
                      <th style="text-align: center;" colspan="3">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($func != 0) {
                      $x = 0;
                      foreach ($func as $linha) {
                    ?>
                        <tr id="linha<?php echo $linha->id ?>">
                          <td><?= $linha->nome . ' ' . $linha->sobrenome ?></td>
                          <td><?= $linha->telefone ?></td>
                          <td><?= $linha->email ?></td>
                          <td><?= $linha->setor ?></td>
													<td align="center">
                            <a href="<?= base_url('funcionario/info/') . $linha->id; ?>" style="text-decoration: none;" title="+ Informações do funcionário">
                              <i class="fa fa-plus"></i> Info
                            </a>
                          </td>
                          <td align="center">
                            <a href="<?= base_url('funcionario/editar/') . $linha->id; ?>" style="text-decoration: none;" title="Exibir/Editar funcionário">
                              <i class="fa fa-edit"></i> Editar
                            </a>
                          </td>
                          <td align="center">
                            <a href="javascript:excluir(<?= $linha->id; ?>);" style="text-decoration: none;" title="Excluir funcionário">
                              <i class="fa fa-trash"></i> Excluir
                            </a>
                          </td>
                        </tr>
                      <?php
                      }
                    } else {
                      ?>
                      <tr>
                        <td colspan="8">
                          <center>Não há funcionários cadastrados</center>
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
											<th>Setor</th>
                      <th style="text-align: center;" colspan="3">Ações</th>
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
  <!-- page script -->

  <script>
    $(function() {
      $("#dados").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        }
      }).buttons().container().appendTo('#dados_wrapper .col-md-6:eq(0)');
    });
  </script>
  <script>
    function excluir(idreg) {
      resp = confirm('Deseja realmente excluir esse registro?');
      if (resp) {
        var ID = idreg;
        $.post(
          "<?php echo site_url('funcionario/excluir/'); ?>", {
            id: ID
          },
          function(data, status) {
            var panel = "#linha" + ID;
            $(panel).remove();
            //alert("Data: " + data + "\nStatus: " + status);
          }
        );
      } else {
        return false;
      }
    }
  </script>
