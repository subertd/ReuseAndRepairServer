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
use ReuseAndRepair\Models\CategoryFactory;
use ReuseAndRepair\Models\Category;
use ReuseAndRepair\Persistence\PersistenceException;

class CategoriesService {

    const ID = "id";

    const MODEL_ERROR = "Unable to get a category model";

    /** @var DataAccessObject */
    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    /**
     * If the user is authorized, insert the category
     *
     * @param AuthenticationService $authenticationService
     * @param $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create a category object from
     * the parameters
     */
    public function insertCategory(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Category $category */
            $category = CategoryFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->insertCategory($category);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, update the category
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create a category object from
     * the parameters
     */
    public function updateCategory(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Category $category */
            $category = CategoryFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->updateCategory($category);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, delete the category
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to identify the category from the
     * parameters
     */
    public function deleteCategory(
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
            return $this->dao->deleteCategory($id);
        }

        return array('success' => false);
    }

    /**
     * gets a list of all categories
     * @return array the list of all categories
     * @throws ServiceException if unable to get a list of categories
     */
    public function getCategories() {
        try {
            return $this->dao->getCategories();
        }
        catch(PersistenceException $e) {
            throw new ServiceException("Unable to get a list of categories", $e);
        }
    }
}