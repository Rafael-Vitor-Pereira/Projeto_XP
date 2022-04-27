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
                <h3 class="card-title">Cadastro de Produtos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("admin/grava_prod"); ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="produto">Produto:</label>
                    <input type="text" name="produto" class="form-control" id="produto" placeholder="Nome do produto">
                  </div>
                  <div class="form-group">
                    <label for="estoque">Quantidade:</label>
                    <input type="number" name="estoque" class="form-control" id="estoque" placeholder="Quantidade de unidades do produto">
                  </div>
                  <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="text" name="preco" class="form-control" id="preco" placeholder="Valor do produto">
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
    //definindo regras de validação de formulário 
    $('#ajaxform').validate({
      rules: {
        produto: {
          required: true,
          minlength: 5
        },
        estoque: {
          required: true,
          minlength: 2
        },
        preco: {
          required: true,
          minlength: 3
        }
      },
      messages: {
        produto: {
          required: "Por favor, insira o nome de um produto",
          minlength: "O nome do produto deve conter, pelo menos, 5 caracteres"
        },
        estoque: {
          required: "Por favor, insira um valor",
          minlength: "O valor deve conter, pelo menos, 2 caracteres"
        },
        preco: {
          required: "Por favor, insira um valor",
          minlength: "O preço deve conter, pelo menos, 3 caracteres"
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