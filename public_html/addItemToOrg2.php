<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $orgID = $_POST['orgID'];
    $itemID = $_POST['itemID'];

    echo "{'orgID':'" . $orgID . "', 'itemID':'" . $itemID . "'}";

# ***   PUT TO Organization_Item table ***
#
#	$query = "INSERT INTO Category VALUES(NULL,'$catName')";
#	$result = $mysqli->query($query);
#	if($result)
#	    echo "<br>Success!";
#	else
#	    echo "<br>Fail!";
?>