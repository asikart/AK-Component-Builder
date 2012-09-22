<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

$doc 	= JFactory::getDocument();
$app 	= JFactory::getApplication();
$lang 	= JFactory::getLanguage();



// Define
// ========================================================================
define('{COMPONENT_NAME_UC}_SITE' , JPATH_COMPONENT_SITE ) ;
define('{COMPONENT_NAME_UC}_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);
define('{COMPONENT_NAME_UC}_SELF' , JPATH_COMPONENT);



// Include global helper.
include_once JPath::clean( JPATH_COMPONENT_ADMINISTRATOR . "/helpers/{COMPONENT_NAME}.php" ) ;
include_once JPath::clean( JPATH_COMPONENT_ADMINISTRATOR . "/includes/loader.php" ) ;
include_once JPath::clean( JPATH_ADMINISTRATOR."/includes/toolbar.php" ) ;



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

