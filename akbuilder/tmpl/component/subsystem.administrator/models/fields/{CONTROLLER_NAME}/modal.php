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

include_once JPATH_ADMINISTRATOR . '/components/com_{COMPONENT_NAME}/includes/core.php';
JForm::addFieldPath(AKPATH_FORM . '/fields');
JFormHelper::loadFieldClass('Modal');

/**
 * Supports a modal picker.
 */
class JFormField{CONTROLLER_NAME_UCFIRST}_Modal extends JFormFieldModal
{
	/**
	 * The form field type.
	 *
	 * @var string
	 * @since    1.6
	 */
	protected $type = '{CONTROLLER_NAME_UCFIRST}_Modal';

	/**
	 * List name.
	 *
	 * @var string
	 */
	protected $view_list = '{CONTROLLER_NAMES}';

	/**
	 * Item name.
	 *
	 * @var string
	 */
	protected $view_item = '{CONTROLLER_NAME}';

	/**
	 * Extension name, eg: com_content.
	 *
	 * @var string
	 */
	protected $extension = 'com_{COMPONENT_NAME}';

}
