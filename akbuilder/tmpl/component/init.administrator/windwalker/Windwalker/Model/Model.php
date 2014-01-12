<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Model;

use Joomla\DI\Container as JoomlaContainer;
use Joomla\DI\ContainerAwareInterface;

use Windwalker\DI\Container;

defined('JPATH_PLATFORM') or die;

/**
 * Prototype admin model.
 *
 * @package     Joomla.Libraries
 * @subpackage  Model
 * @since       3.2
 */
class Model extends \JModelDatabase implements ContainerAwareInterface
{
	/**
	 * The model (base) name
	 *
	 * @var    string
	 * @since  3.2
	 */
	protected $name = null;

	/**
	 * The URL option for the component.
	 *
	 * @var    string
	 * @since  3.2
	 */
	protected $option = null;

	/**
	 * Property component.
	 *
	 * @var string
	 */
	protected $component = null;

	/**
	 * Context string for the model type.  This is used to handle uniqueness
	 * when dealing with the getStoreId() method and caching data structures.
	 *
	 * @var    string
	 * @since  12.2
	 */
	protected $context = '';

	/**
	 * The event to trigger when cleaning cache.
	 *
	 * @var      string
	 * @since    12.2
	 */
	protected $eventCleanCache = null;

	/**
	 * Property container.
	 *
	 * @var
	 */
	protected $container;

	/**
	 * Constructor
	 *
	 * @param   array              $config    An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   JoomlaContainer    $container Service container.
	 * @param   \JRegistry         $state     The model state.
	 * @param   \JDatabaseDriver   $db        The database adpater.
	 *
	 * @throws \Exception
	 */
	public function __construct($config = array(), JoomlaContainer $container = null, \JRegistry $state = null, \JDatabaseDriver $db = null)
	{
		// Guess the option from the class name (Option)Model(View).
		if (empty($this->component))
		{
			$r = null;

			if (!preg_match('/(.*)Model/i', get_class($this), $r))
			{
				throw new \Exception(\JText::_('JLIB_APPLICATION_ERROR_MODEL_GET_NAME'), 500);
			}

			$this->component = strtolower($r[1]);
		}

		$this->option = 'com_' . $this->component;

		// Guess name
		if (!$this->name)
		{
			$this->name = \JArrayHelper::getValue($config, 'name', $this->getName());
		}

		// Register the paths for the form
		$this->registerTablePaths($config);

		// Set the clean cache event
		if (isset($config['event_clean_cache']))
		{
			$this->eventCleanCache = $config['event_clean_cache'];
		}
		elseif (empty($this->eventCleanCache))
		{
			$this->eventCleanCache = 'onContentCleanCache';
		}

		$this->container = $container ? : $this->getContainer();

		$state = new \JRegistry($config);

		parent::__construct($state, $db);

		// Guess the context as Option.ModelName.
		if (empty($this->context))
		{
			$this->context = strtolower($this->option . '.' . $this->getName());
		}

		// Set the internal state marker - used to ignore setting state from the request
		if (empty($config['ignore_request']))
		{
			// Protected method to auto-populate the model state.
			$this->populateState();
		}
	}

	/**
	 * Method to get the model name
	 *
	 * The model name. By default parsed using the classname or it can be set
	 * by passing a $config['name'] in the class constructor
	 *
	 * @return  string  The name of the model
	 *
	 * @since   3.2
	 * @throws  \Exception
	 */
	public function getName()
	{
		if (empty($this->name))
		{
			$r = null;

			if (!preg_match('/Model(.*)/i', get_class($this), $r))
			{
				throw new \Exception(\JText::_('JLIB_APPLICATION_ERROR_MODEL_GET_NAME'), 500);
			}

			$this->name = strtolower($r[1]);
		}

		return $this->name;
	}

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $name     The table name. Optional.
	 * @param   string  $prefix   The class prefix. Optional.
	 * @param   array   $options  Configuration array for model. Optional.
	 *
	 * @return  \JTable  A JTable object
	 *
	 * @since   3.2
	 * @throws  \Exception
	 */
	public function getTable($name = '', $prefix = '', $options = array())
	{
		if (empty($name))
		{
			$name = $this->getName();
		}

		if (empty($prefix))
		{
			$prefix = ucfirst($this->component) . 'Table';
		}

		if ($table = $this->createTable(ucfirst($name), $prefix, $options))
		{
			return $table;
		}

		throw new \Exception(\JText::sprintf('JLIB_APPLICATION_ERROR_TABLE_NAME_NOT_SUPPORTED', $name), 0);
	}

	/**
	 * Method to register paths for tables
	 *
	 * @param array $config
	 *
	 * @return  object  The property where specified, the state object where omitted
	 *
	 * @since   3.2
	 */
	public function registerTablePaths($config = array())
	{
		// Set the default view search path
		if (array_key_exists('table_path', $config))
		{
			$this->addTablePath($config['table_path']);
		}
		elseif (defined('JPATH_COMPONENT_ADMINISTRATOR'))
		{
			// Register the paths for the form
			$paths = new \SplPriorityQueue;
			$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/table', 'normal');

			// For legacy purposes. Remove for 4.0
			$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/tables', 'normal');
		}
	}

	/**
	 * setName
	 *
	 * @param $name
	 *
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = strtolower($name);

		return $this;
	}

	/**
	 * @param string $option
	 */
	public function setOption($option)
	{
		$this->option = $option;

		$this->component = substr($this->option, 4);

		return $this;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * @return  void
	 *
	 * @note    Calling getState in this method will result in recursion.
	 * @since   3.2
	 */
	protected function populateState()
	{
		$this->loadState();
	}

	/**
	 * Gets an array of objects from the results of database query.
	 *
	 * @param   string   $query       The query.
	 * @param   integer  $limitstart  Offset.
	 * @param   integer  $limit       The number of records.
	 *
	 * @return  array  An array of results.
	 *
	 * @since   12.2
	 * @throws  \RuntimeException
	 */
	public function getList($query, $limitstart = 0, $limit = 0)
	{
		$this->db->setQuery($query, $limitstart, $limit);

		$result = $this->db->loadObjectList();

		return $result;
	}

	/**
	 * Returns a record count for the query.
	 *
	 * @param   \JDatabaseQuery|string  $query  The query.
	 *
	 * @return  integer  Number of rows for query.
	 *
	 * @since   12.2
	 */
	public function getListCount($query)
	{
		// Use fast COUNT(*) on JDatabaseQuery objects if there no GROUP BY or HAVING clause:
		if ($query instanceof \JDatabaseQuery
			&& $query->type == 'select'
			&& $query->group === null
			&& $query->having === null)
		{
			$query = clone $query;
			$query->clear('select')->clear('order')->select('COUNT(*)');

			$this->db->setQuery($query);

			return (int) $this->db->loadResult();
		}

		// Otherwise fall back to inefficient way of counting all results.
		$this->db->setQuery($query);
		$this->db->execute();

		return (int) $this->db->getNumRows();
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   3.2
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->published != -2)
			{
				return false;
			}

			$user = \JFactory::getUser();

			return $user->authorise('core.delete', $this->option);
		}
	}

	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   3.2
	 */
	protected function canEditState($record)
	{
		$user = \JFactory::getUser();

		return $user->authorise('core.edit.state', $this->option);
	}

	/**
	 * Method to load and return a model object.
	 *
	 * @param   string  $name    The name of the view
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration settings to pass to JTable::getInstance
	 *
	 * @return  mixed  Model object or boolean false if failed
	 *
	 * @see     JTable::getInstance()
	 */
	protected function createTable($name, $prefix = 'Table', $config = array())
	{
		// Clean the model name
		$name   = preg_replace('/[^A-Z0-9_]/i', '', $name);
		$prefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);

		// Make sure we are returning a DBO object
		if (!array_key_exists('dbo', $config))
		{
			$config['dbo'] = $this->getDb();
		}

		return \JTable::getInstance($name, $prefix, $config);
	}

	/**
	 * Adds to the stack of model table paths in LIFO order.
	 *
	 * @param   mixed  $path  The directory as a string or directories as an array to add.
	 *
	 * @return  void
	 *
	 * @since   12.2
	 */
	public static function addTablePath($path)
	{
		\JTable::addIncludePath($path);
	}

	/**
	 * Clean the cache
	 *
	 * @param   string   $group      The cache group
	 * @param   integer  $client_id  The ID of the client
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	protected function cleanCache($group = null, $client_id = 0)
	{
		$conf = \JFactory::getConfig();
		$dispatcher = \JEventDispatcher::getInstance();

		$options = array(
			'defaultgroup' => ($group)     ? $group : (isset($this->option) ? $this->option : \JFactory::getApplication()->input->get('option')),
			'cachebase'    => ($client_id) ? JPATH_ADMINISTRATOR . '/cache' : $conf->get('cache_path', JPATH_SITE . '/cache')
		);

		$cache = \JCache::getInstance('callback', $options);
		$cache->clean();

		// Trigger the onContentCleanCache event.
		$dispatcher->trigger($this->eventCleanCache, $options);
	}

	/**
	 * Get the DI container.
	 *
	 * @return  Container
	 *
	 * @since   1.0
	 * @throws  \UnexpectedValueException May be thrown if the container has not been set.
	 */
	public function getContainer()
	{
		if (!$this->container)
		{
			$this->container = Container::getInstance($this->option);
		}

		return $this->container;
	}

	/**
	 * Set the DI container.
	 *
	 * @param   JoomlaContainer $container The DI container.
	 *
	 * @return  $this
	 *
	 * @since   1.0
	 */
	public function setContainer(JoomlaContainer $container)
	{
		$this->container = $container;

		return $this;
	}
}
