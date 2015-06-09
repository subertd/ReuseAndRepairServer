<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

    <title>Add an existing Item to an Existing Organization</title>
    <b><u>Add an existing item to an existing organization:</u></b><p></p>
    <form method='post' action='addItemToOrg2.php'>
    Select Item: <select name='itemID'><p></p>

<?php 
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $query = "SELECT item_id, item_name FROM Item"; 
    $result = $mysqli->query($query);

    while ($row = $result->fetch_array()) {
        echo "<option value='" . $row['item_id'] . "'>" . $row['item_name'] . "</option>";
    }
?>

    </select>
    Select Organization: <select name='orgID'>

<?php 
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $query = "SELECT organization_id, organization_name FROM Organization"; 
    $result = $mysqli->query($query);

    while ($row = $result->fetch_array()) {
        echo "<option value='" . $row['organization_id'] . "'>" . $row['organization_name'] . "</option>";
    }
?>

    </select>
    <p></p><input type='submit' name='submit'></form>