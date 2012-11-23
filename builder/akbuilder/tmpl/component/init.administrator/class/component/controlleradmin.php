<?php
/**
 * @package     Windwalker.Framework
 * @subpackage  class
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;


jimport('joomla.application.component.controlleradmin');


class AKControllerAdmin extends JControllerAdmin
{
	
	public $view_list ;
	public $view_item ;
	public $component ;
	
	
	/**
     * Method to get a model object, loading it if required.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   11.1
     */
	public function getModel($name = null, $prefix = null, $config = array('ignore_request' => true))
	{
		$name = $name ? $name : ucfirst($this->view_item) ;
		$prefix = $prefix ? $prefix : ucfirst($this->component).'Model' ;
		return parent::getModel($name, $prefix, $config);
	}
	
	
	
	/**
	 * Rebuild the nested set tree.
	 *
	 * @return	bool	False on failure or error, true on success.
	 * @since	1.6
	 */
	public function rebuild()
	{
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$extension = JRequest::getCmd('extension');
		$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));

		// Initialise variables.
		$model = $this->getModel();

		if ($model->rebuild()) {
			// Rebuild succeeded.
			$this->setMessage(JText::_('JTOOLBAR_REBUILD_SUCCESS'));
			return true;
		} else {
			// Rebuild failed.
			$this->setMessage(JText::_('JLIB_DATABASE_ERROR_REBUILD_FAILED'));
			return false;
		}
	}
	
	
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return	void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$pks 	= $this->input->post->get('cid', array(), 'array');
		$order 	= $this->input->post->get('order', array(), 'array');
		
		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);
		
		foreach( $order as &$row ):
			if($row < 0) $row = -$row ;
		endforeach;
		
		if(JDEBUG){
			echo 'IDS: ' ;
			print_r($pks) ;
			echo 'ORDER: ' ;
			print_r($order) ;
		}
		
		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "Order OK.";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
	
	
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return	void
	 *
	 * @since   3.0
	 */
	public function saveOrderNestedAjax()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get the arrays from the Request
		$pks   = $this->input->post->get('cid', null, 'array');
		$order = $this->input->post->get('order', null, 'array');
		$originalOrder = explode(',', $this->input->getString('original_order_values'));
		
		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);
		
		foreach( $order as &$row ):
			if($row < 0) $row = -$row ;
		endforeach;
		
		if(JDEBUG){
			echo 'IDS: ' ;
			print_r($pks) ;
			echo 'ORDER: ' ;
			print_r($order) ;
		}
		
		// Make sure something has changed
		if (!($order === $originalOrder)) {
			// Get the model
			$model = $this->getModel();
			// Save the ordering
			$return = $model->saveorderNested($pks, $order);
			if ($return)
			{
				echo "Nested order OK.";
			}
		}
		// Close the application
		JFactory::getApplication()->close();

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
		$redirect_tasks = $this->redirect_tasks ;
		
		if(!$this->redirect){
			$this->redirect = AKComponentHelper::_('uri.base64', 'decode', JRequest::getVar('return')) ;
		}
		
        if ($this->redirect && in_array($task, $redirect_tasks)){
            return parent::setRedirect($this->redirect, $msg, $type) ;
        }else{
			return parent::setRedirect($url, $msg, $type) ;
		}
    }
}