<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->lang->line('website')?></title>
        <meta charset='utf-8' />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/all.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css" />

        <script src="<?php echo base_url()?>assets/js/jquery.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    </head>
    <body class='agency'>
			<?php include('navbar.php') ?>
			<div class='container'>
				<?php echo $body; ?>
			</div>
    </body>
</html>
