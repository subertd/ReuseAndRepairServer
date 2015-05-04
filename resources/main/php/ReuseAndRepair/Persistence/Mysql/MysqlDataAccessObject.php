<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:16 PM
 */

namespace ReuseAndRepair\Persistence\Mysql;

use ReuseAndRepair\Models\Organization;
use ReuseAndRepair\Models\Category;
use ReuseAndRepair\Models\Item;

class MysqlDataAccessObject {

    private $mysqli;

    public function __construct() {
        $mysqliFactory = new MysqliFactory();
        $this->mysqli = $mysqliFactory->getInstance();
    }

    public function syncDatabase() {
        // TODO make this query the database for a list of all organization-item associations and return it
    }

    public function setOrganization(Organization $organization) {
        // TODO implement
    }

    public function setCategory(Category $category) {
        // TODO implement
    }

    public function setItem(Item $item) {
        // TODO implement
    }
}