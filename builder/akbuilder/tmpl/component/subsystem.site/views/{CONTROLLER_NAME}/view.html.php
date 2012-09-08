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
		$app 	= JFactory::getApplication() ;
		$user 	= JFactory::getUser() ;
		
		$this->state	= $this->get('State');
		$this->params	= $this->state->get('params');
		$this->item		= $this->get('Item');
		$this->category	= $this->get('Category');
		$this->canDo	= {COMPONENT_NAME_UCFIRST}Helper::getActions();
		
		$layout = $this->getLayout();
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		if( $layout == 'edit' ) {
			$this->form	= $this->get('Form');
			$this->addToolbar();
			
			parent::displayWithPanel($tpl);
			return true ; 
		}
		
		
		// Dsplay Data
		// =====================================================================================
		$item = $this->item ;
		$item->link = JRoute::_("index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAME}&id={$item->id}&alias={$item->alias}&catid={$item->catid}");
		$item->created_user = JFactory::getUser($item->created_by)->get('name') ;
		$item->cat_title = $this->category->title ;
		
		
		
		// Can Edit
		// =====================================================================================
		if (!$user->get('guest')) {
			$userId	= $user->get('id');
			$asset	= 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->id;

			// Check general edit permission first.
			if ($user->authorise('core.edit', $asset)) {
				$this->params->set('access-edit', true);
			}
			// Now check if edit.own is available.
			elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
				// Check for a valid user and that they are the owner.
				if ($userId == $item->created_by) {
					$this->params->set('access-edit', true);
				}
			}
		}
		
		
		
		// View Level
		// =====================================================================================
		if ($access = $this->state->get('filter.access')) {
			// If the access filter has been set, we already know this user can view.
			$this->params->set('access-view', true);
		}
		else {
			// If no access filter is set, the layout takes some responsibility for display of limited information.
			$user = JFactory::getUser();
			$groups = $user->getAuthorisedViewLevels();

			if ($item->catid == 0 || $this->category->access === null) {
				$this->params->set('access-view', in_array($item->access, $groups));
			}
			else {
				$this->params->set('access-view', in_array($item->access, $groups) && in_array($this->category->access, $groups));
			}
		}
		
		
		// Publish Date
		// =====================================================================================
		$pup = JFactory::getDate( $item->publish_up , JFactory::getConfig()->get('offset') )->toUnix(true) ;
		$pdw = JFactory::getDate( $item->publish_down , JFactory::getConfig()->get('offset') )->toUnix(true) ;
		$now = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->toUnix(true) ;
		$null= JFactory::getDate( '0000-00-00 00:00:00' , JFactory::getConfig()->get('offset') )->toUnix(true) ;
		
		if( ($now < $pup && $pup != $null)  || ( $now > $pdw && $pdw != $null ) ) {
			$item->published = 0 ;
		}
		
		
		
		// Plugins
		// =====================================================================================
		$dispatcher	= JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		
		$item->text = $this->params->get('show_intro', 1) ? $item->introtext. $item->fulltext = $item->fulltext : $item->fulltext ;
		$results = $dispatcher->trigger('onContentPrepare', array ('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));

		$item->event = new stdClass();
		$results = $dispatcher->trigger('onContentAfterTitle', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentAfterDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->afterDisplayContent = trim(implode("\n", $results));
		
		
		
		// Params
		// =====================================================================================
		// Merge {CONTROLLER_NAME} params. If this is single-{CONTROLLER_NAME} view, menu params override article params
		// Otherwise, {CONTROLLER_NAME} params override menu item params
		$active	= $app->getMenu()->getActive();
		$temp	= clone ($this->params);
		
		
		// Check to see which parameters should take priority
		if ($active) {
			$currentLink = $active->link;
			
			// If the current view is the active item and an {CONTROLLER_NAME} view for this {CONTROLLER_NAME}, then the menu item params take priority
			if (strpos($currentLink, 'view={CONTROLLER_NAME}') && (strpos($currentLink, '&id='.(string) $item->id))) {
				// $item->params are the {CONTROLLER_NAME} params, $temp are the menu item params
				// Merge so that the menu item params take priority
				$this->params->merge($temp);
				
				// Load layout from active query (in case it is an alternative menu item)
				if (isset($active->query['layout'])) {
					$this->setLayout($active->query['layout']);
				}
			}else {
				// Current view is not a single {CONTROLLER_NAME}, so the {CONTROLLER_NAME} params take priority here
				// Merge the menu item params with the {CONTROLLER_NAME} params so that the {CONTROLLER_NAME} params take priority
				$temp->merge($this->params);
				$this->params = $temp;

				// Check for alternative layouts (since we are not in a single-{CONTROLLER_NAME} menu item)
				// Single-{CONTROLLER_NAME} menu item layout takes priority over alt layout for an {CONTROLLER_NAME}
				if ($layout = $this->params->get('{CONTROLLER_NAME}_layout')) {
					$this->setLayout($layout);
				}
			}
			
		}
		else {
			// Merge so that article params take priority
			$temp->merge($this->params);
			$this->params = $temp;
			
			// Check for alternative layouts (since we are not in a single-article menu item)
			// Single-article menu item layout takes priority over alt layout for an article
			if ($layout = $this->params->get('{CONTROLLER_NAME}_layout')) {
				$this->setLayout($layout);
			}
		}
		
		$item->params = $this->params ;
		
		
		
		parent::display($tpl);
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
	
	
	/*
	 * function showInfo
	 * @param $key
	 */
	
	public function showInfo( $item, $key = null, $label = null, $strip = true, $link = null ,$class = null)
	{
		if(empty($item->$key)){
			return false ;
		}
		
		$lang  = $strip ? substr($key, 2) : $key ;
		
		if(!$label){
			$label = JText::_('COM_{COMPONENT_NAME_UC}_'.strtoupper($lang)) ;
		}else{
			$label = JText::_(strtoupper($label)) ;
		}
		
		$value = $item->$key ;
		
		if($link){
			$value = JHtml::_('link', $link, $value);
		}
		
		$lang = str_replace( '_', '-', $lang );
		
		$info =
<<<INFO
		<div class="{$lang} {$class}" fltlft">
			<span class="label">{$label}:</span>
			<span class="valur">{$value}</span>
		</div>
INFO;
		return $info ;
	}
}
