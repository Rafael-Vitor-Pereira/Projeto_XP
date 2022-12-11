	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<br>
    	<!-- Main content -->
    	<section class="content">
      		<div class="container-fluid">
        		<div class="row">
          			<div class="col-12">
            			<div class="card">
              				<div class="card-header">
                				<center>
                  					<h5><?= $h2 ?></h5>
                				</center>
              				</div>
              				<div class="card-body">
                				<table id="informacoes" class="table table-bordered table-striped">
                    				<tr>
                      					<th colspan="3">Nome</th>
                      					<th>Telefone</th>
										<th>E-mail</th>
									</tr>
									<tr>
										<td colspan="3"><?= $dados->nome . ' ' . $dados->sobrenome ?></td>
                          				<td><?= $dados->telefone ?></td>
                          				<td><?= $dados->email ?></td>
									</tr>
									<tr>
										<th colspan="3">Logradouro</th>
										<th>Número</th>
										<th>Complemento</th>
									</tr>
									<tr>
										<td colspan="3"><?= $dados->logradouro ?></td>
										<td><?= $dados->numero ?></td>
										<td><?= $dados->complemento ?></td>
									</tr>
									<tr>
										<th>Bairro</th>
										<th>Cidade</th>
										<th>Estado</th>
                      					<th>Acesso</th>
										<th>Login</th>
                    				</tr>
									<tr>
										<td><?= $dados->bairro ?></td>
										<td><?= $dados->cidade ?></td>
										<td><?= $dados->estado ?></td>
										<td><?= $dados->acesso ?></td>
										<td><?= $dados->login ?></td>
									</tr>
                				</table>
              				</div><!-- /.card-body -->
            			</div><!-- /.card -->
          			</div><!-- /.col -->
        		</div><!-- /.row -->
      		</div><!-- /.container-fluid -->
    	</section><!-- /.content -->
  	</div><!-- /.content-wrapper -->
  	<!-- page script -->
