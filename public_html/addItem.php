<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

    <title>Add a new Item</title>
    <b><u>Add a new item:</u></b><p></p>
    <form method='post' action='addItem2.php'>
    Item name: <input type='text' name='itemName'><p></p>
    Category: <select name='catID'>

<?php 
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	$mysqli->select_db($database) or die ("Oops! DB not connected"); // select the database

    $query = "SELECT category_id, category_name FROM Category"; 
    $result = $mysqli->query($query);

    while ($row = $result->fetch_array()) {
        echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
    }
?>

    </select>
    <p></p><input type='submit' name='submit'></form>