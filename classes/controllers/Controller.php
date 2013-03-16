<?php

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
     * @return void
     */
    abstract public function doAction();
    
    /**
     * Displays the help page for this controller.
     * @return void
     */
    abstract public function displayHelp();
}
