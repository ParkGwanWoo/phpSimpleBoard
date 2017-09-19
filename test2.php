<?php
	error_reporting(E_ALL);
	ini_set("display_error", "1");
	
	$uploaddir = './images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	$tempfile =  $_FILES['userfile']['tmp_name'];
	
	if(move_uploaded_file($tempfile, $uploadfile)) {
		echo 'success';	
	}else {
		echo 'failed <br>';
	};

	print_r($_FILES);
	
?>