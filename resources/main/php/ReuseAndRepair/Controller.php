<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:30 PM
 */

namespace ReuseAndRepair;

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
use ReuseAndRepair\Models\Organization;
use ReuseAndRepair\Models\Category;
use ReuseAndRepair\Models\Item;

class Controller {

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

    public function handleHttpRequest() {

        $headers = getallheaders();
        $action = $headers[Controller::ACTION];

        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->syncDatabase();
                break;
            case 'POST':
                switch($action) {
                    case Controller::ACTION_ORGANIZATION:
                        $this->insertOrganization();
                        break;
                    case Controller::ACTION_CATEGORY:
                        $this->insertCategory();
                        break;
                    case Controller::ACTION_ITEM:
                        $this->insertItem();
                        break;
                }
                break;
            case 'PUT':
                switch($action) {
                    case Controller::ACTION_ORGANIZATION:
                        $this->updateOrganization();
                        break;
                    case Controller::ACTION_CATEGORY:
                        $this->updateCategory();
                        break;
                    case Controller::ACTION_ITEM:
                        $this->updateItem();
                        break;
                }
                break;
            case 'DELETE':
                switch($action) {
                    case Controller::ACTION_ORGANIZATION:
                        $this->deleteOrganization();
                        break;
                    case Controller::ACTION_CATEGORY:
                        $this->deleteCategory();
                        break;
                    case Controller::ACTION_ITEM:
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
                'code' =>$e->getCode()
            );
        }

        $this->jsonResponsePresenter->present($response);
    }

    private function updateCategory() {
        throw new \Exception("Not yet implemented");
    }

    private function deleteCategory() {
        throw new \Exception("Not yet implemented");
    }

    private function insertItem() {
        throw new \Exception("Not yet implemented");
    }

    private function updateItem() {
        throw new \Exception("Not yet implemented");
    }

    private function deleteItem() {
        throw new \Exception("Not yet implemented");
    }
}