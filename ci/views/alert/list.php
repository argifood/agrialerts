	<?php	if (($this->session->flashdata('message'))) {	?>
	<div class='alert alert-dismissable alert-<?php echo $this->session->flashdata('messagetype') ?>'>
		<button class='close' type='button' data-dismiss='alert'>&times;</button>
		<strong><?php echo $this->session->flashdata('message') ?></strong>
	</div>
	<?php } ?>
	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('alert');?></h2>
		<?php if(count($viewdata) > 0){?>
		<div class='form-group'>
			<div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 text-right'>
			</div>
			<div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right'>
				<a class='btn btn-primary form-control' href='<?php echo site_url('alerts/add') ?>'><?php echo $this->lang->line('add');?></a>
			</div>
		</div>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<table class='table table-hover table-striped'>
				<thead>
					<tr>
            <th><?php echo $this->lang->line('alert_name');?></th>
            <th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($viewdata As $key => $val) { ?>
						<tr>
							<td><a href="<?php echo site_url('alerts/update/'.$key) ?>" > <?php echo $val ?> </a></td>
              <td><a class="del-task" data-id="<?php echo $key ?>" data-task="<?php echo $val ?>" href="#" title="Διαγραφή"><i class="fa fa-trash text-danger"></i></a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php }
			else {?>
			<p class='lead text-center'>
				<?php echo $this->lang->line('nodata');?>
			</p>
			<p class='text-center'>
				<a class='btn btn-primary' href='<?php echo site_url('alerts/add') ?>'><?php echo $this->lang->line('add');?></a>
			</p>
			<?php } ?>
		</div>
	</div>

  <script>
    $(".del-task").click(function(){
      var self = $(this);
      var thetask = self.attr('data-task');
      var theid = self.attr('data-id');
      if(confirm("Θέλετε να διαγράψετε το αντικείμενο "+thetask+";")){
        $.ajax({
         url: "<?php echo site_url('alerts/delete/')?>"+"/"+theid,
         type: 'post',
         success: function(response){
          if(response == 1){
           location.reload(true);
          }
          else {
            alert("Δεν είναι δυνατόν να διαγραφεί το συγκεκριμένο αντικείμενο. Επικοινωνήστε με το διαχειριστή");
          }
         }
        });
      }
    });
  </script>