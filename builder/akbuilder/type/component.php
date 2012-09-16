<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class AKBuilderComponent extends AKBuilder
{

	public function __construct($type = 'cpmponent', $name='com_custom', $client='administrator', $option = array() )
	{
		parent::__construct($type, $name, $client, $option);
		
		switch($client){
			case 'site':
				$this->target_path = JPATH_ROOT.'/components/'.'com_'.$this->extension ;
			break;
			
			case 'administrator':
			default :
				$this->target_path = JPATH_ADMINISTRATOR.'/components/com_'.$this->extension ;
			break;
		}
	}
	
	
	
	public function init($name='item.items', $client='administrator')
	{
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type.DS.'init.'.$this->client ;
		$this->addFiles( '' , $name , $client );
		$this->addSubsystem( $name , $client );
	}
	
	
	
	public function addSubSystem($name='item.items', $client='administrator' )
	{
		$this->tmpl_path = AKBUILDER_PATH.'/tmpl/'.$this->type.'/subsystem.'.$this->client ;
	
		//$this->addControllers($name,  $client);
		//$this->addModels($name,  $client);
		//$this->addViews($name,  $client);
		//$this->addTable($name,  $client);
		$this->addFiles( '' , $name , $client );
		$this->importSQL($name);
	}
	
	
	
	public function importSQL($name='item.items', $client='administrator')
	{
		
		$conf = JFactory::getConfig();
 
        $host 		= $conf->get('host');
        $user 		= $conf->get('user');
        $password 	= $conf->get('password');
        $database 	= $conf->get('db');
        $prefix 	= $conf->get('dbprefix');
        $driver 	= $conf->get('dbtype');
        $debug 		= $conf->get('debug');
 
        $options = array('driver' => $driver, 'host' => $host, 'user' => $user, 'password' => $password, 'database' => $database, 'prefix' => $prefix);
 
        $db = JDatabase::getInstance($options);
		
		$db  = JFactory::getDbo();
		
		$sql = JFile::read( $this->tmpl_path.'/sql/install.sql' );
		$sql = $this->replaceName($sql, $name);
		
		$sqls = $db->splitSql($sql) ;
		
		foreach( $sqls as $sql ):
			$db->setQuery( $sql );
			$db->query();
		endforeach;
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
	
	
	
	/*
	public function addControllers($name='item.items', $client='administrator')
	{
		$this->addFiles('controllers', $name, $client) ;
	}
	
	public function addModels($name='item.items', $client='administrator')
	{
		$this->addFiles('models', $name, $client) ;
	}
	
	public function addViews($name='item.items', $client='administrator')
	{
		$this->addFiles('views', $name, $client) ;
	}
	
	public function addTable($name='item.items', $client='administrator')
	{
		$this->addFiles('tables', $name, $client) ;
	}
	
	public function addHelper($name='item', $client='administrator')
	{
		
	}
	
	public function addForm($name='item', $client='administrator')
	{
		
	}
	
	public function addField($name='item', $client='administrator')
	{
		
	}
	
	public function addRule($name='item', $client='administrator')
	{
		
	}
	
	*/
	
	
	/*
	 * function _buildReplaceKey
	 * @param $name
	 */
	
	public function _buildReplaceKey($name = 'item.items')
	{
		parent::_buildReplaceKey($name) ;
		
		$r['{COMPONENT_NAME}'] 			= strtolower($this->extension) ;
		$r['{COMPONENT_NAME_UC}'] 		= strtoupper($this->extension) ;
		$r['{COMPONENT_NAME_UCFIRST}'] 	= ucfirst($this->extension) ;
		
		$r['{CONTROLLER_NAMES}'] 		= strtolower($this->list_name) ;
		$r['{CONTROLLER_NAMES_UC}'] 	= strtoupper($this->list_name) ;
		$r['{CONTROLLER_NAMES_UCFIRST}']= ucfirst($this->list_name) ;
		
		$r['{CONTROLLER_NAME}'] 		= strtolower($this->item_name) ;
		$r['{CONTROLLER_NAME_UC}'] 		= strtoupper($this->item_name) ;
		$r['{CONTROLLER_NAME_UCFIRST}'] = ucfirst($this->item_name) ;
		
		$this->replace_key = $r ;
	}
}