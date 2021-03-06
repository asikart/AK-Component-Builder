<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_{COMPONENT_NAME}
 * @author      Simon ASika <asika32764@gmail.com>
 * @copyright   Copyright (C) 2013 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once AKPATH_COMPONENT . '/viewitem.php';

/**
 * View class for a item edit of {COMPONENT_NAME_UCFIRST}.
 *
 * @package     Joomla.Site
 * @subpackage  com_{COMPONENT_NAME}
 */
class {COMPONENT_NAME_UCFIRST}View{CONTROLLER_NAME_UCFIRST} extends AKViewItem
{
	/**
	 * @var        string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_{COMPONENT_NAME_UC}';

	/**
	 * Item to edit.
	 *
	 * @var array
	 */
	protected $item;

	/**
	 * Model state to get some configuration.
	 *
	 * @var JRegistry
	 */
	protected $state;

	/**
	 * The Component option name.
	 *
	 * @var    ing
	 */
	protected $option = 'com_{COMPONENT_NAME}';

	/**
	 * The URL view list variable.
	 *
	 * @var    ing
	 */
	protected $list_name = '{CONTROLLER_NAMES}';

	/**
	 * The URL view item variable.
	 *
	 * @var    ing
	 */
	protected $item_name = '{CONTROLLER_NAME}';

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @see     JViewLegacy::loadTemplate()
	 * @since   12.2
	 */
	public function display($tpl = null)
	{
		$app  = JFactory::getApplication();
		$user = JFactory::getUser();

		$this->state    = $this->get('State');
		$this->params   = $this->state->get('params');
		$this->item     = $this->get('Item');
		$this->category = $this->get('Category');
		$this->canDo    = {COMPONENT_NAME_UCFIRST}Helper::getActions();

		$layout = $this->getLayout();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		if ($layout == 'edit')
		{
			$this->form         = $this->get('Form');
			$this->fields_group = $this->get('FieldsGroup');
			$this->fields       = $this->get('FieldsName');

			parent::displayWithPanel($tpl);

			return true;
		}

		// Prepare setting data
		$this->item = new JObject(get_object_vars($this->item));
		$item       = $this->item;

		// Link
		// =====================================================================================
		$item->link = new JURI("index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAME}&id={$item->id}");
		$item->link->setVar('alias', $item->get('alias'));
		$item->link->setVar('catid', $item->get('catid'));
		$item->link = JRoute::_((string) $item->link);

		// Dsplay Data
		// =====================================================================================
		$item->created_user = JFactory::getUser($item->created_by)->get('name');
		$item->cat_title    = isset($this->category) ? $this->category->title : null;

		if ($item->modified == '0000-00-00 00:00:00')
		{
			$item->modified = '';
		}

		// Can Edit
		// =====================================================================================
		if (!$user->get('guest'))
		{
			$userId = $user->get('id');
			$asset  = 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.' . $item->id;

			// Check general edit permission first.
			if ($user->authorise('core.edit', $asset))
			{
				$this->params->set('access-edit', true);
			}
			// Now check if edit.own is available.
			elseif (!empty($userId) && $user->authorise('core.edit.own', $asset))
			{
				// Check for a valid user and that they are the owner.
				if ($userId == $item->created_by)
				{
					$this->params->set('access-edit', true);
				}
			}
		}

		// View Level
		// =====================================================================================
		if ($access = $this->state->get('filter.access'))
		{
			// If the access filter has been set, we already know this user can view.
			$this->params->set('access-view', true);
		}
		else
		{
			// If no access filter is set, the layout takes some responsibility for display of limited information.
			$user   = JFactory::getUser();
			$groups = $user->getAuthorisedViewLevels();

			if (!$item->get('catid') || empty($this->category->access))
			{
				$this->params->set('access-view', in_array($item->get('access'), $groups));
			}
			else
			{
				$this->params->set('access-view', in_array($item->access, $groups) && in_array($this->category->access, $groups));
			}
		}

		// Publish Date
		// =====================================================================================
		$pup  = JFactory::getDate($item->get('publish_up'), JFactory::getConfig()->get('offset'))->toUnix(true);
		$pdw  = JFactory::getDate($item->get('publish_down'), JFactory::getConfig()->get('offset'))->toUnix(true);
		$now  = JFactory::getDate('now', JFactory::getConfig()->get('offset'))->toUnix(true);
		$null = JFactory::getDate('0000-00-00 00:00:00', JFactory::getConfig()->get('offset'))->toUnix(true);

		if (($now < $pup && $pup != $null) || ($now > $pdw && $pdw != $null))
		{
			$item->published = 0;
		}

		// Plugins
		// =====================================================================================
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');

		$item->text = $this->params->get('show_intro', 1) ? $item->introtext . $item->fulltext = $item->fulltext : $item->fulltext;
		$results    = $dispatcher->trigger('onContentPrepare', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));

		$item->event                    = new stdClass;
		$results                        = $dispatcher->trigger('onContentAfterTitle', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results                           = $dispatcher->trigger('onContentBeforeDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results                          = $dispatcher->trigger('onContentAfterDisplay', array('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', &$item, &$this->params, 0));
		$item->event->afterDisplayContent = trim(implode("\n", $results));

		// Params
		// =====================================================================================
		// Merge {CONTROLLER_NAME} params. If this is single-{CONTROLLER_NAME} view, menu params override article params
		// Otherwise, {CONTROLLER_NAME} params override menu item params
		$active       = $app->getMenu()->getActive();
		$temp         = clone ($this->params);
		$item->params = new JRegistry($item->params);

		// Check to see which parameters should take priority
		if ($active)
		{
			$currentLink = $active->link;

			// If the current view is the active item and an {CONTROLLER_NAME} view for this {CONTROLLER_NAME},
			// then the menu item params take priority
			if (strpos($currentLink, 'view={CONTROLLER_NAME}') && (strpos($currentLink, '&id=' . (string) $item->id)))
			{
				// $item->params are the {CONTROLLER_NAME} params, $temp are the menu item params
				// Merge so that the menu item params take priority
				$item->params->merge($temp);

				// Load layout from active query (in case it is an alternative menu item)
				if (isset($active->query['layout']))
				{
					$this->setLayout($active->query['layout']);
				}
			}
			else
			{
				// Current view is not a single {CONTROLLER_NAME}, so the {CONTROLLER_NAME} params take priority here
				// Merge the menu item params with the {CONTROLLER_NAME} params so that the {CONTROLLER_NAME} params take priority
				$temp->merge($item->params);
				$this->params = $temp;

				// Check for alternative layouts (since we are not in a single-{CONTROLLER_NAME} menu item)
				// Single-{CONTROLLER_NAME} menu item layout takes priority over alt layout for an {CONTROLLER_NAME}
				if ($layout = $this->params->get('{CONTROLLER_NAME}_layout'))
				{
					$this->setLayout($layout);
				}

				// If not Active, set Title
				$this->setTitle($item->get('title'));
			}
		}
		else
		{
			// Merge so that article params take priority
			$temp->merge($this->params);
			$this->params = $temp;

			// Check for alternative layouts (since we are not in a single-article menu item)
			// Single-article menu item layout takes priority over alt layout for an article
			if ($layout = $this->params->get('{CONTROLLER_NAME}_layout'))
			{
				$this->setLayout($layout);
			}

			// If not Active, set Title
			$this->setTitle($item->get('title'));
		}

		$item->params = $this->params;

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 */
	protected function addToolbar()
	{
		AKToolBarHelper::title('{CONTROLLER_NAME_UCFIRST}' . ' ' . JText::_('COM_{COMPONENT_NAME_UC}_TITLE_ITEM_EDIT'), 'article-add.png');

		parent::addToolbar();
	}

	/**
	 * Set page title by JDocument.
	 *
	 * @param  string $title Title.
	 *
	 * @return void
	 */
	public function setTitle($title = '')
	{
		parent::setTitle($title);
	}

	/**
	 * Show or hide some fields setting.
	 *
	 * @return void
	 */
	public function handleFields()
	{
		$form = $this->form;

		parent::handleFields();

		// For Joomla! 3.0
		if (JVERSION >= 3)
		{
			// $form->removeField('name', 'fields');
		}
		else
		{
			// $form->removeField('name', 'fields');
		}
	}
}
