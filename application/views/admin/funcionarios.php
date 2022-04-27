<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php
  $this->load->view('header');
  $this->load->view('admin/menu');
  ?>
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
                    <tr style="text-align: center;">
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Telefone</th>
                      <th>E-mail</th>
                      <th>Endereço</th>
                      <th>Setor</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($func != 0) {
                      $x = 0;
                      foreach ($func as $linha) {
                    ?>
                        <tr id="linha<?php echo $linha->id ?>">
                          <td style="width: 5%;">
                            <center><?= $linha->id ?></center>
                          </td>
                          <td style="width: 16%;"><?= $linha->nome . ' ' . $linha->sobrenome ?></td>
                          <td style="width: 13%;"><?= $linha->telefone ?></td>
                          <td style="width: 13%;"><?= $linha->email ?></td>
                          <td style="width: 25%;"><?= $linha->endereco ?></td>
                          <td style="width: 10%;"><?= $linha->setor ?></td>
                          <td align="center">
                            <a href="<?= base_url('admin/editar/') . $linha->id; ?>" style="text-decoration: none;" title="Exibir/Editar usuário">
                              <i class="fa fa-edit"></i> Editar
                            </a>
                          </td>
                          <td align="center">
                            <a href="javascript:excluir(<?= $linha->id; ?>);" style="text-decoration: none;" title="Excluir usuário">
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
                    <tr style="text-align: center;">
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Telefone</th>
                      <th>E-mail</th>
                      <th>Endereço</th>
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
  <?php $this->load->view('footer') ?>
  <!-- page script -->

  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

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
          "<?php echo site_url('admin/excluir/'); ?>", {
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
  </body>

</html>