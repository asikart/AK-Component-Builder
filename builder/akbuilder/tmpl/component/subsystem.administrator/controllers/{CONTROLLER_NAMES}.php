<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;


include_once JPATH_ADMINISTRATOR.'/components/com_{COMPONENT_NAME}/class/component/controlleradmin.php' ;

/**
 * {CONTROLLER_NAMES_UCFIRST} list controller class.
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAMES_UCFIRST} extends AKControllerAdmin
{
	public $view_list = '{CONTROLLER_NAMES}' ;
	public $view_item = '{CONTROLLER_NAME}' ;
	public $component = '{COMPONENT_NAME}';
	
	
	
	/**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   11.1
     */
	
    function __construct() {
		
		$this->redirect_tasks = array(
			'save', 'cancel', 'publish', 'unpublish', 'delete'
		);
		
        parent::__construct();
    }
}