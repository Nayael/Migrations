<?php
namespace Nayael\Migrations\Controller;

/**
 * Displays help on the shell
 * @package Migrations
 * @subpackage classes/controllers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class HelpController extends Controller
{
    public function doAction($argv)
    {
        if (!isset($argv[0])) {
            $this->displayHelp();
            return;
        }

        $class = ucfirst($argv[0]) . 'Controller';
        if (!file_exists(MAIN_PATH . '/classes/controllers/' . $class . '.php')) {
            echo 'Invalid argument "' . $argv[0] . '". Run "php migrate help" to see available commands.' . "\n\n";
            return;
        }
        require_once MAIN_PATH . '/classes/controllers/' . $class . '.php';
        $class = '\\Nayael\\Migrations\\Controller\\' . $class;

        $controller = new $class();
        $controller->displayHelp();
    }

    public function displayHelp()
    {
        echo "PHP Mysql Migrations\n\n";
        echo "Commands:\n";
        echo "up [version]           Updates the database to the latest version\n";
        echo "                       (or a specific version if given)\n";
        echo "down [version]         Downgrades the database to the given version\n\n";
    }
}