<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/6/2015
 * Time: 12:36 AM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\PersistenceException;

class ItemCategoriesService {

    /** @var DataAccessObject */
    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    /**
     * get a list of all organization-item relationships
     * @return array the list of item-category relationships
     * @throws ServiceException if unable to get a list of item-category relationships
     */
    public function getItemCategories() {
        try {
            return $this->dao->getItemCategories();
        }
        catch (PersistenceException $e) {
            throw new ServiceException("Unable to get a list of item-category relationships", null, $e);
        }
    }
}