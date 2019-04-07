	<?php
	if (($this->session->flashdata('message'))) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'add-nuts5');
	echo form_open(site_url('nuts5s/add'), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('nuts5');?></h2>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 

        <label class='control-label' for='nuts5_name'><?php echo $this->lang->line('nuts5_name') ?></label>
        <input type='text' class='form-control' name='nuts5_name' id='nuts5_name' required />
      </div> 
<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 

        <label class='control-label' for='nuts3_id'><?php echo $this->lang->line('nuts3_id') ?></label>
        <select class='form-control' name='nuts3_id' id='nuts3_id' required>
          <option value=''><?php echo $this->lang->line('nuts3_id') ?></option>
          <?php foreach($nuts3 As $key => $val) { ?>
          <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
          <?php } ?>
        </select>
      </div> 

	</div>
	<div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('nuts5s') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new_nuts5' id='new_nuts5'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
