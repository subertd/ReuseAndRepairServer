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
use ReuseAndRepair\Presenters\JsonSyncResponsePresenter;
use ReuseAndRepair\Presenters\JsonSetResponsePresenter;
use ReuseAndRepair\Presenters\JsonDeleteResponsePresenter;
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

    private $params;

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
     * @var JsonSyncResponsePresenter
     */
    private $jsonSyncResponsePresenter;

    /**
     * @var JsonSetResponsePresenter
     */
    private $jsonSetResponsePresenter;

    /**
     * @var JsonDeleteResponsePresenter
     */
    private $jsonDeleteResponsePresenter;

    /**
     * @param array $params the http request body data
     */
    public function __construct(array $params) {

        /** @var array params */
        $this->params = $params;

        $this->authenticationService = new AuthenticationService();
        $this->authorizationService = new AuthorizationService();

        /** @var DataAccessObject $dao */
        $dao = new MysqlDataAccessObject();

        $this->databaseSyncService = new DatabaseSyncService($dao);

        $this->organizationsService = new OrganizationsService($dao);
        $this->categoriesService = new CategoriesService($dao);
        $this->itemsService = new ItemsService($dao);

        $this->jsonSyncResponsePresenter = new JsonSyncResponsePresenter();
        $this->jsonSetResponsePresenter = new JsonSetResponsePresenter();
        $this->jsonDeleteResponsePresenter = new JsonDeleteResponsePresenter();
    }

    public function syncDatabase() {
        $this->jsonSyncResponsePresenter->present(
            $this->databaseSyncService->syncDatabase());
    }

    public function setOrganization() {

        try {
            $response = $this->organizationsService->setOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $this->params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' =>$e->getCode()
            );
        }

        $this->jsonSetResponsePresenter->present($response);
    }

    public function deleteOrganization() {

        try {
            $response = $this->organizationsService->deleteOrganization(
                $this->authenticationService,
                $this->authorizationService,
                $this->params);
        }
        catch (ServiceException $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        $this->jsonDeleteResponsePresenter->present($response);
    }

    public function setCategory() {
        throw new \Exception("Not yet implemented");
    }

    public function deleteCategory() {
        throw new \Exception("Not yet implemented");
    }

    public function setItem() {
        throw new \Exception("Not yet implemented");
    }

    public function deleteItem() {
        throw new \Exception("Not yet implemented");
    }
}