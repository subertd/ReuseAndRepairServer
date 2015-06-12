<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:16 PM
 */

namespace ReuseAndRepair\Persistence\Mysql;

use ReuseAndRepair\Models\ModelException;
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

    const READ_ORGANIZATION_REUSE_ITEMS_STRING = "SELECT
            organization_id AS organizationId,
            item_id AS itemId
        FROM `cs419-g15`.`Organization_Reuse_Item`";

    const READ_ORGANIZATION_REPAIR_ITEMS_STRING = "SELECT
            organization_id AS organizationId,
            item_id AS itemId,
            additional_repair_info AS additionalRepairInfo
        FROM `cs419-g15`.`Organization_Repair_Item`";

    const DELETE_ORGANIZATION_REUSE_ITEM_FOR_ORGANIZATION_STRING = "DELETE FROM
            `cs419-g15`.`Organization_Reuse_Item`
        WHERE `organization_id` = ?";

    const DELETE_ORGANIZATION_REPAIR_ITEM_FOR_ORGANIZATION_STRING = "DELETE FROM
            `cs419-g15`.`Organization_Repair_Item`
        WHERE `organization_id` = ?";

    const READ_ITEM_CATEGORIES_STRING = "SELECT
            item_id AS itemId,
            category_id AS categoryId
        FROM `cs419-g15`.`Item_Category`";

    const DELETE_ITEM_CATEGORIES_FOR_ITEM_STRING = "DELETE FROM
            `cs419-g15`.`Item_Category`
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
            'organizationReuseItems' => $this->queryAsArray(
                self::READ_ORGANIZATION_REUSE_ITEMS_STRING),
            'organizationRepairItems' => $this->queryAsArray(
                self::READ_ORGANIZATION_REPAIR_ITEMS_STRING),
            'itemCategories' => $this->queryAsArray(
                self::READ_ITEM_CATEGORIES_STRING)
        );

        $this->mysqli->commit(); // end transaction

        return $database;
    }

    // TODO add documentation
    private function queryAsArray($query)
    {
        if (!($result = $this->mysqli->query($query)))
        {
            throw new PersistenceException($this->mysqli->error, $this->mysqli->errno);
        }

        return $this->resultToArray($result);
    }

    // TODO add documentation
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
        $this->mysqli->autocommit(false);

        try {
            $this->insertOrganizationToOrganizationTable($organization);
            $this->clearOrganizationReuseItemsForOrganization($organization);
            $this->clearOrganizationRepairItemsForOrganization($organization);
            $this->setOrganizationReuseItemsForOrganization($organization);
            $this->setOrganizationRepairItemsForOrganization($organization);

            $this->mysqli->commit();

            return array('success' => true);
        } catch (MysqliException $e) {

            $this->mysqli->rollback();
            $this->mysqli->autocommit(true);
            throw new PersistenceException("Unable to persist organization", null, $e);
        }
    }

    /**
     * @param Organization $organization the organization to insert
     * @throws MysqliException if there is a problem building or executing sql statements
     */
    private function insertOrganizationToOrganizationTable(Organization $organization) {

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
            throw new MysqliException("Unable to prepare statement for insert organization " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssss", $name, $phoneNumber, $websiteUrl, $physicalAddress))
        {
            throw new MysqliException("Unable to bind params for insert organization" . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }

        $organization->setId($stmt->insert_id);
    }

    private function updateOrganizationInOrganizationTable(Organization $organization)
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
            throw new MysqliException("Unable to prepare statement for update organization " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssssi",
            $name,$phoneNumber, $websiteUrl, $physicalAddress, $id))
        {
            throw new MysqliException("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }
    }

    /**
     * @param Organization $organization the organization who's reuses item relationships are to be cleared
     * @throws MysqliException if there is a problem building or executing sql statements
     */
    private function clearOrganizationReuseItemsForOrganization(Organization $organization) {

        /** @var int $organizationId */
        $organizationId = $organization->getId();

        if (!($stmt = $this->mysqli->prepare(self::DELETE_ORGANIZATION_REUSE_ITEM_FOR_ORGANIZATION_STRING))) {
            throw new MysqliException(
                "Unable to prepare statement for delete all organization reuses item relationships for an organization");
        }
        if (!($stmt->bind_param("i", $organizationId))) {
            throw new MysqliException(
                "Unable to bind params for delete all organization reuses item relationships for an organization");
        }
        if (!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }
    }

    /**
     * @param Organization $organization the organization who's repairs item relationships are to be cleared
     * @throws MysqliException if there is a problem building or executing sql statements
     */
    private function clearOrganizationRepairItemsForOrganization(Organization $organization) {

        /** @var int $organizationId */
        $organizationId = $organization->getId();

        if (!($stmt = $this->mysqli->prepare(self::DELETE_ORGANIZATION_REPAIR_ITEM_FOR_ORGANIZATION_STRING))) {
            throw new MysqliException(
                "Unable to prepare statement for delete all organization repairs item relationships for an organization");
        }
        if (!($stmt->bind_param("i", $organizationId))) {
            throw new MysqliException(
                "Unable to bind params for delete all organization repairs item relationships for an organization");
        }
        if (!($result = $stmt->execute())) {
            throw new MysqliException($stmt->error, $stmt->errno);
        }
    }

    private function setOrganizationReuseItemsForOrganization(Organization $organization) {

        /** @var int $organizationId */
        $organizationId = $organization->getId();

        /** @var array $itemRelationships */
        $itemRelationships = $organization->getReuseItemRelationships();

        if (count($itemRelationships) == 0) {
            return;
        }

        $sql =
            "INSERT INTO `cs419-g15`.`Organization_Reuse_Item` (
                `organization_id`,
                `item_id`
        ) VALUES ";
        foreach ($itemRelationships as $index=>$itemRef) {
            $itemId = (int)$itemRef['itemId'];
            if ($index > 0) { $sql .= ", "; }
            $sql .= "($organizationId, $itemId)";
        }
        $sql .= ";";

        if (!($result = $this->mysqli->query($sql))) {
            throw new MysqliException($this->mysqli->error, $this->mysqli->errno);
        }
    }

    private function setOrganizationRepairItemsForOrganization(Organization $organization) {

        /** @var int $organizationId */
        $organizationId = $organization->getId();

        /** @var array $itemRelationships */
        $itemRelationships = $organization->getRepairItemRelationships();

        if (count($itemRelationships) == 0) {
            return;
        }

        $sql =
            "INSERT INTO `cs419-g15`.`Organization_Repair_Item` (
                `organization_id`,
                `item_id`,
                `additional_repair_info`
            ) VALUES ";
        foreach($itemRelationships as $index=>$itemRelationship) {
            $itemId = (int)$itemRelationship['itemId'];
            $additionalRepairInfo = isset($itemRelationship['additionalRepairInfo']) ? $this->mysqli->real_escape_string($itemRelationship['additionalRepairInfo']) : "";
            if ($index > 0) { $sql .= ", "; }
            $sql .= "($organizationId, $itemId, '$additionalRepairInfo')";
        }
        $sql .= ";";

        if (!($result = $this->mysqli->query(($sql)))) {
            throw new MysqliException($this->mysqli->error, $this->mysqli->errno);
        }
    }

    public function updateOrganization(Organization $organization)
    {
        $this->mysqli->autocommit(false);

        try {
            $this->updateOrganizationInOrganizationTable($organization);
            $this->clearOrganizationReuseItemsForOrganization($organization);
            $this->clearOrganizationRepairItemsForOrganization($organization);
            $this->setOrganizationReuseItemsForOrganization($organization);
            $this->setOrganizationRepairItemsForOrganization($organization);

            $this->mysqli->commit();
        }
        catch (MysqliException $e) {

            $this->mysqli->rollback();
            $this->mysqli->autocommit(true);
            throw new PersistenceException("Unable to persist updates to organization", null, $e);
        }

        return array('success' => true);
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
            $this->mysqli->autocommit(true);
            throw new PersistenceException("Unable to persist item", null, $e);
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

    /**
     * @param Item $item the item to insert
     * @throws MysqliException if there is a problem building or executing sql statements
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
     * @throws MysqliException if there is a problem building or executing sql statements
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

        if (count($categoryRefs) == 0) {
            return;
        }

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

    public function close() {
        $this->mysqli->close();
    }
}