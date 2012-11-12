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

if( JVERSION >= 3){
	JHtml::_('formbehavior.chosen', 'select');
}



// Init some API objects
// ================================================================================
$app 	= JFactory::getApplication() ;
$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
$doc 	= JFactory::getDocument();
$uri 	= JFactory::getURI() ;
$user	= JFactory::getUser();


// Edit setting
// ================================================================================
$tabs = count( $this->fields ) > 1 ? true : false;

$span_left 	= 8 ;
$span_right = 4 ;

$width_left = 60 ;
$width_right= 40 ;
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
	
	
	<?php if( JVERSION >= 3 ): ?>
	<!-- Tab Buttons -->
	<ul class="nav nav-tabs">
		<?php foreach( $this->fields as $key => $group): ?>
		<li class="<?php echo $key == 0 ? 'active' : ''; ?>">
			<a href="#<?php echo $group; ?>" data-toggle="tab"><?php echo JText::_('COM_{COMPONENT_NAME_UC}_EDIT_FIELDS_'.$group); ?></a>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	
	
	<!-- Tab Bodys -->
	<?php echo $tabs ? {COMPONENT_NAME_UCFIRST}Helper::_('panel.startTabs', '{CONTROLLER_NAME}Tab', array( 'active' => $this->fields[0] ) ) : null ; ?>
		<?php foreach( $this->fields as $key => $group ): 
				$fieldsets = $this->form->getFieldsets($group) ;
				
				echo $tabs ? {COMPONENT_NAME_UCFIRST}Helper::_('panel.addPanel' , '{CONTROLLER_NAME}Tab', JText::_('COM_{COMPONENT_NAME_UC}_EDIT_FIELDS_'.$group) , $group ) : null ;
		?>
			<div class="row-fluid">
			
				
				<!-- Left Bar -->
				<div class="span<?php echo $span_left; ?><?php echo JVERSION < 3 ? ' width-'.$width_left : '' ;?> fltlft">
					
					<?php foreach( $fieldsets as  $k => $fieldset ): ?>
						
						<?php if( empty($fieldset->align) ) $fieldset->align = 'left' ; ?>
						<?php if( $fieldset->align == 'right' ) continue; ?>
						
						<?php
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
						
					<?php endforeach; ?>
					
				</div>
				
				
				<!-- Right Bar -->
				<div class="span<?php echo $span_right; ?><?php echo JVERSION < 3 ? ' width-'.$width_right : '' ;?> fltlft">
					
					<?php foreach( $fieldsets as  $k => $fieldset ): ?>
						
						<?php if( empty($fieldset->align) ) $fieldset->align = 'left' ; ?>
						<?php if( $fieldset->align == 'left' ) continue; ?>
						
						<?php
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
						
					<?php endforeach; ?>
					
				</div>
			
			</div>
			
			<div class="clr"></div>
			
			<?php echo $tabs ? {COMPONENT_NAME_UCFIRST}Helper::_('panel.endPanel' , '{CONTROLLER_NAME}Tab' , $group ) : null ; ?>
			
		<?php endforeach; ?>
		
		<?php echo $tabs ? {COMPONENT_NAME_UCFIRST}Helper::_('panel.endTabs' ) : null ; ?>
	
	
	<!-- Hidden Inputs -->
	<div id="hidden-inputs">
		<input type="hidden" name="option" value="com_{COMPONENT_NAME}" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<div class="clr"></div>
</form>