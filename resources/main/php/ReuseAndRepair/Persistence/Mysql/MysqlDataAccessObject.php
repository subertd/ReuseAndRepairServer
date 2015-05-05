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

        if (!($stmt = $this->mysqli->prepare(
            MysqlDataAccessObject::INSERT_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssss",
            $name,$phoneNumber, $websiteUrl, $physicalAddress))
        {
            die("Unable to bind params " . $stmt->error);
        }

        $result =  $stmt->execute();

        return array(
            'success' => $result
        );
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

        if (!($stmt = $this->mysqli->prepare(
            MysqlDataAccessObject::UPDATE_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("ssssi",
            $name,$phoneNumber, $websiteUrl, $physicalAddress, $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        $result =  $stmt->execute();

        return array(
            'success' => $result
        );
    }

    public function deleteOrganization($id) {

        if (!($stmt = $this->mysqli->prepare(
            MysqlDataAccessObject::DELETE_ORGANIZATION_STRING)))
        {
            die("Unable to prepare statement " . $this->mysqli->error);
        }

        if (!$stmt->bind_param("i", $id))
        {
            die("Unable to bind params " . $stmt->error);
        }

        $result =  $stmt->execute();

        return array(
            'success' => $result
        );
    }

    public function insertCategory(Category $category) {
        throw new \Exception("Not yet implemented");
    }

    public function updateCategory(Category $category) {
        throw new \Exception("Not yet implemented");
    }

    public function deleteCategory($id) {
        throw new \Exception("Not yet implemented");
    }

    public function insertItem(Item $item) {
        throw new \Exception("Not yet implemented");
    }

    public function updateItem(Item $item) {
        throw new \Exception("Not yet implemented");
    }

    public function deleteItem($id) {
        throw new \Exception("Not yet implemented");
    }
}