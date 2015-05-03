<?php
	session_start();
	
	$serverAddress = 'mysql.eecs.oregonstate.edu';
	$password = 'xZbt6uNNXxvCbDMC';
	$user = 'cs419-g15';
	$database = 'cs419-g15';
	
	$mysqli = new mysqli($serverAddress, $user, $password, $database);

	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

?>