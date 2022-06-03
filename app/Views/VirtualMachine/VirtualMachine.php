<!DOCTYPE html>
<html>
	
	<head>
		
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url('css/HackLandStyle.css'); ?>" />
		<title>HackLand</title>
		<script src="<?php echo base_url('js/jquery.js'); ?>"></script>

	</head>
	
	<body>

		<div id='Main'>
			<div class="application">
				<div class="application-header">
					<span class="application-header-index">Mon Intranet</span>
					<span class="application-header-index">Mon Réseau</span>
					<span class="application-header-index">Internet</span>
				</div>
				<div class="application-body">

				</div>
			</div>
		</div>
		
		<?php \App\Controllers\Scrap::open("taskBar"); ?>
		
	</body>
	
</html>