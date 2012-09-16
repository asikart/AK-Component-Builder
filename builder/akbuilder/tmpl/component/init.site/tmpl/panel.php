<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

?>
<div id="ak-panel-wrap">
	<div id="toolbar-box" class="ak-toolbar m">
		<div id="ref-title" class="fltlft">
			<?php echo JFactory::getApplication()->JComponentTitle; ?>
		</div>

		<?php echo JToolBar::getInstance('toolbar')->render('toolbar') ; ?>

		<div class="clr"></div>
	</div>
	
	<div id="element-box" class="m">
			<?php echo $this->loadInnerTemplate('default');?>
	</div>
</div>