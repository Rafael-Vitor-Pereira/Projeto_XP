<?php

if ($this->session->userdata('logged') != TRUE) :

	redirect('pagina', 'refresh');

endif;

echo validation_errors('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-warning"></i> Aten&ccedil;&atilde;o!</h4>', '</div>');

?>

<script>
	$(function() {
		$('#ajaxform')[0].reset();
	});
</script>