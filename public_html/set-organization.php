<?php

require_once('../autoload.php');

use ReuseAndRepair\Controller;

/** @var array $params */
$params = json_decode(file_get_contents("php://input"), true);

$controller = new Controller($params != null ? $params : array());
$controller->setOrganization();