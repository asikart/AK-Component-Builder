<?php

use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

/**
 * Class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAMES_UCFIRST}
 *
 * @since 1.0
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAMES_UCFIRST} extends ListModel
{
	/**
	 * populateState
	 *
	 * @param null $ordering
	 * @param null $direction
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$queryHelper = $this->container->get('model.{CONTROLLER_NAMES}.helper.query');

		$queryHelper->addTable('{CONTROLLER_NAME}', '#__{COMPONENT_NAME}_{CONTROLLER_NAMES}')
			->addTable('category',  '#__categories', '{CONTROLLER_NAME}.catid      = category.id')
			->addTable('user',      '#__users',      '{CONTROLLER_NAME}.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', '{CONTROLLER_NAME}.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  '{CONTROLLER_NAME}.language   = lang.lang_code');

		$this->filterFields = array_merge($this->filterFields, $queryHelper->getFilterFields());

		parent::populateState('{CONTROLLER_NAME}.catid, {CONTROLLER_NAME}.ordering', 'ASC');
	}

	/**
	 * processFilters
	 *
	 * @param JDatabaseQuery $query
	 * @param array          $filters
	 *
	 * @return  JDatabaseQuery
	 */
	protected function processFilters(\JDatabaseQuery $query, $filters = array())
	{
		// If no state filter, set published >= 0
		if (!isset($filters['{CONTROLLER_NAME}.published']))
		{
			$query->where($query->quoteName('{CONTROLLER_NAME}.published') . ' >= 0');
		}

		return parent::processFilters($query, $filters);
	}

	/**
	 * configureFilters
	 *
	 * @param FilterHelper $filterHelper
	 *
	 * @return  void
	 */
	protected function configureFilters($filterHelper)
	{
	}

	/**
	 * configureSearches
	 *
	 * @param \Windwalker\Model\Filter\SearchHelper $searchHelper
	 *
	 * @return  void
	 */
	protected function configureSearches($searchHelper)
	{
	}
}
