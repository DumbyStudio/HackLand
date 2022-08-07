<!DOCTYPE html>
<html>
	
	<head>
		
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url('css/HackLandStyle.css'); ?>" />
		<title>HackLand</title>
		<script src="<?php echo base_url('js/jquery.js');?>"></script>

	</head>
	
	<body>

		<div id='Main'>
			<div class="application">
				<div class="application-header">
					<span class="application-header-index" onclick="openSoftware('Intranet')">Mon Intranet</span>
					<span class="application-header-index" onclick="openSoftware('Network')">Mon Réseau</span>
					<span class="application-header-index" onclick="openSoftware('Internet')">Internet</span>
					<span class="application-header-index" onclick="openSoftware('Parameters')">Paramètres</span>
				</div>
				<div id="application_body" class="application-body">
					
				</div>
			</div>
		</div>
		
		<?php \App\Controllers\Scrap::open("taskBar"); ?>

		<script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
		<script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>*
		<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>
		<script type="text/jsx" src="<?php echo base_url('js/HackOS/header.js'); ?>"></script>
		<script id="applicationScript"></script>

	</body>
	
</html>