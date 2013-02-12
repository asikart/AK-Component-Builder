<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * {COMPONENT_NAME_UCFIRST} model.
 */
class {COMPONENT_NAME_UCFIRST}Model{CONTROLLER_NAME} extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_{COMPONENT_NAME_UC}';


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
		$form = $this->loadForm('com_{COMPONENT_NAME}.{CONTROLLER_NAME}', '{CONTROLLER_NAME}', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
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
		$data = JFactory::getApplication()->getUserState('com_{COMPONENT_NAME}.edit.{CONTROLLER_NAME}.data', array());

		if (empty($data)) 
		{
			$data = $this->getItem();
		}else{
			$data = new JObject($data);
		}

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
		if ($item = parent::getItem($pk)) {

			//Do any procesing on fields here if needed
			
		}

		return $item;
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
		parent::preprocessForm($form, $data, $group);
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
				$table->alias = JFilterOutput::stringURLSafe( $date->toSql() ) ;
			}
		}
		
		// created date
		if(isset($table->created) && !$table->created){
			$table->created = $date->toSql();
		}
		
		// modified date
		if(isset($table->modified) && $table->id){
			$table->modified = $date->toSql();
		}
		
		// created user
		if(isset($table->created_by) && !$table->created_by){
			$table->created_by = $user->get('id');
		}
		
		// modified user
		if(isset($table->modified_by) && $table->id){
			$table->modified_by = $user->get('id');
		}
		
		// ordering
		if (!$table->id) {
			// Set ordering to the last item if not set
			if (!$table->ordering) {
				$db->setQuery('SELECT MAX(ordering) FROM #__{COMPONENT_NAME}_{CONTROLLER_NAMES}');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

}