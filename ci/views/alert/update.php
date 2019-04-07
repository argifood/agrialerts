	<?php
	if ($this->session->flashdata('message')) {
	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php }
	$attributes = array('class' => 'form', 'id' => 'update-alert');
	echo form_open_multipart(site_url('alerts/update/'.$row['alert_id']), $attributes);
	?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('alert');?></h2>
    <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'> 
      <label class='control-label' for='alert_name'><?php echo $this->lang->line('alert_name') ?></label>
      <input type='text' class='form-control' name='alert_name' id='alert_name' value='<?php echo $row['alert_name'] ?>'required />
    </div> 
    <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'> 
      <label class='control-label' for='agency_id'><?php echo $this->lang->line('agency_id') ?></label>
      <select class='form-control' name='agency_id' id='agency_id' required>
        <option value=''><?php echo $this->lang->line('agency_id') ?></option>
        <?php foreach($agency As $key => $val) { ?>
        <option value='<?php echo $key ?>' <?php echo ($key == $row['agency_id'])? 'selected' : '' ?>> <?php echo $val ?> </option>
        <?php } ?>
      </select>
    </div> 
    <div class='form-group col-lg-3 col-md-3 col-sm-3 col-xs-12'> 
      <label class='control-label' for='alert_from'><?php echo $this->lang->line('alert_from') ?></label>
      <input type='text' class='form-control datepicker' name='alert_from' id='alert_from' value='<?php echo prety_date($row['alert_from'], FALSE) ?>'required />
    </div> 
    <div class='form-group col-lg-3 col-md-3 col-sm-3 col-xs-12'> 
      <label class='control-label' for='alert_to'><?php echo $this->lang->line('alert_to') ?></label>
      <input type='text' class='form-control datepicker' name='alert_to' id='alert_to' value='<?php echo prety_date($row['alert_to'], FALSE) ?>'required />
    </div> 
    <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'> 
      <label class='control-label' for='alert_file'><?php echo $this->lang->line('alert_file') ?></label>
      <?php if (!empty($row['alert_file'])){?>
      <a href="<?php echo site_url('files/download/'.$row['alert_file'])?>" target='_blank'>Προβολή αρχείου ή&hellip;</a>
      <?php } ?>
      <div class="input-group">
      <span class="input-group-btn">
        <span class="btn btn-info btn-file">
            Επιλέξτε αρχείο&hellip; <input type="file" name="userfile" required>
        </span>
      </span>
      <input type="text" class="form-control" readonly placeholder="Ανεβάστε το <?php echo $this->lang->line('alert_file') ?>">
      </div>
    </div> 
	</div>
  <?php include (VIEWPATH.'alert_dim/list.php')?>
  <div class='row'>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<a class='btn btn-default form-control' href="<?php echo site_url('alerts') ?>">Επιστροφή</a>
		</div>
		<div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
			<button class='btn btn-primary form-control' name='new' id='newfeedform'>Αποθήκευση</button>
		</div>
	</div>
	<?php echo form_close() ?>
	<script>
    $( function() {
      $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' }, $.datepicker.regional[ "el" ]).keydown(false);
    } );
    $(".btn-file :file").change(function(){
        var input_file = $(this);
        var input_text = input_file.parents('.input-group').find(':text');
        var label= input_file.val().replace(/\\/g, '/').replace(/.*\//, '');
        input_text.val(label);
        $('#file_name').val(label);
    });
	</script>