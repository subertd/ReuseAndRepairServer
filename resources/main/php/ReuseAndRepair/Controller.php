<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:30 PM
 */

namespace ReuseAndRepair;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\MysqlDataAccessObject;
use ReuseAndRepair\Presenters\JsonSetResponsePresenter;
use ReuseAndRepair\Services\AuthenticationService;
use ReuseAndRepair\Services\DatabaseSyncService;
use ReuseAndRepair\Services\OrganizationsService;
use ReuseAndRepair\Services\CategoriesService;
use ReuseAndRepair\Services\ItemsService;
use ReuseAndRepair\Services\ServiceException;
use ReuseAndRepair\Models\Organization;
//use ReuseAndRepair\Models\Category;
//use ReuseAndRepair\Models\Item;

class Controller {

    private $authenticationService;

    private $databaseSyncService;

    private $organizationsService;
    private $categoriesService;
    private $itemsService;

    private $jsonSetResponsePresenter;

    public function __construct() {

        $this->authenticationService = new AuthenticationService();

        /** @var DataAccessObject $dao */
        $dao = new MysqlDataAccessObject();

        $this->databaseSyncService = new DatabaseSyncService($dao);

        $this->organizationsService = new OrganizationsService($dao);
        $this->categoriesService = new CategoriesService($dao);
        $this->itemsService = new ItemsService($dao);

        $this->jsonSetResponsePresenter = new JsonSetResponsePresenter();
    }

    public function syncDatabase() {
        // TODO implement
    }

    public function setOrganization() {

        $organization = new Organization;

        // TODO set the properties of the organization

        try {
            $response = $this->organizationsService->setOrganization(
                $this->authenticationService,
                $organization);

            $this->jsonSetResponsePresenter->present($response);
        }
        catch (ServiceException $e) {
            // TODO handle
        }
    }

    public function deleteOrganization() {
        // TODO implement
    }

    public function setCategory() {
        // TODO implement
        return null;
    }

    public function deleteCategory() {
        // TODO implement
    }

    public function setItem() {
        // TODO implement
    }

    public function deleteItem() {
        // TODO implement
    }
}