<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:22 PM
 */

namespace ReuseAndRepair\Persistence;


use ReuseAndRepair\Models\Organization;
use ReuseAndRepair\Models\Category;
use ReuseAndRepair\Models\Item;

interface DataAccessObject {

    /**
     * Get all the data from persistent memory
     *
     * @return array
     */
    public function syncDatabase();


    /**
     * Commit an Organization to persistent memory
     *
     * if the Organization has an id number already, will update,
     * otherwise, insert
     *
     * @param Organization $organization
     * @return array
     */
    public function setOrganization(Organization $organization);

    /**
     * Remove an Organization from persistent memory
     *
     * @param $id
     * @return array
     */
    public function deleteOrganization($id);

    /**
     * Commit a Category to persistent memory
     *
     * if the Category has an id number already, will update,
     * otherwise, insert
     *
     * @param Category $category
     * @return array
     */
    public function setCategory(Category $category);

    /**
     * Remove a Category from persistent memory
     *
     * @param $id
     * @return array
     */
    public function deleteCategory($id);

    /**
     * Commit an Item to persistent memory
     *
     * if the Item has an id number already, will update,
     * otherwise, insert
     *
     * @param Item $item
     * @return array
     */
    public function setItem(Item $item);

    /**
     * Remove an Item from persistent memory
     *
     * @param $id
     * @return array
     */
    public function deleteItem($id);
}