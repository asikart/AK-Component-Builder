<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\View\Layout\FileLayout;

JHtmlBootstrap::tooltip();
JHtmlFormbehavior::chosen('select');
JHtmlBehavior::multiselect('adminForm');
JHtmlDropdown::init();

/**
 * Prepare data for this template.
 *
 * @var Windwalker\DI\Container $container
 */
$container = $this->getContainer();
?>

<div id="{COMPONENT_NAME}" class="windwalker {CONTROLLER_NAMES} tablelist row-fluid">
	<form action="<?php echo JURI::getInstance(); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

		<?php if (!empty($this->data->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<h4 class="page-header"><?php echo JText::_('JOPTION_MENUS'); ?></h4>
			<?php echo $this->data->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else: ?>
		<div id="j-main-container">
		<?php endif;?>

			<?php echo (new FileLayout('joomla.searchtools.default'))->render(array('view' => $this->data)); ?>

			<?php echo $this->loadTemplate('table'); ?>

			<?php echo (new FileLayout('joomla.batchtools.modal'))->render(array('view' => $this->data, 'task_prefix' => '{CONTROLLER_NAMES}.')); ?>

			<!-- Hidden Inputs -->
			<div id="hidden-inputs">
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<?php echo JHtml::_('form.token'); ?>
			</div>

		</div>
	</form>
</div>
