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

    const ACTION = "Action";
    const ACTION_SYNC = "sync";
    const ACTION_ORGANIZATION = "organization";
    const ACTION_CATEGORY = "category";
    const ACTION_ITEM = "item";
    const ACTION_ORGANIZATION_REUSE_ITEM = "organizationItem";
    const ACTION_ITEM_CATEGORY = "itemCategory";

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
     * upon (i.e. organization, category, item, organizationItem, itemCategory)
     */
    public function routeHttpRequest() {

        $headers = getallheaders(); // gets the headers of the HTTP request
        $action = isset($headers[self::ACTION]) ? $headers[self::ACTION] : null;
        $action = isset($headers[strtolower(self::ACTION)]) ? $headers[strtolower(self::ACTION)] : $action;

        try {

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    switch ($action) {
                        case self::ACTION_ORGANIZATION:
                            $this->getOrganizations();
                            break;
                        case self::ACTION_CATEGORY:
                            $this->getCategories();
                            break;
                        case self::ACTION_ITEM:
                            $this->getItems();
                            break;
                        case self::ACTION_SYNC:
                        default:
                            $this->syncDatabase();
                            break;
                    }
                    break;
                case 'POST':
                    switch ($action) {
                        case self::ACTION_ORGANIZATION:
                            $this->insertOrganization();
                            break;
                        case self::ACTION_CATEGORY:
                            $this->insertCategory();
                            break;
                        case self::ACTION_ITEM:
                            $this->insertItem();
                            break;
                        default:
                            throw new ControllerException("Missing or unknown POST action: '$action'");
                    }
                    break;
                case 'PUT':
                    switch ($action) {
                        case self::ACTION_ORGANIZATION:
                            $this->updateOrganization();
                            break;
                        case self::ACTION_CATEGORY:
                            $this->updateCategory();
                            break;
                        case self::ACTION_ITEM:
                            $this->updateItem();
                            break;
                        default:
                            throw new ControllerException("Missing or unknown PUT action: '$action'");
                    }
                    break;
                case 'DELETE':
                    switch ($action) {
                        case self::ACTION_ORGANIZATION:
                            $this->deleteOrganization();
                            break;
                        case self::ACTION_CATEGORY:
                            $this->deleteCategory();
                            break;
                        case self::ACTION_ITEM:
                            $this->deleteItem();
                            break;
                        default:
                            throw new ControllerException("Missing or unknown DELETE action: '$action'");
                    }
                    break;
            }
        }
        catch(ControllerException $e) {
            $this->presenter->presentException($e);
        }
        finally {
            $this->dao->close();
        }
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
     * gets a list of all organizations
     */
    private function getOrganizations() {
        try {
            $this->presenter->presentResponse(
                $this->organizationsService->getOrganizations());
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
                $this->categoriesService->insertCategory(
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
     * gets a list of all categories
     */
    private function getCategories() {
        try {
            $this->presenter->presentResponse(
                $this->categoriesService->getCategories());
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
     * gets a list of all items
     */
    private function getItems() {
        try {
            $this->presenter->presentResponse(
                $this->itemsService->getItems());
        }
        catch (ServiceException $e) {
            $this->presenter->presentException($e);
        }
    }
}
