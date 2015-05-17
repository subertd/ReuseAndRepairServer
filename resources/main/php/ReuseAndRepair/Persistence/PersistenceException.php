<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 2:01 PM
 */

namespace ReuseAndRepair\Persistence;


class PersistenceException extends \Exception  {

    public function __construct($message = null, $errno = null, $cause = null) {
        parent::__construct($message, $errno, $cause);
    }
}