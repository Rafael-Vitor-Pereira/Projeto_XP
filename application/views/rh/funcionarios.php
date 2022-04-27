<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php
  $this->load->view('header');
  $this->load->view('rh/menu');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br><br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h5>
                  <center>Lista de Funcionários</center>
                </h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dados" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Telefone</th>
                      <th>Endereço</th>
                      <th>Setor</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($func as $row) :
                    ?>
                      <tr id="linha<?php echo $row->id ?>">
                        <td><?php echo $row->nome . ' ' . $row->sobrenome ?></td>
                        <td><?php echo $row->email ?></td>
                        <td><?php echo $row->telefone; ?></td>
                        <td><?php echo $row->endereco; ?></td>
                        <td><?php echo $row->setor; ?></td>
                        <td align="center">
                          <a href="<?= base_url('editar_func/') . $row->id; ?>" style="text-decoration: none;" title="Exibir/Editar usuário">
                            <i class="fa fa-edit"></i> Editar
                          </a>
                        </td>
                        <td align="center">
                          <a href="javascript:excluir(<?= $row->id; ?>);" style="text-decoration: none;" title="Excluir usuário">
                            <i class="fa fa-trash"></i> Excluir
                          </a>
                        </td>
                      </tr>
                    <?php
                    endforeach;
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Telefone</th>
                      <th>Endereço</th>
                      <th>Setor</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
          "<?php echo base_url('rh/excluir/'); ?>", {
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