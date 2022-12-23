	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0">
              <?= $h2 ?>
            </h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
					<?php if($this->session->userdata('user_acess') == 'admin' || $this->session->userdata('user_acess') == 'chefe de finanças'){ ?>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?= $vendas->num ?></h3>
									<p>Vendas diária</p>
								</div>
								<div class="icon">
									<i class="ion ion-bag"></i>
								</div>
								<a href="<?= base_url('vendas/listarDiario'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>R$ <?= number_format($lucro, 2, ',', '.'); ?></h3>
									<p>Lucro Mensal</p>
								</div>
								<div class="icon">
									<i class="ion ion-stats-bars"></i>
								</div>
								<a href="<?= base_url('admin/balanco'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					<?php } ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $func->num ?></h3>
                <p>Funcionários</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= base_url('admin/funcionarios'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
					<?php if($this->session->userdata('user_acess') == 'admin' || $this->session->userdata('user_acess') == 'chefe de finanças'){ ?>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-danger">
								<div class="inner">
									<h3>R$ <?= number_format($valor_diario->valor, 2, ',', '.'); ?></h3>
									<p>Custos Diários</p>
								</div>
								<div class="icon">
									<i class="ion ion-pie-graph"></i>
								</div>
								<a href="<?= base_url('custo/listar'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					<?php } ?>
        </div>
        <div class="row">
					<?php if($this->session->userdata('user_acess') == 'admin' || $this->session->userdata('user_acess') == 'chefe de finanças'){ ?>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?= $vendas_mensal->num ?></h3>
									<p>Vendas mensal</p>
								</div>
								<div class="icon">
									<i class="ion ion-bag"></i>
								</div>
								<a href="<?= base_url('vendas/listarMensal'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					<?php } if($this->session->userdata('user_acess') == 'admin' || $this->session->userdata('user_acess') == 'chefe de estoque'){ ?>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3><?= $prod->num ?></h3>
									<p>Produtos em Estoque</p>
								</div>
								<div class="icon">
									<i class="ion ion-stats-bars"></i>
								</div>
								<a href="<?= base_url('admin/produtos'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					<?php } if($this->session->userdata('user_acess') == 'admin' || $this->session->userdata('user_acess') == 'chefe de finanças'){ ?>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-warning">
								<div class="inner">
									<h3>R$ <?= number_format($caixa->valor, 2, ',', '.'); ?></h3>
									<p>Caixa da empresa</p>
								</div>
								<div class="icon">
									<i class="ion ion-person-add"></i>
								</div>
								<a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-danger">
								<div class="inner">
									<h3>R$ <?= number_format($valor_mensal->valor, 2, ',', '.'); ?></h3>
									<p>Custos Mensais</p>
								</div>
								<div class="icon">
									<i class="ion ion-bag"></i>
								</div>
								<a href="<?= base_url('custo/listarMensal'); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<?php } ?>
        </div>
        <!-- /.row -->
        <?php $this->load->view('admin/tarefas') ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <?php $this->load->view('footer'); ?>
  <!-- REQUIRED SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="<?= base_url('assets/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/raphael/raphael.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script>
  <script src="<?= base_url("assets/"); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url("assets/"); ?>plugins/jquery-validation/additional-methods.min.js"></script>

  <script>
    $('#ajaxform').validate({
      rules: {
        descricao: {
          required: true,
          minlength: 10,
          maxlength: 80
        },
        data: {
          required: true
        },
        setor: {
          required: true
        },
      },
      messages: {
        descricao: {
          required: "Por favor, insira uma descrição",
          minlength: "A descrição deve conter, pelo menos, 10 caracteres",
          maxlength: "A descrição pode conter no máximo 80 caracteres"
        },
        data: {
          required: "Por favor, insira uma data"
        },
        setor: {
          required: "Por favor, insira um setor"
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
