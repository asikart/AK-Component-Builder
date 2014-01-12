<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use {COMPONENT_NAME_UCFIRST}\Component\{COMPONENT_NAME_UCFIRST}Component as {COMPONENT_NAME_UCFIRST}ComponentBase;

// No direct access
defined('_JEXEC') or die;

/**
 * Class {COMPONENT_NAME_UCFIRST}Component
 *
 * @since 1.0
 */
final class {COMPONENT_NAME_UCFIRST}Component extends {COMPONENT_NAME_UCFIRST}ComponentBase
{
	/**
	 * Property defaultController.
	 *
	 * @var string
	 */
	protected $defaultController = '{CONTROLLER_NAMES}.display';

	/**
	 * init
	 *
	 * @return void
	 */
	protected function prepare()
	{
		parent::prepare();
	}
}
