<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $categoryId = "NULL";
    $categoryName = $_POST['catName'];

    echo "{'categoryId':'" . $categoryId . "', 'categoryName':'" . $categoryName. "'}";

# ***   ADD TO Category table ***
#
#	$query = "INSERT INTO Category VALUES(NULL,'$catName')";
#	$result = $mysqli->query($query);
#	if($result)
#	    echo "<br>Success!";
#	else
#	    echo "<br>Fail!";
?>