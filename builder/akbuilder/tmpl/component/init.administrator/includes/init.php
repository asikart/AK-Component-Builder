<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

$doc 	= JFactory::getDocument();
$app 	= JFactory::getApplication();
$lang 	= JFactory::getLanguage();



// Define
// ========================================================================
define('{COMPONENT_NAME_UC}_SITE' , JPATH_COMPONENT_SITE );
define('{COMPONENT_NAME_UC}_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);
define('{COMPONENT_NAME_UC}_SELF' , JPATH_COMPONENT);

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR) ;
}


// Include global helper.
include_once JPath::clean( JPATH_COMPONENT_ADMINISTRATOR . '/class/proxy.class.php' ) ;
include_once JPath::clean( JPATH_COMPONENT_ADMINISTRATOR . "/helpers/{COMPONENT_NAME}.php" ) ;
include_once JPath::clean( JPATH_COMPONENT_ADMINISTRATOR . "/includes/loader.php" ) ;
include_once JPath::clean( JPATH_ADMINISTRATOR . "/includes/toolbar.php" ) ;
{COMPONENT_NAME_UCFIRST}Helper::setPrefix('{COMPONENT_NAME_UCFIRST}Helper') ;
{COMPONENT_NAME_UCFIRST}Helper::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/core');
{COMPONENT_NAME_UCFIRST}Helper::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/custom');



// Include joomla api
// ========================================================================
jimport('joomla.application.component.controller');
jimport('joomla.application.component.controllerform');
jimport('joomla.application.component.controlleradmin');

jimport('joomla.application.component.view');

jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.modelitem');

jimport('joomla.html.toolbar');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');



// Include Component Custom class
// ========================================================================
{COMPONENT_NAME}Loader("admin://class/viewpanel.class" ) ;
{COMPONENT_NAME}Loader("admin://class/aktext.class" ) ;
{COMPONENT_NAME}Loader("admin://class/toolbar.class" ) ;
{COMPONENT_NAME}Loader("admin://class/fieldmodal.class" ) ;
{COMPONENT_NAME}Loader("admin://class/akhelper/akhelper.init" ) ;



// Include Helpers
// ========================================================================

if( $app->isSite() ){
	
	// Include Admin language as global language.
	$lang->load('', JPATH_ADMINISTRATOR);
	$lang->load('com_{COMPONENT_NAME}', JPATH_COMPONENT_ADMINISTRATOR );
	
	// Include Joomla! admin css
	{COMPONENT_NAME_UCFIRST}Helper::_('include.core');
	
	// set Base to fix toolbar anchor bug
	$doc->setBase( JFactory::getURI()->toString() );
	
}else{
	
}


// Detect version
{COMPONENT_NAME_UCFIRST}Helper::_('version.detectVersion');

