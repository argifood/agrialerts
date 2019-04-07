	<?php
	if (($this->session->flashdata('message'))) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'add-user_pref');
	echo form_open(site_url('user_prefs/add'), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('user_pref');?></h2>
    <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'> 
      <label class='control-label' for='agritype_id'><?php echo $this->lang->line('agritype_id') ?></label>
      <select class='form-control' name='agritype_id' id='agritype_id' required>
        <option value=''><?php echo $this->lang->line('agritype_id') ?></option>
        <?php foreach($agritype As $key => $val) { ?>
        <option value='<?php echo $key ?>' > <?php echo $val ?> </option>
        <?php } ?>
      </select>
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
			<a class='btn btn-default form-control' href="<?php echo site_url('user_prefs') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new_user_pref' id='new_user_pref'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
