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
                <h3 class="card-title">Informações pessoais</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?= $user ?>" class="form-control" id="nome" readonly>
                  </div>
                  <div class="col-md-3">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" value="<?= $email ?>" class="form-control" id="email" readonly>
                  </div>
                  <div class="col-md-3">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" value="<?= $telefone ?>" class="form-control" id="telefone" readonly>
                  </div>
                  <div class="col-md-3">
                    <label for="user">Usuário:</label>
                    <input type="text" name="user" value="<?= $user_name ?>" class="form-control" id="user" readonly>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div id="loading" class="overlay" style="visibility: hidden">
                <i class="fa fa-refresh fa-spin"></i>
              </div>
              <div class="card-footer">
                <form action="<?= base_url('pagina/editar') ?>">
                  <button type="submit" class="btn btn-default" id="editar" style="float: right;">Editar</button>
                </form>
              </div>
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
  
  <script>
    //definindo regras de validação de formulário 
    $('#ajaxform').validate({
      rules: {
        nome: {
          required: true,
          minlength: 3,
          maxlength: 80,
        },
        sobrenome: {
          required: true,
          minlength: 3,
          maxlength: 80,
        },
        telefone: {
          required: true,
          minlength: 16,
        },
        cpf: {
          required: true,
          minlength: 14,
        },
        email: {
          required: true,
          email: true,
        },
        usuario: {
          required: true,
          minlength: 3,
          maxlength: 15,
        },
        senha: {
          required: true,
          minlength: 6,
          maxlength: 30,
        },
      },
      messages: {
        nome: {
          required: "Por favor, insira um nome",
          minlength: "O nome deve conter, pelo menos, 3 caracteres",
          maxlength: "O nome pode conter no máximo 80 caracteres"
        },
        sobrenome: {
          required: "Por favor, insira um sobrenome",
          minlength: "O sobrenome deve conter, pelo menos, 3 caracteres",
          maxlength: "O sobrenome pode conter no máximo 80 caracteres"
        },
        telefone: {
          required: "Por favor, insira um telefone",
          minlength: "O telefone deve conter, pelo menos, 16 caracteres",
        },
        cpf: {
          required: "Por favor, insira um CPF",
          minlength: "O CPF deve conter, pelo menos, 14 caracteres",
        },
        email: {
          required: "Por favor, insira um e-mail",
          email: "Por favor, insira um e-mail válido"
        },
        usuario: {
          required: "Por favor, insira um usuario",
          minlength: "O usuario deve conter, pelo menos, 3 caracteres",
          maxlength: "O usuario pode conter no máximo 15 caracteres"
        },
        senha: {
          required: "Por favor, insira um senha",
          minlength: "A senha deve conter, pelo menos, 6 caracteres",
          maxlength: "A senha pode conter no máximo 30 caracteres"
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
        if ($('#ajaxform').valid()) {
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
