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

class MysqlDataAccessObject implements DataAccessObject {

    //const SYNC_DATABASE_STRING =

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

    const INSERT_CATEGORY_STRING = "INSERT INTO `cs419-g15`.`Category` (
            `category_name`
        ) VALUES (?)";

    const UPDATE_CATEGORY_STRING = "UPDATE `cs419-g15`.`Category` SET
            `category_name` = ?
            WHERE `category_id` = ?";

    const DELETE_CATEGORY_STRING = "DELETE FROM `cs419-g15`.`Category`
            WHERE `category_id` = ?";

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

    /** @var \mysqli  */
    private $mysqli;

    public function __construct() {
        $mysqliFactory = new MysqliFactory();
        $this->mysqli = $mysqliFactory->getInstance();
    }

    public function syncDatabase() {
        return array(
            'test'=>'Hello World'
        );
        // TODO make this query the database for a list of all organization-item associations and return it
    }

    public function insertOrganization(Organization $organization) {

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

        $result =  $stmt->execute();

        return array('success' => $result);
    }

    public function updateOrganization(Organization $organization) {

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

        $result =  $stmt->execute();

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

        $result =  $stmt->execute();

        return array('success' => $result);
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

        $result =  $stmt->execute();

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

        $result =  $stmt->execute();

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

        $result =  $stmt->execute();

        return array('success' => $result);
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

        $result =  $stmt->execute();

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

        $result =  $stmt->execute();

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

        $result =  $stmt->execute();

        return array('success' => $result);
    }
}