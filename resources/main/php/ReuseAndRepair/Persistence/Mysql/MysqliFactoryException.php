<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 4:46 PM
 */

namespace ReuseAndRepair\Persistence\Mysql;


class MysqliFactoryException extends \Exception {

    public function __construct($message = null, $errno = null, $cause = null) {
        parent::__construct($message, $errno, $cause);
    }
}