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
JFormHelper::loadFieldClass('itemlist');

/**
 * Supports an HTML select list of categories
 */
class JFormField{CONTROLLER_NAME_UCFIRST}_List extends JFormFieldItemlist
{
	/**
	 * The form field type.
	 *
	 * @var string
	 */
	public $type = '{CONTROLLER_NAME_UCFIRST}_List';

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

	/**
	 * Set the published column name in table.
	 *
	 * @var string
	 */
	protected $published_field = 'published';

	/**
	 * Set the ordering column name in table.
	 *
	 * @var string
	 */
	protected $ordering_field = null;
}
