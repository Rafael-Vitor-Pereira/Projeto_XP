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
              				</div><!-- /.card-header -->
              				<form id="ajaxform" name="ajaxform" action="<?= base_url("produtos/gravarEdicao"); ?>" method="POST">
                				<div class="card-body">
									<input type="hidden" name="id" value="<?= $dados->id ?>">
                   					<div class="form-group">
                   						<label for="nome">Nome:</label>
                   						<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="<?= $dados->produto ?>">
                   					</div>
                   					<div class="form-group">
                   						<label for="quantidade">Quantidade:</label>
                   						<input type="number" name="quantidade" class="form-control" id="quantidade" placeholder="Quantidade" value="<?= $dados->estoque ?>">
                   					</div>
									<div class="form-group">
                      					<label for="preco">Preço:</label>
                      					<input type="number" name="preco" class="form-control" id="preco" placeholder="Preço" value="<?= $dados->preco ?>">
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
					</div><!--/.col (left) -->
					<div id="simple-msg"></div>
          			<!-- right column -->
          			<div class="col-md-6"></div>
          			<!--/.col (right) -->
        		</div><!-- /.row -->
      		</div><!-- /.container-fluid -->
    	</section><!-- /.content -->
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
        		quantidade: {
          			required: true
        		},
        		preco: {
          			required: true
        		}
      		},
      		messages: {
				nome: {
					required: "Por favor, insira um nome",
					minlength: "O nome deve conter, pelo menos, 3 caracteres",
					maxlength: "O nome pode conter no máximo 80 caracteres"
				},
				quantidade: {
					required: "Por favor, insira um sobrenome"
				},
				preco: {
					required: "Por favor, insira um telefone"
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
