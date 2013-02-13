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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');




// Init some API objects
// ================================================================================
$app 	= JFactory::getApplication() ;
$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
$doc 	= JFactory::getDocument();
$uri 	= JFactory::getURI() ;
$user	= JFactory::getUser();


// Set value
$fieldset = $this->current_fieldset ;

// set form align
if(!empty($fieldset->horz) && $fieldset->horz !== 'false'){
	$form_class = 'form-horizontal' ;
}else{
	$form_class = '' ;
}
?>
	
<fieldset class="adminform <?php echo $form_class; ?>">
	<legend><?php echo JText::_('COM_{COMPONENT_NAME_UC}_EDIT_FIELDSET_'.$fieldset->name); ?></legend>
	
	<?php foreach($this->form->getFieldset($fieldset->name) as $field ): ?>
		<div class="control-group">
			<?php echo $field->label; ?>
			<div class="controls">
				<?php echo $field->input; ?>
			</div>
		</div>
	<?php endforeach; ?>
	
	<br /><br />

</fieldset>