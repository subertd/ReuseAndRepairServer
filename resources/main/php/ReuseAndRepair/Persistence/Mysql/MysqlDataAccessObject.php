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

    const INSERT_STRING = "INSERT INTO `cs419-g15`.`Organization` (
            `organization_name`,
            `phone_number`,
            `website_url`,
            `physical_address`
        ) VALUES (?, ?, ?, ?)";

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

    public function setOrganization(Organization $organization) {

        if ($organization->getId() == null)
        {
            $name = $organization->getName();

            $phoneNumber = $organization->getPhoneNumber();

            $websiteUrl = $organization->getWebsiteUrl();

            $physicalAddress = $organization->getPhysicalAddress();

            if (!($stmt = $this->mysqli->prepare(
                MysqlDataAccessObject::INSERT_STRING)))
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
        else {
            throw new \Exception("Not yet implemented - update instead of insert");
        }
    }

    public function deleteOrganization($id) {
        throw new \Exception("Not yet implemented");
    }

    public function setCategory(Category $category) {
        throw new \Exception("Not yet implemented");
    }

    public function deleteCategory($id) {
        throw new \Exception("Not yet implemented");
    }

    public function setItem(Item $item) {
        throw new \Exception("Not yet implemented");
    }

    public function deleteItem($id) {
        throw new \Exception("Not yet implemented");
    }
}