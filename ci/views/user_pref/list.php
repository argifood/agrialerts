	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('user_pref');?></h2>
		<?php if(count($viewdata) > 0){?>
		<div class='form-group'>
			<div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 text-right'>
			</div>
			<div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right'>
				<a class='btn btn-primary form-control' href='<?php echo site_url('user_prefs/add') ?>'><?php echo $this->lang->line('add');?></a>
			</div>
		</div>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<table class='table table-hover table-striped'>
				<thead>
					<tr>
            <th><?php echo $this->lang->line('agritype_id');?></th>
            <th><?php echo $this->lang->line('nuts2_id');?></th>
            <th><?php echo $this->lang->line('nuts3_id');?></th>
            <th><?php echo $this->lang->line('nuts5_id');?></th>
            <th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($viewdata As $row) { ?>
						<tr>
							<td><a href="<?php echo site_url('user_prefs/update/'.$row['user_pref_id']) ?>" > <?php echo $row['agritype_name'] ?> </a></td>
							<td> <?php echo $row['nuts2_name'] ?> </td>
							<td> <?php echo $row['nuts3_name'] ?> </td>
							<td> <?php echo $row['nuts5_name'] ?> </td>
              <td><a class="del-task" data-id="<?php echo $row['user_pref_id'] ?>" data-task="<?php echo $row['agritype_name'] ?>" href="#" title="Διαγραφή"><i class="fa fa-trash text-danger"></i></a></td>
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
				<a class='btn btn-primary' href='<?php echo site_url('user_prefs/add') ?>'><?php echo $this->lang->line('add');?></a>
			</p>
			<?php } ?>
		</div>
	</div>

  <script>
    $(".del-task").click(function(){
      var self = $(this);
      var thetask = self.attr('data-task');
      var theid = self.attr('data-id');
      if(confirm("Θέλετε να σταματήσετε να λαμβάνεται προειδοποιήσεις για "+thetask+";")){
        $.ajax({
         url: "<?php echo site_url('user_prefs/delete/')?>"+"/"+theid,
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