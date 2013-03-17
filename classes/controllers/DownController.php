<?php
namespace Nayael\Migrations\Controller;

require_once MAIN_PATH . '/lib/File.php';
require_once MAIN_PATH . '/classes/helpers/MigrationHelper.php';

use Nayael\File\File;
use Nayael\Migrations\Helper\MigrationHelper;

/**
 * Executes MySQL migrations (DOWN instructions)
 * @package Migrations
 * @subpackage classes/controllers
 * @author Nicolas Vannier <nicolas.vannier93@gmail.com>
 */
class DownController extends Controller
{
    public function doAction($argv)
    {

    }

    public function displayHelp()
    {
        
    }
}