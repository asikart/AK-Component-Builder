<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$fieldset = $data->fieldset;
?>
<fieldset id="{CONTROLLER_NAME}-edit-fieldset-<?php echo $fieldset->name ?>" class="<?php echo $data->class ?>">
	<legend>
		<?php echo $fieldset->label ? JText::_($fieldset->label) : JText::_('COM_{COMPONENT_NAME_UC}_EDIT_FIELDSET_' . $fieldset->name); ?>
	</legend>

	<?php foreach ($data->form->getFieldset($fieldset->name) as $field): ?>
		<div id="control_<?php echo $field->id; ?>">
			<?php echo $field->getControlGroup() . "\n\n"; ?>
		</div>
	<?php endforeach;?>
</fieldset>
