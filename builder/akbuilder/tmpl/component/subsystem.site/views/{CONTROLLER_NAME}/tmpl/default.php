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

JHtml::_('behavior.framework');
{COMPONENT_NAME_UCFIRST}Helper::_('include.bootstrap');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
$item 		= $this->item ;
$uri 		= JFactory::getURI() ;
?>

<form action="<?php echo JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAME}'); ?>" method="post" name="adminForm" id="adminForm">

	<div id="{COMPONENT_NAME}-wrap" class="container-fluid {CONTROLLER_NAMES}<?php echo $this->get('pageclass_sfx');?>">
		<div id="{COMPONENT_NAME}-wrap-inner">
			
			<div class="{CONTROLLER_NAME}-item item<?php if($item->published == 0) echo ' well well-small'; ?>">
				<div class="{CONTROLLER_NAME}-item-inner">
					
					
					<?php if ($canEdit) : ?>
					<!-- Edit -->
					<!-- ============================================================================= -->
					<div class="edit-icon btn-toolbar fltrt">
						<div class="btn-group">
							<?php echo JHtml::_( 'link', JRoute::_('index.php?option=com_{COMPONENT_NAME}&task={CONTROLLER_NAME}.edit&id='.$item->id.'&return='.base64_encode($uri->toString())) , JText::_('JTOOLBAR_EDIT'), array( 'class' => 'btn btn-small' ) ); ?>
							<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $item->id; ?>','{CONTROLLER_NAMES}.publish')" title="啟用"><?php echo JText::_('JTOOLBAR_ENABLE'); ?></a>
								</li>
								<li>
									<a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $item->id; ?>','{CONTROLLER_NAMES}.unpublish')" title="停用"><?php echo JText::_('JTOOLBAR_DISABLE'); ?></a>
								</li>
							</ul>
						  </div>
						
					</div>
					<div style="display: none;">
						<?php echo JHtml::_('grid.id', $item->id, $item->id); ?>
					</div>
					<!-- ============================================================================= -->
					<!-- Edit End -->
					<?php endif; ?>
					
					
					
					<!-- Heading -->
					<!-- ============================================================================= -->
					<div class="heading">
						<h2><?php echo $params->get('link_titles') ? JHtml::_('link', $item->link, $item->title) : $item->title ?></h2>
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
							<?php echo $this->showInfo($item, 'cat_title', 	'jcategory', null, JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}&id='.$item->catid)); ?>
							<?php echo $this->showInfo($item, 'created', 	'com_{COMPONENT_NAME}_created', null); ?>
							<?php echo $this->showInfo($item, 'modified', 	'com_{COMPONENT_NAME}_modified', null); ?>
							<?php echo $this->showInfo($item, 'created_user', 'com_{COMPONENT_NAME}_created_by', null); ?>
						</div>
					</div>
					
					<hr class="info-separator" />
					<!-- ============================================================================= -->
					<!-- Info -->
					
					
					
					<!-- Content -->
					<!-- ============================================================================= -->
					<div class="content">
						<div class="content-inner row-fluid">
							
							<div class="span12">
								<?php if( !empty($item->images) ): ?>
								<div class="content-img">
									<?php echo JHtml::_('image', $item->images, $item->title); ?>
								</div>
								<?php endif; ?>
								
								<div class="text">
									<?php echo $item->text; ?>
								</div>	
							</div>
							
						</div>
					</div>
					<!-- ============================================================================= -->
					<!-- Content End -->
					
					
					
					<!-- afterDisplayContent -->
					<!-- ============================================================================= -->
					<?php echo $this->item->event->afterDisplayContent; ?>
					<!-- ============================================================================= -->
					<!-- afterDisplayContent -->
					
					
					
				</div>
			</div>
			
		</div>
	</div>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="return" value="<?php echo base64_encode($uri->toString()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>		
