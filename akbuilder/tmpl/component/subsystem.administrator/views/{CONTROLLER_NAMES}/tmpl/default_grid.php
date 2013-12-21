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

$user   = JFactory::getUser();
$userId = $user->get('id');

$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$orderCol  = $this->state->get('list.orderCol', 'a.ordering');
$canOrder  = $user->authorise('core.edit.state', 'com_{COMPONENT_NAME}');
$saveOrder = $listOrder == $orderCol || ($listOrder == 'a.lft' && $listDirn == 'asc');
$trashed   = $this->state->get('filter.published') == -2 ? true : false;

jimport('libraries.joomla.html.jgrid');
include_once AKPATH_HTML . '/grid.php';

// Set Table
// =================================================================================
$table = array();
$th    = array();
$tr    = array();

// For Joomla!3.0
// ================================================================================
if (JVERSION >= 3)
{
	if ($saveOrder)
	{
		$method          = 'saveOrderAjax';
		$saveOrderingUrl = 'index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAMES}.' . $method . '&tmpl=component';
		JHtml::_('sortablelist.sortable', 'itemList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, false);
	}
}

// Set Rows and Cells
// =================================================================================
foreach ($this->items as $i => $item):
	$item = new JObject($item);

	$ordering   = ($listOrder == 'a.ordering');
	$canCreate  = $user->authorise('core.create', 'com_{COMPONENT_NAME}');
	$canEdit    = $user->authorise('core.edit', 'com_{COMPONENT_NAME}');
	$canCheckin = $user->authorise('core.edit.state', 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.' . $item->a_id)
		|| $item->get('a_checked_out') == $userId
		|| $item->get('a_checked_out') == 0;
	$canChange  = $user->authorise('core.edit.state', 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.' . $item->a_id) && $canCheckin;
	$canEditOwn = $user->authorise('core.edit.own', 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.' . $item->a_id) && $item->get('a_created_by') == $userId;

	// Example Column START
	// =================================================================================
	$column = 'example';

	// Example TH
	// -----------------------------------------
	if ($i == 0)
	{
		$th[$column]['option']['class'] = 'center';
		$th[$column]['option']['width'] = '5%';
		$th[$column]['content']         = JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder);
	}

	// Example TD Option
	// -----------------------------------------
	$option['class'] = 'nowrap center';

	// Example TD Content
	// -----------------------------------------

	$content = 'EXAMPLE';

	// Put in $td
	// -----------------------------------------
	$td[$column]['option']  = $option;
	$td[$column]['content'] = $content;

	// Checkbox Column START
	// =================================================================================
	$column = 'checkbox';

	// Checkbox TH
	// -----------------------------------------
	if ($i == 0)
	{
		$th[$column]['option']['class'] = 'center';
		$th[$column]['option']['width'] = '1%';
		$th[$column]['content']         = '<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />';
	}

	// Checkbox TD Option
	// -----------------------------------------
	$option['class'] = 'nowrap center';

	// Checkbox TD Content
	// -----------------------------------------

	$content = JHtml::_('grid.id', $i, $item->a_id);

	// Put in $td
	// -----------------------------------------
	$td[$column]['option']  = $option;
	$td[$column]['content'] = $content;

	// Sort Column
	// =================================================================================
	$column = 'sort';

	// Sort TH
	// -----------------------------------------
	if ($i == 0)
	{
		$th[$column]['option']['class'] = 'nowrap center hidden-phone';
		$th[$column]['option']['width'] = '1%';
		$th[$column]['content']         = JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING');
	}

	// Sort TD Option
	// -----------------------------------------
	$option['class'] = 'order nowrap center hidden-phone';

	// Sort TD Content
	// -----------------------------------------
	if ($canChange)
	{
		$disableClassName = '';
		$disabledLabel    = '';

		if (!$saveOrder || !$canOrder)
		{
			$disabledLabel    = JText::_('JORDERINGDISABLED');
			$disableClassName = 'inactive tip-top';
		}
	}

	$content = '<span class="sortable-handler hasTooltip ' . $disableClassName . '" title="' . $disabledLabel . '">
                        <i class="icon-menu"></i>
                    </span>';

	$content .= '<input type="text" style="display:none" name="order[]" size="5" value="' . $item->a_ordering . '" class="width-20 text-area-order " />';

	// Put in $td
	// -----------------------------------------
	$td[$column]['option']  = $option;
	$td[$column]['content'] = $content;

	// Title
	// =================================================================================
	$column = 'a_title';

	// Title TH
	if ($i == 0)
	{
		$th[$column]['option']['class'] = 'center';
		$th[$column]['option']['width'] = null;
		$th[$column]['content']         = JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder);
	}

	// Title TD
	$option['class'] = 'nowrap has-context';

	$content = '<div class="pull-left">';

	if ($item->get('a_checked_out'))
	{
		$content .= JHtml::_('jgrid.checkedout', $i, $item->get('a_checked_out'), $item->get('a_checked_out_time'), '{CONTROLLER_NAMES}.', $canCheckin);
	}

	if ($canEdit || $canEditOwn)
	{
		$content .= JHtml::link(JRoute::_('index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAME}.edit&id=' . $item->a_id), $item->get('a_title'));
	}

	if (JVERSION >= 3)
	{
		$content .= '<div class="small">' . JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->get('a_alias'))) . '</div></div>';

		// Create dropdown items
		if ($canEdit || $canEditOwn)
		{
			JHtml::_('dropdown.edit', $item->a_id, '{CONTROLLER_NAME}.');
			JHtml::_('dropdown.divider');
		}

		if ($canChange || $canEditOwn)
		{
			if ($item->get('a_published'))
			{
				JHtml::_('dropdown.unpublish', 'cb' . $i, '{CONTROLLER_NAMES}.');
			}
			else
			{
				JHtml::_('dropdown.publish', 'cb' . $i, '{CONTROLLER_NAMES}.');
			}

			JHtml::_('dropdown.divider');
		}

		if ($item->get('a_checked_out') && $canCheckin)
		{
			JHtml::_('dropdown.checkin', 'cb' . $i, '{CONTROLLER_NAMES}.');
		}

		if ($canChange || $canEditOwn)
		{
			if ($trashed)
			{
				JHtml::_('dropdown.untrash', 'cb' . $i, '{CONTROLLER_NAMES}.');
			}
			else
			{
				JHtml::_('dropdown.trash', 'cb' . $i, '{CONTROLLER_NAMES}.');
			}
		}

		// Render dropdown list
		echo JHtml::_('dropdown.render');
	}

	$td[$column]['option']  = $option;
	$td[$column]['content'] = $content;

	// Published Column START
	// =================================================================================
	$column = 'a_published';

	// Published TH
	// -----------------------------------------
	if ($i == 0)
	{
		$th[$column]['option']['class'] = 'nowrap center';
		$th[$column]['option']['width'] = '5%';
		$th[$column]['content']         = JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder);
	}

	// Published TD Option
	// -----------------------------------------
	$option['class'] = 'nowrap center';

	// Published TD Content
	// -----------------------------------------

	$content = JHtml::_('jgrid.published', $item->a_published, $i, '{CONTROLLER_NAMES}.', $canChange, 'cb', $item->a_publish_up, $item->a_publish_down);

	// Put in $td
	// -----------------------------------------
	$td[$column]['option']  = $option;
	$td[$column]['content'] = $content;

	// Set TR
	// =================================================================================
	$tr[$i]['option']['class']             = "row" . ($i % 2);
	$tr[$i]['option']['sortable-group-id'] = $item->a_catid;
	$tr[$i]['td']                          = $td;
endforeach;

// Set th in Table
$table['thead']['tr'][0]['th']     = $th;
$table['thead']['tr'][0]['option'] = array();
$table['tbody']['tr']              = $tr;

$table_option = array('class' => 'table table-striped adminlist', 'id' => 'itemList');

// Render Grid
echo $this->renderGrid($table, $table_option);
