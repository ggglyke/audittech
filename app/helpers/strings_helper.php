<?php

	function dashesToCamelCase($string, $capitalizeFirstCharacter = false){

	    $str = str_replace('-', '', ucwords($string, '-'));

	    if (!$capitalizeFirstCharacter) {
	        $str = lcfirst($str);
	    }

	    return $str;
	    die('$str');
	}

	function validate_url($url){
		$url = trim($url);
	
		return ((strpos($url, "http://") === 0 || strpos($url, "https://") === 0) && filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED) !== false);
	}

	function emptyP($html){

		$pattern = "/<p[^>]*><\\/p[^>]*>/"; 
		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  use this pattern to remove any empty tag

		return preg_replace($pattern, '', $html); 
	}