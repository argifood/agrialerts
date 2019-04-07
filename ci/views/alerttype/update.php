	<?php
	if ($this->session->flashdata('message')) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'update-alerttype');
	echo form_open(site_url('alerttypes/update/'.$row['alerttype_id']), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('alerttype');?></h2>
		<div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'> 
	        <label class='control-label' for='alerttype_name'><?php echo $this->lang->line('alerttype_name') ?></label>
	        <input type='text' class='form-control' name='alerttype_name' id='alerttype_name' value='<?php echo $row['alerttype_name'] ?>'required />
		</div> 
	</div>
	<div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('alerttypes') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new' id='newfeedform'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
