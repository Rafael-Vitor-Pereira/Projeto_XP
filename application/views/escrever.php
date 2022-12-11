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
  <script>
    $(function() {
      //Add text editor
      $('#compose-textarea').summernote()
    })
  </script>
  </body>

</html>
