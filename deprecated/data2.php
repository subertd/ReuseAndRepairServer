<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once('../autoload.php');

use ReuseAndRepair\Controllers\DataController;

$dataController = new DataController();
$dataController->routeHttpRequest();
