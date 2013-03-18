<?php
namespace Nayael\Migrations;

/**
 * This class is used to get a particular controller from a command line argument
 * @package Migrations
 * @subpackage classes
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class ControllerFactory
{
    static public function getController(&$argv)
    {
        require_once MAIN_PATH . '/classes/controllers/Controller.php';

        $script_name = array_shift($argv);
        $controller_name = array_shift($argv);
        
        if ($controller_name == null) {
            $controller_name = 'help';
        }
        $class = ucfirst($controller_name) . 'Controller';

        if (!file_exists(MAIN_PATH . '/classes/controllers/' . $class . '.php')) {
            echo 'Invalid argument "' . $controller_name . '". Run "php migrate help" to see available commands.' . "\n\n";
            return;
        }
        require_once MAIN_PATH . '/classes/controllers/' . $class . '.php';
        $class = '\\Nayael\\Migrations\\Controller\\' . $class;

        $controller = new $class();
        return $controller;
    }
}