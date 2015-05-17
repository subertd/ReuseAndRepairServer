<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    echo "<b><u>Categories</b></u><br>";

	$query = "SELECT * FROM Category" or die ("Oops! DB not connected"); 
    $result = $mysqli->query($query); 

    echo "<table><tr><td>Cat ID</td>";
    echo "<td>Cat Name</td></tr>";
    while($row = mysqli_fetch_array($result)) { 
        echo "<tr><td>" . $row["category_id"] . "</td><td>" . $row["category_name"] . "</td></tr>"; 
    }
    echo "</table><p></p><p></p>";
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    echo "<b><u>Items</b></u><br>";

	$query = "SELECT * FROM Item" or die ("Oops! DB not connected"); 
    $result = $mysqli->query($query); 

    echo "<table><tr><td>Item ID</td>";
    echo "<td>Item Name</td>";
    echo "<td>Cat ID</td></tr>";
    while($row = mysqli_fetch_array($result)) { 
        echo "<tr><td>" . $row["item_id"] . "</td><td>" . $row["item_name"] . "</td><td>" . $row["category_id"] . "</td></tr>"; 
    }
    echo "</table><p></p><p></p>";
?>

<?php
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    echo "<b><u>Organizations</b></u><br>";

	$query = "SELECT * FROM Organization" or die ("Oops! DB not connected"); 
    $result = $mysqli->query($query); 

    echo "<table><tr><td>Organization ID</td>";
    echo "<td>Organization Name</td>";
    echo "<td>Phone Number</td>";
    echo "<td>Website</td>";
    echo "<td>Physical address</td></tr>";
    while($row = mysqli_fetch_array($result)) { 
        echo "<tr><td>" . $row["organization_id"] . "</td><td>" . $row["organization_name"] . "</td><td>" . $row["phone_number"] 
        . "</td><td>" . $row["website_url"] . "</td><td>" . $row["physical_address"] ."</td></tr>"; 
    }
    echo "</table><p></p><p></p>";
?>