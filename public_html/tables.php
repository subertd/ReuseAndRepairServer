<?php 
	ini_set('display_errors', 'On');
	include 'library.php';
	$mysqli = new mysqli($serverAddress, $user, $password, $database);
	
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
    // Table creation SQL queries
        // Organization Table
        $result = $mysqli->query(
            "CREATE TABLE  `cs419-g15`.`Organization` (
            `organization_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `phone_number` VARCHAR( 14 ) NULL ,
            `website_url` VARCHAR( 255 ) NULL ,
            `physical address` VARCHAR( 255 ) NULL
            ) ENGINE = INNODB" 
        );
        if($result == 'TRUE')
            echo "Table 'Organization' creation successful.<br>";
        else
            echo "Table 'Organization' creation fail.<br>";
        
        // Category Table
        $result = $mysqli->query(
            "CREATE TABLE  `cs419-g15`.`Category` (
            `category_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `category_name` VARCHAR( 255 ) NOT NULL
            ) ENGINE = INNODB" 
        );
        if($result == 'TRUE')
            echo "Table 'Category' creation successful.<br>";
        else
            echo "Table 'Category' creation fail.<br>";
        
        // Item Table
        $result = $mysqli->query(
            "CREATE TABLE  `cs419-g15`.`Item` (
            `item_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `item_name` VARCHAR( 255 ) NOT NULL ,
            `category_id` INT NOT NULL ,
            INDEX (  `category_id` )
            ) ENGINE = INNODB" 
        );
        if($result == 'TRUE')
            echo "Table 'Item' creation successful.<br>";
        else
            echo "Table 'Item' creation fail.<br>";

        echo "<p>";

    // Category insertion queries
    $result = $mysqli->query(
        "INSERT INTO  `cs419-g15`.`Category` (
        `category_id` ,
        `category_name`
        )
        VALUES 
        (NULL ,  'Household'), (NULL ,  'Bedding / bath'), (NULL ,  'Children’s goods'), 
        (NULL , 'Appliances - small'), (NULL , 'Appliances - large'), (NULL , 'Building/ home improvement'), 
        (NULL , 'Wearable items'), (NULL , 'Useable Electronics'), (NULL , 'Sporting equipment/ camping'), 
        (NULL , 'Garden'), (NULL , 'Food'), (NULL , 'Medical supplies'), 
        (NULL , 'Office equipment'), (NULL , 'Packing materials'), (NULL , 'Miscellaneous'),
        (NULL , 'Repair items');" 
    );
    if($result == 'TRUE')
        echo "Table 'Category' insertions successful.<br>";
    else
        echo "Table 'Category' insertions fail.<br>";

    // Item insertion queries
    $result = $mysqli->query(
        "INSERT INTO  `cs419-g15`.`Item` (
        `item_id` ,
        `item_name` ,
        `category_id`
        )
        VALUES 
        (NULL ,  'Arts and crafts',  '1'), 
        (NULL ,  'Arts and crafts',  '1'), 
        (NULL ,  'Barbeque grills',  '1'), 
        (NULL ,  'Books',  '1'), 
        (NULL ,  'Canning jars',  '1'), 
        (NULL ,  'Cleaning supplies',  '1'), 
        (NULL ,  'Clothes hangers',  '1'), 
        (NULL ,  'Cookware',  '1'), 
        (NULL ,  'Dishes',  '1'), 
        (NULL ,  'Fabric',  '1'), 
        (NULL ,  'Food storage containers',  '1'), 
        (NULL ,  'Furniture',  '1'), 
        (NULL ,  'Luggage',  '1'), 
        (NULL ,  'Mattresses',  '1'), 
        (NULL ,  'Ornaments',  '1'), 
        (NULL ,  'Toiletries',  '1'), 
        (NULL ,  'Utensils',  '1'), 
        (NULL ,  'Blankets',  '2'), 
        (NULL ,  'Comforters',  '2'), 
        (NULL ,  'Linens',  '2'), 
        (NULL ,  'Sheets',  '2'), 
        (NULL ,  'Small rugs',  '2'), 
        (NULL ,  'Towels ',  '2'), 
        (NULL ,  'Arts and crafts ',  '3'), 
        (NULL ,  'Baby carriers',  '3'), 
        (NULL ,  'Baby gates',  '3'), 
        (NULL ,  'Bike trailers',  '3'), 
        (NULL ,  'Books',  '3'), 
        (NULL ,  'Child car seats',  '3'), 
        (NULL ,  'Clothes',  '3'), 
        (NULL ,  'Crayons',  '3'), 
        (NULL ,  'Cribs',  '3'), 
        (NULL ,  'Diapers ',  '3'), 
        (NULL ,  'High chairs',  '3'), 
        (NULL ,  'Maternity',  '3'), 
        (NULL ,  'Musical instruments',  '3'), 
        (NULL ,  'Nursing items',  '3'), 
        (NULL ,  'Playpens',  '3'), 
        (NULL ,  'School supplies',  '3'), 
        (NULL ,  'Strollers',  '3'), 
        (NULL ,  'Toys',  '3'), 
        (NULL ,  'Blenders',  '4'), 
        (NULL ,  'Dehumidifiers',  '4'), 
        (NULL ,  'Fans',  '4'), 
        (NULL ,  'Microwaves',  '4'), 
        (NULL ,  'Space heaters',  '4'), 
        (NULL ,  'Toasters',  '4'), 
        (NULL ,  'Vacuum cleaners',  '4'), 
        (NULL ,  'Dishwashers',  '5'), 
        (NULL ,  'Freezers',  '5'), 
        (NULL ,  'Refrigerators',  '5'), 
        (NULL ,  'Stoves',  '5'), 
        (NULL ,  'Washers/ dryers',  '5'), 
        (NULL ,  'Bricks',  '6'), 
        (NULL ,  'Carpet padding',  '6'), 
        (NULL ,  'Carpets',  '6'), 
        (NULL ,  'Ceramic tiles',  '6'), 
        (NULL ,  'Doors',  '6'), 
        (NULL ,  'Drywall',  '6'), 
        (NULL ,  'Electrical supplies',  '6'), 
        (NULL ,  'Hand tools',  '6'), 
        (NULL ,  'Hardware',  '6'), 
        (NULL ,  'Insulation',  '6'), 
        (NULL ,  'Ladders',  '6'), 
        (NULL ,  'Light fixtures',  '6'), 
        (NULL ,  'Lighting ballasts',  '6'), 
        (NULL ,  'Lumber',  '6'), 
        (NULL ,  'Motors',  '6'), 
        (NULL ,  'Paint',  '6'), 
        (NULL ,  'Pipe',  '6'), 
        (NULL ,  'Plumbing',  '6'), 
        (NULL ,  'Power tools',  '6'), 
        (NULL ,  'Reusable metal items',  '6'), 
        (NULL ,  'Roofing ',  '6'), 
        (NULL ,  'Vinyl',  '6'), 
        (NULL ,  'Windows',  '6'), 
        (NULL ,  'Belts',  '7'), 
        (NULL ,  'Boots',  '7'), 
        (NULL ,  'Clothes',  '7'), 
        (NULL ,  'Coats',  '7'), 
        (NULL ,  'Hats',  '7'), 
        (NULL ,  'Rainwear',  '7'), 
        (NULL ,  'Sandals',  '7'), 
        (NULL ,  'Shoes',  '7'), 
        (NULL ,  'Calculators',  '8'), 
        (NULL ,  'Cameras',  '8'), 
        (NULL ,  'Cassette players',  '8'), 
        (NULL ,  'Cd players',  '8'), 
        (NULL ,  'Cds',  '8'), 
        (NULL ,  'Cell phones',  '8'), 
        (NULL ,  'Computers ',  '8'),
        (NULL ,  'Curling irons',  '8'), 
        (NULL ,  'DVD players',  '8'), 
        (NULL ,  'Game consoles',  '8'), 
        (NULL ,  'GPS systems',  '8'), 
        (NULL ,  'Hair dryers',  '8'), 
        (NULL ,  'Monitors',  '8'), 
        (NULL ,  'MP3 players',  '8'), 
        (NULL ,  'Printers',  '8'), 
        (NULL ,  'Projectors',  '8'), 
        (NULL ,  'Receivers',  '8'), 
        (NULL ,  'Scanners',  '8'), 
        (NULL ,  'Speakers',  '8'), 
        (NULL ,  'Tablets',  '8'), 
        (NULL ,  'Telephones',  '8'), 
        (NULL ,  'TVs',  '8'), 
        (NULL ,  'Backpacks',  '9'), 
        (NULL ,  'Balls',  '9'), 
        (NULL ,  'Barbells',  '9'), 
        (NULL ,  'Bicycles',  '9'), 
        (NULL ,  'Bike tires ',  '9'), 
        (NULL ,  'Camping equipment',  '9'),
        (NULL ,  'Day packs',  '9'), 
        (NULL ,  'Dumbbells',  '9'), 
        (NULL ,  'Exercise equipment',  '9'), 
        (NULL ,  'Golf clubs',  '9'), 
        (NULL ,  'Helmets',  '9'), 
        (NULL ,  'Hiking boots',  '9'), 
        (NULL ,  'Skateboards',  '9'), 
        (NULL ,  'Skis',  '9'), 
        (NULL ,  'Small boats',  '9'), 
        (NULL ,  'Snowshoes',  '9'), 
        (NULL ,  'Sporting goods',  '9'), 
        (NULL ,  'Tennis rackets',  '9'), 
        (NULL ,  'Tents',  '9'), 
        (NULL ,  'Chain saws',  '10'), 
        (NULL ,  'Fencing',  '10'), 
        (NULL ,  'Garden pots',  '10'), 
        (NULL ,  'Garden tools',  '10'), 
        (NULL ,  'Hand clippers',  '10'), 
        (NULL ,  'Hoses',  '10'), 
        (NULL ,  'Lawn furniture',  '10'), 
        (NULL ,  'Livestock supplies',  '10'), 
        (NULL ,  'Loppers',  '10'), 
        (NULL ,  'Mowers',  '10'), 
        (NULL ,  'Seeders',  '10'), 
        (NULL ,  'Soil amendment',  '10'), 
        (NULL ,  'Sprinklers',  '10'), 
        (NULL ,  'Wheel barrows',  '10'), 
        (NULL ,  'Beverages',  '11'), 
        (NULL ,  'Surplus garden produce',  '11'), 
        (NULL ,  'Unopened canned goods',  '11'), 
        (NULL ,  'Unopened packaged food',  '11'), 
        (NULL ,  'Adult diapers',  '12'), 
        (NULL ,  'Blood pressure monitors',  '12'), 
        (NULL ,  'Canes',  '12'), 
        (NULL ,  'Crutches',  '12'), 
        (NULL ,  'Eye glasses',  '12'), 
        (NULL ,  'Glucose meters',  '12'), 
        (NULL ,  'Hearing aids',  '12'), 
        (NULL ,  'Hospital beds',  '12'), 
        (NULL ,  'Reach extenders',  '12'), 
        (NULL ,  'Shower chairs',  '12'), 
        (NULL ,  'Walkers',  '12'),
        (NULL ,  'Wheelchairs',  '12'), 
        (NULL ,  'Calculators',  '13'), 
        (NULL ,  'Computers ',  '13'), 
        (NULL ,  'Fax machines',  '13'), 
        (NULL ,  'Headsets',  '13'), 
        (NULL ,  'Monitors',  '13'), 
        (NULL ,  'Office furniture',  '13'), 
        (NULL ,  'Paper shredders',  '13'), 
        (NULL ,  'Printer cartridge refilling',  '13'), 
        (NULL ,  'Printers',  '13'), 
        (NULL ,  'Scanners',  '13'), 
        (NULL ,  'Telephones',  '13'), 
        (NULL ,  'Bubble wrap',  '14'), 
        (NULL ,  'Clean foam peanuts',  '14'), 
        (NULL ,  'Foam sheets',  '14'), 
        (NULL ,  'Egg cartons',  '15'), 
        (NULL ,  'Firewood',  '15'), 
        (NULL ,  'Fabric',  '15'), 
        (NULL ,  'Paper bags',  '15'), 
        (NULL ,  'Pet supplies',  '15'), 
        (NULL ,  'Shopping  bags',  '15'),
        (NULL ,  'Vehicles/ parts',  '15'), 
        (NULL ,  'Computer paper',  '15'), 
        (NULL ,  'Reusable metal items',  '15'), 
        (NULL ,  'Cell phones',  '16'), 
        (NULL ,  'small appliances',  '16'), 
        (NULL ,  'Books',  '16'), 
        (NULL ,  'Cell phones',  '16'), 
        (NULL ,  'Clothes',  '16'), 
        (NULL ,  'Computers',  '16'), 
        (NULL ,  'Furniture',  '16'), 
        (NULL ,  'Lamps',  '16'), 
        (NULL ,  'Lawn power equipment',  '16'), 
        (NULL ,  'Outdoor Gear',  '16'),
        (NULL ,  'Sandals',  '16'), 
        (NULL ,  'Shoes, boots',  '16'),
        (NULL ,  'Upholstery, car',  '16'), 
        (NULL ,  'Upholstery, Furniture',  '16')
        ;" 
    );
    if($result == 'TRUE')
        echo "Table 'Item' insertions successful.<br>";
    else
        echo "Table 'Item' insertions fail.<br>";

    echo "<p>";

    // Table deletion queries

    // $result = $mysqli->query("DROP TABLE Organization");
    // if($result == 'TRUE')
    //     echo "Table 'Organization' delete successful.<br>";
    // else
    //     echo "Table 'Organization' delete fail.<br>";
    
    // $result = $mysqli->query("DROP TABLE Category");
    // if($result == 'TRUE')
    //     echo "Table 'Category' delete successful.<br>";
    // else
    //     echo "Table 'Category' delete fail.<br>";
    
    // $result = $mysqli->query("DROP TABLE Item");
    // if($result == 'TRUE')
    //     echo "Table 'Item' delete successful.<br>";
    // else
    //     echo "Table 'Item' delete fail.<br>";

?>