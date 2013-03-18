<?php
namespace Nayael\Migrations\Helper;

require_once MAIN_PATH . '/classes/helpers/PDOHelper.php';

/**
 * Migration Helper to run MySQL migrations
 * @package Migrations
 * @subpackage classes/helpers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class MigrationHelper
{
    /**
     * Runs the migration by executing SQL queries inside a file
     * @param  File  $file   The .sql file
     * @param  array $config The database configuration data
     * @return bool          Success or fail
     */
    static public function runMigration($file, $config)
    {
        // First, getting the PDO object
        $pdo = PDOHelper::getPdoObj($config['db']);
        if (null === $pdo) {
            return false;
        }
        
        // We try to execture the sql query inside the file
        try {
            $query = $file->read();
            $exec = $pdo->exec($query);
        } catch (PDOException $e) {
            echo "\nError while executing the following query :\n" . $query . "\n";
            return false;
        }
        return true;
    }
}
