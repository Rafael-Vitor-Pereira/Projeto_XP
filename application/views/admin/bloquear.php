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
                  <h5>Lista de Usuários</h5>
                </center>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dados" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Perfil</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($num >= 2) {
                      foreach ($usuario as $row) :
                        if ($row->id != $id) {
                    ?>
                          <tr id="linha<?php echo $row->id; ?>">
                            <td><?php echo $row->nome ?></a></td>
                            <td><?php echo $row->email; ?></td>
                            <td><?php echo $row->acesso; ?></td>
                            <td>
                              <a href="#s" class="status" id="<?= $row->id; ?>" style="text-decoration: none;">
                                <span id="s<?= $row->id; ?>">
                                  <?php
                                  if ($row->status == 1) echo "<i class='fa fa-toggle-on'></i> Ativo";
                                  else echo "<i class='fa fa-toggle-off'></i> Inativo";
                                  ?>
                                </span>
                              </a>
                            </td>
                          </tr>
                      <?php
                        }
                      endforeach;
                    } else {
                      ?>
                      <tr>
                        <td colspan='4'>
                          <center>Não há usuários cadastrados</center>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Perfil</th>
                      <th>Status</th>
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
  <?= $this->load->view('footer'); ?>
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
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        }
      }).buttons().container().appendTo('#dados_wrapper .col-md-6:eq(0)');
    });
  </script>

  <script>
    $(".status").click(function() {

      var ID = $(this).attr("id");

      $.post(
        "<?php echo base_url('admin/gravar_status/'); ?>", {
          id: ID
        },
        function(data, status) {
          var panel = "#s" + ID;
          $(panel).html(data);
          //alert("Data: " + data + "\nStatus: " + status);
        }
      );
    });
  </script>
  </body>

</html>