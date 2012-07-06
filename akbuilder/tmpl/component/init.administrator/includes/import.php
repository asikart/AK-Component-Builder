<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$lang = JFactory::getLanguage();

// define
define('{COMPONENT_NAME_UC}_SITE' , JPATH_COMPONENT_SITE ) ;
define('{COMPONENT_NAME_UC}_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);

//include joomla api
jimport('joomla.application.component.controller');
jimport('joomla.application.component.controllerform');
jimport('joomla.application.component.controlleradmin');

jimport('joomla.application.component.view');

jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.modelitem');

jimport('joomla.html.toolbar');

// include Component Custom class
include_once JPath::clean( {COMPONENT_NAME_UC}_ADMIN."/class/viewpanel.class.php" ) ;
include_once JPath::clean( {COMPONENT_NAME_UC}_ADMIN."/helpers/aktext.php" ) ;

if( $app->isSite() ){
	include_once JPath::clean( PAYANY_ADMIN."/helpers/{COMPONENT_NAME}.php" ) ;
	$lang->load('', JPATH_ADMINISTRATOR);
	$lang->load('com_{COMPONENT_NAME}', {COMPONENT_NAME_UC}_ADMIN );
}else{
	include_once JPath::clean( {COMPONENT_NAME_UC}_ADMIN."/helpers/{COMPONENT_NAME}.php" ) ;
}


// include css
$doc->addStyleSheet('administrator/templates/bluestork/css/template.css');