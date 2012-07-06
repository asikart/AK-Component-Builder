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
class {COMPONENT_NAME_UCFIRST}View{CONTROLLER_NAME_UCFIRST}s extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
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
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= {COMPONENT_NAME_UCFIRST}Helper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_{COMPONENT_NAME_UC}_TITLE_{CONTROLLER_NAME_UC}S'), '{CONTROLLER_NAME}s.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'{CONTROLLER_NAME}';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('{CONTROLLER_NAME}.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit')) {
			    JToolBarHelper::editList('{CONTROLLER_NAME}.edit','JTOOLBAR_EDIT');
			    JToolBarHelper::deleteList('', '{CONTROLLER_NAME}s.delete','JTOOLBAR_EMPTY_TRASH');
		    }
        }

		if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::divider();
			    JToolBarHelper::publish('{CONTROLLER_NAME}s.publish', 'JTOOLBAR_ENABLE', true);
				JToolBarHelper::unpublish('{CONTROLLER_NAME}s.unpublish', 'JTOOLBAR_DISABLE', true);
            	JToolBarHelper::custom('{CONTROLLER_NAME}s.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
        
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_{COMPONENT_NAME}');
		}

	}
}
