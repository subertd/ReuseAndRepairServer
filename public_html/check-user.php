<?php	
if ((isset($_POST['username']))&&(isset($_POST['password']))) {

	require_once("../autoload.php");

	use ReuseAndRepair\Persistence\Mysql\MysqliFactory;
	use ReuseAndRepair\Persistence\Mysql\MysqliFactoryException;

	try {
		$mysqliFactory = new MysqliFactory();
		$mysqli = $mysqliFactory->getInstance();
		assert($mysqli != null);
		echo "successfully resolved a mysqli object";
		
		$q="SELECT username, password FROM `cs419-g15`.`admin_account` WHERE username='".$mysqli->real_escape_string($_POST['username'])."' AND password='".$mysqli->real_escape_string($_POST['password'])."'";

		if (!$result = $mysqli->query($q)) {
			//----- for debugging purpose only -----
			//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
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
				//echo '<p class="success">Login successful...</p>';//this echo will never echo, because it is after header.
			}
		}
	}
	catch (MysqliFactoryException $e) {
		echo "<p>There was a problem getting a mysqli object; ";
		echo '(' . $e->getCode() . ') ';
		echo $e->getMessage() . "</p>";
	}

}
else {
	include('redirect.php');
}
?>