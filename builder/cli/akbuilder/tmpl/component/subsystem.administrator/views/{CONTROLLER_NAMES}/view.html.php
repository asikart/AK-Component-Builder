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

jimport('joomla.application.component.view');

/**
 * View class for a list of {COMPONENT_NAME_UCFIRST}.
 */
class {COMPONENT_NAME_UCFIRST}View{CONTROLLER_NAMES_UCFIRST} extends AKView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public	$list_name = '{CONTROLLER_NAMES}' ;
	public	$item_name = '{CONTROLLER_NAME}' ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->filter		= $this->get('Filter');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		
		// if is frontend, show toolbar
		if($app->isAdmin())	{
			parent::display($tpl);
		}else{
			parent::displayWithPanel($tpl);
		}
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= {COMPONENT_NAME_UCFIRST}Helper::getActions();

		JToolBarHelper::title( ucfirst($this->getName()) . ' ' . JText::_('COM_{COMPONENT_NAME_UC}_TITLE_LIST'), 'article.png');
		
        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/'.$this->item_name;
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew( $this->item_name.'.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit')) {
			    JToolBarHelper::editList( $this->item_name.'.edit','JTOOLBAR_EDIT');
		    }
        }
		
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('Are you sure?', $this->list_name.'.delete');
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish( $this->list_name.'.publish', 'JTOOLBAR_ENABLE', true);
			JToolBarHelper::unpublish( $this->list_name.'.unpublish', 'JTOOLBAR_DISABLE', true);
			JToolBarHelper::custom( $this->list_name.'.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			JToolBarHelper::divider();
		}
		
		if ($canDo->get('core.admin')) {
			AKToolBarHelper::preferences('com_{COMPONENT_NAME}');
		}

	}
}
