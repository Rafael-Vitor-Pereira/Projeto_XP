<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php
  $this->load->view('header');
  $this->load->view('admin/menu');
  ?>
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
                <h3 class="card-title">Editar Funcionário</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("admin/gravar_editar"); ?>" method="POST">
                <input type="hidden" name="id" id="id" value="<?= $func->id ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="nome">Nome:</label>
                      <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="<?= $func->nome ?>">
                    </div>
                    <div class="form-group col-6">
                      <label for="sobrenome">Sobrenome:</label>
                      <input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome" value="<?= $func->sobrenome ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="email">E-mail:</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="<?= $func->email ?>">
                    </div>
                    <div class="form-group col-6">
                      <label for="telefone">Telefone:</label>
                      <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Telefone" value="<?= $func->telefone ?>" onkeypress="mascara_tel(this)">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-9">
                      <label for="endereco">Endereço:</label>
                      <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Endereço" value="<?= $func->endereco ?>">
                    </div>
                    <div class="form-group col-3">
                      <label for="setor">Setor:</label>
                      <input type="text" name="setor" class="form-control" id="setor" placeholder="Setor" value="<?= $func->setor ?>">
                    </div>
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
  <?php $this->load->view('footer') ?>
  <!-- jquery-validation -->
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Page specific script -->
  <script>
    function mascara_tel(tel) {
      if (tel.value.length == 0)
        tel.value = '(' + tel.value;
      if (tel.value.length == 3) tel.value = tel.value + ') ';
      if (tel.value.length == 6) tel.value = tel.value + ' ';
      if (tel.value.length == 11) tel.value = tel.value + '-';
    }

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