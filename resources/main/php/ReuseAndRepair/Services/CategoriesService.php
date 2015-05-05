<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:24 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Models\Category;

class CategoriesService {

    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    public function setCategory(
        AuthenticationService $authenticationService, Category $category)
    {
        throw new \Exception("Not yet implemented");
    }
}