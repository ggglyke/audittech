<?php
	function loadHeaderorFooterFile($name){
		/*switch($name){
			case 'ordertable':
				echo 'ordertable header css';
				break;
		}*/
		if($name == 'quillJsHeader'){
			echo '<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">';
		} else if($name == 'tableCss') {
			echo '<link rel="stylesheet" href="' . URLROOT . '/css/table.css">';
			echo '<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">';
		} else if($name == 'quillJsFooter'){
			echo '<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>';
		} else if($name == 'quillCustomCss'){
				echo '<link rel="stylesheet" href="' . URLROOT . '/css/quillCustomCss.css">';
		} else if($name == 'tableSorter'){
				echo '';
		}

		
	}