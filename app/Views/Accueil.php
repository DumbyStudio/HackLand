<!DOCTYPE html>
<html>
	
	<head>
		
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url('css/HackLandStyle.css'); ?>" />
		<title>HackLand</title>
		
	</head>
	
	<body>
		
		<?php \App\Controllers\Scrap::open("header"); ?>

		<div id='Main'>
			Bienvenue sur HackLand
		</div>
		
		<?php \App\Controllers\Scrap::open("footer"); ?>
		
	</body>
	
</html>