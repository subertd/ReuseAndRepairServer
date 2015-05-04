<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:24 PM
 */

namespace ReuseAndRepair\Services;

use ReuseAndRepair\Persistence\DataAccessObject;
use ReuseAndRepair\Models\Organization;

class OrganizationsService {

    private $dao;

    public function __construct(DataAccessObject $dao) {
        $this->dao = $dao;
    }

    public function setOrganization(
        AuthenticationService $authenticationService,
        Organization $organization)
    {
        return null;
        // TODO implement
    }
}