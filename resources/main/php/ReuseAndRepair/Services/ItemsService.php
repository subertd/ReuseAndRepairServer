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

class ItemsService {

    const ID = "id";

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
        if (empty($params[self::ID])
            || !is_numeric($params[self::ID])
            || !( ( ( (float) $params[self::ID]) % 1) == 0)
        ) {
            throw new ServiceException(
                "Missing parameter" . self::ID);
        }

        $id = (int) $params[self::ID];

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->deleteItem($id);
        }

        return array('success' => false);
    }
}