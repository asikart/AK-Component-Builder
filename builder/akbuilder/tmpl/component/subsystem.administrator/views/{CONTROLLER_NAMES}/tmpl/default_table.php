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



// Init some API objects
// ================================================================================
$app 	= JFactory::getApplication() ;
$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
$doc 	= JFactory::getDocument();
$uri 	= JFactory::getURI() ;
$user	= JFactory::getUser();
$userId	= $user->get('id');



// List Control
// ================================================================================
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_{COMPONENT_NAME}');
$saveOrder	= $listOrder == 'a.ordering' || ($listOrder == 'a.lft' && $listDirn == 'asc');
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$orderCol 	= 'a.ordering' ;
$show_root	= JRequest::getVar('show_root') ;


// SaveOrder Ajax Function
// ================================================================================
if ($saveOrder)
{
	$method = 'saveOrderAjax' ;
	$saveOrderingUrl = 'index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAMES}.'.$method.'&tmpl=component';
	JHtml::_('sortablelist.sortable', 'itemList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, false);
}

?>

<!-- List Table -->
<table class="table table-striped adminlist" id="itemList">
	<thead>
		<tr>
			<!--Sort-->
			<th width="1%" class="nowrap center hidden-phone">
				<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', $orderCol, $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
			</th>
			
			<!--Checkbox-->
			<th width="1%">
				<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
			</th>
			
			<!--TITLE-->
			<th>
				<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
			</th>
			
			<!--PUBLISHED-->
			<th width="5%" class="nowrap">
				<?php echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
			</th>
			
			<!--CATEGORY-->
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JCATEGORY', 'b.title', $listDirn, $listOrder); ?>
			</th>
			
			<!--VIEW LEVEL-->
			<th width="5%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ACCESS', 'd.title', $listDirn, $listOrder); ?>
			</th>
			
			<!--CREATED DATE-->
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JDATE', 'a.created', $listDirn, $listOrder); ?>
			</th>
			
			<!--AUTHOR-->
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JAUTHOR', 'c.name', $listDirn, $listOrder); ?>
			</th>
			
			<!--LANGUAGE-->
			<th width="5%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_LANGUAGE', 'e.title', $listDirn, $listOrder); ?>
			</th>
			
			<!--ID-->
			<th width="1%" class="nowrap">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>

		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="15">
				<div class="pull-left">
					<?php echo $this->pagination->getListFooter(); ?>
				</div>
				
				<!-- Limit Box -->
				<?php // In Joomla!3.0, Pagination Footer has no limit box, we add this next to pagination.  ?>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		
		$item = new JObject($item);
		
		$ordering	= ($listOrder == $orderCol);
		$canEdit	= $user->authorise('core.edit',			'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->a_id);
		$canCheckin	= $user->authorise('core.manage',		'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->a_id) || $item->a_checked_out == $userId || $item->a_checked_out == 0;
		$canChange	= $user->authorise('core.edit.state',	'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->a_id) && $canCheckin;
		$canEditOwn = $user->authorise('core.edit.own',		'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->a_id) && $item->c_id == $userId;

		?>
		<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->a_catid ;?>">

			<!-- Drag sort for Joomla!3.0 -->
			<td class="order nowrap center hidden-phone">
			<?php if ($canChange) :
				$disableClassName = '';
				$disabledLabel	  = '';

				if (!$saveOrder) :
					$disabledLabel    = JText::_('JORDERINGDISABLED');
					$disableClassName = 'inactive tip-top';
				endif; ?>
				<span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
					<i class="icon-menu"></i>
				</span>
				<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->a_ordering;?>" class="width-20 text-area-order " />
			<?php else : ?>
				<span class="sortable-handler inactive" >
					<i class="icon-menu"></i>
				</span>
			<?php endif; ?>
			</td>

			<!--CHECKBOX-->
			<td class="center">
				<?php echo JHtml::_('grid.id', $i, $item->a_id); ?>
			</td>
			
			<!--TITLE AND CONTROL-->
			<td class="n/owrap has-context">
				
				<div class="pull-left fltlft">
				
				
				<!-- Checkout -->
				<?php if ($item->get('a_checked_out')) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->get('a_checked_out'), $item->get('a_checked_out_time'), '{CONTROLLER_NAMES}.', $canCheckin); ?>
				<?php endif; ?>
				
				
				<!-- Title -->
				<?php if ($canEdit || $canEditOwn) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAME}.edit&id='.$item->a_id); ?>">
						<?php echo $item->get('a_title'); ?>
					</a>
				<?php else: ?>
					<?php echo $item->get('a_title'); ?>
				<?php endif; ?>
				
				
				<!-- Sub Title -->
				<div class="small">
					<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape( $item->get('a_alias') ));?>
				</div>

				</div>
				
				
				<!-- Title Edit Button -->
				<div class="pull-left">
					<?php
						// Create dropdown items
						if($canEdit || $canEditOwn){
							JHtml::_('dropdown.edit', $item->a_id, '{CONTROLLER_NAME}.');
							JHtml::_('dropdown.divider');
						}
						
						
						if($canChange || $canEditOwn) {
							if ($item->a_published) :
							JHtml::_('dropdown.unpublish', 'cb' . $i, '{CONTROLLER_NAMES}.');
							else :
								JHtml::_('dropdown.publish', 'cb' . $i, '{CONTROLLER_NAMES}.');
							endif;
							JHtml::_('dropdown.divider');
						}
						
						
						if ($item->a_checked_out && $canCheckin) :
							JHtml::_('dropdown.checkin', 'cb' . $i, '{CONTROLLER_NAMES}.');
						endif;
						
						if($canChange || $canEditOwn) {
							if ($trashed) :
								JHtml::_('dropdown.untrash', 'cb' . $i, '{CONTROLLER_NAMES}.');
							else :
								JHtml::_('dropdown.trash', 'cb' . $i, '{CONTROLLER_NAMES}.');
							endif;
						}
						
						// Render dropdown list
						echo JHtml::_('dropdown.render');
						?>
				</div>

			</td>
			
			<!--PUBLISHED-->
			<td class="center">
				<?php echo JHtml::_('jgrid.published', $item->a_published, $i, '{CONTROLLER_NAMES}.', $canChange, 'cb', $item->a_publish_up, $item->a_publish_down); ?>
			</td>
			
			<!--CATEGORY-->
			<td class="center">
				<?php echo $item->get('b_title'); ?>
			</td>
			
			<!--VIEW LEVEL-->
			<td class="center">
				<?php echo $item->get('d_title'); ?>
			</td>
			
			<!--CREATED DATE-->
			<td class="center">
				<?php echo JHtml::_('date', $item->get('a_created'), JText::_('DATE_FORMAT_LC4')); ?>
			</td>
			
			<!--AUTHOR-->
			<td class="center">
				<?php echo $item->get('c_name'); ?>
			</td>
			
			<!--LANGUAGE-->
			<td class="center">
				<?php if ($item->get('a_language')=='*'):?>
					<?php echo JText::alt('JALL', 'language'); ?>
				<?php else:?>
					<?php echo $item->get('e_title') ? $this->escape($item->e_title) : JText::_('JUNDEFINED'); ?>
				<?php endif;?>
			</td>
			
			<!--ID-->
			<td class="center">
				<span><?php echo (int) $item->get('a_id'); ?></span>
			</td>

		</tr>
		<?php endforeach; ?>
	</tbody>
</table>