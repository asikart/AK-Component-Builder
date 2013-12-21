<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 * @author      Simon ASika <asika32764@gmail.com>
 * @copyright   Copyright (C) 2013 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once AKPATH_COMPONENT . '/controlleradmin.php';

/**
 * {CONTROLLER_NAMES_UCFIRST} list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAMES_UCFIRST} extends AKControllerAdmin
{
	/**
	 * The URL view list variable.
	 *
	 * @var  string
	 */
	protected $view_list = '{CONTROLLER_NAMES}';

	/**
	 * The URL view item variable.
	 *
	 * @var  string
	 */
	protected $view_item = '{CONTROLLER_NAME}';

	/**
	 * The Component name.
	 *
	 * @var  string
	 */
	protected $component = '{COMPONENT_NAME}';

	/**
	 * Constructor.
	 *
	 * @param   array $config An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   11.1
	 */
	function __construct($config = array())
	{
		$this->redirect_tasks = array(
			'save', 'cancel', 'publish', 'unpublish', 'delete'
		);

		parent::__construct($config);
	}
}