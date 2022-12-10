<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
  		<!-- Brand Logo -->
  		<a href="<?= base_url('admin'); ?>" class="brand-link" style="text-decoration: none;">
    		<img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    		<span class="brand-text font-weight-light"><?= $titulo ?></span>
  		</a>

  		<!-- Sidebar -->
  		<div class="sidebar">
    		<!-- Sidebar user panel (optional) -->
    		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
      			<div class="image">
        			<img src="<?= base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
      			</div>
      			<div class="info">
        			<a href="<?= base_url('pagina/credenciais'); ?>" style="text-decoration: none;" class="d-block"><?= strtoupper($this->session->userdata('user_name')) ?></a>
      			</div>
    		</div>

    		<!-- Sidebar Menu -->
    		<nav class="mt-2">
      			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        			<li class="nav-item">
          				<a href="<?= base_url('admin'); ?>" class="nav-link">
            				<i class="nav-icon fas fa-tachometer-alt"></i>
            				<p> Dashboard </p>
          				</a>
        			</li>
					<?php if (($this->session->userdata('user_acess') == 'admin')) { ?>
						<li class="nav-item">
          					<a href="#" class="nav-link">
            					<i class="nav-icon fas fa-users"></i>
            					<p>Usuários <i class="fas fa-angle-left right"></i></p>
          					</a>
          					<ul class="nav nav-treeview">
            					<li class="nav-item">
              						<a href="<?= base_url('usuario/cadastrar'); ?>" class="nav-link">
                						<i class="far fa-circle nav-icon"></i>
                						<p>Cadastrar</p>
              						</a>
            					</li>
								<li class="nav-item">
              						<a href="<?= base_url('usuario/listar'); ?>" class="nav-link">
                						<i class="far fa-circle nav-icon"></i>
                						<p>Listar/Buscar</p>
              						</a>
            					</li>
							</ul>
						</li>
					<?php } ?>
					<li class="nav-item">
          				<a href="#" class="nav-link">
            				<i class="nav-icon fas fa-users"></i>
            				<p>Funcionários <i class="fas fa-angle-left right"></i></p>
    	      			</a>
      	    			<ul class="nav nav-treeview">
        	    			<li class="nav-item">
          	    				<a href="<?= base_url('funcionario/cadastrar'); ?>" class="nav-link">
            	    				<i class="far fa-circle nav-icon"></i>
              	  					<p>Cadastrar</p>
              					</a>
            				</li>
							<li class="nav-item">
  	            				<a href="<?= base_url('funcionario/listar'); ?>" class="nav-link">
    	            				<i class="far fa-circle nav-icon"></i>
      	          					<p>Listar/Buscar</p>
        	      				</a>
          	  				</li>
						</ul>
					</li>
					<?php if(($this->session->userdata('user_acess') == 'admin') || ($this->session->userdata('user_acess') == 'chefe de estoque')){ ?>
						<li class="nav-item">
  	        				<a href="#" class="nav-link">
								<i class="nav-icon fa fa-box"></i>
      	      					<p>Produtos <i class="fas fa-angle-left right"></i></p>
          					</a>
	          				<ul class="nav nav-treeview">
  	          					<li class="nav-item">
    	          					<a href="<?= base_url('produto/cadastrar'); ?>" class="nav-link">
      	          						<i class="far fa-circle nav-icon"></i>
        	        					<p>Cadastrar</p>
          	    					</a>
            					</li>
								<li class="nav-item">
  	            					<a href="<?= base_url('produto/listar'); ?>" class="nav-link">
    	            					<i class="far fa-circle nav-icon"></i>
      	          						<p>Listar/Buscar</p>
        	      					</a>
          	  					</li>
							</ul>
						</li>
					<?php } if(($this->session->userdata('user_acess') == 'admin') || ($this->session->userdata('user_acess') == 'chefe de finanças')){ ?>
						<li class="nav-item">
  	        				<a href="#" class="nav-link">
								<i class="nav-icon fas fa-dollar-sign"></i>
      	      					<p>Vendas <i class="fas fa-angle-left right"></i></p>
          					</a>
	          				<ul class="nav nav-treeview">
  	          					<li class="nav-item">
    	          					<a href="<?= base_url('vendas/cadastrar'); ?>" class="nav-link">
      	          						<i class="far fa-circle nav-icon"></i>
        	        					<p>Cadastrar</p>
          	    					</a>
            					</li>
								<li class="nav-item">
              						<a href="<?= base_url('vendas/listar'); ?>" class="nav-link">
                						<i class="far fa-circle nav-icon"></i>
                						<p>Listar/Buscar</p>
	              					</a>
  	          					</li>
							</ul>
						</li>
					<?php } if(($this->session->userdata('user_acess') == 'admin') || ($this->session->userdata('user_acess') == 'chefe de finanças')){ ?>
						<li class="nav-item">
        	  				<a href="#" class="nav-link">
								<i class="nav-icon fa fa-receipt"></i>
            					<p>Custos <i class="fas fa-angle-left right"></i></p>
	          				</a>
  	        				<ul class="nav nav-treeview">
    	        				<li class="nav-item">
      	        					<a href="<?= base_url('custo/cadastrar'); ?>" class="nav-link">
        	        					<i class="far fa-circle nav-icon"></i>
          	      						<p>Cadastrar</p>
            	  					</a>
            					</li>
								<li class="nav-item">
  	            					<a href="<?= base_url('custo/listar'); ?>" class="nav-link">
    	            					<i class="far fa-circle nav-icon"></i>
      	          						<p>Listar/Buscar</p>
        	      					</a>
          	  					</li>
							</ul>
						</li>
					<?php } if(($this->session->userdata('user_acess') == 'admin')){ ?>
  	      				<li class="nav-item">
    	      				<a href="<?= base_url('admin/bloquear'); ?>" class="nav-link">
								<i class="nav-icon fa fa-ban"></i>
        	    				<p>Bloquear usuário</p>
	          				</a>
  	      				</li>
					<?php } ?>
    	  			<li class="nav-item">
          				<a href="<?= base_url('pagina/contatos'); ?>" class="nav-link">
            				<i class="nav-icon fas fa-table"></i>
            				<p>Contatos</p>
          				</a>
        			</li>
        			<li class="nav-item">
          				<a href="<?= base_url('pagina/mensagens'); ?>" class="nav-link">
            				<i class="nav-icon far fa-envelope"></i>
            				<p>Mensagens</p>
          				</a>
        			</li>
      			</ul>
    		</nav><!-- /.sidebar-menu -->
  		</div><!-- /.sidebar -->
	</aside>
