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
								<center><h5><?= $h2 ?></h5></center>
							</div>
							<div class="card-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Telefone</th>
											<th>E-mail</th>
											<th>Acesso</th>
											<th style="text-align: center;">Status</th>
											<th style="text-align: center;" colspan="3">Ações</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($dados != 0) {
											$x = 0;
											foreach ($dados as $linha) {
											?>
												<tr id="linha<?php echo $linha->id ?>">
													<td><?= $linha->nome ?></td>
													<td><?= $linha->telefone ?></td>
													<td><?= $linha->email ?></td>
													<td><?= $linha->acesso ?></td>
													<td>
														<a href="#s" class="status" id="<?= $linha->id; ?>" style="text-decoration: none;">
															<span id="s<?= $linha->id; ?>">
																<?php
																if ($linha->status == 1) echo "<i class='fa fa-toggle-on'></i> Ativo";
																else echo "<i class='fa fa-toggle-off'></i> Inativo";
																?>
															</span>
														</a>
													</td>
													<td align="center">
														<a href="<?= base_url('usuario/info/') . $linha->id; ?>" style="text-decoration: none;" title="+ Informações do usuário">
															<i class="fa fa-plus"></i> Info
														</a>
													</td>
													<td align="center">
														<a href="<?= base_url('usuario/editar/') . $linha->id; ?>" style="text-decoration: none;" title="Exibir/Editar usuário">
															<i class="fa fa-edit"></i> Editar
														</a>
													</td>
													<td align="center">
														<a href="javascript:excluir(<?= $linha->id; ?>);" style="text-decoration: none;" title="Excluir usuário">
															<i class="fa fa-trash"></i> Excluir
														</a>
													</td>
												</tr>
											<?php
											}
											} else {
											?>
											<tr>
												<td colspan="8">
												<center>Não há funcionários cadastrados</center>
												</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th>Nome</th>
											<th>Telefone</th>
											<th>E-mail</th>
											<th>Acesso</th>
											<th style="text-align: center;">Status</th>
											<th style="text-align: center;" colspan="3">Ações</th>
										</tr>
									</tfoot>
								</table>
							</div><!-- /.card-body -->
						</div><!-- /.card -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->
	<!-- page script -->

	<script>
		$(function() {
			$("#dados").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
				"language": {
					"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
				}
			}).buttons().container().appendTo('#dados_wrapper .col-md-6:eq(0)');
		});
	</script>
	<script>
		$(".status").click(function() {
			var ID = $(this).attr("id");
			$.post(
				"<?php echo base_url('usuario/status/'); ?>", {
					id: ID
				},
				function(data, status) {
					var panel = "#s" + ID;
					$(panel).html(data);
					//alert("Data: " + data + "\nStatus: " + status);
				}
			);
		});

		function excluir(idreg) {
			resp = confirm('Deseja realmente excluir esse registro?');
			if (resp) {
				var ID = idreg;
				$.post(
					"<?php echo site_url('usuario/excluir/'); ?>", {
						id: ID
					},
					function(data, status) {
						var panel = "#linha" + ID;
						$(panel).remove();
						//alert("Data: " + data + "\nStatus: " + status);
					}
				);
			} else {
				return false;
			}
		}
	</script>
