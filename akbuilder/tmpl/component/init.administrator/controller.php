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

include_once AKPATH_COMPONENT . '/controller.php';

/**
 * Main Controller of {COMPONENT_NAME_UCFIRST}.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}Controller extends AKController
{
	/**
	 * Method to display a view.
	 *
	 * @param  boolean  $cachable   If true, the view output will be cached
	 * @param  mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return JController   This object to support chaining.
	 *
	 * @since  1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Load the submenu.
		$input = JFactory::getApplication()->input;
		{COMPONENT_NAME_UCFIRST}Helper::addSubmenu($input->get('view', '{CONTROLLER_NAMES}'));

		$view = $input->get('view', '{CONTROLLER_NAMES}');
		$input->set('view', $view);

		parent::display();

		// Debug
		$doc = JFactory::getDocument();

		if ((AKDEBUG || JDEBUG) && $doc->getType() == 'html')
		{
			echo '<hr style="clear:both;" />';
			echo AKHelper::_('system.renderProfiler', 'WindWalker');
		}

		return $this;
	}
}
