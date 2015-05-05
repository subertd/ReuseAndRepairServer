<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:23 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;

class DatabaseSyncService {

    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    public function syncDatabase() {
        // TODO parse HTTP request parameters

        return $this->dao->syncDatabase();
    }
}