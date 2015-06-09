<?php 
ini_set('display_errors', 'On');
header("content-type:text/html");


require_once("../autoload.php");

use ReuseAndRepair\Persistence\Mysql\MysqliFactory;
use ReuseAndRepair\Persistence\Mysql\MysqliFactoryException;

try {
    $mysqliFactory = new MysqliFactory();
    $mysqli = $mysqliFactory->getInstance();
    assert($mysqli != null);
    echo "successfully resolved a mysqli object";
}
catch (MysqliFactoryException $e) {
    echo "<p>There was a problem getting a mysqli object; ";
    echo '(' . $e->getCode() . ') ';
    echo $e->getMessage() . "</p>";
}

