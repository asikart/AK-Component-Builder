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
 * View to edit
 */
class {COMPONENT_NAME_UCFIRST}View{CONTROLLER_NAME_UCFIRST} extends AKView
{
	protected $state;
	protected $item;
	protected $form;
	
	public	$list_name = '{CONTROLLER_NAMES}' ;
	public	$item_name = '{CONTROLLER_NAME}' ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->canDo	= {COMPONENT_NAME_UCFIRST}Helper::getActions();

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
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title( '{CONTROLLER_NAME_UCFIRST}' . ' ' . JText::_('COM_{COMPONENT_NAME_UC}_TITLE_ITEM_EDIT'), 'article-add.png');

		JToolBarHelper::apply('{CONTROLLER_NAME}.apply');
		JToolBarHelper::save('{CONTROLLER_NAME}.save');
		JToolBarHelper::custom('{CONTROLLER_NAME}.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		JToolBarHelper::custom('{CONTROLLER_NAME}.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		JToolBarHelper::cancel('{CONTROLLER_NAME}.cancel');
	}
}
