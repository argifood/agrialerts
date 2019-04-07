	<?php
	if (($this->session->flashdata('message'))) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'add-agency');
	echo form_open(site_url('agencies/add'), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('agency');?></h2>
		<div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'> 

        <label class='control-label' for='agency_name'><?php echo $this->lang->line('agency_name') ?></label>
        <input type='text' class='form-control' name='agency_name' id='agency_name' required />
      </div> 
<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 

        <label class='control-label' for='agency_address'><?php echo $this->lang->line('agency_address') ?></label>
        <input type='text' class='form-control' name='agency_address' id='agency_address' required />
      </div> 
<div class='form-group col-lg-2 col-md-2 col-sm-2 col-xs-12'> 

        <label class='control-label' for='agency_zip'><?php echo $this->lang->line('agency_zip') ?></label>
        <input type='text' class='form-control' name='agency_zip' id='agency_zip' required />
      </div> 
<div class='form-group col-lg-3 col-md-3 col-sm-3 col-xs-12'> 

        <label class='control-label' for='agency_city'><?php echo $this->lang->line('agency_city') ?></label>
        <input type='text' class='form-control' name='agency_city' id='agency_city' required />
      </div> 

	</div>
	<div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('agencies') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new_agency' id='new_agency'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
