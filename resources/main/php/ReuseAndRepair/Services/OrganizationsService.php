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

class OrganizationsService {

    const ID = "organizationId";

    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    public function setOrganization(
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
                return $this->dao->setOrganization($organization);
            }
        }
        catch (ModelException $e) {
            throw new ServiceException(
                "Unable to get an organization model", null, $e);
        }

        return array(
            'success' => false
        );
    }

    public function deleteOrganization(
        AuthenticationService $authenticationService,
        AuthorizationService $authorizationService,
        array $params)
    {
        if (empty($params[OrganizationsService::ID])
            || !is_numeric(($id = $params[OrganizationsService::ID])))
        {
            throw new ServiceException(
                "Missing parameter " . OrganizationsService::ID);
        }

        if ($authorizationService->isAuthorized(
            $authenticationService, $params))
        {
            return $this->dao->deleteOrganization($id);
        }
    }
}