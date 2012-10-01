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
	
	
	/**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   11.1
     */
	
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
	
	
	/**
     * Method to run batch operations.
     *
     * @param   object  $model  The model of the component being processed.
     *
     * @return    boolean     True if successful, false otherwise and internal error is set.
     *
     * @since    11.1
     */
	
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel();

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
	
	
	/**
     * Gets the URL arguments to append to an item redirect.
     *
     * @param   integer  $recordId  The primary key id for the item.
     * @param   string   $urlVar    The name of the URL variable for the id.
     *
     * @return  string  The arguments to append to the redirect URL.
     *
     * @since   11.1
     */
	
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
	
	
	/**
     * Gets the URL arguments to append to a list redirect.
     *
     * @return  string  The arguments to append to the redirect URL.
     *
     * @since   11.1
     */
	
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
	
	
	/**
     * Function that allows child controller access to model data
     * after the data has been saved.
     *
     * @param   JModel  &$model     The data model object.
     * @param   array   $validData  The validated data.
     *
     * @return  void 
     *
     * @since   11.1
     */
	
	protected function postSaveHook( &$model, $validData = array())
    {
		
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