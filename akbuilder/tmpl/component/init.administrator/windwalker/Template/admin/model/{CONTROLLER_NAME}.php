<?php

use Windwalker\Model\AdminModel;

/**
 * Class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAME_UCFIRST}
 *
 * @since 1.0
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAME_UCFIRST} extends AdminModel
{
	/**
	 * Method to set new item ordering as first or last.
	 *
	 * @param   JTable $table    Item table to save.
	 * @param   string $position 'first' or other are last.
	 *
	 * @return  void
	 */
	public function setOrderPosition($table, $position = 'last')
	{
		parent::setOrderPosition($table, $position);
	}
}
