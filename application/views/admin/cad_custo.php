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
                <h3 class="card-title">Lançamento de custos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("admin/grava_custo"); ?>" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="cod">Tipo Custo:</label>
                    <select name="cod" id="cod" class="form-control">
                      <option value=""> -------------------------- </option>
                      <option value="1">Salário de Funcionários</option>
                      <option value="2">Compra de produtos</option>
                      <option value="3">Compra de Equipamentos</option>
                      <option value="4">Pagamento de empréstimo</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="valor">Valor:</label>
                    <input type="text" name="valor" class="form-control" id="valor" placeholder="Valor total do custo">
                  </div>
                </div><!-- /.card-body -->
                <div id="loading" class="overlay" style="visibility: hidden">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="gravar" style="float: right;">Salvar</button>
                </div>
              </form>
            </div><!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6"></div>
          <!--/.col (right) -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php $this->load->view('footer'); ?>
  <!-- jquery-validation -->
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <script>
    //definindo regras de validação de formulário 
    $('#ajaxform').validate({
      rules: {
        cod: {
          required: true
        },
        valor: {
          required: true
        }
      },
      messages: {
        cod: {
          required: "Por favor, escolha uma das opções"
        },
        valor: {
          required: "Por favor, insira um valor"
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
          var postData = $(this).serializeArray();
          var formURL = $(this).attr("action");
          $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
              $("#simple-msg").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
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