<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 6/9/2015
 * Time: 2:07 PM
 */

namespace ReuseAndRepair;


class Session {

    public function __construct() {
        $root = $_SERVER['DOCUMENT_ROOT'];
        session_save_path ("sessions");
        session_start();
    }

    public function establishAuthenticatedSession($userId) {

        $sessionToken = \openssl_random_pseudo_bytes (100, $cstrong);

        $_SESSION['userId'] = $userId;
        $_SESSION['sessionToken'] = $sessionToken;
        
        return $sessionToken;
    }

    public function verifySessionToken($userId, $sessionToken) {

        if (isset($_SESSION['userId']) && isset($_SESSION['sessionToken'])) {

            if (strcmp($userId, $_SESSION['userId']) == 0
                && strcmp($sessionToken, $_SESSION['sessionToken']) == 0)
            {
                return true;
            }
        }

        return false;
    }

    public function hasAuthenticatedSession() {

        if (isset($_SESSION['userId']) && isset($_SESSION['sessionToken'])) {
            return true;
        }
        else {
            return false;
        }
    }
}
