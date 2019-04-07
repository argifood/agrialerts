	<?php
	if ($this->session->flashdata('message')) {
	?>
	<div class='alert alert-dismissable alert-<?php $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'update-nuts3');
	echo form_open(site_url('nuts3s/update/'.$row['nuts3_id']), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('nuts3');?></h2>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 

        <label class='control-label' for='nuts3_name'><?php echo $this->lang->line('nuts3_name') ?></label>
        <input type='text' class='form-control' name='nuts3_name' id='nuts3_name' value='<?php echo $row['nuts3_name'] ?>'required />
      </div> 
<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 

        <label class='control-label' for='nuts2_id'><?php echo $this->lang->line('nuts2_id') ?></label>
        <select class='form-control' name='nuts2_id' id='nuts2_id' required>
          <option value=''><?php echo $this->lang->line('nuts2_id') ?></option>
          <?php foreach($nuts2 As $key => $val) { ?>
          <option value='<?php echo $key ?>' <?php echo ($key == $row['nuts2_id'])? 'selected' : '' ?>> <?php echo $val ?> </option>
          <?php } ?>
        </select>
      </div> 

	</div>
	<div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('nuts3s') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new' id='newfeedform'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
