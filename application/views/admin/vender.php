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
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div id="simple-msg"></div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $h2 ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("admin/grava_venda"); ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <select name="produto" id="produto" class="form-control">
                      <option value=""> ------------------- </option>
                      <?php
                      if ($prod != 0) {
                        foreach ($prod as $linha) {
                      ?>
                          <option value="<?= $linha->id ?>"><?= $linha->produto ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" name="quantidade" class="form-control" id="quantidade" placeholder="Quantidade de unidades vendidas">
                  </div>
                </div>
                <!-- /.card-body -->
                <div id="loading" class="overlay" style="visibility: hidden">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="gravar" style="float: right;">Salvar</button>
                </div>

              </form>
            </div>
            <!-- /.card -->
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
  <?php $this->load->view('footer'); ?>
  <!-- jquery-validation -->
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <script>
    function mascara_tel(tel) {
      if (tel.value.length == 0)
        tel.value = '(' + tel.value;
      if (tel.value.length == 3) tel.value = tel.value + ') ';
      if (tel.value.length == 6) tel.value = tel.value + ' ';
      if (tel.value.length == 11) tel.value = tel.value + '-';
    }

    function mascara_cpf(cpf) {
      if (cpf.value.length == 3) cpf.value = cpf.value + '.';
      if (cpf.value.length == 7) cpf.value = cpf.value + '.';
      if (cpf.value.length == 11) cpf.value = cpf.value + '-';
    }
    //definindo regras de validação de formulário 
    $('#ajaxform').validate({
      rules: {
        produto: {
          required: true,
        },
        quantidade: {
          required: true,
          minlength: 2,
        }
      },
      messages: {
        produto: {
          required: "Por favor, escolha uma opção",
        },
        quantidade: {
          required: "Por favor, insira um número",
          minlength: "A quantidade deve conter, pelo menos, 2 digitos",
        }
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