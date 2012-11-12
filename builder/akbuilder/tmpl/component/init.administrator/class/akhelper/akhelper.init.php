<?php
/**
 * @package     AKHelper
 * @subpackage  main
 *
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// No direct access
defined('_JEXEC') or die;


if( !defined('DS') ){
	define('DS', DIRECTORY_SEPARATOR) ;
}


//Define 
require_once (dirname(__FILE__).DS.'akhelper.defines.php') ;

//Load AKHelper
if(!class_exists('AKHelper')){
	require_once (AKHELPER_PATH.DS.'akhelper.php') ;
}



