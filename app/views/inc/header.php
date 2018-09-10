<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet"> 
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/layout.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="<?php echo URLROOT; ?>/js/tablesorter/tablesorter.min.js"></script>

  <?php if(isset($data['external_modules_header'])){
  	foreach ($data['external_modules_header'] as $module) {
  		loadHeaderorFooterFile($module);
  	}
  }
  ?>
    <script src="<?php echo URLROOT; ?>/js/tablesorter/tablesorter.widgets.js"></script>
  <title><?php echo SITENAME; ?> - <?php echo $data['title']; ?></title>
</head>
<body>
	<?php require APPROOT .'/views/inc/navbar.php'; ?>
	<div class="container container-main">
  
