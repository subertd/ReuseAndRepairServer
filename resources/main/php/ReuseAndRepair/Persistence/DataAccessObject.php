<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:22 PM
 */

namespace ReuseAndRepair\Persistence;


interface DataAccessObject {

    // TODO add documentation

    public function syncDatabase();

    public function setOrganization($organization);

    public function setCategory($category);

    public function setItem($item);
}