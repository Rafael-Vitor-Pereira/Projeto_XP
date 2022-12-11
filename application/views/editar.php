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
                <h3 class="card-title">Editar dados</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url('pagina/gravar_editar') ?>" method="POST">
                <input type="text" name="access" value="<?= $access ?>" readonly style="display: none">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="nome">Nome:</label>
                      <input type="text" name="nome" value="<?= $user ?>" class="form-control" id="nome" placeholder="Nome">
                    </div>
                    <div class="form-group col-6">
                      <label for="telefone">Telefone:</label>
                      <input type="text" name="telefone" class="form-control" id="telefone" value="<?= $telefone ?>" onkeypress="mascara_tel(this)" placeholder="Telefone" maxlength="16">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="email">E-mail:</label>
                      <input type="email" name="email" value="<?= $email ?>" class="form-control" id="email" placeholder="E-mail">
                    </div>
                    <div class="form-group col-6">
                      <label for="user">Usuário:</label>
                      <input type="text" name="user" value="<?= $user_name ?>" class="form-control" id="user" placeholder="Usuário">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="pass">Senha antiga:</label>
                      <input type="password" name="pass_ant" class="form-control" id="pass_ant" placeholder="Senha">
                    </div>
                    <div class="form-group col-6">
                      <label for="pass">Nova Senha:</label>
                      <input type="password" name="pass" class="form-control" id="pass" placeholder="Senha">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="pass">Confirme Senha:</label>
                      <input type="password" name="confirme" class="form-control" id="confirme" placeholder="Senha">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div id="loading" class="overlay" style="visibility: hidden">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" style="float: right;" id="gravar">Salvar</button>
                </div>

              </form>
            </div>
            <!-- /.card -->

            <div id="simple-msg"></div>

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Page specific script -->
  <script>
    var form = $('#ajaxform');
    //definindo regras de validação de formulário
    $('#ajaxform').validate({
      rules: {
        nome: {
          required: true,
          minlength: 3,
          maxlength: 80,
        },
        email: {
          required: true,
          email: true,
        },
      },
      messages: {
        nome: {
          required: "Por favor, insira um nome",
          minlength: "O nome deve conter, pelo menos, 3 caracteres",
          maxlength: "O nome pode conter no máximo 80 caracteres"
        },
        email: {
          required: "Por favor, insira um e-mail",
          email: "Por favor, insira um e-mail válido"
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
