<?php
	require_once ('../../app/libraries/Controller.php');
	require_once ('../../app/controllers/Tasks.php');

	if(isset($_POST['taskId']) && $_POST['taskId'] != '' && isset($_POST['statusLabel']) && $_POST['statusLabel'] != ''){
		if($this->projectModel->quickUpdate()){
			echo 'plop';
		}
	}