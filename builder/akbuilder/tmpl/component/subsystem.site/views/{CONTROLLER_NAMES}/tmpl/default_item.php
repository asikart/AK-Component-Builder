<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// no direct access
defined('_JEXEC') or die;

$params		= $this->params;
$item 		= $this->item ;
$user 		= JFactory::getUser() ;
$uri 		= JFactory::getURI() ;
$canEdit 	= $user->authorise('core.edit', 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.'.$item->id);

$anchor_id	= '{CONTROLLER_NAME}-item-'.$item->id ;
?>
<div id="<?php echo $anchor_id; ?>" class="{CONTROLLER_NAMES}-item item">
	<div class="{CONTROLLER_NAMES}-item-inner">
		
		<?php if ($canEdit) : ?>
		<!-- Edit -->
		<!-- ============================================================================= -->
		<div class="edit-icon btn-toolbar fltrt">
			<div class="btn-group">
				<?php echo JHtml::_( 'link', JRoute::_('index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAME}.edit&id='.$item->a_id.'&return='.base64_encode($uri->toString())) , JText::_('JTOOLBAR_EDIT'), array( 'class' => 'btn btn-small' ) ); ?>
				<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li>
						<a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $item->a_id; ?>','{CONTROLLER_NAMES}.publish')" title="啟用"><?php echo JText::_('JTOOLBAR_ENABLE'); ?></a>
					</li>
					<li>
						<a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $item->a_id; ?>','{CONTROLLER_NAMES}.unpublish')" title="停用"><?php echo JText::_('JTOOLBAR_DISABLE'); ?></a>
					</li>
				</ul>
			  </div>
			
		</div>
		<div style="display: none;">
			<?php echo JHtml::_('grid.id', $item->a_id, $item->a_id); ?>
		</div>
		<!-- ============================================================================= -->
		<!-- Edit End -->
		<?php endif; ?>
		
		
		
		<!-- Heading -->
		<!-- ============================================================================= -->
		<div class="heading">
			<h2><?php echo $params->get('link_titles_in_list', 1) ? JHtml::_('link', $item->link, $item->a_title) : $item->a_title ?></h2>
		</div>
		<!-- ============================================================================= -->
		<!-- Heading -->
		
		
		<!-- afterDisplayTitle -->
		<!-- ============================================================================= -->
		<?php echo $this->item->event->afterDisplayTitle; ?>
		<!-- ============================================================================= -->
		<!-- afterDisplayTitle -->
		
		
		<!-- beforeDisplayContent -->
		<!-- ============================================================================= -->
		<?php echo $this->item->event->beforeDisplayContent; ?>
		<!-- ============================================================================= -->
		<!-- beforeDisplayContent -->
		
		
		<!-- Info -->
		<!-- ============================================================================= -->
		<div class="info">
			<div class="info-inner">
				<?php echo $this->showInfo($item, 'b_title', 'jcategory', null, JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}&id='.$item->a_catid)); ?>
				<?php echo $this->showInfo($item, 'a_created'); ?>
				<?php echo $this->showInfo($item, 'a_modified'); ?>
				<?php echo $this->showInfo($item, 'c_name', 'com_{COMPONENT_NAME}_created_by', null); ?>
			</div>
		</div>
		<!-- ============================================================================= -->
		<!-- Info -->
		
		
		
		<hr class="info-separator" />
		
		
		
		<!-- Content -->
		<!-- ============================================================================= -->
		<div class="content">
			<div class="content-inner row-fluid">
				
				<?php $text_span = 12 ; ?>
				
				<?php if( !empty($item->a_images) ): ?>
				<?php $text_span = $text_span - 3 ; ?>
				<div class="content-img thumbnail span3">
					<?php echo JHtml::_('image', $item->a_images, $item->a_title); ?>
				</div>
				<?php endif; ?>
				
				<div class="text span<?php echo $text_span; ?>">
					<?php echo $item->text; ?>
				</div>
				
			</div>
		</div>
		<!-- ============================================================================= -->
		<!-- Content -->
		
		
		
		<!-- Link -->
		<!-- ============================================================================= -->
		<div class="row-fluid">
			<div class="span12">
				<p></p>
				<p class="readmore">
					<?php echo JHtml::_('link', $item->link, JText::_('COM_{COMPONENT_NAME_UC}_READMORE'), array( 'class' => 'btn btn-small btn-primary' )); ?>
				</p>
			</div>
		</div>
		<!-- ============================================================================= -->
		<!-- Link -->
		
		
		
		<!-- afterDisplayContent -->
		<!-- ============================================================================= -->
		<?php echo $this->item->event->afterDisplayContent; ?>
		<!-- ============================================================================= -->
		<!-- afterDisplayContent -->
		
		
	</div>
</div>