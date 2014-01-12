<?php
/**
 * Part of joomla321 project. 
 *
 * @copyright  Copyright (C) 2011 - 2013 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

use Windwalker\Table\Table;

class {COMPONENT_NAME_UCFIRST}Table{CONTROLLER_NAME_UCFIRST} extends Table
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('#__{COMPONENT_NAME}_{CONTROLLER_NAMES}');
	}
}
