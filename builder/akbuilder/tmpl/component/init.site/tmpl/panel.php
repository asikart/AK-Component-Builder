<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

?>
<div id="ak-panel-wrap">
	<div id="toolbar-box" class="ak-toolbar m">
		<div id="ref-title" class="fltlft">
			<?php echo JFactory::getApplication()->get('JComponentTitle'); ?>
		</div>
		<div id="toolbar" class="toolbar-list">
			<?php echo JToolBar::getInstance('toolbar')->render('toolbar') ; ?>
		</div>
		<div class="clr"></div>
	</div>
	<div id="element-box" class="m">
			<?php echo $this->loadInnerTemplate('default');?>
	</div>
</div>