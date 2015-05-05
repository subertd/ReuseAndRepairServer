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
use ReuseAndRepair\Presenters\JsonResponsePresenter;
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
 * @package ReuseAndRepair
 */
class DataController {

    const ACTION = "action";
    const ACTION_ORGANIZATION = "organization";
    const ACTION_CATEGORY = "category";
    const ACTION_ITEM = "item";

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
     * @var JsonResponsePresenter
     */
    private $jsonResponsePresenter;

    public function __construct() {

        $this->authenticationService = new AuthenticationService();
        $this->authorizationService = new AuthorizationService();

        /** @var DataAccessObject $dao */
        $dao = new MysqlDataAccessObject();

        $this->databaseSyncService = new DatabaseSyncService($dao);

        $this->organizationsService = new OrganizationsService($dao);
        $this->categoriesService = new CategoriesService($dao);
        $this->itemsService = new ItemsService($dao);

        $this->jsonResponsePresenter = new JsonResponsePresenter();
    }

    /**
     * handles an HTTP request
     */
    public function handleHttpRequest() {

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
                }
                break;
        }
    }

    private function syncDatabase() {
        $this->jsonResponsePresenter->present(
            $this->databaseSyncService->syncDatabase());
    }

    /**
     * inserts an organization
     */
    private function insertOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->organizationsService->insertOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' =>$e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * updates an existing organization
     */
    private function updateOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->organizationsService->updateOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' =>$e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * deletes an existing organization
     */
    private function deleteOrganization() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->organizationsService->deleteOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * inserts a category
     */
    private function insertCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->organizationsService->insertOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * updates and existing category
     */
    private function updateCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->categoriesService->insertCategory(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * deletes an existing category
     */
    private function deleteCategory() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->categoriesService->deleteCategory(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * inserts an item
     */
    private function insertItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->itemsService->insertItem(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * updates an existing item
     */
    private function updateItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->itemsService->insertItem(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    /**
     * delets an existing item
     */
    private function deleteItem() {

        /** @var array $params */
        $params = json_decode(file_get_contents("php://input"), true);

        try {
            $response = $this->itemsService->deleteItem(
                $this->authenticationService,
                $this->authorizationService,
                $params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }
}