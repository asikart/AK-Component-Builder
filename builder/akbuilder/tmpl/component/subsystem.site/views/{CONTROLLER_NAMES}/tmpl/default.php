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

JHtml::_('behavior.tooltip');
{COMPONENT_NAME_UCFIRST}Helper::_('include.bootstrap');

$user	= JFactory::getUser();
$userId	= $user->get('id');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_{COMPONENT_NAME}');
$saveOrder	= $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_{COMPONENT_NAME}&view={CONTROLLER_NAMES}'); ?>" method="post" name="adminForm" id="adminForm">
	
	<div id="{COMPONENT_NAME}-wrap" class="container-fluid {CONTROLLER_NAMES}<?php echo $this->get('pageclass_sfx');?>">
		<div id="{COMPONENT_NAME}-wrap-inner">
			
			<!-- Heading -->
			<?php if ($this->params->get('show_page_heading', 1)) : ?>
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
			<?php endif; ?>
		
			<?php if ($this->params->get('show_category_title') or $this->params->get('page_subheading')) : ?>
			<h2>
				<?php echo $this->escape($this->params->get('page_subheading')); ?>
				<?php if ($this->params->get('show_category_title')) : ?>
					<span class="subheading-category"><?php echo $this->category->title;?></span>
				<?php endif; ?>
			</h2>
			<?php endif; ?>
			<!-- Heading End -->
			
			
			
			<!-- Description -->
			<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
				<div class="category-desc">
				<?php if ($this->params->get('show_description_image') && $this->category->params->get('image')) : ?>
					<img src="<?php echo $this->category->params()->get('image'); ?>"/>
				<?php endif; ?>
				<?php if ($this->params->get('show_description') && $this->category->description) : ?>
					<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_{COMPONENT_NAME}.category'); ?>
				<?php endif; ?>
				<div class="clr"></div>
				</div>
			<?php endif; ?>
			<!-- Description End -->
			
			
			
			<!-- {CONTROLLER_NAMES_UCFIRST} List -->
			<div id="{CONTROLLER_NAMES}-wrap">
				<?php $leadingcount=0 ; ?>
				<?php if (!empty($this->lead_items)) : ?>
				<div class="row-fluid">
					<?php foreach ($this->lead_items as &$item) : ?>
						<div class="item span12<?php echo $item->a_published == 0 ? ' well' : null; ?>">
							<?php
								$this->item = &$item;
								echo $this->loadTemplate('item');
							?>
						</div>
						<?php
							$leadingcount++;
						?>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php
					$introcount=(count($this->intro_items));
					$counter=0;
				?>
				<?php if (!empty($this->intro_items)) : ?>
				
					<?php foreach ($this->intro_items as $key => &$item) : ?>
					<?php
						$key= ($key-$leadingcount)+1;
						$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
						
						$span = round( 12 / $this->columns );
						
						if ($rowcount==1) : ?>
					<div class="row-fluid">
					<?php endif; ?>
					<div class="item span<?php echo $span; ?><?php echo $item->a_published == 0 ? ' well' : null; ?>">
						<?php
							$this->item = &$item;
							echo $this->loadTemplate('item');
						?>
					</div>
					<?php $counter++; ?>
					
					<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
						<span class="row-separator"></span>
						</div>
		
					<?php endif; ?>
							
					<?php endforeach; ?>
				
				
				<?php endif; ?>
				
				<?php if (!empty($this->link_items)) : ?>
				
					<?php echo $this->loadTemplate('links'); ?>
				
				<?php endif; ?>
				
				
					<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
						<div class="cat-children">
						<h3>
							<?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
						</h3>
							<?php echo $this->loadTemplate('children'); ?>
						</div>
					<?php endif; ?>
				
				<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
					<div class="pagination">
						<?php if ($this->params->def('show_pagination_results', 1)) : ?>
						<p class="counter">
								<?php echo $this->pagination->getPagesCounter(); ?>
						</p>
						<?php endif; ?>
						
						<?php echo $this->pagination->getPagesLinks(); ?>
					</div>
				<?php  endif; ?>
			</div>
			<!-- {CONTROLLER_NAMES_UCFIRST} List End -->
			
		</div>
	</div>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="return" id="return_url" value="<?php echo base64_encode(JFactory::getURI()->toString()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	
</form>