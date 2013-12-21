<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_{COMPONENT_NAME}
 * @author      Simon ASika <asika32764@gmail.com>
 * @copyright   Copyright (C) 2013 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Main Controller of {COMPONENT_NAME_UCFIRST}.
 *
 * @package     Joomla.Site
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}Controller extends JControllerLegacy
{
	/**
	 * Typical view method for MVC based architecture
	 *
	 * This function is provide as a default implementation, in most cases
	 * you will need to override it in your own controllers.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JControllerLegacy  A JControllerLegacy object to support chaining.
	 *
	 * @since   12.2
	 */
	public function display($cachable = false, $urlparams = array())
	{
		// Load the submenu.
		{COMPONENT_NAME_UCFIRST}Helper::addSubmenu(JRequest::getCmd('view', '{CONTROLLER_NAMES}'));

		$view = JRequest::getCmd('view', '{CONTROLLER_NAMES}');
		JRequest::setVar('view', $view);

		parent::display();

		return $this;
	}
}
