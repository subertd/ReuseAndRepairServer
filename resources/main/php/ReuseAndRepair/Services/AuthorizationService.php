<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 5:17 PM
 */

namespace ReuseAndRepair\Services;


/**
 * Class AuthorizationService
 * @package ReuseAndRepair\Services
 *
 * Handles authorization of users to make changes to the data
 */
class AuthorizationService {


    /**
     * Returns whether the user is authorized to make changes to the data
     *
     * At the moment, any user who can be authenticated is a priveledged user
     *
     * @param AuthenticationService $authenticationService
     * @param array $params the parsed HTTP request parameters
     * @return bool true if the user is authorized, else false
     */
    public function isAuthorized(AuthenticationService $authenticationService,
        array $params)
    {
        /*
         * Put here, the code for determining whether a user, once identified,
         * is an administrative user.
         *
         * Use the AuthenticationService to get the identity of the user
         */

        return $authenticationService->authenticate($params);
    }
}