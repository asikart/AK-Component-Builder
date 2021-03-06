<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

include_once AKPATH_COMPONENT . '/modellist.php';

/**
 * Methods supporting a list of {COMPONENT_NAME_UCFIRST} records.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAMES_UCFIRST} extends AKModelList
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var     string
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_{COMPONENT_NAME_UC}';

	/**
	 * The Component name.
	 *
	 * @var    string
	 */
	protected $component = '{COMPONENT_NAME}';

	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 */
	protected $item_name = '{CONTROLLER_NAME}';

	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 */
	protected $list_name = '{CONTROLLER_NAMES}';

	/**
	 * The URL view list to request remote data (only use in API system).
	 *
	 * @var    string
	 */
	public $request_item = '';

	/**
	 * The URL view item to request remote data (only use in API system).
	 *
	 * @var    string
	 */
	public $request_list = '';

	/**
	 * The default method to call. (only use in API system).
	 *
	 * @var    string
	 */
	public $default_method = 'getItems';

	/**
	 * Constructor.
	 *
	 * @param    array  $config  An optional associative array of configuration settings.
	 *
	 * @see      JController
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
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'filter_order_Dir', 'filter_order', '*'
			);

			$config['filter_fields'] = {COMPONENT_NAME_UCFIRST}Helper::_('db.mergeFilterFields', $config['filter_fields'], $config['tables']);
		}

		// Other settings
		// ========================================================================
		$config['fulltext_search'] = true;

		$config['core_sidebar'] = false;

		$this->config = $config;

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param  null  $ordering   Default ordering.
	 * @param  null  $direction  Default direction.
	 *
	 * @return void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Set First order field
		$this->setState('list.orderingPrefix', array( /*'a.catid'*/));

		parent::populateState($ordering, 'asc');
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Get some data
		// ========================================================================

		// Create a new query object.
		$db       = $this->getDbo();
		$q        = $db->getQuery(true);
		$order    = $this->getState('list.ordering', 'a.id');
		$dir      = $this->getState('list.direction', 'asc');
		$prefix   = $this->getState('list.orderingPrefix', array());
		$orderCol = $this->getState('list.orderCol', 'a.ordering');

		// Filter and Search
		$filter = $this->getState('filter', array());
		$search = $this->getState('search');
		$wheres = $this->getState('query.where', array());
		$having = $this->getState('query.having', array());

		$layout    = JRequest::getVar('layout');
		$nested    = $this->getState('items.nested');
		$avoid     = JRequest::getVar('avoid');
		$show_root = JRequest::getVar('show_root');

		// Nested
		// ========================================================================
		if ($nested && !$show_root)
		{
			$q->where("a.id != 1");
		}

		if ($avoid)
		{
			$table = $this->getTable();
			$table->load($avoid);

			$q->where("a.lft < {$table->lft} OR a.rgt > {$table->rgt}");
			$q->where("a.id != {$avoid}");
		}

		// Search
		// ========================================================================
		$q = $this->searchCondition($search, $q);

		// Filter
		// ========================================================================
		$q = $this->filterCondition($filter, $q);

		// Published
		if (empty($filter['a.published']))
		{
			$q->where("{$db->qn('a.published')} >= 0");
		}

		// Ordering
		// ========================================================================
		if ($orderCol == $order)
		{
			$prefix = count($prefix) ? implode(', ', $prefix) . ', ' : '';
		}
		else
		{
			$prefix = '';
		}

		$order = $db->qn($order);

		// Custom Where
		// ========================================================================
		foreach ($wheres as $k => $v)
		{
			$q->where($v);
		}

		// Custom Having
		// ========================================================================
		foreach ($having as $k => $v)
		{
			$q->having($v);
		}

		// Build query
		// ========================================================================

		// Get select columns
		$select = {COMPONENT_NAME_UCFIRST}Helper::_('db.getSelectList', $this->config['tables']);

		// Build query
		$q->select($select)
			->from('#__{COMPONENT_NAME}_{CONTROLLER_NAMES} AS a')
			->leftJoin('#__categories  AS b ON a.catid = b.id')
			->leftJoin('#__users       AS c ON a.created_by = c.id')
			->leftJoin('#__viewlevels  AS d ON a.access = d.id')
			->leftJoin('#__languages   AS e ON a.language = e.lang_code')
			// ->where("")
			->order("{$prefix}{$order} {$dir}");

		return $q;
	}

	/**
	 * Set search condition to support multiple search inputs.
	 *
	 * @param   array          $search Search fields and values.
	 * @param   JDatabaseQuery $q      The query object.
	 * @param   array          $ignore An array for ignore fields.
	 *
	 * @return  JDatabaseQuery
	 */
	public function searchCondition($search, $q = null, $ignore = array())
	{
		// Set ignore fields, and you can set yourself search later.
		if (!$ignore)
		{
			$ignore = array(// 'a.title',
				// 'b.title'
			);
		}

		$q = parent::searchCondition($search, $q, $ignore);

		// Do some another filter here

		return $q;
	}

	/**
	 * Set query filter.
	 *
	 * @param   array          $filter Filter fields and values.
	 * @param   JDatabaseQuery $q      The query object.
	 * @param   array          $ignore An array for ignore fields.
	 *
	 * @return  type
	 */
	public function filterCondition($filter, $q = null, $ignore = array())
	{
		// Set ignore fields, and you can set yourself filter later.
		if (!$ignore)
		{
			$ignore = array(// 'a.published',
				// 'b.id'
			);
		}

		$q = parent::filterCondition($filter, $q, $ignore);

		// Do some another filter here

		return $q;
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    $type     The table type to instantiate
	 * @param   string  $prefix   A prefix for the table class name. Optional.
	 * @param   array   $config   Configuration array for model. Optional.
	 *
	 * @return  JTable  A database object.
	 *
	 * @since   1.6
	 */
	public function getTable($type = null, $prefix = null, $config = array())
	{
		return parent::getTable($type, $prefix, $config);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string $id A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		return parent::getStoreId($id);
	}

	/**
	 * Method to get list page filter form.
	 *
	 * @return   object  JForm object.
	 *
	 * @since    2.5
	 */

	public function getFilter()
	{
		$filter = parent::getFilter();

		return $filter;
	}
}
