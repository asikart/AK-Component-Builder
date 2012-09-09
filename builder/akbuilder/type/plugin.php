<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class AKBuilderPlugin extends AKBuilder
{
	
	public $group ;
	
	public function __construct( $type, $extension_name='com_custom', $client='administrator', $option = array() )
	{
		parent::__construct($type, $extension_name, $client);
		
		$this->group = $option['group'] ;
		
		$this->target_path = JPATH_ROOT.DS.'plugins/'.$this->group.'/'.$this->extension ;
	}
	
	
	public function init($name='item.items', $client='administrator')
	{
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type.DS.'init' ;
		
		$this->addFiles( '' , $name , $client );
	}
	
	
	public function convertTemplate($name='sakura.sakuras')
	{
		$this->tmpl_path = AKBUILDER_PATH.'/tmpl/' . $this->type . '/init' ;
		
		parent::convertTemplate($name);
	}
	
	
	public function _buildReplaceKey($name = 'item.items')
	{
		parent::_buildReplaceKey($name) ;
		
		$r['{EXTENSION_NAME}'] 			= strtolower($this->extension) ;
		$r['{EXTENSION_NAME_UC}'] 		= strtoupper($this->extension) ;
		$r['{EXTENSION_NAME_UCFIRST}'] 	= ucfirst($this->extension) ;
		
		$r['{GROUP_NAME}'] 				= strtolower($this->group) ;
		$r['{GROUP_NAME_UC}'] 			= strtoupper($this->group) ;
		$r['{GROUP_NAME_UCFIRST}']		= ucfirst($this->group) ;
		
		$r['{CONTROLLER_NAMES}'] 		= strtolower($this->list_name) ;
		$r['{CONTROLLER_NAMES_UC}'] 	= strtoupper($this->list_name) ;
		$r['{CONTROLLER_NAMES_UCFIRST}']= ucfirst($this->list_name) ;
		
		$r['{CONTROLLER_NAME}'] 		= strtolower($this->item_name) ;
		$r['{CONTROLLER_NAME_UC}'] 		= strtoupper($this->item_name) ;
		$r['{CONTROLLER_NAME_UCFIRST}'] = ucfirst($this->item_name) ;
		
		$this->replace_key = $r ;
	}
}