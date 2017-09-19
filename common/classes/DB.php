<?php
	
	class DB {
		var $db = ''; //Database Connection
		var $dbHost = "localhost";
		var $dbUser = "root";
		var $dbPass = "znls0505";
		var $dbName = "SimpleBoard";
		
		function connect_db($dbHost, $dbUser, $dbPass, $dbName) {
			// $this->$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbCharset);
			$db = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
			return $db;
			
		}
	}
 ?>

<?php
	$obj = new DB;
	$obj->connect_db($dbHost, $dbUser, $dbPass, $dbName, $dbCharset);
?>