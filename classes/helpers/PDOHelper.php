<?php
namespace Nayael\Migrations\Helper;

/**
 * A helper class to connect to a database using PDO
 * @package Migrations
 * @subpackage classes/controllers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class PDOHelper
{
    static public function getPdoObj(array $db_config)
    {
        try {
            $pdo = new \PDO('mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['database'], $db_config['username'], $db_config['password']);
        } catch(Exception $e) {
            echo "> Error while connecting to database :\n" . $e->getMessage();
            return null;
        }
        return $pdo;
    }
}
