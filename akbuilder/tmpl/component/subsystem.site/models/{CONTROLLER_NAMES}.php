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

include_once AKPATH_COMPONENT.'/modellist.php' ;

/**
 * Methods supporting a list of {COMPONENT_NAME_UCFIRST} records.
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAMES_UCFIRST} extends AKModelList
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected 	$text_prefix = 'COM_{COMPONENT_NAME_UC}';
	
	public 		$component = '{COMPONENT_NAME}' ;
	public 		$item_name = '{CONTROLLER_NAME}' ;
	public 		$list_name = '{CONTROLLER_NAMES}' ;
	
	
    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
		
		// Set query tables
		// ========================================================================
		$config['tables'] = array(
				'a' => '#__{COMPONENT_NAME}_{CONTROLLER_NAMES}',
				'b' => '#__categories',
				'c' => '#__users',
				'd' => '#__viewlevels',
				'e' => '#__languages'
			);
		
		
		
		// Set filter fields
		// ========================================================================
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter'
            );
			
			$config['filter_fields'] = {COMPONENT_NAME_UCFIRST}Helper::_('db.mergeFilterFields', $config['filter_fields'] , $config['tables'] );
        }
		
		
		
		$this->config = $config ;

        parent::__construct($config);
    }
	
	
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = null, $prefix = null, $config = array())
	{
		return parent::getTable( $type , $prefix , $config );
	}
	


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app 	= JFactory::getApplication();
		$user 	= JFactory::getUser() ;
		$pk		= JRequest::getInt('id');

		$this->setState('category.id', $pk);

		
		
		// Load the parameters. Merge Global and Menu Item params into new object
		// =====================================================================================
		$comParams = $app->getParams();
		$menuParams = new JRegistry;

		if ($menu = $app->getMenu()->getActive()) {
			$menuParams->loadString($menu->params);
		}
		
		$mergedParams = clone $menuParams;
		$mergedParams->merge($comParams);

		$this->setState('params', $mergedParams);
		$params = $mergedParams ;
		
		// Set ViewLevel and user groups
		$groups	= implode(',', $user->getAuthorisedViewLevels());
		
		$this->setState('access.group', $groups);
		
		
		
		// List state information.
		// =====================================================================================
		$itemid = JRequest::getInt('id', 0) . ':' . JRequest::getInt('Itemid', 0);
		$this->setState('layout', JRequest::getCmd('layout'));
		
		
		// Order
		// =====================================================================================
		$orderCol = $params->get('orderby', 'a.ordering');
		$this->setState('list.ordering', $orderCol);
		
		
		
		// Order Dir
		// =====================================================================================
		$listOrder = $params->get('order_dir', 'asc');
		$this->setState('list.direction', $listOrder);
		
		
		
		// Limitstart
		// =====================================================================================
		$this->setState('list.start', JRequest::getUInt('limitstart', 0));

		
		
		// Limit
		// =====================================================================================
		$num_leading 	= $params->get('num_leading_articles', 1) ;
		$num_intro		= $params->get('num_intro_articles', 4) ;
		$num_links		= $params->get('num_links', 4);
		$limit = $num_leading + $num_intro + $num_links ;
		
		$this->setState('list.num_leading', $num_leading);
		$this->setState('list.num_intro', $num_intro);
		$this->setState('list.num_links', $num_links);
		$this->setState('list.links', $num_links);
		$this->setState('list.limit', $limit);

		
		
		// Max Level
		// =====================================================================================
		$maxLevel = $params->get('maxLevel');

		if ($maxLevel) {
			$this->setState('filter.max_category_levels', $maxLevel);
		}
		
		
		
		// Edit Access
		// =====================================================================================
		if (($user->authorise('core.edit.state', 'com_{COMPONENT_NAME}')) ||  ($user->authorise('core.edit', 'com_{COMPONENT_NAME}'))){
			// filter on published for those who do not have edit or edit.state rights.
			$this->setState('filter.unpublished', 1);
		}
		
		
		
		// View Level
		// =====================================================================================
		if (!$params->get('show_noauth')) {
			$this->setState('filter.access', true);
		}
		else {
			$this->setState('filter.access', false);
		}
		
		
		
		// Language
		// =====================================================================================
		$this->setState('filter.language', $app->getLanguageFilter());
		
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . json_encode($this->getState());

		return parent::getStoreId($id);
	}
	
	
	/**
	 * Method to get list page filter form.
	 *
	 * @return	object		JForm object.
	 * @since	2.5
	 */
	
	public function getFilter()
	{
		//$filter = parent::getFilter();
		
		//return $filter ;
	}
	
	

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$q		= $db->getQuery(true);
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');
		$date   = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user   = JFactory::getUser() ;
		
		
		// Filter and Search
		$filter = $this->getState('filter',	array()) ;
		$search = $this->getState('search', array()) ;
		$wheres = $this->getState('query.where', array()) ;
		$having = $this->getState('query.having', array()) ;
		
		
		
		// Category
		// =====================================================================================
		$category = $this->getCategory() ;
		if( in_array('b.lft', $this->filter_fields) && in_array('b.rgt', $this->filter_fields) ){
			$q->where("( b.lft >= {$category->lft} AND b.rgt <= {$category->rgt} )") ;
		}
		
		
		
		// Max Level
		// =====================================================================================
		$maxLevel = $this->getState('filter.max_category_levels', -1);
		
		if($maxLevel > 0){
			$q->where("b.level <= {$maxLevel}");
		}
		
		
		
		// Edit Access
		// =====================================================================================
		if($this->getState('filter.unpublished')){
			$q->where('a.published >= 0') ;
		}else{
			$q->where('a.published > 0') ;
			
			$nullDate = $db->Quote($db->getNullDate());
			$nowDate = $db->Quote($date->toSQL(true));
			
			if( in_array('a.publish_up', $this->filter_fields) && in_array('a.publish_down', $this->filter_fields) ){
				$q->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
				$q->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
			}
		}
		
		
		
		// View Level
		// =====================================================================================
		if ($access = $this->getState('filter.access') && in_array('a.access', $this->filter_fields)) {
			$groups	= implode(',', $user->getAuthorisedViewLevels());
			$q->where('a.access IN ('.$groups.')');
		}
		
		
		
		// Language
		// =====================================================================================
		if ($this->getState('filter.language') && in_array('a.language', $this->filter_fields)) {
			$lang_code = $db->quote( JFactory::getLanguage()->getTag() ) ;
			$q->where("a.language IN ('{$lang_code}', '*')");
		}
		
		
		
		// Filter
		// ========================================================================
		foreach($filter as $k => $v ){
			if($v !== '' && $v != '*' && in_array($k, $this->filter_fields)){
				$k = $db->qn($k);
				$q->where("{$k}='{$v}'") ;
			}
		}
		
		
		
		// Search
		// ========================================================================
		$searc_where = array();
		foreach($search as $k => $v ){
			if(in_array($k, $this->filter_fields)){
				$k = $db->qn($k);
				$searc_where[] = "{$k} LIKE '{$v}'" ;
			}
		}
		if(count($searc_where)){
			$q->where( ' ( ' .implode(' OR ', $searc_where) . ' ) ');
		}
		
		
		
		// Custom Where
		// ========================================================================
		foreach($wheres as $k => $v ){
			$q->where($v) ;
		}
		
		
		
		// Custom Having
		// ========================================================================
		foreach($having as $k => $v ){
			$q->having($v) ;
		}
		
		
		
		// get select columns
		$select = {COMPONENT_NAME_UCFIRST}Helper::_( 'db.getSelectList', $this->config['tables'] );
		
		//build query
		$q->select($select)
			->from('#__{COMPONENT_NAME}_{CONTROLLER_NAMES} AS a')
			->leftJoin('#__categories 	AS b ON a.catid = b.id')
			->leftJoin('#__users 		AS c ON a.created_by = c.id')
			->leftJoin('#__viewlevels 	AS d ON a.access = d.id')
			->leftJoin('#__languages 	AS e ON a.language = e.lang_code')
			//->where("")
			->order( " {$order} {$dir}" ) ;
		
		return $q;
	}
}
