<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:30 PM
 */

namespace ReuseAndRepair\Services;


use ReuseAndRepair\Session;

class AuthenticationService {

    const USER_ID = "userId";
    const SESSION_TOKEN = "sessionToken";

    /*
     * Put here, code to retrieve the user's identity, or whatever
     */
    public function authenticate($params) {

        $session = new Session();

        if (empty($params[self::USER_ID]) || empty($params[self::SESSION_TOKEN])) {
            throw new ServiceException("Missing parameters for userId and/or sessionToken");
        }

        if ($session->verifySessionToken($params[self::USER_ID], $params[self::SESSION_TOKEN])) {
            return true;
        }
        else {

            return false;
        }
    }
}
