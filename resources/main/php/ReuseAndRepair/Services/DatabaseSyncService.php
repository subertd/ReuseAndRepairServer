<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:23 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\PersistenceException;

class DatabaseSyncService {

    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    public function syncDatabase() {
        try {
            return $this->dao->syncDatabase();
        }
        catch (PersistenceException $e) {
            throw new ServiceException(
                "Unable to sync from database", null, $e);
        }
    }
}