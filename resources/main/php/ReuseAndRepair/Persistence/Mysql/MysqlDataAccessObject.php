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
            `item_name`,
            `category_id`
        ) VALUES (?, ?)";

    const UPDATE_ITEM_STRING = "UPDATE `cs419-g15`.`Item` SET
            `item_name` = ?,
            `category_id` = ?
            WHERE `item_id` = ?";

    const DELETE_ITEM_STRING = "DELETE FROM `cs419-g15`.`Item`
            WHERE `item_id` = ?";

    const READ_ITEMS_STRING = "SELECT
        item_id AS id,
        item_name AS name,
        category_id AS categoryRef
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
                self::READ_ORGANIZATION_ITEMS_STRING)
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

    /*
    private function constructGetItemsDatabaseQuery() {

        return "

        SELECT
        i.`item_id` AS " . ItemFactory::ID . ",
        i.`item_name` AS " . ItemFactory::NAME . ",
        c.`category_id` AS " . ItemFactory::CATEGORY_REF . ",
        c.`category_id` AS " . CategoryFactory::ID . ",
        c.`category_name` AS " . CategoryFactory::NAME . ",
        o.`organization_id` AS " . OrganizationFactory::ID . ",
        o.`organization_name` AS " . OrganizationFactory::NAME . ",
        o.`phone_number` AS " . OrganizationFactory::PHONE_NUMBER . ",
        o.`website_url` AS " . OrganizationFactory::WEBSITE_URL . ",
        o.`physical_address` AS " . OrganizationFactory::PHYSICAL_ADDRESS . "

        FROM
        `cs419-g15`.`Item` i

        # using left joins will eliminate categories with no items
        # and organizations that do not reuse/rebuild any items
        # while preserving items with no organizations that reuse/rebuild them
        # this seems appropriate

        # supply the category name for each item's category reference
        LEFT JOIN `cs419-g15`.`Category` c ON i.`category_id` = c.`category_id`

        # get all the relationships between items and organizations
        LEFT JOIN `cs419-g15`.`Organization_Item` oi ON oi.`item_id` = i.`item_id`
        LEFT JOIN `cs419-g15`.`Organization` o ON o.`organization_id` = oi.`organization_id`

        ORDER BY " . ItemFactory::ID . "
    ;";
    }

    public function getItems() {

        $query = $this->constructGetItemsDatabaseQuery();

        if (!$results = $this->mysqli->query($query)) {
            throw new PersistenceException(
                $this->mysqli->error, $this->mysqli->errno);
        }

        // Parse rows into item hierarchy

        /** @var array $items /
        $items = array();

        /** @var array $curItem /
        $curItem = null;
        while (($row = $results->fetch_assoc()) != null) {

            // If this row has a new item
            if ($curItem == null
                || $row[ItemFactory::ID] != $curItem[ItemFactory::ID]) {

                // Put the previous item in the items array
                $curItem == null || array_push($items, $curItem);

                // Start a new Item instance
                $curItem = array(
                    ItemFactory::ID => $row[ItemFactory::ID],
                    ItemFactory::NAME => $row[ItemFactory::NAME],
                    CategoryFactory::ID => $row[CategoryFactory::ID],
                    CategoryFactory::NAME => $row[CategoryFactory::NAME],
                    'organizations' => array()
                );
            }

            $this->parseOrganization($curItem, $row);
        }

        return $items;
    }

    private function parseOrganization(array &$curItem, array $row) {

        if (!empty($row[OrganizationFactory::ID])) {

            $organization = array(
                OrganizationFactory::ID =>
                    $row[OrganizationFactory::ID],

                OrganizationFactory::NAME =>
                    $row[OrganizationFactory::NAME],

                OrganizationFactory::PHONE_NUMBER =>
                    $row[OrganizationFactory::PHONE_NUMBER],

                OrganizationFactory::WEBSITE_URL =>
                    $row[OrganizationFactory::WEBSITE_URL],

                OrganizationFactory::PHYSICAL_ADDRESS =>
                    $row[OrganizationFactory::PHYSICAL_ADDRESS]
            );

            array_push($curItem['organizations'], $organization);
        }
    }
*/

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

        /** @var string $name */
        $name = $item->getName();

        /** @var int $categoryRef */
        $categoryRef = $item->getCategoryRef();

        if (!($stmt = $this->mysqli->prepare(self::INSERT_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("si", $name, $categoryRef))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
    }

    public function updateItem(Item $item) {

        /** @var int $id */
        $id = $item->getId();

        /** @var string $name */
        $name = $item->getName();

        /** @var int $categoryRef */
        $categoryRef = $item->getCategoryRef();

        if (!($stmt = $this->mysqli->prepare(self::UPDATE_ITEM_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("sii",
            $name,$categoryRef, $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        if(!($result = $stmt->execute())) {
            throw new PersistenceException($stmt->error, $stmt->errno);
        }

        return array('success' => $result);
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