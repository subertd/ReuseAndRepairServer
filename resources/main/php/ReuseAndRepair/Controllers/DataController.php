<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:30 PM
 */

namespace ReuseAndRepair\Controllers;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\Mysql\MysqlDataAccessObject;
use ReuseAndRepair\Presenters\Presenter;
use ReuseAndRepair\Presenters\JsonPresenter;
use ReuseAndRepair\Services\AuthenticationService;
use ReuseAndRepair\Services\AuthorizationService;
use ReuseAndRepair\Services\DatabaseSyncService;
use ReuseAndRepair\Services\OrganizationsService;
use ReuseAndRepair\Services\CategoriesService;
use ReuseAndRepair\Services\ItemsService;
use ReuseAndRepair\Services\OrganizationItemsService;
use ReuseAndRepair\Services\ServiceException;

/**
 * Class Controller
 *
 * The controller is responsible for parsing the request body, routing the
 * request to the appropriate services, and passing the response to the
 * appropriate presenter.
 *
 * @package ReuseAndRepair\Controllers
 */
class DataController {

    const ACTION = "action";
    const ACTION_ORGANIZATION = "organization";
    const ACTION_CATEGORY = "category";
    const ACTION_ITEM = "item";
    const ACTION_ORGANIZATION_ITEM = "organization_item";

    /** @var DataAccessObject */
    private $dao;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var AuthorizationService
     */
    private $authorizationService;

    /**
     * @var DatabaseSyncService
     */
    private $databaseSyncService;

    /**
     * @var OrganizationsService
     */
    private $organizationsService;

    /**
     * @var CategoriesService
     */
    private $categoriesService;

    /**
     * @var ItemsService
     */
    private $itemsService;

    /**
     * @var OrganizationItemsService
     */
    private $organizationItemsService;

    /**
     * @var Presenter
     */
    private $presenter;

    public function __construct() {

        $this->authenticationService = new AuthenticationService();
        $this->authorizationService = new AuthorizationService();

        $this->dao = new MysqlDataAccessObject();

        $this->databaseSyncService = new DatabaseSyncService($this->dao);

        $this->organizationsService = new OrganizationsService($this->dao);
        $this->categoriesService = new CategoriesService($this->dao);
        $this->itemsService = new ItemsService($this->dao);
        $this->organizationItemService
            = new OrganizationItemService($this->dao);

        $this->presenter = new JsonPresenter();
    }

    /**
     * Routes an HTTP request to the appropriate service layer objects
     *
     * The request type determines which operation to perform:
     * -POST = create
     * -GET = read
     * -PUT = update
     * -DELETE = delete
     *
     * and the action header determines which entity to perform the operation
     * upon (i.e. organization, category, item, organization_item)
     */
    public function routeHttpRequest() {

        $headers = getallheaders();

        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->syncDatabase();
                break;
            case 'POST':
                $action = $headers[DataController::ACTION];
                switch($action) {
                    case DataController::ACTION_ORGANIZATION:
                        $this->insertOrganization();
                        break;
                    case DataController::ACTION_CATEGORY:
                        $this->insertCategory();
                        break;
                    case DataController::ACTION_ITEM:
                        $this->insertItem();
                        break;
                    case self::ACTION_ORGANIZATION_ITEM:
                        $this->insertOrganizationItem();
                        break;
                }
                break;
            case 'PUT':
                $action = $headers[DataController::ACTION];
                switch($action) {
                    case DataController::ACTION_ORGANIZATION:
                        $this->updateOrganization();
                        break;
                    case DataController::ACTION_CATEGORY:
                        $this->updateCategory();
                        break;
                    case DataController::ACTION_ITEM:
                        $this->updateItem();
                        break;
                    case self::ACTION_ORGANIZATION_ITEM:
                        $this->updateOrganizationItem();
                }
                break;
            case 'DELETE':
                $action = $headers[DataController::ACTION];
                switch($action) {
                    case DataController::ACTION_ORGANIZATION:
                        $this->deleteOrganization();
                        break;
                    case DataController::ACTION_CATEGORY:
                        $this->deleteCategory();
                        break;
                    case DataController::ACTION_ITEM:
                        $this->deleteItem();
                        break;
                    case self::ACTION_ORGANIZATION_ITEM:
                        $this->deleteOrganizationItem();
                }
                break;
        }

        $this->dao->close();
    }

    /**
     * gets all the data in the database
     */
    private function syncDatabase() {
        try {
            $this->presenter->presentResponse(
                $this->databaseSyncService->syncDatabase());
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * inserts an organization
     */
    private function insertOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationsService->insertOrganization(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * updates an existing organization
     */
    private function updateOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationsService->updateOrganization(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * deletes an existing organization
     */
    private function deleteOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationsService->deleteOrganization(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * inserts a category
     */
    private function insertCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationsService->insertOrganization(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * updates and existing category
     */
    private function updateCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->categoriesService->updateCategory(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * deletes an existing category
     */
    private function deleteCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->categoriesService->deleteCategory(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * inserts an item
     */
    private function insertItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->itemsService->insertItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * updates an existing item
     */
    private function updateItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->itemsService->updateItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * deletes an existing item
     */
    private function deleteItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->itemsService->deleteItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * Inserts a new organization-item relationship
     */
    private function insertOrganizationItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationItemsService->insertOrganizationItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * Updates an existing organization-item relationship
     */
    private function updateOrganizationItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationItemsService->updateOrganizationItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }

    /**
     * Deletes an organization-item relationship
     */
    private function deleteOrganizationItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $this->presenter->presentResponse(
                $this->organizationItemsService->deleteOrganizationItem(
                    $this->authenticationService,
                    $this->authorizationService,
                    $params));
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }
}