<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
    <br>
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php $this->load->view('menu_msg') ?>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-body p-0">
                <div class="mailbox-read-info">
                  <h5><?= $msg['titulo'] ?></h5>
                  <h6>De: <?= $msg['email_remet'] ?>
                    <?php $data_timestamp = strtotime($msg['data']); ?>
                    <span class="mailbox-read-time float-right"><?= date('d M Y', $data_timestamp) . ' ' . $msg['hora'] ?></span>
                  </h6>
                </div>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <?= to_html($msg['conteudo']) ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            <?php if ($msg['excluida'] == 'não') { ?>
              <div class="card-footer">
                <div class="float-right">
                  <form action="<?= base_url('escrever') ?>" method="post">
                    <input type="text" name="dest" value="<?= $msg['email_remet'] ?>" style='display: none;' readonly>
                    <button type="submit" class="btn btn-default"><i class="fas fa-reply"></i>
                      Responder</button>
                    <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                  </form>
                </div>
                <form action="<?= base_url('excluir') ?>" method="post">
                  <input type="number" name="id" value="<?= $msg['id'] ?>" style='display: none;' readonly>
                  <input type="number" name="pag" value="ler_msg" style='display: none;' readonly>
                  <button type="submit" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                  <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </form>
              </div>
            <?php } ?>
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
  <?php $this->load->view('footer'); ?>
  <!-- jquery-validation -->
  <script src="<?php echo base_url("application/views/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url("application/views/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
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

  <?php $this->load->view('footer'); ?>