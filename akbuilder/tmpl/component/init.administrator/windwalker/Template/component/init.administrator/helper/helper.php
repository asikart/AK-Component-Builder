<?php

/**
 * Class {COMPONENT_NAME_UCFIRST}Helper
 *
 * @since 1.0
 */
abstract class {COMPONENT_NAME_UCFIRST}Helper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		$app       = \JFactory::getApplication();
		$inflector = \JStringInflector::getInstance(true);

		// Add Category Menu Item
		if ($app->isAdmin())
		{
			JHtmlSidebar::addEntry(
				JText::_('JCATEGORY'),
				'index.php?option=com_categories&extension=com_{COMPONENT_NAME}',
				($vName == 'categories')
			);
		}

		foreach (new \DirectoryIterator(JPATH_ADMINISTRATOR . '/components/com_{COMPONENT_NAME}/view') as $folder)
		{
			if ($folder->isDir() && $inflector->isPlural($view = $folder->getBasename()))
			{
				$name = \JText::_('COM_{COMPONENT_NAME_UC}_VIEW_' . strtoupper($view));

				JHtmlSidebar::addEntry(
					JText::sprintf('LIB_WINDWALKER_TITLE_ITEM_EDIT', $name),
					'index.php?option=com_{COMPONENT_NAME}&view=' . $view,
					($vName == $view)
				);
			}
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $option  Action option.
	 *
	 * @return  JObject
	 *
	 * @since   1.0
	 */
	public static function getActions($option = 'com_{COMPONENT_NAME}')
	{
		$user   = JFactory::getUser();
		$result = new \JObject;

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.own',
			'core.edit.state',
			'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $option));
		}

		return $result;
	}
}
