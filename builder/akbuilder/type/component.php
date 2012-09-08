<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class AKBuilderComponent extends AKBuilder
{

	public $component = '' ;
	
	public $isNew = false ;
	
	public $type = 'component' ;
	
	public $path = '' ;
	
	public $tmpl_path = '' ;
	
	public $client = '' ;
	
	public $addfiles = array();
	
	public $existsfiles = array();
	
	public $convertfiles = array();
	
	public function __construct( $name='com_custom', $client='administrator' )
	{
		$this->component = $name ;
		
		if( substr($this->component,0,4) == 'com_' ){
			$this->component = substr($this->component, 4) ;
		}
		
		$this->client 	= $client ;
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type ;
		
		switch($client){
			case 'site':
				$this->path = JPATH_ROOT.DS.'components'.DS.'com_'.$this->component ;
			break;
			
			case 'administrator':
				$this->path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$this->component ;
			break;
		}
	}
	
	public function init($name='item.items', $client='administrator')
	{
		/*
		$folders = array();
		$files	 = array();
		
		$folders[] = 'controllers' ;
		$folders[] = 'models' ;
		$folders[] = 'views' ;
		$folders[] = 'language' ;
		
		if($client == 'administrator' ){
			$folders[] = 'helpers' ;
			$folders[] = 'sql' ;
			$folders[] = 'tables' ;
			
			$files[] = 'access.xml' ;
			$files[] = 'component_name.xml' ;
			$files[] = 'config.xml' ;
			$files[] = 'controller.php' ;
			$files[] = '' ;
			$files[] = '' ;
			$files[] = '' ;
		}
		*/
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type.DS.'init.'.$this->client ;
		$this->addFiles( '' , $name , $client );
		$this->addSubsystem( $name , $client );
	}
	
	public function addSubSystem($name='item.items', $client='administrator' )
	{
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type.DS.'subsystem.'.$this->client ;
	
		$this->addControllers($name,  $client);
		$this->addModels($name,  $client);
		$this->addViews($name,  $client);
		$this->addTable($name,  $client);
		$this->addSQL($name);
	}
	
	public function convertTemplate($name='sakura.sakuras', $client='administrator')
	{
		$this->tmpl_path = AKBUILDER_PATH.DS.'tmpl'.DS.$this->type ;
		
		$files = JFolder::files( $this->tmpl_path, '.' , true, true);
		
		$tmpl = array();
		
		foreach( $files as $k => $v ){
			$tmpl[$k]['target'] 	= $this->replaceName( $v , $name, true );
			$tmpl[$k]['content'] 	= $this->replaceName( JFile::read( $v ) , $name, true );
			
			JFile::delete($v);
		}
		
		foreach( $tmpl as $v ){
			JFile::write( $v['target'] , $v['content'] ) ;
			$this->convertfiles[] = $v['target'] ;
		}
	}
	
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
	
	public function addSQL($name='item.items', $client='administrator')
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
		
		$sql = JFile::read( $this->tmpl_path.DS.'sql'.DS.'install.sql' );
		$sql = $this->replaceName($sql,$name);
		
		$db->setQuery( $sql );
		$db->queryBatch();
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
	
	public function addFile( $file = 'controller.php', $name = 'item.items' , $client = 'administrator' )
	{
		$file_path 	= JPath::clean($this->tmpl_path.'/'.$file) ;
		$content 	= $this->replaceName( JFile::read( $file_path , '.' , true, true) , $name );
		
		$target_path = $this->replaceName( JPath::clean($this->path.'/'.$file) , $name );
		
		if( !JFile::exists( $target_path ) )
			JFile::write( $target_path , $content ) ;
	}
	
	public function addFiles( $type = 'controllers', $name = 'item.items' , $client = 'administrator' )
	{
		$files = JFolder::files( $this->tmpl_path.DS.$type, '.' , true, true);
		
		//AK::show($files);
		
		$tmpl = array();
		
		foreach( $files as $k => $v ){
			$tmpl[$k]['target'] 	= $this->replaceName( str_replace( $this->tmpl_path , $this->path , $v) , $name );
			$tmpl[$k]['content'] 	= $this->replaceName( JFile::read( $v ) , $name );
		}
		
		//AK::show($tmpl);
		
		foreach( $tmpl as $v ){
			if( !JFile::exists( $v['target'] ) ){
				JFile::write( $v['target'] , $v['content'] ) ;
				$this->addfiles[] = $v['target'] ;
			}else{
				$this->existsfiles[] = $v['target'] ;
			}
		}
	}
	
	public function replaceName($content = '' , $name = 'item.items', $flip = false)
	{
		// handles name item and name list
		$name = explode('.', $name);
		$nameItem = $name[0] ;
		$nameList = isset($name[1]) ? $name[1] : $name[0].'s' ;
		
		
		$r['{COMPONENT_NAME}'] 			= strtolower($this->component) ;
		$r['{COMPONENT_NAME_UC}'] 		= strtoupper($this->component) ;
		$r['{COMPONENT_NAME_UCFIRST}'] 	= ucfirst($this->component) ;
		
		$r['{CONTROLLER_NAMES}'] 		= strtolower($nameList) ;
		$r['{CONTROLLER_NAMES_UC}'] 	= strtoupper($nameList) ;
		$r['{CONTROLLER_NAMES_UCFIRST}']= ucfirst($nameList) ;
		
		$r['{CONTROLLER_NAME}'] 		= strtolower($nameItem) ;
		$r['{CONTROLLER_NAME_UC}'] 		= strtoupper($nameItem) ;
		$r['{CONTROLLER_NAME_UCFIRST}'] = ucfirst($nameItem) ;
		
		//$r['controller_names'] 			= strtolower($nameList);
		//$r['controller_name'] 			= strtolower($nameItem);
		
		//$r['component_name'] 			= strtolower($this->component);
		
		if($flip){
			$r = array_flip($r);
		}
		
		return strtr( $content , $r ) ;
	}
}