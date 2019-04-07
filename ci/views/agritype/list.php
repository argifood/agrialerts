	<div class='row'>
	<h2 class='text-center'><?php echo $this->lang->line('agritype');?></h2>
		<?php if(count($viewdata) > 0){?>
		<div class='form-group'>
			<div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 text-right'>
			</div>
			<div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right'>
				<a class='btn btn-primary form-control' href='<?php echo site_url('agritypes/add') ?>'><?php echo $this->lang->line('add');?></a>
			</div>
		</div>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<table class='table table-hover table-striped'>
				<thead>
					<tr>
            <th><?php echo $this->lang->line('agritype_name');?></th>
            <th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($viewdata As $key => $val) { ?>
						<tr>
							<td><a href="<?php echo site_url('agritypes/update/'.$key) ?>" > <?php echo $val ?> </a></td>
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
				<a class='btn btn-primary' href='<?php echo site_url('agritypes/add') ?>'><?php echo $this->lang->line('add');?></a>
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
         url: "<?php echo site_url('agritypes/delete/')?>"+"/"+theid,
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