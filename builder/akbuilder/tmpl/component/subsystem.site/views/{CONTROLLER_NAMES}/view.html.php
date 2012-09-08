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
	
	public	$lead_items ;
	public	$intro_items ;
	public	$link_items ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state		= $this->get('State');
		$this->params		= $this->state->get('params');
		$this->category		= $this->get('Category');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->filter		= $this->get('Filter');

		
		
		// Check for errors.
		// =====================================================================================
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		
		
		// Set Data
		// =====================================================================================
		foreach( $this->items as &$item ):
			$item->link = JRoute::_("index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAME}&id={$item->a_id}&alias={$item->a_alias}&catid={$item->a_catid}");
			
			
			// Publish Date
			// =====================================================================================
			$pup = JFactory::getDate( $item->a_publish_up , JFactory::getConfig()->get('offset') )->toUnix(true) ;
			$pdw = JFactory::getDate( $item->a_publish_down , JFactory::getConfig()->get('offset') )->toUnix(true) ;
			$now = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->toUnix(true) ;
			$null= JFactory::getDate( '0000-00-00 00:00:00' , JFactory::getConfig()->get('offset') )->toUnix(true) ;
			
			if( ($now < $pup && $pup != $null)  || ( $now > $pdw && $pdw != $null ) ) {
				$item->a_published = 0 ;
			}
			
			
			// Plugins
			// =====================================================================================
			$item->event = new stdClass();

			$dispatcher = JDispatcher::getInstance();
			$item->text = $item->a_introtext ;
			$results = $dispatcher->trigger('onContentPrepare', array ('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));

			$results = $dispatcher->trigger('onContentAfterTitle', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$item->params, 0));
			$item->event->afterDisplayTitle = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$item->params, 0));
			$item->event->beforeDisplayContent = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onContentAfterDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$item->params, 0));
			$item->event->afterDisplayContent = trim(implode("\n", $results));
		
		endforeach;
		
		
		
		// Params
		// =====================================================================================
		$registry = new JRegistry ;
		$registry->loadString($this->category->params) ;
		$this->category->params = $registry ;
		
		
		
		// Count Leading, Items & Links Number
		// =====================================================================================
		$numLeading	= $this->params->def('num_leading_articles', 1);
		$numIntro	= $this->params->def('num_intro_articles', 4);
		$numLinks	= $this->params->def('num_links', 4);
		
		
		// For blog layouts, preprocess the breakdown of leading, intro and linked articles.
		// This makes it much easier for the designer to just interrogate the arrays.
		$max = count($this->items);

		// The first group is the leading articles.
		$limit = $numLeading;
		for ($i = 0; $i < $limit && $i < $max; $i++) {
			$this->lead_items[$i] = &$this->items[$i];
		}

		// The second group is the intro articles.
		$limit = $numLeading + $numIntro;
		// Order articles across, then down (or single column mode)
		for ($i = $numLeading; $i < $limit && $i < $max; $i++) {
			$this->intro_items[$i] = &$this->items[$i];
		}

		$this->columns = max(1, $this->params->def('num_columns', 1));
		$order = $this->params->def('multi_column_order', 1);

		$limit = $numLeading + $numIntro + $numLinks;
		// The remainder are the links.
		for ($i = $numLeading + $numIntro; $i < $limit && $i < $max;$i++)
		{
				$this->link_items[$i] = &$this->items[$i];
		}
		
		
		
		parent::display($tpl);
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
