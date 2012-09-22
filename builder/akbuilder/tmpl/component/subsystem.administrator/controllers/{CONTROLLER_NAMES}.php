<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * {CONTROLLER_NAMES_UCFIRST} list controller class.
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAMES_UCFIRST} extends JControllerAdmin
{
	public $view_list = '{CONTROLLER_NAMES}' ;
	public $view_item = '{CONTROLLER_NAME}' ;
	
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = '{CONTROLLER_NAME}', $prefix = '{COMPONENT_NAME_UCFIRST}Model')
	{
		$model = parent::getModel($name, $prefix, array());
		return $model;
	}
	
	
	/**
     * Set a URL for browser redirection.
     *
     * @param   string  $url   URL to redirect to.
     * @param   string  $msg   Message to display on redirect. Optional, defaults to value set internally by controller, if any.
     * @param   string  $type  Message type. Optional, defaults to 'message' or the type set by a previous call to setMessage.
     *
     * @return  JController  This object to support chaining.
     *
     * @since   11.1
     */
	
	public function setRedirect($url, $msg = null, $type = null)
    {
		$task  = $this->getTask() ;
		$redirect_tasks = array('save', 'cancel', 'publish', 'unpublish', 'delete');
		
		if(!$this->redirect){
			$this->redirect = base64_decode(JRequest::getVar('return')) ;
		}
		
        if ($this->redirect && in_array($task, $redirect_tasks)){
            return parent::setRedirect($this->redirect, $msg, $type) ;
        }else{
			return parent::setRedirect($url, $msg, $type) ;
		}
    }
}