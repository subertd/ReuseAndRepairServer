<?php

const CREATE_ORGANIZATION_TABLE_QUERY =
    "CREATE TABLE  `cs419-g15`.`Organization` (
            `organization_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `organization_name` VARCHAR ( 255) NOT NULL,
            `phone_number` VARCHAR( 14 ) NULL ,
            `website_url` VARCHAR( 255 ) NULL ,
            `physical_address` VARCHAR( 255 ) NULL
            ) ENGINE = INNODB";

const CREATE_CATEGORY_TABLE_QUERY = "CREATE TABLE  `cs419-g15`.`Category` (
            `category_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `category_name` VARCHAR( 255 ) NOT NULL
            ) ENGINE = INNODB";

const CREATE_ITEM_TABLE_QUERY = "CREATE TABLE  `cs419-g15`.`Item` (
            `item_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `item_name` VARCHAR( 255 ) NOT NULL ,
            `category_id` INT NOT NULL ,
            FOREIGN KEY (`category_id`) REFERENCES `cs419-g15`.`Category`(`category_id`) ON DELETE CASCADE
            ) ENGINE = INNODB";

const CREATE_ORGANIZATION_ITEM_TABLE_QUERY =
    "CREATE TABLE `cs419-g15`.`Organization_Item` (
            `organization_id` INT NOT NULL,
            `item_id` INT NOT NULL,
            `additional_repair_information` TEXT,
            FOREIGN KEY (`organization_id`) REFERENCES `cs419-g15`.`Organization`(`organization_id`) ON DELETE CASCADE,
            FOREIGN KEY (`item_id`) REFERENCES `cs419-g15`.`Item`(`item_id`) ON DELETE CASCADE,
            UNIQUE KEY (`organization_id`, `item_id`)
            ) ENGINE = INNODB;";

const DROP_ORGANIZATION_TABLE_QUERY =
    "DROP TABLE IF EXISTS `cs419-g15`.`Organization`";

const DROP_CATEGORY_TABLE_QUERY = "DROP TABLE IF EXISTS `cs419-g15`.`Category`";

const DROP_ITEM_TABLE_QUERY = "DROP TABLE IF EXISTS `cs419-g15`.`Item`";

const DROP_ORGANIZATION_ITEM_TABLE_QUERY = "DROP TABLE IF EXISTS `cs419-g15`.`Organization_Item`";

header("Content-type:text/html");
ini_set('display_errors', 'On');

require_once("../autoload.php");

use ReuseAndRepair\Persistence\Mysql\MysqliFactory;
use ReuseAndRepair\Persistence\Mysql\MysqliFactoryException;

try {
    $mysqliFactory = new MysqliFactory();
    $mysqli = $mysqliFactory->getInstance();
}
catch (MysqliFactoryException $e) {
    die ("Failed to connect to Mysql: " . $e);
}

dropTables($mysqli);
createTables($mysqli);
insertRowsIntoTables($mysqli);

/**
 * @param mysqli $mysqli
 */
function dropTables($mysqli)
{
    dropOrganizationItemTable($mysqli);
    dropItemTable($mysqli);
    dropCategoryTable($mysqli);
    dropOrganizationTable($mysqli);

    echo "<p>";
}

/**
 * @param mysqli $mysqli
 */
function dropOrganizationItemTable($mysqli) {
    $result = $mysqli->query(DROP_ORGANIZATION_ITEM_TABLE_QUERY);
    if($result == 'TRUE') {
        echo "Table 'Organization_Item' delete successful.<br>";
    } else {
        echo "Table 'Organization_Item' delete fail.<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function dropItemTable($mysqli) {
    $result = $mysqli->query(DROP_ITEM_TABLE_QUERY);
    if($result == 'TRUE') {
        echo "Table 'Item' delete successful.<br>";
    } else {
        echo "Table 'Item' delete fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function dropCategoryTable($mysqli) {
    $result = $mysqli->query(DROP_CATEGORY_TABLE_QUERY);
    if($result == 'TRUE') {
        echo "Table 'Category' delete successful.<br>";
    } else {
        echo "Table 'Category' delete fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function dropOrganizationTAble($mysqli) {
    $result = $mysqli->query(DROP_ORGANIZATION_TABLE_QUERY);
    if($result == 'TRUE') {
        echo "Table 'Organization' delete successful.<br>";
    } else {
        echo "Table 'Organization' delete fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function createTables($mysqli) {

    createOrganizationTable($mysqli);
    createCategoryTable($mysqli);
    createItemTable($mysqli);
    createOrganizationItemTable($mysqli);

    echo "<p>";
}

/**
 * @param mysqli $mysqli
 */
function createOrganizationTable($mysqli) {
    $result = $mysqli->query(CREATE_ORGANIZATION_TABLE_QUERY);
    if ($result == 'TRUE') {
        echo "Table 'Organization' creation successful.<br>";
    } else {
        echo "Table 'Organization' creation fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function createCategoryTable($mysqli) {
    $result = $mysqli->query(
        CREATE_CATEGORY_TABLE_QUERY
    );
    if($result == 'TRUE') {
        echo "Table 'Category' creation successful.<br>";
    } else {
        echo "Table 'Category' creation fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function createItemTable($mysqli) {
    $result = $mysqli->query(
        CREATE_ITEM_TABLE_QUERY
    );
    if($result == 'TRUE') {
        echo "Table 'Item' creation successful.<br>";
    } else {
        echo "Table 'Item' creation fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function createOrganizationItemTable($mysqli) {
    $result = $mysqli->query(
        CREATE_ORGANIZATION_ITEM_TABLE_QUERY
    );
    if($result == 'TRUE') {
        echo "Table 'Organization_Item' creation successful.<br>";
    } else {
        echo "Table 'Organization_Item' creation fail; " . $mysqli->error . "<br>";
    }
}

/**
 * @param mysqli $mysqli
 */
function insertRowsIntoTables($mysqli)
{
    insertRowsIntoOrganizationTable($mysqli);
    insertRowsIntoCategoryTable($mysqli);
    insertRowsIntoItemTable($mysqli);
    insertRowsIntoOrganizationItemTable($mysqli);
}

/**
 * @param mysqli $mysqli
 */
function insertRowsIntoOrganizationTable($mysqli) {
    $result = $mysqli->query(
        "INSERT INTO  `cs419-g15`.`Organization` (
    `organization_id` ,
    `organization_name`,
    `phone_number`,
    `website_url`,
    `physical_address`
    )
    VALUES
        (NULL, 'Book binding', '(541) 757-9861', 'http://www.cornerstoneassociates.com/bj-bookbinding-about-us.html', 
            '108 SW 3rd St, Corvallis, OR 97333'), 
        (NULL, 'Cell Phone Sick Bay', '(541) 230-1785', NULL, '252 Sw Madison Ave, Suite 110, Corvallis, OR 97333'),
        (NULL, 'Geeks N Nerds', '(541) 753-0018', 'http://www.computergeeksnnerds.com/', '950 Southeast Geary St Unit D 
            Albany, OR 97321'), 
        (NULL, 'Specialty Sewing By Leslie', '(541) 758-4556', 'http://www.specialtysewing.com/Leslie_Seamstress/Welcome.html', 
            '225 SW Madison Ave Corvallis, OR 97333'), 
        (NULL, 'Covallis Technical', '(541) 704-7009', 'http://www.corvallistechnical.com/', '966 NW Circle Blvd Corvallis, OR'), 
        (NULL, 'Bellevue Computers', '541-757-3487', 'http://www.bellevuepc.com/', '1865 NW 9th St Corvallis, OR'), 
        (NULL, 'OSU Repair Fair', '541-737-5398', 'http://fa.oregonstate.edu/surplus', 'Oregon State University Property Services                   Building 644 S.W. 13th St Corvallis, OR'), 
        (NULL, 'P.K Furniture Repair & Refinishing', '541-230-1727', 'http://www.pkfurniturerefinishing.net/', '5270 NW Hwy 99 
            Corvallis, Oregon 97330'), 
        (NULL, 'Furniture Restoration Center', '(541) 929-6681', 'http://restorationsupplies.com/', '1321 Main St, Philomath, OR'),             (NULL, 'Power equipment', '(541) 757-8075', 'https://corvallispowerequipment.stihldealer.net/', 
            '713 NE Circle Blvd Corvallis, OR 97330'), 
        (NULL, 'Robnett''s', '(541) 753-5531', 'http://ww3.truevalue.com/robnetts/Home.aspx', '400 SW 2nd St Corvallis, OR 97333'), 
        (NULL, 'Footwise', '(541) 757-0875', 'http://footwise.com/', '301 SW Madison Ave #100, Corvallis, OR 97333'), 
        (NULL, 'Sedlack', '(541) 752-1498', 'http://www.sedlaksshoes.net/', '225 SW 2nd St, Corvallis, OR 97333'), 
        (NULL, 'Foam Man', '(541) 754-9378', 'http://www.thefoammancorvallis.com/', '2511 NW 9th St, Corvallis, OR 97330');"
    );
    if ($result == 'TRUE')
        echo "Table 'Organization' insertions successful.<br>";
    else
        echo "Table 'Organization' insertions fail.<br>";
}

/**
 * @param mysqli $mysqli
 */
function insertRowsIntoCategoryTable($mysqli)
{
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
    if ($result == 'TRUE')
        echo "Table 'Category' insertions successful.<br>";
    else
        echo "Table 'Category' insertions fail.<br>";
}

/**
 * @param mysqli $mysqli
 */
function insertRowsIntoItemTable($mysqli)
{
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
    if ($result == 'TRUE')
        echo "Table 'Item' insertions successful.<br>";
    else
        echo "Table 'Item' insertions fail.<br>";

    echo "<p>";
}

/**
 * @param mysqli $mysqli
 */
function insertRowsIntoOrganizationItemTable($mysqli) {
    // TODO implement
}

?>