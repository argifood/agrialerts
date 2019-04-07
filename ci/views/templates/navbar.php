<?php $perms = $this->session->userdata('permissions'); ?>
<nav class="navbar navbar-default navbar-fixed-top" >
    <div class='container-fluid'>
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 	</div>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li><a href='<?php echo site_url('home')?>'><i class="fa fa-home"></i> <?php echo $this->lang->line('home');?></a></li>
			<?php if (($perms & CAN_MANAGE_ALERTS) === CAN_MANAGE_ALERTS) { ?>
			<li><a href='<?php echo site_url('alerts')?>'><i class="fas fa-bell"></i> <?php echo $this->lang->line('alert');?></a></li>
			<?php }
			 if (($perms & CAN_ONLY_READ_ALERTS) === CAN_ONLY_READ_ALERTS) { ?>
			<li><a href='<?php echo site_url('user_prefs')?>'><i class="fas fa-tasks"></i> <?php echo $this->lang->line('user_pref');?></a></li>
			<?php }
      if (($perms & CAN_MANAGE_PARAMETERS) === CAN_MANAGE_PARAMETERS) { ?>
			<li class="dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fas fa-cog"></i> <?php echo $this->lang->line('params');?><b class="caret"></b></a>
				<ul class="dropdown-menu multi-level">
					<?php
					if (($perms & CAN_MANAGE_PARAMETERS) === CAN_MANAGE_PARAMETERS) { ?>
					<li><a href='<?php echo site_url('agritypes')?>'><i class="fa "></i> <?php echo $this->lang->line('agritypes');?></a></li>
					<li><a href='<?php echo site_url('alerttypes')?>'><i class="fa "></i> <?php echo $this->lang->line('alerttype');?></a></li>
					<?php }?>
				</ul>
			</li>
			<?php }
			if (($perms & CAN_MANAGE_USERS) === CAN_MANAGE_USERS ||
				 ($perms & CAN_MANAGE_GROUPS) === CAN_MANAGE_GROUPS) { ?>
			<li class="dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-users"></i>  <?php echo $this->lang->line('users');?><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php
					if (($perms & CAN_MANAGE_USERS) === CAN_MANAGE_USERS) { ?>
					<li><a href='<?php echo site_url('user/addUser')?>'><i class="fa "></i> <?php echo $this->lang->line('register');?></a></li>
					<li><a href='<?php echo site_url('user')?>'><i class="fa "></i> <?php echo $this->lang->line('users_list');?></a></li>
					<li><a href='<?php echo site_url('user/listInactive')?>'><i class="fa "></i> <?php echo $this->lang->line('users_inactive');?></a></li>
					<?php } ?>
					<?php
					if (($perms & CAN_MANAGE_GROUPS) === CAN_MANAGE_GROUPS) { ?>
					<li><a href='<?php echo site_url('user_groups')?>'><i class="fa "></i> <?php echo $this->lang->line('groups');?></a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
			<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('fname').' '.$this->session->userdata('lname')?><b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href='<?php echo site_url('user/showUser/')?>'><i class="fa fa-pencil"></i>  <?php echo $this->lang->line('changeData');?></a></li>
				<li><a href='<?php echo site_url('user/changePassword')?>'><i class="fa fa-lock"></i>  <?php echo $this->lang->line('changePassword');?></a></li>
				<li class="divider"></li>
				<li><a href='<?php echo site_url('user/logout')?>'><i class="fa fa-power-off"></i>  <?php echo $this->lang->line('logout');?></a></li>
			</ul>
			</li>
		</ul>
	</div>	
	</div>
</nav>
