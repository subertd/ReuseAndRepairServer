<?php

require_once('../autoload.php');

use ReuseAndRepair\Controller;

$controller = new Controller($_GET);
$controller->syncDatabase();