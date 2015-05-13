<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $itemId = "NULL";
    $itemName = $_POST['itemName'];
    $categoryRef = $_POST['catID'];

    echo "{'itemId':'" . $itemId . "', 'itemName':'" . $itemName . "', 'categoryRef':'" . $categoryRef . "'}";

# ***   ADD TO Item table ***
#
#	$query = "INSERT INTO Category VALUES(NULL,'$catName')";
#	$result = $mysqli->query($query);
#	if($result)
#	    echo "<br>Success!";
#	else
#	    echo "<br>Fail!";
?>