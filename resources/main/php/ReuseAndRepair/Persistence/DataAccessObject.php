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
     * Insert a new Organization to persistent memory at the next index
     *
     * @param Organization $organization
     * @return array
     */
    public function insertOrganization(Organization $organization);

    /**
     * Update the Organization at an existing index
     *
     * @param Organization $organization
     * @return array
     */
    public function updateOrganization(Organization $organization);

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
    public function insertCategory(Category $category);

    /**
     * Update the Category at an existing index
     *
     * @param Category $category
     * @return array
     */
    public function updateCategory(Category $category);

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
    public function insertItem(Item $item);

    /**
     * Update the Item at an existing index
     *
     * @param Item $item
     * @return array
     */
    public function updateItem(Item $item);

    /**
     * Remove an Item from persistent memory
     *
     * @param $id
     * @return array
     */
    public function deleteItem($id);
}