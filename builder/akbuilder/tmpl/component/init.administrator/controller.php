<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// No direct access
defined('_JEXEC') or die;

class {COMPONENT_NAME_UCFIRST}Controller extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Load the submenu.
		{COMPONENT_NAME_UCFIRST}Helper::addSubmenu(JRequest::getCmd('view', '{CONTROLLER_NAMES}'));

		$view = JRequest::getCmd('view', '{CONTROLLER_NAMES}');
        JRequest::setVar('view', $view);

		parent::display();

		return $this;
	}
}
