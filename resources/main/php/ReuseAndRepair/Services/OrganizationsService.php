<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:24 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Models\OrganizationFactory;
use ReuseAndRepair\Models\Organization;
use ReuseAndRepair\Models\ModelException;
use ReuseAndRepair\Persistence\PersistenceException;

class OrganizationsService {

    const ID = "id";

    const MODEL_ERROR = "Unable to get an organization model";

    /** @var DataAccessObject */
    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    /**
     * If the user is authorized, insert the organization
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create an organization object
     * from the parameters
     */
    public function insertOrganization(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Organization $organization */
            $organization = OrganizationFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->insertOrganization($organization);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, update the organization
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create an organization object
     * from the parameters
     */
    public function updateOrganization(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        try {
            /** @var Organization $organization */
            $organization = OrganizationFactory::getInstance($params);

            if ($authorizationService->isAuthorized(
                $authenticationService, $params)
            ) {
                return $this->dao->updateOrganization($organization);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(self::MODEL_ERROR, null, $e);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, delete the organization
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to identify the organization from
     * the parameters
     */
    public function deleteOrganization(
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
            return $this->dao->deleteOrganization($id);
        }

        return array('success' => false);
    }

    /**
     * gets a list of all organizations
     * @return array the list of organizations
     * @throws ServiceException if unable to get a list of organizations
     */
    public function getOrganizations() {
        try {
            return $this->dao->getOrganizations();
        }
        catch(PersistenceException $e) {
            throw new ServiceException("Unable to get a list of organizations", $e);
        }
    }
}