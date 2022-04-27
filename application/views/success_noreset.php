<?php

if ($this->session->userdata('logged') != TRUE) :

	redirect(base_url(), 'refresh');

endif;

?>

<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-check"></i> Informa&ccedil;&atilde;o:</h4>
	<?php echo $msg; ?>
</div>