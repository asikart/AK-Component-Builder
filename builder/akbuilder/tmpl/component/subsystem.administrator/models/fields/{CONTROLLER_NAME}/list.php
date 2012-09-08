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

jimport('joomla.html.html');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of categories
 */
class JFormField{CONTROLLER_NAME_UCFIRST}_list extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = '{CONTROLLER_NAME_UCFIRST}_list';
	
	public $value ;
	
	public $name ; 
	
	protected function getOptions()
	{
		// Initialise variables.
        $options = array();
        $name = (string) $this->element['name'];
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->select('*')
			->from('#__{COMPONENT_NAME}_{CONTROLLER_NAMES}')
			->where('published >= 1')
			;
		
		$db->setQuery($q);
		$items = $db->loadObjectList();
		
		$items = $items ? $items : array() ;
		
		foreach( $items as $item ):
			$item = new JObject($item);
			$options[] = JHtml::_('select.option', $item->id, $item->title );
		endforeach;
		
		// Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
	
}