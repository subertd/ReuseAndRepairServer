<?php 
		ini_set('display_errors', 'On');
		include 'library.php'; 
?>

    <title>Add a new Category</title>

    <b><u>Add a new category:</u></b><p></p>
    <form method="post" action="addCat2.php">
        Category name: <input type="text" name="catName"><p></p>
        <input type="submit" name="submit">
    </form>