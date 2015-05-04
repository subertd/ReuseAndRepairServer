<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 12:11 PM
 */

namespace ReuseAndRepair\Mysql;

use ReuseAndRepair\Mysql\MysqlException;

class MysqliFactory {

    const HOST = "host";
    const USER = "user";
    const PASSWORD = "password";
    const DATABASE = "database";

    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct() {
        $databaseProperties = parse_ini_file(
            "../resources/main/config/database.ini");

        // TODO add error message for missing ini file

        $this->host = $databaseProperties[MysqliFactory::HOST];
        $this->user = $databaseProperties[MysqliFactory::USER];
        $this->password = $databaseProperties[MysqliFactory::PASSWORD];
        $this->database = $databaseProperties[MysqliFactory::DATABASE];
    }

    /**
     * Get an instance of a mysqli
     *
     * @return \mysqli the instance
     * @throws MysqlException if a mysqli could not be created
     */
    public function getInstance() {
        $mysqli =  new \mysqli(
            $this->host, $this->user, $this->password, $this->database);

        if ($mysqli->connect_errno > 0) {
            throw new MysqlException($mysqli->connect_error, $mysqli->connect_errno);
        }

        return $mysqli;
    }
}