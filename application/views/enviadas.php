<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <?php
  $this->load->view('header');
  if ($logado == 'admin') {
    $this->load->view('admin/menu');
  } else if ($logado == 'chefe de RH') {
    $this->load->view('rh/menu');
  } else if ($logado == 'chefe de estoque') {
    $this->load->view('estoque/menu');
  } else if ($logado == 'chefe de finanças') {
    $this->load->view('financas/menu');
  }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br><br>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $this->load->view('menu_msg') ?>
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5>
                <center><?= $h2 ?></center>
              </h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php
                    if ($msg != 0) {
                      foreach ($msg as $linha) {
                        if ($linha['remetente'] == $id && $linha['excluido'] == 'não') {
                          if ($linha['data'] == date('Y-m-d')) {
                            $dif = strtotime(date('H:i:s')) - strtotime($linha['hora']);
                          } else {
                            $dif = strtotime(date('Y-m-d')) - strtotime($linha['data']);
                          }
                          if ($dif < 60) {
                            $tempo = $dif . ' segundos atrás';
                          } else if ($dif >= 60 && $dif < 3600) {
                            $tempo = date('i', $dif) . ' minutos atrás';
                          } else if ($dif >= 3600 && $dif < 86400) {
                            $tempo = date('H', $dif) . ' horas atrás';
                          } else if ($dif >= 86400 && $dif < 604800) {
                            $tempo = date('d', $dif) . ' dias atrás';
                          } else if ($dif >= 604800 && $dif < 2419200) {
                            $tempo = date('w', $dif) . ' semanas atrás';
                          } else if ($dif >= 2419200 && $dif < 29030400) {
                            $tempo = date('m', $dif) . ' meses atrás';
                          } else {
                            $tempo = date('Y', $dif) . ' anos atrás';
                          }
                    ?>
                          <tr>
                            <td>
                              <div class="icheck-primary">
                                <input type="checkbox" value="" id="check<?= $linha['id'] ?>">
                                <label for="check<?= $linha['id'] ?>"></label>
                              </div>
                            </td>
                            <td class="mailbox-star"></td>
                            <td class="mailbox-name"><a href="ler_msg/<?= $linha['id'] ?>">EU</a></td>
                            <td class="mailbox-subject"><b><?= $linha['titulo'] ?></b> - <?= resumo_msg($linha['conteudo']); ?>...
                            </td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date"><?= $tempo ?></td>
                          </tr>
                      <?php
                        }
                      }
                    } else {
                      ?>
                      <tr>
                        <td>
                          <center>Não há mensagens no momento</center>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                  <i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </button>
                <div class="float-right">
                  1-50/50
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('footer'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      //Enable check and uncheck all functionality
      $('.checkbox-toggle').click(function() {
        var clicks = $(this).data('clicks')
        if (clicks) {
          //Uncheck all checkboxes
          $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          //Check all checkboxes
          $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $(this).data('clicks', !clicks)
      })

      //Handle starring for font awesome
      $('.mailbox-star').click(function(e) {
        e.preventDefault()
        //detect type
        var $this = $(this).find('a > i')
        var fa = $this.hasClass('fa')

        //Switch states
        if (fa) {
          $this.toggleClass('fa-star')
          $this.toggleClass('fa-star-o')
        }
      })
    })
  </script>
  </body>

</html>
