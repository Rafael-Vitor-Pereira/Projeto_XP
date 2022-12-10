  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br><br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar Custo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("custo/gravarEdicao"); ?>" method="POST">
                <input type="hidden" name="id" id="id" value="<?= $dados->id ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="tipo">Tipo de custo:</label>
                    <select name="tipo" id="tipo" class="form-control">
											<option value=""> -------------------------- </option>
											<option value="1" <?= $dados->cod == 1 ? 'selected' : ''; ?> >Salário de Funcionários</option>
											<option value="2" <?= $dados->cod == 2 ? 'selected' : ''; ?> >Compra de produtos</option>
											<option value="3" <?= $dados->cod == 3 ? 'selected' : ''; ?> >Compra de Equipamentos</option>
											<option value="4" <?= $dados->cod == 4 ? 'selected' : ''; ?> >Pagamento de empréstimo</option>
										</select>
                  </div>
                  <div class="form-group">
                    <label for="valor">Valor:</label>
                    <input type="number" name="valor" class="form-control" id="valor" placeholder="valor" value="<?= $dados->valor ?>">
                  </div>
								</div>
                <!-- /.card-body -->
                <div id="loading" class="overlay" style="visibility: hidden">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="gravar">Salvar</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            <div id="simple-msg"></div>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6"></div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- jquery-validation -->
  <script src="<?= base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.js"></script>
  <script src="<?= base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Page specific script -->
  <script>
    var form = $('#ajaxform');
    //definindo regras de validação de formulário
    $('#ajaxform').validate({
      rules: {
        tipo: {
          required: true,
        },
        valor: {
          required: true,
          minlength: 3
        },
      },
      messages: {
        tipo: {
          required: "Por favor, escolha uma das opções",
        },
        valor: {
          required: "Por favor, insira um valor",
          minlength: "O valor deve conter no mínimo 3 digitos"
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    //submetendo formulário via ajax post
    $("#gravar").click(function() {
      $("#ajaxform").submit(function(e) {
        //envia somente se formulário estiver validado
        if (form.valid()) {
          $("#loading").css("visibility", "visible");
          var postData = $(this).serializeArray();
          var formURL = $(this).attr("action");
          $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
              $("#loading").css("visibility", "hidden");
              $("#simple-msg").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $("#loading").css("visibility", "hidden");
              var error = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> ' + textStatus + '</h4>' + errorThrown + '</div>';
              $("#simple-msg").html(error);
            }
          });
          e.preventDefault(); //STOP default action
          e.unbind();
        }
        return false;
      });
    });
  </script>
  </body>

</html>
