<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $orgId = "NULL";
    $orgName = $_POST['orgName'];
    $orgPhone = $_POST['orgPhone'];
    $orgURL = $_POST['orgURL'];
    $orgAddr = $_POST['orgAddr'];

    echo "{'orgId':'" . $orgId . "', 'orgName':'" . $orgName . "', 'orgPhone':'" . $orgPhone . "', 'orgURL':'" . $orgURL . "', 'orgAddr':'" .           $orgAddr . "'}";

# ***   ADD TO Organization table ***
#
#	$query = "INSERT INTO Category VALUES(NULL,'$catName')";
#	$result = $mysqli->query($query);
#	if($result)
#	    echo "<br>Success!";
#	else
#	    echo "<br>Fail!";
?>