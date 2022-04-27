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
                <div class="row">
                  <div class="col-4">&nbsp;</div>
                  <div class="col-4">&nbsp;</div>
                  <div class="col-4">
                    <form action="<?= base_url('admin/balanco') ?>" method="post">
                      <center><label for="mes">Buscar por mês e ano</label></center>
                      <div class="row">
                        <div class="col-4">
                          <select name="mes" id="mes" class="form-control">
                            <option value="">Mês</option>
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <select name="ano" id="ano" class="form-control">
                            <option value="">Ano</option>
                            <?php
                            for ($i = 2022; $i <= 2050; $i++) {
                            ?>
                              <option value="<?= $i ?>"><?= $i ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-4">
                          <input type="submit" value="Buscar" class="btn btn-primary">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th colspan="3">
                        <center>Entrando</center>
                      </th>
                      <th colspan="3">
                        <center>Saindo</center>
                      </th>
                    </tr>
                    <tr>
                      <th>
                        <center>Tipo</center>
                      </th>
                      <th>
                        <center>Valor</center>
                      </th>
                      <th>
                        <center>Data</center>
                      </th>
                      <th>
                        <center>Tipo</center>
                      </th>
                      <th>
                        <center>Valor</center>
                      </th>
                      <th>
                        <center>Data</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $x = 0;
                    $somaCapital = 0;
                    $somaCusto = 0;
                    while ($x < $quant) {
                    ?>
                      <tr>
                        <?php
                        if (isset($capital[$x])) {
                          $somaCapital = $somaCapital + $capital[$x]->valor;
                          $date_entrada = date_create($capital[$x]->data);
                          if ($capital[$x]->cod == 1) {
                            $desc_cap = 'Venda';
                          } else if ($capital[$x]->cod == 2) {
                            $desc_cap = 'Empréstimo';
                          }
                        ?>
                          <td style="width: 16%;"><?= $desc_cap ?></td>
                          <td style="width: 16%;">R$ <?= number_format($capital[$x]->valor, 2, ',', '.') ?></td>
                          <td style="width: 16%;"><?= date_format($date_entrada, 'd-m-Y') ?></td>
                        <?php
                        } else {
                        ?>
                          <td style="width: 16%;"></td>
                          <td style="width: 16%;"></td>
                          <td style="width: 16%;"></td>
                        <?php
                        }
                        if (isset($custo[$x])) {
                          if ($custo[$x]->cod == 1) {
                            $desc_custo = 'Salário de Funconários';
                          } else if ($custo[$x]->cod == 2) {
                            $desc_custo = 'Compra de produtos';
                          } else if ($custo[$x]->cod == 3) {
                            $desc_custo = 'Compra de Equipamentos';
                          } else if ($custo[$x]->cod == 4) {
                            $desc_custo = 'Pagamento de empréstimo';
                          }
                          $somaCusto = $somaCusto + $custo[$x]->valor;
                          $date_saida = date_create($custo[$x]->data);
                        ?>
                          <td style="width: 16%;"><?= $desc_custo ?></td>
                          <td style="width: 16%;">R$ <?= number_format($custo[$x]->valor, 2, ',', '.') ?></td>
                          <td style="width: 16%;"><?= date_format($date_saida, 'd-m-Y') ?></td>
                        <?php } ?>
                      </tr>
                    <?php
                      $x++;
                    }
                    ?>
                    <tr>
                      <td><b>Total</b></td>
                      <td colspan="2"><b>R$ <?= number_format($somaCapital, 2, ',', '.') ?></b></td>
                      <td><b>Total</b></td>
                      <td colspan="2"><b>R$ <?= number_format($somaCusto, 2, ',', '.') ?></b></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3">
                        <center>Entrando</center>
                      </th>
                      <th colspan="3">
                        <center>Saindo</center>
                      </th>
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
  <?php $this->load->view('footer'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>
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
  </body>

</html>