<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/9/2015
 * Time: 12:07 PM
 */

require_once("../resources/php/main/InfoController.php");
require_once("../resources/php/main/InfoPresenter.php");
require_once("../resources/php/main/InfoService.php");

use ReuseAndRepair\Info\InfoController;

$infoController = new InfoController();
$infoController->getInfo();
