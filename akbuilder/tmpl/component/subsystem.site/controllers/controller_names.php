<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * {CONTROLLER_NAMES_UCFIRST} list controller class.
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAMES_UCFIRST} extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = '{CONTROLLER_NAME}', $prefix = '{COMPONENT_NAME_UCFIRST}Model', $config = array() )
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}