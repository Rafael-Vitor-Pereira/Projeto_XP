  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cadastro de Funcionários</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="ajaxform" name="ajaxform" action="<?= base_url("funcionario/gravarEdicao"); ?>" method="POST">
                <div class="card-body">
                  <div class="row">
										<input type="hidden" name="id" value="<?= $dados->id ?>">
                    <div class="form-group col-4">
                      <label for="nome">Nome:</label>
                      <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="<?= $dados->nome ?>">
                    </div>
                    <div class="form-group col-4">
                      <label for="sobrenome">Sobrenome:</label>
                      <input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome" value="<?= $dados->sobrenome ?>">
                    </div>
										<div class="form-group col-4">
                      <label for="email">E-mail:</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="<?= $dados->email ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-2">
                      <label for="telefone">Telefone:</label>
                      <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Telefone" data-inputmask="'mask': '(99) 9 9999-9999'" data-mask value="<?= $dados->telefone ?>">
                    </div>
                    <div class="form-group col-2">
                      <label for="cpf">CPF:</label>
                      <input type="text" name="cpf" class="form-control" id="cpf" placeholder="CPF" data-inputmask="'mask': '999.999.999-99'" data-mask value="<?= $dados->cpf ?>">
                    </div>
                    <div class="form-group col-2">
                      <label for="cep">CEP:</label>
                      <input type="text" name="cep" class="form-control" id="cep" placeholder="CEP" data-inputmask="'mask': '99999-999'" data-mask value="<?= $dados->CEP ?>">
                    </div>
                    <div class="form-group col-4">
                      <label for="logradouro">Logradouro:</label>
                      <input type="text" name="logradouro" class="form-control" id="logradouro" placeholder="Logradouro" readonly value="<?= $dados->logradouro ?>">
                    </div>
                    <div class="form-group col-2">
                      <label for="numero">Número:</label>
                      <input type="text" name="numero" class="form-control" id="numero" placeholder="Número" value="<?= $dados->numero ?>">
                    </div>
									</div>
                  <div class="row">
										<div class="form-group col-2">
                      <label for="complemento">Complemento:</label>
                      <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Complemento" value="<?= $dados->complemento ?>">
                    </div>
										<div class="form-group col-3">
                      <label for="estado">Bairro:</label>
                      <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Bairro" readonly value="<?= $dados->bairro ?>">
                    </div>
										<div class="form-group col-3">
                      <label for="cidade">Cidade:</label>
                      <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Cidade" readonly value="<?= $dados->cidade ?>">
                    </div>
										<div class="form-group col-2">
                      <label for="estado">Estado:</label>
                      <input type="text" name="estado" class="form-control" id="estado" placeholder="Estado" readonly value="<?= $dados->estado ?>">
                    </div>
                    <div class="form-group col-2">
                      <label for="setor">Setor:</label>
                      <select name="setor" id="setor" class="form-control">
                        <option value="Administrativo" <?= $dados->setor == 'Administrativo' ? 'selected' : '' ?> >Administrativo</option>
                        <option value="RH" <?= $dados->setor == 'RH' ? 'selected' : '' ?> >Recursos Humanos</option>
                        <option value="Estoque" <?= $dados->setor == 'Estoque' ? 'selected' : '' ?> >Estoque</option>
                        <option value="Financeiro" <?= $dados->setor == 'Financeiro' ? 'selected' : '' ?> >Financeiro</option>
                      </select>
                    </div>
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
					<div id="simple-msg"></div>
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
  <!-- jquery-validation -->
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <script>
    //definindo regras de validação de formulário 
    $('#ajaxform').validate({
      rules: {
        nome: {
          required: true,
          minlength: 3,
          maxlength: 80
        },
        sobrenome: {
          required: true,
          minlength: 3,
          maxlength: 80
        },
        telefone: {
          required: true,
          minlength: 16
        },
        cpf: {
          required: true,
          minlength: 14
        },
        email: {
          required: true,
          email: true
        },
        cep: {
          required: true,
          minlength: 8
        },
				numero: {
					required: true,
					minlength: 2
				},
        setor: {
          required: true
        }
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
          minlength: "O telefone deve conter, pelo menos, 16 caracteres"
        },
        cpf: {
          required: "Por favor, insira um CPF",
          minlength: "O CPF deve conter, pelo menos, 14 caracteres"
        },
        email: {
          required: "Por favor, insira um e-mail",
          email: "Por favor, insira um e-mail válido"
        },
        cep: {
          required: "Por favor, insira um CEP",
          minlength: "O CEP deve conter, pelo menos, 8 caracteres"
        },
				numero: {
          required: "Por favor, insira um Número",
          minlength: "O Número deve conter, pelo menos, 8 caracteres"
        },
        setor: {
          required: "Por favor, escolha uma das opções"
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

		$(document).ready(function() {
			function limpa_formulário_cep() {
				// Limpa valores do formulário de cep.
				$("#logradouro").val("");
				$("#bairro").val("");
				$("#cidade").val("");
				$("#estado").val("");
			}
			//Quando o campo cep perde o foco.
			$("#cep").blur(function() {
				//Nova variável "cep" somente com dígitos.
				var cep = $(this).val().replace(/\D/g, '');
				//Verifica se campo cep possui valor informado.
				if (cep != "") {
					//Expressão regular para validar o CEP.
					var validacep = /^[0-9]{8}$/;
					//Valida o formato do CEP.
					if(validacep.test(cep)) {
						//Preenche os campos com "..." enquanto consulta webservice.
						$("#logradouro").val("...");
						$("#bairro").val("...");
						$("#cidade").val("...");
						$("#estado").val("...");
						//Consulta o webservice viacep.com.br/
						$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
							if (!("erro" in dados)) {
								//Atualiza os campos com os valores da consulta.
								$("#logradouro").val(dados.logradouro);
								$("#bairro").val(dados.bairro);
								$("#cidade").val(dados.localidade);
								$("#estado").val(dados.uf);
							}else{
								//CEP pesquisado não foi encontrado.
								limpa_formulário_cep();
								alert("CEP não encontrado.");
							}
						});
					}else{
						//cep é inválido.
						limpa_formulário_cep();
						alert("Formato de CEP inválido.");
					}
				}else{
					//cep sem valor, limpa formulário.
					limpa_formulário_cep();
				}
			});
		});
	</script>
