<?php

require_once('../autoload.php');

use ReuseAndRepair\Controllers\DataController;

$dataController = new DataController();
$dataController->routeHttpRequest();