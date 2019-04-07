	<?php
	if (($this->session->flashdata('message'))) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'add-alert_dim');
	echo form_open(site_url('alert_dims/add'), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('alert_dim');?></h2>
		<div class='form-group col-lg-3 col-md-3 col-sm-3 col-xs-12'> 
			<label class='control-label' for='alerttype_id'><?php echo $this->lang->line('alerttype_id') ?></label>
			<select class='form-control' name='alerttype_id' id='alerttype_id' required>
			  <option value=''><?php echo $this->lang->line('alerttype_id') ?></option>
			  <?php foreach($alerttype As $key => $val) { ?>
			  <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
			  <?php } ?>
			</select>
		</div> 
		<div class='form-group col-lg-5 col-md-5 col-sm-5 col-xs-12'> 
			<label class='control-label' for='agritype_id'><?php echo $this->lang->line('agritype_id') ?></label>
			<select class='form-control' name='agritype_id' id='agritype_id' required>
			  <option value=''><?php echo $this->lang->line('agritype_id') ?></option>
			  <?php foreach($agritype As $key => $val) { ?>
			  <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
			  <?php } ?>
			</select>
		</div> 
		<div class='form-group col-lg-4 col-md-4 col-sm-4 col-xs-12'> 
			<label class='control-label' for='agri_dim_severity'><?php echo $this->lang->line('agri_dim_severity') ?></label>
			<input type='text' class='form-control' name='agri_dim_severity' id='agri_dim_severity' required />
		</div> 
		<div class='form-group col-lg-4 col-md-4 col-sm-4 col-xs-12'> 
			<label class='control-label' for='nuts2_id'><?php echo $this->lang->line('nuts2_id') ?></label>
			<select class='form-control' name='nuts2_id' id='nuts2_id' required>
			  <option value=''><?php echo $this->lang->line('nuts2_id') ?></option>
			  <?php foreach($nuts2 As $key => $val) { ?>
			  <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
			  <?php } ?>
			</select>
		</div> 
		<div class='form-group col-lg-4 col-md-4 col-sm-4 col-xs-12'> 
			<label class='control-label' for='nuts3_id'><?php echo $this->lang->line('nuts3_id') ?></label>
			<select class='form-control' name='nuts3_id' id='nuts3_id' >
			  <option value=''><?php echo $this->lang->line('nuts3_id') ?></option>
			  <?php foreach($nuts3 As $key => $val) { ?>
			  <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
			  <?php } ?>
			</select>
		</div> 
		<div class='form-group col-lg-4 col-md-4 col-sm-4 col-xs-12'> 
			<label class='control-label' for='nuts5_id'><?php echo $this->lang->line('nuts5_id') ?></label>
			<select class='form-control' name='nuts5_id' id='nuts5_id' >
			  <option value=''><?php echo $this->lang->line('nuts5_id') ?></option>
			  <?php foreach($nuts5 As $key => $val) { ?>
			  <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
			  <?php } ?>
			</select>
		</div> 
	</div>
	<div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('alerts/update/'.$this->session->userdata('alert')) ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new_alert_dim' id='new_alert_dim'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
