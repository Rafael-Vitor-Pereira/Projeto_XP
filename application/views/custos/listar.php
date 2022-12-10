  <br>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
								<?php if($mensal){ ?>
									<div class="row">
                  	<div class="col-4">&nbsp;</div>
                  	<div class="col-4">&nbsp;</div>
                  	<div class="col-4">
                    	<form action="<?= base_url('custo/listarMensal') ?>" method="post">
                      	<center><label for="mes">Buscar por mês e ano</label></center>
                      	<div class="row">
                        	<div class="col-4">
                          	<select name="mes" id="mes" class="form-control">
                            	<option value="">Mês</option>
                            	<option value="01">Janeiro</option>
                            	<option value="02">Fevereiro</option>
                            	<option value="03">Março</option>
                            	<option value="04">Abril</option>
                            	<option value="05">Maio</option>
                            	<option value="06">Junho</option>
                            	<option value="07">Julho</option>
                            	<option value="08">Agosto</option>
                            	<option value="09">Setembro</option>
                            	<option value="10">Outubro</option>
                            	<option value="11">Novembro</option>
                            	<option value="12">Dezembro</option>
                          	</select>
                        	</div>
                        	<div class="col-4">
                          	<select name="ano" id="ano" class="form-control">
                            	<option value="">Ano</option>
                            	<?php for ($i = 2022; $i <= 2050; $i++) { ?>
                              	<option value="<?= $i ?>"><?= $i ?></option>
                            	<?php } ?>
                          	</select>
                        	</div>
                        	<div class="col-4">
                          	<input type="submit" value="Buscar" class="btn btn-primary">
                        	</div>
                      	</div>
                    	</form>
                  	</div>
                	</div>
								<?php } ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tipo de Custo</th>
                      <th>Valor</th>
											<th colspan="2" style="text-align: center;">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $x = 0;
                    if ($custo != '') {
                      foreach ($custo as $linha) {
                        if ($linha->cod == 1) {
                          $desc = 'Salário de Funconários';
                        } elseif ($linha->cod == 2) {
                          $desc = 'Compra de produtos';
                        } elseif ($linha->cod == 3) {
                          $desc = 'Compra de Equipamentos';
                        }else{
													$desc = 'Pagamento de emprestimo';
												}
                    ?>
                        <tr id="linha<?= $linha->id; ?>">
                          <td><?= $linha->id ?></td>
                          <td><?= $desc ?></td>
                          <td>R$ <?= number_format($linha->valor, 2, ',', '.') ?></td>
													<td align="center"><a href="<?= site_url('custo/editar/'); ?><?= $linha->id; ?>" title="Exibir/Editar custo"><i class="fa fa-edit"></i> Editar</a></td>
                      		<td align="center"><a href="javascript:excluir(<?= $linha->id; ?>);" title="Excluir consulta"><i class="fa fa-trash"></i> Excluir</a></td>
                        </tr>
                      <?php
                      }
                    } else {
                      ?>
                      <tr>
                        <td colspan="5">
                          <center>Não há custo nenhum no dia de hoje</center>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Tipo de Custo</th>
                      <th>Valor</th>
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
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

<script>
  function excluir(idreg) {
    resp = confirm('Deseja realmente excluir esse registro?');

    if (resp) {
      var ID = idreg;

      $.post(
        "<?php echo site_url('custo/excluir/'); ?>", {
          id: ID
        },
        function(data, status) {
          var panel = "#linha" + ID;
          $(panel).remove();
          //alert("Data: " + data + "\nStatus: " + status);
        });
    } else {
      return false;
    }
  }
</script>
