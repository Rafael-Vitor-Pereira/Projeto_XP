<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css'); ?>">
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
    <center>
      <?php if ($msg = get_msg()) {
        echo $msg;
      } ?>
    </center>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php $this->load->view('menu_msg') ?>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <center>
                  <h5">Escreva uma nova mensagem</h5>
                </center>
              </div>
              <!-- /.card-header -->
              <form method="post">
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" name="dest" id="dest" placeholder="Para:" <?php if (isset($dest)) { ?> value="<?= $dest ?>" <?php } ?> />
                  </div>
                  <div class="form-group">
                    <input class="form-control" name="titulo" id="titulo" placeholder="Titulo:">
                  </div>
                  <div class="form-group">
                    <textarea id="compose-textarea" name="conteudo" id="conteudo" class="form-control" style="height: 300px;"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Descartar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Enviar</button>
                  </div>
              </form>
              <button type="submit" name="rascunho" value="rascunho" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Rascunho</button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->
  <?php $this->load->view('footer'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
  <!-- Summernote -->
  <script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      //Add text editor
      $('#compose-textarea').summernote()
    })
  </script>
  </body>

</html>