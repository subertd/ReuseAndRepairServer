<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:24 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Models\ModelException;
use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Models\ItemFactory;
use ReuseAndRepair\Models\Item;
use ReuseAndRepair\Persistence\PersistenceException;

class ItemsService {

    const MODEL_ERROR = "Unable to get an item model";

    /** @var DataAccessObject */
    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    /**
     * If the user is authorized, insert the item
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create an item object
     */
    public function insertItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Item $item */
            $item = ItemFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->insertItem($item);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, update the item
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create an item object from the
     * parameters
     */
    public function updateItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Item $item */
            $item = ItemFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->updateItem($item);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, delete the item
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params
     * @return array the response
     * @throws ServiceException if unable to identify the item from the
     * parameters
     */
    public function deleteItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        if (empty($params[ItemFactory::ID])
            || !is_numeric($params[ItemFactory::ID])
            || !( ( ( (float) $params[ItemFactory::ID]) % 1) == 0)
        ) {
            throw new ServiceException(
                "Missing parameter" . ItemFactory::ID);
        }

        $id = (int) $params[ItemFactory::ID];

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->deleteItem($id);
        }

        return array('success' => false);
    }

    /**
     * gets a list of all items
     * @return array the list of items
     * @throws ServiceException if unable to get a list of items
     */
    public function getItems() {
        try {
            return $this->dao->getItems();
        }
        catch(PersistenceException $e) {
            throw new ServiceException($e);
        }
    }
}