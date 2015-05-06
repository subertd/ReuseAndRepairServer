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
     * @param Organization $organization the organization to insert
     * @return array the result
     */
    public function insertOrganization(Organization $organization);

    /**
     * Update the Organization at an existing index
     *
     * @param Organization $organization the updated organization
     * @return array the result
     */
    public function updateOrganization(Organization $organization);

    /**
     * Remove an organization at a given index from persistent memory
     *
     * @param $id the index of the organization to delete
     * @return array the result
     */
    public function deleteOrganization($id);

    /**
     * Commit a Category to persistent memory at the next index
     *
     * @param Category $category the catetgory to insert
     * @return array the result
     */
    public function insertCategory(Category $category);

    /**
     * Update the Category at an existing index
     *
     * @param Category $category the updated category
     * @return array the result
     */
    public function updateCategory(Category $category);

    /**
     * Remove a Category at a given index from persistent memory
     *
     * @param $id the index of the category to delete
     * @return array the result
     */
    public function deleteCategory($id);

    /**
     * Commit an Item to persistent memory at the next index
     *
     * @param Item $item the item to insert
     * @return array the result
     */
    public function insertItem(Item $item);

    /**
     * Update the Item at an existing index
     *
     * @param Item $item the updated item
     * @return array the result
     */
    public function updateItem(Item $item);

    /**
     * Remove an Item at a given index from persistent memory
     *
     * @param $id the index of the item to delete
     * @return array the result
     */
    public function deleteItem($id);

    /**
     * Close the connection to persistent memory
     *
     * Call this once, at the end of the server execution
     */
    public function close();
}