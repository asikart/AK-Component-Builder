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
	public	$sort_fields ;

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
		
		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal') {
			$this->addToolbar();
			
			if( JVERSION >= 3 ){
				$this->sidebar = JHtmlSidebar::render();
			}
		}
		
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
		$user 	= JFactory::getUser() ;
		$filter_state 	= $this->state->get('filter') ;
		
        // Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		
		JToolBarHelper::title( ucfirst($this->getName()) . ' ' . JText::_('COM_{COMPONENT_NAME_UC}_TITLE_LIST'), 'article.png');
       
		
		// Toolbar Buttons
		// ========================================================================
		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 ) {
			JToolBarHelper::addNew( $this->item_name.'.add');
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList( $this->item_name.'.edit');
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish( $this->list_name.'.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish( $this->list_name.'.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::checkin($this->list_name.'.checkin');
			JToolBarHelper::divider();
		}
		
		if ($filter_state['a.published'] == -2 && $canDo->get('core.delete')) {
			JToolbarHelper::deleteList('Are you sure?', $this->list_name.'.delete');
		}
		elseif ($canDo->get('core.edit.state')) {
			JToolbarHelper::trash($this->list_name.'.trash');
		}
		
		// Add a batch modal button
		if ($user->authorise('core.edit') && JVERSION >= 3)
		{
			AKToolbarHelper::modal( 'JTOOLBAR_BATCH', 'batchModal');
		}
		
		if ($canDo->get('core.admin')) {
			AKToolBarHelper::preferences('com_{COMPONENT_NAME}');
		}
		
		
		
		// Sidebar Filters
		// ========================================================================
		if( JVERSION >= 3 ){
			
			JHtmlSidebar::setAction('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}');
			
			$filters 		= $this->filter['filter_sidebar'] ;
			
			foreach( $filters as $filter ):
				
				$options = array();
				$i = 0 ;
				foreach( $filter->option as $option ):
					$options[$i]['value'] 	= (string) $option['value'] ;
					$options[$i]['text'] 	= (string) $option ;
					$i++ ;
				endforeach;
				
				
				JHtmlSidebar::addFilter(
					(string) $filter['title'],
					(string) 'filter['.$filter['name'].']',
					JHtml::_('select.options', $options, 'value', 'text', $filter_state[(string)$filter['name']], true)
				);
			endforeach;
			
		}
		
	}
	
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		$this->sort_fields = array(
			'a.ordering' 		=> JText::_('JGRID_HEADING_ORDERING'),
			'a.published' 		=> JText::_('JPUBLISHED'),
			'a.title' 			=> JText::_('JGLOBAL_TITLE'),
			'b.title' 			=> JText::_('JCATEGORY'),
			'd.title' 			=> JText::_('JGRID_HEADING_ACCESS'),
			'a.created_by' 		=> JText::_('JAUTHOR'),
			'e.title' 			=> JText::_('JGRID_HEADING_LANGUAGE'),
			'a.created' 		=> JText::_('JDATE'),
			'a.id' 				=> JText::_('JGRID_HEADING_ID')
		);
		
		return $this->sort_fields ;
	}
	
	
	
	
	/*
	 * function renderGrid
	 * @param $table
	 */
	
	public function renderGrid($table, $option = array())
	{
		// Set Grid
		// =================================================================================
		$grid = new JGrid();
		
		$grid->setTableOptions($option);
		$grid->setColumns( array_keys($table['thead']['tr'][0]['th']) ) ;
		
		
		
		// Thead
		// =================================================================================
		$grid->addRow($table['thead']['tr'][0]['option'], 1) ;
		
		foreach( $table['thead']['tr'][0]['th'] as $key => $th ):
			$grid->setRowCell($key, $th['content'] , $th['option']);
		endforeach;
		
		
		
		// Tbody
		// =================================================================================
		foreach( $table['tbody']['tr'] as $tr ):
			
			$grid->addRow($tr['option']) ;
			
			foreach( $tr['td'] as $key2 => $td ):
				
				$grid->setRowCell($key2, $td['content'] , $td['option']);
				
			endforeach;
			
		endforeach;
		
		
		return $grid ;
	}
}
