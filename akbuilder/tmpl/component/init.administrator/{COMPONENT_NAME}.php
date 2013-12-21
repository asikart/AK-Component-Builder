<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_{COMPONENT_NAME}'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Init
include_once JPATH_COMPONENT_ADMINISTRATOR . '/includes/init.php';

// Include dependancies
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('{COMPONENT_NAME_UCFIRST}');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
