<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * {CONTROLLER_NAME_UCFIRST} controller class.
 */
class {COMPONENT_NAME_UCFIRST}Controller{CONTROLLER_NAME_UCFIRST} extends JControllerForm
{
	
	public $view_list = '{CONTROLLER_NAMES}' ;
	public $view_item = '{CONTROLLER_NAME}' ;
	
	public $redirect ;
	
    function __construct() {
		
		$this->allow_url_params = array(
			'return'
		);
		
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = '{CONTROLLER_NAME_UCFIRST}', $prefix = '{COMPONENT_NAME_UCFIRST}Model', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel();

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
	
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$append = parent::getRedirectToItemAppend($recordId , $urlVar );
		
		foreach( $this->allow_url_params as $param ):
			if(JRequest::getVar($param)){
				$append .= "&{$param}=" . JRequest::getVar($param) ;
			}
		endforeach;
		
		return $append ;
	}
	
	protected function getRedirectToListAppend()
	{
		$append = parent::getRedirectToListAppend();
		
		foreach( $this->allow_url_params as $param ):
			if(JRequest::getVar($param)){
				$append .= "&{$param}=" . JRequest::getVar($param) ;
			}
		endforeach;
		
		return $append ;
	}
	
	protected function postSaveHook( &$model, $validData = array())
    {
		
    }
	
	
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