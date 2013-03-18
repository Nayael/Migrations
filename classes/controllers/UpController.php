<?php
namespace Nayael\Migrations\Controller;

require_once MAIN_PATH . '/lib/File.php';
require_once MAIN_PATH . '/classes/helpers/MigrationHelper.php';

use Nayael\File\File;
use Nayael\Migrations\Helper\MigrationHelper;

/**
 * Executes MySQL migrations (UP instructions)
 * @package Migrations
 * @subpackage classes/controllers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class UpController extends Controller
{
    public function doAction($argv)
    {
        $arg = array_shift($argv);
        $target_version = (int)$arg;
        if (0 === $target_version && null !== $arg) {
            echo "Invalid argument \"" . $arg . "\" supplied for version number. Integer expected.\n";
            echo "\n-- UPGRADE FAILED --\n";
            return;
        }

        // Parsing the config file
        try {
            $config_file = new File(MAIN_PATH . '/config/build.ini');
            $config = $config_file->parse(true);
        } catch (Exception $e) {
            echo "Error processing the file : " . $e->getMessage();
            return;
        }
        echo "-- UPGRADING DATABASE " . $config['db']['database'] . " --\n\n";

        $current_version = (int)$config['current_version'];
        echo 'Current version is ' . $current_version;

        $sql_file = null;
        $i = $current_version;
        
        // We test if the targetted version exists or not
        $sql_file = new File($config['migrations_path'] . '/' . $target_version . '-up.sql');
        if ($target_version != 0 && !$sql_file->exists()) {
            echo "\nVersion " . $target_version . ' of database "' . $config['db']['database'] . '" does not exist. Upgrading to the latest version.' . "\n";
        }

        echo "\n";
        do {
            $i++;
            // Stop the migration if the target version has been reached
            if (0 !== $target_version && $i > $target_version) {
                echo '> DATABASE ' . $config['db']['database'] . ' upgraded to version ' . ($i - 1) . ".\n";
                break;
            }

            $sql_file = new File($config['migrations_path'] . '/' . $i . '-up.sql');

            // Stop the migration if the latest version has been reached
            if (!$sql_file->exists()) {
                if ($i == $current_version + 1) {
                    echo '> DATABASE ' . $config['db']['database'] . " is already up to date.\n";
                    break;
                }
                echo "\n> DATABASE " . $config['db']['database'] . ' upgraded to version ' . ($i - 1) . ".\n";
                break;
            }

            // We run the migration for each version
            if (!MigrationHelper::runMigration($sql_file, $config)) {
                echo "\n-- UPGRADE FAILED --\n";
                return;
            }
        } while ($sql_file->exists());

        $this->updateVersion($i - 1);  // We update the current_version in the config file
        echo "\n-- UPGRADE SUCCESSFUL --\n";
    }

    public function displayHelp()
    {
        echo "PHP Mysql Migrations\n\n";
        echo "\"up\" command:\n";
        echo "Updates the database to the latest version (or a specific version if given)\n\n";
        echo "Reads all the '[version]-up.sql' files and executes the queries from the current version\n";
        echo "to the given version (or latest if none given).\n\n";
        echo "Examples:\n";
        echo "'php migrate up' - Updates to the latest version\n";
        echo "'php migrate up 12' - Updates to version 12\n";
    }
}