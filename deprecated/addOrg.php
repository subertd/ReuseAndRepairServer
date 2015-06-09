<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

    <title>Add a new Organization</title>

    <b><u>Add a new organization:</u></b><p></p>
    <form method="post" action="addOrg2.php">
        Organization name: <input type="text" name="orgName"><p></p>
        Phone number: <input type="text" name="orgPhone"><p></p>
        Website URL: <input type="text" name="orgURL" value="http://"><p></p>
        Physical address: <input type="text" name="orgAddr"><p></p>
        <input type="submit" name="submit">
    </form>