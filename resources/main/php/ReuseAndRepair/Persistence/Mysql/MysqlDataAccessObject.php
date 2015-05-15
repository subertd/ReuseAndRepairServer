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
use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\PersistenceException;

/**
 * Class MysqlDataAccessObject
 * @package ReuseAndRepair\Persistence\Mysql
 *
 * An implementation of DataAccessObject that uses the mysqli library to
 * persist the data with MySQL
 *
 * Note: documentation for public methods can be found in DataAccessObject
 */
class MysqlDataAccessObject implements DataAccessObject {

    const INSERT_ORGANIZATION_STRING = "INSERT INTO `cs419-g15`.`Organization` (
            `organization_name`,
            `phone_number`,
            `website_url`,
            `physical_address`
        ) VALUES (?, ?, ?, ?)";

    const UPDATE_ORGANIZATION_STRING = "UPDATE `cs419-g15`.`Organization` SET
            `organization_name` = ?,
            `phone_number` = ?,
            `website_url` = ?,
            `physical_address` = ?
            WHERE `organization_id` = ?";

    const DELETE_ORGANIZATION_STRING = "DELETE FROM `cs419-g15`.`Organization`
            WHERE `organization_id` = ?";

    const READ_ORGANIZATIONS_STRING = "SELECT
        organization_id AS id,
        organization_name AS name,
        phone_number AS phoneNumber,
        website_url AS websiteUrl,
        physical_address AS physicalAddress
      FROM `cs419-g15`.`Organization`";

    const INSERT_CATEGORY_STRING = "INSERT INTO `cs419-g15`.`Category` (
            `category_name`
        ) VALUES (?)";

    const UPDATE_CATEGORY_STRING = "UPDATE `cs419-g15`.`Category` SET
            `category_name` = ?
            WHERE `category_id` = ?";

    const DELETE_CATEGORY_STRING = "DELETE FROM `cs419-g15`.`Category`
            WHERE `category_id` = ?";

    const READ_CATEGORIES_STRING = "SELECT
        category_id AS id,
        category_name AS name
      FROM `cs419-g15`.`Category`";

    const INSERT_ITEM_STRING = "INSERT INTO `cs419-g15`.`Item` (
            `item_name`
        ) VALUES (?)";

    const UPDATE_ITEM_STRING = "UPDATE `cs419-g15`.`Item` SET
            `item_name` = ?
            WHERE `item_id` = ?";

    const DELETE_ITEM_STRING = "DELETE FROM `cs419-g15`.`Item`
            WHERE `item_id` = ?";

    const READ_ITEMS_STRING = "SELECT
        item_id AS id,
        item_name AS name
      FROM `cs419-g15`.`Item`";

    const INSERT_ORGANIZATION_ITEM_STRING =
        "INSERT INTO `cs419-g15`.`Organization_Item` (
            `organization_id`,
            `item_id`,
            `additional_repair_information`
        ) VALUES (?, ?, ?)";

    const UPDATE_ORGANIZATION_ITEM_STRING =
        "UPDATE `cs419-g15`.`Organization_Item` SET
            `additional_repair_information` = ?
        WHERE `organization_id` = ? AND `item_id` = ?";

    const DELETE_ORGANIZATION_ITEM_STRING =
        "DELETE FROM `cs419-g15`.`Organization_Item`
        WHERE `organization_id` = ? AND `item_id` = ?";

    const READ_ORGANIZATION_ITEMS_STRING =
        "SELECT
            organization_id AS organizationRef,
            item_id AS itemRef
        FROM `cs419-g15`.`Organization_Item`";

    const READ_ITEM_CATEGORIES_STRING = "SELECT
        item_id AS itemId,
        category_id AS categoryId
      FROM `cs419-g15`.`Item_Category`";

    const DELETE_ITEM_CATEGORIES_FOR_ITEM_STRING =
        "DELETE FROM `cs419-g15`.`Item_Category`
        WHERE `item_id` = ?";

    /**
     * @var \mysqli $mysqli
     */
    private $mysqli;

    public function __construct() {
        $mysqliFactory = new MysqliFactory();
        $this->mysqli = $mysqliFactory->getInstance();
    }

    public function syncDatabase() {

        $this->mysqli->autocommit(false); // begin transaction

        $database = array(
            'organizations' => $this->queryAsArray(
                self::READ_ORGANIZATIONS_STRING),
            'categories' => $this->queryAsArray(
                self::READ_CATEGORIES_STRING),
            'items' => $this->queryAsArray(
                self::READ_ITEMS_STRING),
            'organizationItems' => $this->queryAsArray(
                self::READ_ORGANIZATION_ITEMS_STRING),
            'itemCategories' => $this->queryAsArray(
                self::READ_ITEM_CATEGORIES_STRING)
        );

        $this->mysqli->commit(); // end transaction

        return $database;
    }

    private function queryAsArray($query)
    {
        if (!($result = $this->mysqli->query($query)))
        {
            throw new PersistenceException($this->mysqli->error, $this->mysqli->errno);
        }

        return $this->resultToArray($result);
    }

    private function resultToArray(\mysqli_result $result)
    {
        $array = array();
        while(($row = $result->fetch_assoc()) != null) {
            array_push($array, $row);
        }
        return $array;
    }

    public function insertOrganization(Organization $organization)
    {
        /** @var string $name */
        $name = $organization->getName();

        /** @var string $phoneNumber */
        $phoneNumber = $organization->getPhoneNumber();

        /** @var string $websiteUrl */
        $websiteUrl = $organization->getWebsiteUrl();

        /** @var string $physicalAddress */
        $physicalAddress = $organization->getPhysicalAddress();

        if (!($stmt = $this->mysqli->prepare(self::INSERT_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssss",
            $name,$phoneNumber, $websiteUrl, $physicalAddress))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }


        return array('success' => $result);
    }

    public function updateOrganization(Organization $organization)
    {
        /** @var int $id */
        $id = $organization->getId();

        /** @var string $name */
        $name = $organization->getName();

        /** @var string $phoneNumber */
        $phoneNumber = $organization->getPhoneNumber();

        /** @var string $websiteUrl */
        $websiteUrl = $organization->getWebsiteUrl();

        /** @var string $physicalAddress */
        $physicalAddress = $organization->getPhysicalAddress();

        if (!($stmt = $this->mysqli->prepare(self::UPDATE_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssssi",
            $name,$phoneNumber, $websiteUrl, $physicalAddress, $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function deleteOrganization($id) {

        if (!($stmt = $this->mysqli->prepare(self::DELETE_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("i", $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function getOrganizations()
    {
        return $this->queryAsArray(self::READ_ORGANIZATIONS_STRING);
    }

    public function insertCategory(Category $category) {

        /** @var string $name */
        $name = $category->getName();

        if (!($stmt = $this->mysqli->prepare(self::INSERT_CATEGORY_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("s", $name))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function updateCategory(Category $category) {

        /** @var int $id */
        $id = $category->getId();

        /** @var string $name */
        $name = $category->getName();

        if (!($stmt = $this->mysqli->prepare(self::UPDATE_CATEGORY_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("si",
            $name,$id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function deleteCategory($id) {

        if (!($stmt = $this->mysqli->prepare(self::DELETE_CATEGORY_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("i", $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function getCategories()
    {
        return $this->queryAsArray(self::READ_CATEGORIES_STRING);
    }

    public function insertItem(Item $item) {

        $this->mysqli->autocommit(false);

        try {
            $this->insertItemToItemTable($item);
            $this->clearItemCategoriesForItem($item);
            $this->setItemCategoriesForItem($item);

            $this->mysqli->commit();

            return array('success' => true);
        }
        catch (MysqliException $e) {
            $this->mysqli->rollback();
            throw new PersistenceException("Unable to persist item", null, $e);
        }
    }

    /**
     * @param Item $item the item to insert
     * @throws MysqliException
     */
    private function insertItemToItemTable(Item $item) {

        /** @var string $name */
        $name = $item->getName();

        if (!($stmt = $this->mysqli->prepare(self::INSERT_ITEM_STRING))) {
            throw new MysqliException("Unable to prepare statement for insert item" . $this->mysqli->error);
        }

        if (!$stmt->bind_param("s", $name)) {
            throw new MysqliException("Unable to bind params for insert item" . $stmt->error);
        }

        if (!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }

        $item->setId($stmt->insert_id);
    }

    /**
     * @param Item $item the item who's category relationships are to be cleared
     * @throws MysqliException if there is a problem executing the sql
     */
    private function clearItemCategoriesForItem(Item $item) {

        /** @var int $itemId */
        $itemId = $item->getId();

        if (!($stmt = $this->mysqli->prepare(self::DELETE_ITEM_CATEGORIES_FOR_ITEM_STRING))) {
            throw new MysqliException(
                "Unable to prepare statement for delete all item category relationships for an item");
        }
        if (!($stmt->bind_param("i", $itemId))) {
            throw new MysqliException("Unable to bind params for delete all item category relationships for an item");
        }
        if (!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }
    }

    /**
     * @param Item $item the item to set item-category relationships for
     * @throws MysqliException if there is a problem executing the sql
     */
    private function setItemCategoriesForItem(Item $item) {

        /** @var int $itemId */
        $itemId = $item->getId();

        /** @var array $categoryRefs */
        $categoryRefs = $item->getCategoryRefs();

        $sql =
            "INSERT INTO `cs419-g15`.`Item_Category` (
            `item_id`,
            `category_id`
        ) VALUES ";

        foreach ($categoryRefs as $index=>$categoryRef) {
            $safeCategoryId = (int)$categoryRef;
            if ($index > 0) { $sql .= ", "; }
            $sql .= "($itemId, $safeCategoryId)";
        }

        $sql .= ";";

        if (!($result = $this->mysqli->query($sql))) {
            throw new MysqliException($this->mysqli->error, $this->mysqli->errno);
        }
    }

    /**
     * @param Item $item the item to update
     * @throws MysqliException if there is a problem executing the sql
     */
    private function updateItemInItemTable(Item $item) {

        /** @var int $id */
        $id = $item->getId();

        /** @var string $name */
        $name = $item->getName();

        if (!($stmt = $this->mysqli->prepare(self::UPDATE_ITEM_STRING))) {
            die("Unable to prepare statement for update item in item table" . $this->mysqli->error);
        }

        if (!$stmt->bind_param("si", $name, $id)) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }

        if (!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }
    }

    public function updateItem(Item $item) {

        try {
            $this->updateItemInItemTable($item);
            $this->clearItemCategoriesForItem($item);
            $this->setItemCategoriesForItem($item);

            return array('success' => true);
        }
        catch(MysqliException $e) {
            throw new PersistenceException("Unable to update item", null, $e);
        }
    }

    public function getItemCategories()
    {
        return $this->queryAsArray(self::READ_ITEM_CATEGORIES_STRING);
    }

    public function deleteItem($id) {

        if (!($stmt = $this->mysqli->prepare(self::DELETE_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("i", $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function getItems()
    {
        return $this->queryAsArray(self::READ_ITEMS_STRING);
    }

    public function insertOrganizationItem(
        $organizationId, $itemId, $additionalRepairInformation)
    {
        if (!($stmt = $this->mysqli->prepare(
            self::INSERT_ORGANIZATION_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param(
            "iis", $organizationId, $itemId, $additionalRepairInformation))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function updateOrganizationItem(
        $organizationId, $itemId, $additionalRepairInformation)
    {
        if (!($stmt = $this->mysqli->prepare(
            self::UPDATE_ORGANIZATION_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param(
            "iis", $additionalRepairInformation, $organizationId, $itemId))
        {
            die("Unable to bind params " . $stmt->error);
        }

        $result = $stmt->execute();

        return array('success' => $result, 'rows affected' => $this->mysqli->affected_rows);
    }

    public function deleteOrganizationItem($organizationId, $itemId)
    {
        if (!($stmt = $this->mysqli->prepare(
            self::DELETE_ORGANIZATION_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ii", $organizationId, $itemId))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function getOrganizationItems()
    {
        return $this->queryAsArray(self::READ_ORGANIZATION_ITEMS_STRING);
    }

    public function close() {
        $this->mysqli->close();
    }
}