<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * {CONTROLLER_NAME} Table class
 */
class {COMPONENT_NAME_UCFIRST}Table{CONTROLLER_NAME} extends JTable
{
	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__{COMPONENT_NAME}_{CONTROLLER_NAMES}', 'id', $db);
	}
	
	/**
     * Method to compute the default name of the asset.
     * The default name is in the form table_name.id
     * where id is the value of the primary key of the table.
     *
     * @return  string 
     *
     * @since   11.1
     */
    protected function _getAssetName()
    {
        $k = $this->_tbl_key;
        return 'com_{COMPONENT_NAME}.{CONTROLLER_NAME}.' . (int) $this->$k;
    }
 
    /**
     * Method to return the title to use for the asset table.
     *
     * @return  string 
     *
     * @since   11.1
     */
    protected function _getAssetTitle()
    {
        if( isset($this->title) )
			return $this->title ;
		else
			return $this->_getAssetName() ;
    }
	
	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see		JTable:bind
	 * @since	1.5
	 */
	public function bind($array, $ignore = '')
	{
		// set params
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}
		
		 // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules']))
        {
            $rules = new JAccessRules($array['rules']);
            $this->setRules($rules);
        }
		
		return parent::bind($array, $ignore);
	}

}
