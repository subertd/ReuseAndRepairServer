<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/6/2015
 * Time: 12:36 AM
 */

namespace ReuseAndRepair\Services;


use ReuseAndRepair\Models\ItemFactory;
use ReuseAndRepair\Models\OrganizationFactory;
use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Persistence\PersistenceException;

class OrganizationItemsService {

    const ADDITIONAL_REPAIR_INFORMATION = "additionalRepairInformation";

    const MODEL_ERROR = "Unable to get an organizationItem model";

    /** @var DataAccessObject */
    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    /**
     * If the user is authorized, insert the organization-item relationship
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to identify the organization-item
     * relationship from the parameters
     */
    public function insertOrganizationItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        if (empty($params[OrganizationFactory::ID])
            || !is_numeric($params[OrganizationFactory::ID])
            || !( ( ( (float) $params[OrganizationFactory::ID]) % 1) == 0)

            || empty($params[ItemFactory::ID])
            || !is_numeric($params[ItemFactory::ID])
            || !( ( ( (float) $params[ItemFactory::ID]) % 1) == 0)

        ) {
            throw new ServiceException("Missing parameters");
        }

        $organizationId = (int) $params[OrganizationFactory::ID];
        $itemId = (int) $params[ItemFactory::ID];
        $additionalRepairInformation
            = isset($params[self::ADDITIONAL_REPAIR_INFORMATION]) ?
                $params[self::ADDITIONAL_REPAIR_INFORMATION] : '';

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->insertOrganizationItem(
                $organizationId, $itemId, $additionalRepairInformation);
        }

        return array('success' => false);
    }

    /**
     * If the user is authorized, update the organization-item
     *
     * @param AuthenticationService $authenticationService
     * @param AuthorizationService $authorizationService
     * @param array $params the parsed HTTP request parameters
     * @return array the response
     * @throws ServiceException if unable to create
     */
    public function updateOrganizationItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        if (empty($params[OrganizationFactory::ID])
            || !is_numeric($params[OrganizationFactory::ID])
            || !( ( ( (float) $params[OrganizationFactory::ID]) % 1) == 0)

            || empty($params[ItemFactory::ID])
            || !is_numeric($params[ItemFactory::ID])
            || !( ( ( (float) $params[ItemFactory::ID]) % 1) == 0)

        ) {
            throw new ServiceException("Missing parameters");
        }

        $organizationId = (int) $params[OrganizationFactory::ID];
        $itemId = (int) $params[ItemFactory::ID];
        $additionalRepairInformation = $params[self::ADDITIONAL_REPAIR_INFORMATION];

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->updateOrganizationItem(
                $organizationId, $itemId, $additionalRepairInformation);
        }

        return array('success' => false);
    }

    public function deleteOrganizationItem(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        if (empty($params[OrganizationFactory::ID])
            || !is_numeric($params[OrganizationFactory::ID])
            || !( ( ( (float) $params[OrganizationFactory::ID]) % 1) == 0)

            || empty($params[ItemFactory::ID])
            || !is_numeric($params[ItemFactory::ID])
            || !( ( ( (float) $params[ItemFactory::ID]) % 1) == 0)

        ) {
            throw new ServiceException("Missing parameters");
        }

        $organization_id = (int) $params[OrganizationFactory::ID];
        $item_id = (int) $params[ItemFactory::ID];

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->deleteOrganizationItem($organization_id, $item_id);
        }

        return array('success' => false);
    }

    /**
     * get a list of all organization-item relationships
     * @return array the list of organization-item relationships
     * @throws ServiceException if unable to get a list of organization-item relationships
     */
    public function getOrganizationItems() {
        try {
            return $this->dao->getOrganizationItems();
        }
        catch (PersistenceException $e) {
            throw new ServiceException("Unable to get a list of organization-item relationships", $e);
        }
    }
}