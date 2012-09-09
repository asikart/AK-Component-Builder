<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

define( 'AKBUILDER_PATH' , __DIR__ ) ;

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );

class AKBuilder
{
	
	public $extension ;
	
	public $ext_name ;
	
	public $isNew = false ;
	
	public $type ;
	
	public $target_path ;
	
	public $tmpl_path ;
	
	public $client ;
	
	public $replace_key ;
	
	public $addfiles 		= array();
	
	public $existsfiles 	= array();
	
	public $convertfiles 	= array();
	
	
	
	public static function getInstance($type = 'component', $extension_name='com_custom', $client='administrator', $option = array())
	{
		static $instance ;
		
		if( !isset( $instance[$type][$client] ) ) {
			include_once __DIR__.'/type/'.$type.'.php' ;
			$class_name = __CLASS__.ucfirst($type);
			$instance = new $class_name( $type, $extension_name, $client, $option);
		}
		
		return $instance ;
	}
	
	
	/*
	 * function __contruct
	 * @param 
	 */
	
	public function __construct($type = 'cpmponent' ,$extension_name='com_custom', $client='administrator', $option = array())
	{
		$this->ext_name  = $extension_name ;
		$this->extension = substr($extension_name, 4) ;
		$this->client 	 = $client ;
		$this->type 	 = $type ;
		$this->tmpl_path = AKBUILDER_PATH.'/tmpl/'.$this->type ;
	}
	
	
	
	public function init($name='item.items', $client='administrator')
	{
		
	}
	
	
	
	public function convertTemplate($name='sakura.sakuras')
	{
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
	
	
	
	public function addSQL($name='item.items', $client='administrator')
	{
		
	}
	
	
	
	public function addFile( $file = 'controller.php', $name = 'item.items' , $client = 'administrator' )
	{
		$file_path 	= JPath::clean($this->tmpl_path.'/'.$file) ;
		
		if( !JFile::exists($file_path) ) return false ;
		
		$content 	 = $this->replaceName( JFile::read( $file_path , '.' , true, true) , $name );
		$target_path = $this->replaceName( JPath::clean($this->target_path.'/'.$file) , $name );
		
		if( !JFile::exists( $target_path ) ){
			JFile::write( $target_path , $content ) ;
			$this->addfiles[] = $target_path ;
		}else{
			$this->existsfiles[] = $target_path ;
		}
	}
	
	
	
	public function addFiles( $path = 'controllers', $name = 'item.items' , $client = 'administrator' )
	{
		$path = $path ? $this->tmpl_path.'/'.trim($path) : $this->tmpl_path ;
		$files = JFolder::files( $path , '.' , true, true);
		
		$tmpl = array();
		
		foreach( $files as $k => $v ){
			$target_path = str_replace( $this->tmpl_path , $this->target_path , $v) ;
			$tmpl[$k]['target'] 	= $this->replaceName( $target_path , $name );
			$tmpl[$k]['content'] 	= $this->replaceName( JFile::read( $v ) , $name );
		}
		
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
		if(!$this->replace_key){
			$this->_buildReplaceKey($name);
		}
		
		$r = $this->replace_key ;
		
		if($flip){
			$r = array_flip($r);
		}
		
		return strtr( $content , $r ) ;
	}
	
	
	/*
	 * function _buildReplaceKey
	 * @param $name
	 */
	
	public function _buildReplaceKey($name = 'item.items')
	{
		// handles name item and name list
		$name = explode('.', $name) ;
		$this->item_name = $name[0] ;
		$this->list_name = isset($name[1]) ? $name[1] : $name[0].'s' ;
		
	}
}