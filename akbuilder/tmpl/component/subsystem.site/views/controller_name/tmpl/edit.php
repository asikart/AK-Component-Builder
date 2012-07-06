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
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == '{CONTROLLER_NAME}.cancel' || document.formvalidator.isValid(document.id('{CONTROLLER_NAME}-form'))) {
			Joomla.submitform(task, document.getElementById('{CONTROLLER_NAME}-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_( JFactory::getURI()->toString() ); ?>" method="post" name="adminForm" id="{CONTROLLER_NAME}-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_{COMPONENT_NAME_UC}_LEGEND_{CONTROLLER_NAME_UC}'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('information') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<input type="hidden" name="option" value="com_{COMPONENT_NAME}" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>