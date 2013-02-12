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

jimport('joomla.application.component.modeladmin');

/**
 * {COMPONENT_NAME_UCFIRST} model.
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAME_UCFIRST} extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected 	$text_prefix = 'COM_{COMPONENT_NAME_UC}';
	
	public 		$component = '{COMPONENT_NAME}' ;
	
	public 		$item_name = '{CONTROLLER_NAME}' ;
	
	public 		$list_name = '{CONTROLLER_NAMES}' ;
	
	public 		$item ;
	
	public 		$category ;
	
	
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = '{CONTROLLER_NAME_UCFIRST}', $prefix = '{COMPONENT_NAME_UCFIRST}Table', $config = array())
	{	
		return parent::getTable( $type , $prefix , $config );
	}
	
	

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm("com_{COMPONENT_NAME}.{CONTROLLER_NAME}", '{CONTROLLER_NAME}', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		return $form;
	}
	
	
	/*
	 * function getFields
	 * @param 
	 */
	
	public function getFields()
	{
		if(!empty($this->fields_name)) return $this->fields_name ;
		
		$xml_file 		= JPATH_COMPONENT.'/models/forms/{CONTROLLER_NAME}.xml' ;
		$xml 			= JFactory::getXML( $xml_file );
		$fields 		= $xml->xpath('/form/fields');
		$fields_name 	= array();
		
		foreach( $fields as $field ):
			if( (string) $field['name'] != 'other' )
				$fields_name[] = (string) $field['name'] ;
		endforeach;
		
		return $this->fields_name = $fields_name ;
	}
	
	

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState("com_{COMPONENT_NAME}.edit.{CONTROLLER_NAME}.data", array());
		
		if (empty($data)) 
		{
			$data = $this->getItem();
		}else{
			$data = new JObject($data);
		}
		
		
		
		// Get params, convert $data->params['xxx'] to $data->param_xxx
		// ==========================================================================================
		if( isset($data->params) && is_array($data->params)){
			foreach( $data->params as $key => $param ):
				$key = 'param_'.$key ;
				if(empty($data->$key)){
					$data->$key = $param ;
				}
			endforeach;
		}
		
		
		
		// This seeting is for Fields Group
		// Convert data[field] to data[fields_group][field] then Jform can bind data into forms.
		// ==========================================================================================
		$fields = $this->getFields();
		
		foreach( $fields as $field ):
			$data->$field = clone $data ;
		endforeach;
		
		
		return $data;
	}

	
	
	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if($item = parent::getItem($pk)){
			
			
			
			return $item ;	
		}

		return false;
	}
	
	
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		parent::populateState();
	}
	
	
	
	/**
     * Method to allow derived classes to preprocess the form.
     *
     * @param   JForm   $form   A JForm object.
     * @param   mixed   $data   The data expected for the form.
     * @param   string  $group  The name of the plugin group to import (defaults to "content").
     *
     * @return  void 
     *
     * @see     JFormField
     * @since   11.1
     * @throws  Exception if there is an error in the form event.
     */
    protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		return parent::preprocessForm($form, $data, $group);
	}
	
	
	
	/*
	 * function getCategory
	 * @param 
	 */
	
	public function getCategory($pk = null)
	{	
		if(!empty($this->category)){
			return $this->category ;
		}
		
		$pk = $pk ? $pk : $this->getItem()->catid ;
		
		$this->category  = JTable::getInstance('Category');
		
		if(!$this->category->load($pk) ) {
			$this->setError($this->category->getError());
            return false;
		}
		
		return $this->category ;
	}
	
	
	
	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');
		
		$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user 	= JFactory::getUser() ;
		$db 	= JFactory::getDbo();
		
		
		// alias
        if( isset($table->alias) ) {
			
			if(!$table->alias){
				$table->alias = JFilterOutput::stringURLSafe( trim($table->title) ) ;
			}else{
				$table->alias = JFilterOutput::stringURLSafe( trim($table->alias) ) ;
			}
			
			if(!$table->alias){
				$table->alias = JFilterOutput::stringURLSafe( $date->toSql(true) ) ;
			}
		}
		
		// created date
		if(isset($table->created) && !$table->created){
			$table->created = $date->toSql(true);
		}
		
		// modified date
		if(isset($table->modified) && $table->id){
			$table->modified = $date->toSql(true);
		}
		
		// created user
		if(isset($table->created_by) && !$table->created_by){
			$table->created_by = $user->get('id');
		}
		
		// modified user
		if(isset($table->modified_by) && $table->id){
			$table->modified_by = $user->get('id');
		}
		
		
		// Version
		$table->version++ ;
		
		
		
		// Set Ordering 
		if (!$table->id) {
			// Set ordering to the last item if not set
			if (!$table->ordering) {
				$table->reorder('catid = '.(int) $table->catid.' AND published >= 0');
			}
		}
		
	}
	
	
	
	/**
     * Method to test whether a record can be deleted.
     *
     * @param   object  $record  A record object.
     *
     * @return  boolean  True if allowed to delete the record. Defaults to the permission for the component.
     *
     * @since   12.2
     */
    protected function canDelete($record)
    {
        $user = JFactory::getUser();
        return $user->authorise('core.delete', $this->option.'.'.$this->item_name.'.'.$record->id);
    }
 
    /**
     * Method to test whether a record can be deleted.
     *
     * @param   object  $record  A record object.
     *
     * @return  boolean  True if allowed to change the state of the record. Defaults to the permission for the component.
     *
     * @since   12.2
     */
    protected function canEditState($record)
    {
        $user = JFactory::getUser();
        return $user->authorise('core.edit.state', $this->option.'.'.$this->item_name.'.'.$record->id);
	}
}