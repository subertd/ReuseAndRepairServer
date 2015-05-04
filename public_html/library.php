<?php
	session_start();
	
	//$serverAddress = 'mysql.eecs.oregonstate.edu';
	//$password = 'xZbt6uNNXxvCbDMC';
	//$user = 'cs419-g15';
	$database = 'cs419-g15';

    $serverAddress = 'localhost';
    $password = 'rightin2';
    $user = 'root';
	
	$mysqli = new mysqli($serverAddress, $user, $password, $database);

	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

?>