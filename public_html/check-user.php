<?php	
if ((isset($_POST['username']))&&(isset($_POST['password']))) {

        $databaseProperties = parse_ini_file("../resources/main/config/database.ini");
        $dbhost = $databaseProperties["host"];
        $dbuser = $databaseProperties["user"];
        $dbpass = $databaseProperties["password"];
        $dbname = $databaseProperties["database"];
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		$q="SELECT username, password FROM `cs419-g15`.`admin_account` WHERE username='".$mysqli->real_escape_string($_POST['username'])."' AND password='".$mysqli->real_escape_string($_POST['password'])."'";

		if (!$result = $mysqli->query($q)) {
			//----- for debugging purpose only -----
			echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		}
		else {
			if ($result->num_rows==0) {
				echo '<p class="error">Sorry, login was unsuccessful. <br>Please try again.</p>';
			}
			else {					
				session_start(); 
				$_SESSION['username'] = $mysqli->real_escape_string($_POST['username']);
				$_SESSION['password'] = $mysqli->real_escape_string($_POST['password']);	
				
				header("HTTP/1.0 202 Accepted");
			}
		}
}
else {
	include('redirect.php');
}
?>