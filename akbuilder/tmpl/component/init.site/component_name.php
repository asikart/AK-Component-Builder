<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_{COMPONENT_NAME}')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// include helper
$helper = JPATH_COMPONENT.DS.'helpers'.DS.'{COMPONENT_NAME}.php' ;
if( file_exists($helper) ){
	include_once $helper ;
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('{COMPONENT_NAME_UCFIRST}');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
