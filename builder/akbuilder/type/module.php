<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class AKBuilderModule extends AKBuilder
{
	
	public function __construct( $type, $extension_name='com_custom', $client='administrator', $option = array() )
	{
		parent::__construct($type, $extension_name, $client);
		
		switch($client){
			case 'site':
				$this->target_path = JPATH_ROOT.DS.'modules'.DS.'mod_'.$this->extension ;
			break;
			
			case 'administrator':
				$this->target_path = JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_'.$this->extension ;
			break;
		}
	}
	
	
	
	public function init($name='item.items', $client='administrator')
	{
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type.DS.'init.'.$this->client ;
		
		$this->addFiles( '' , $name , $client );
	}
	
	
	
	public function convertTemplate($name='sakura.sakuras')
	{
		if($this->client == 'all'){
			$this->tmpl_path = AKBUILDER_PATH.'/tmpl/' . $this->type ;
		}else{
			$this->tmpl_path = AKBUILDER_PATH.'/tmpl/' . $this->type . '/init.' . $this->client ;
		}
		
		parent::convertTemplate($name);
	}
	
	
	public function _buildReplaceKey($name = 'item.items')
	{
		parent::_buildReplaceKey($name) ;
		
		$r['{EXTENSION_NAME}'] 			= strtolower($this->extension) ;
		$r['{EXTENSION_NAME_UC}'] 		= strtoupper($this->extension) ;
		$r['{EXTENSION_NAME_UCFIRST}'] 	= ucfirst($this->extension) ;
		
		$r['{CONTROLLER_NAMES}'] 		= strtolower($this->list_name) ;
		$r['{CONTROLLER_NAMES_UC}'] 	= strtoupper($this->list_name) ;
		$r['{CONTROLLER_NAMES_UCFIRST}']= ucfirst($this->list_name) ;
		
		$r['{CONTROLLER_NAME}'] 		= strtolower($this->item_name) ;
		$r['{CONTROLLER_NAME_UC}'] 		= strtoupper($this->item_name) ;
		$r['{CONTROLLER_NAME_UCFIRST}'] = ucfirst($this->item_name) ;
		
		$this->replace_key = $r ;
	}
}