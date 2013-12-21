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

include_once AKPATH_COMPONENT . '/controllerform.php';

/**
 * {CONTROLLER_NAME_UCFIRST} controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAME_UCFIRST} extends AKControllerForm
{
	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 */
	protected $view_list = '{CONTROLLER_NAMES}';

	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 */
	protected $view_item = '{CONTROLLER_NAME}';

	/**
	 * The Component name.
	 *
	 * @var    string
	 */
	protected $component = '{COMPONENT_NAME}';

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JControllerLegacy
	 * @since   12.2
	 * @throws  Exception
	 */
	function __construct($config = array())
	{
		$this->allow_url_params = array(
			'return'
		);

		$this->redirect_tasks = array(
			'save', 'cancel', 'publish', 'unpublish', 'delete'
		);

		parent::__construct($config);
	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   12.2
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$result = $model->postSaveHook($validData);

		return $result;
	}
}
