<?php

/**
 * info.php
 *
 * handles requests for information about the ReuseAndRepair configuration
 */

require_once("../autoload.php");

use ReuseAndRepair\Info\InfoController;

$infoController = new InfoController();
$infoController->getInfo();
