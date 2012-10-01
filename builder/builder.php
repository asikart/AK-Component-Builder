<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die();

/**
 * Scaffold CLI Bootstrap
 *
 * Run the framework bootstrap with a couple of mods based on the script's needs
 */

// We are a valid entry point.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

// Load system defines
if (file_exists(dirname(dirname(__FILE__)) . '/defines.php'))
{
	require_once dirname(dirname(__FILE__)) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(dirname(__FILE__)));
	require_once JPATH_BASE . '/includes/defines.php';
}

// Get the framework.
require_once JPATH_LIBRARIES . '/import.php';

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';


// Import necessary classes not handled by the autoloaders
jimport('joomla.application.menu');
jimport('joomla.environment.uri');
jimport('joomla.event.dispatcher');
jimport('joomla.utilities.utility');
jimport('joomla.utilities.arrayhelper');

// Import the configuration.
require_once JPATH_CONFIGURATION . '/configuration.php';

// System configuration.
$config = new JConfig;

// Configure error reporting to maximum for CLI output.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Library language
$lang = JFactory::getLanguage();

/**
 * A command line to generate extension scaffold.
 *
 * @package     Joomla.CLI
 * @subpackage  com_finder
 * @since       2.5
 */
class AKBuilderCli extends JApplicationCli
{
	/**
	 * Start time for the index process
	 *
	 * @var    string
	 * @since  2.5
	 */
	private $_time = null;

	/**
	 * Start time for each batch
	 *
	 * @var    string
	 * @since  2.5
	 */
	private $_qtime = null;

	/**
	 * Entry point for Finder CLI script
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function doExecute()
	{
		$args = $this->input->args;
		$args = implode( ' ' , $args ) ;
		
		
		if( $args == 'add subsystem' ):
			$this->check();
			$this->addSubsystem();
		elseif( $args == 'project init' ):
			$this->check();
			$this->initProject();
		elseif($args == 'convert template'):
			$this->check();
			$this->convertTemplate();
		elseif($this->input->get('help') == 1):
			$this->showHelp();
		endif;
		
		$this->showHelp();
		
		$this->out("Command {$args} not found.");
		$this->close();
	}
	
	
	
	public function check()
	{
		$args = $this->input->args;
		$args = implode( ' ' , $args ) ;
		
		$input 	= $this->input ;
		
		// is extension name exists
		$this->extension = $input->get( 'e' , 1 ) ;
		
		if( $this->extension == 1 ) {
			$this->missingParams('e', $msg) ;
		}
		
		$this->type = substr($this->extension, 0, 3) ;
		switch($this->type){
			case 'com' : $this->type = 'component' ; 	break ;
			case 'mod' : $this->type = 'module' ; 	break ;
			case 'plg' : $this->type = 'plugin' ; 	break ;
			default : $this->missingParams(null, 'Extension type "'.$this->type.'" not exists.');
		}
		
		// is name exists
		$this->name = $input->get( 'n' , 1 ) ;
		if( $this->type == 'component' && $this->name == 1 ) {
			$this->missingParams('n') ;
		}
		
		// is client exists
		$this->client = $input->get( 'c' , 1 ) ;
		
		if( $this->type == 'plugin' ){
			if( $this->client != 1  ){
				$this->missingParams( 'c' , 'Extension type "Plugin" does not support "client" .' );
			}
		}elseif( $args == 'convert template' ){
			$this->client = 'all' ;
		}else{
			if( $this->client == 1 ) {
				$this->missingParams('c') ;
			}elseif( $this->client != 'site' && $this->client != 'administrator' && $this->client != 'admin' ){
				$this->missingParams( 'c' , 'Wrong Client Type, only support "site" , "administrator" or "admin" .' );
			}
		}
		
		if( $this->client == 'admin' ) $this->client = 'administrator' ;
		
		
		// if is Plugin, need group param
		$this->group = $input->get( 'g' , 1 ) ;
		if( $this->type == 'plugin' && $this->group == 1 ){
			$this->missingParams('g', 'Extension type "Plugin" need -g (group) param.') ;
		}elseif($this->type != 'plugin'){
			$this->group = null ;
		}
	}
	
	
	
	public function getAKBuilder()
	{
		include_once (__DIR__.DS.'akbuilder'.DS.'akbuilder.php') ;
		
		return AKBuilder::getInstance( $this->type , $this->extension , $this->client, array('group'=> $this->group) );
	}
	
	
	
	public function addSubsystem()
	{
		$input 	= $this->input ;
		$builder = $this->getAKBuilder();
		
		if( method_exists( $builder, 'addSubsystem') ){
			$builder->addSubsystem( $this->name );
		}else{
			$this->missingParams( null , 'This extension type does not support subsystem.' );
		}
		
		$this->success($builder);
	}
	
	
	
	public function initProject()
	{
		$input 	= $this->input ;
		$builder = $this->getAKBuilder();
		$builder->init( $this->name );
		
		$this->success($builder);
	}
	
	
	
	public function convertTemplate()
	{
		$input 	= $this->input ;
		$builder = $this->getAKBuilder();
		$builder->convertTemplate( $this->name );
		
		$this->success($builder);
	}
	
	
	
	public function success($builder)
	{
		foreach( $builder->addfiles as $f ){
			$this->out( "Created file: $f" );
		}
		
		foreach( $builder->existsfiles as $f ){
			$this->out( "File exists: $f" );
		}
		
		foreach( $builder->convertfiles as $f ){
			$this->out( "File Converted: $f" );
		}
		
		$this->out("Create successfully.");
		$this->close();
	}
	
	
	
	public function missingParams($key, $msg = null)
	{
		if(!$msg){
			$msg = "Missing Param: -{$key} or value." ;
		}
	
		$this->out( $msg );
		$this->out( '- You can type "--help" to get some help.' );
		$this->out();
		$this->close();
	}
	
	
	
	/*
	 * function showHelp
	 * @param 
	 */
	
	public function showHelp()
	{
		$help = __DIR__.'/akbuilder/help.txt' ;
		
		jimport('joomla.filesystem.file');
		
		if(JFile::exists($help)) {
			$this->out( JFile::read($help) );
			$this->out();
			$this->close();	
		}
	}
	
}

// Instantiate the application object, passing the class name to JCli::getInstance
// and use chaining to execute the application.
JApplicationCli::getInstance('AKBuilderCli')->execute();
