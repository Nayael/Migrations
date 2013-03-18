<?php
namespace Nayael\Migrations\Controller;

require_once MAIN_PATH . '/lib/File.php';

use Nayael\File\File;

/**
 * Abstract controller class
 * @package Migrations
 * @subpackage classes/controllers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
abstract class Controller
{
    
    public function __construct()
    {
        
    }
    
    /**
     * Determines what action should be performed and takes that action.
     * @param array $argv The command arguments
     * @return void
     */
    abstract public function doAction($argv);
    
    /**
     * Displays the help page for this controller.
     * @return void
     */
    abstract public function displayHelp();

    /**
     * Updates the current_version property in the config file
     * @param  int $version The new current version
     */
    public function updateVersion($version)
    {
        $config_file = new File(MAIN_PATH . '/config/build.ini');
        $lines = $config_file->readLines();
        foreach ($lines as &$line) {
            // We update the line with the "current_version" parameter
            if (strpos($line, 'current_version') === 0) {
                $line = 'current_version = ' . $version;
                break;
            }
        }
        // We rewrite the file with the updated parameter
        $config_file->writeLines($lines, true, false);
    }
}
