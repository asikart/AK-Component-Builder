<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die();

/**
 * Finder CLI Bootstrap
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

// Force library to be in JError legacy mode
JError::$legacy = true;

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
 * A command line cron job to run the Finder indexer.
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
		
		if( !isset($args[0]) ){
			$this->out("Need Params.");
			$this->close();
		}
		
		//if( $args == 'project init' ) $this->close('123') ;
		
		if( $args == 'add subsystem' ):
			$this->check();
			$this->addSubsystem();
		elseif( $args == 'project init' ):
			$this->check();
			$this->initProject();
		endif;
		
		//$command = implode( ' ' , $this->input->args ) ;
		$this->out("Command {$args} not found.");
		$this->close();
		
		//$this->out( print_r($this->input) );

		// Print a blank line at the end.
		$this->out();
	}
	
	public function check()
	{
		$args = $this->input->args;
		
		$input 	= $this->input ;
		
		// is name exists
		$name = $input->get( 'n' , 1 ) ;
		if( $name == 1 ) {
			$this->missingParams('n') ;
		}
		
		// is client exists
		$client = $input->get( 'c' , 1 ) ;
		if( $client == 1 ) {
			$this->missingParams('c') ;
		}elseif( $client != 'site' && $client != 'administrator' ){
			$this->missingParams( 'c' , 'Wrong Client Type, only support "site" or "administrator" .' );
		}
		
		// is extension name exists
		$ext = $input->get( 'e' , 1 ) ;
		if( $ext == 1 ) {
			$this->missingParams('e', $msg) ;
		}
		
		$type	= $input->get( 't' , 'component' );
		if( $type != 'component' ){
			$this->missingParams( 'Extension type only support component now.' );
		}
	}
	
	public function getAKBuilder()
	{
		include_once (__DIR__.DS.'akbuilder'.DS.'akbuilder.php') ;
		$input 	= $this->input ;
		return AKBuilder::getInstance( $input->get('t', 'component' ) , $input->get('e') , $input->get('c') );
	}
	
	public function addSubsystem()
	{
		$input 	= $this->input ;
		$builder = $this->getAKBuilder();
		$builder->addSubsystem( $input->get('n') );
		
		$this->success($builder);
	}
	
	public function initProject()
	{
		$input 	= $this->input ;
		$builder = $this->getAKBuilder();
		$builder->init( $input->get('n') );
		
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
		
		$this->out("Create successfully.");
		$this->close();
	}
	
	public function missingParams($key, $msg = null)
	{
		if(!$msg){
			$msg = "Missing Param: -{$key} or value." ;
		}
	
		$this->out( $msg );
		$this->out();
		$this->close();
	}

}

// Instantiate the application object, passing the class name to JCli::getInstance
// and use chaining to execute the application.
JApplicationCli::getInstance('AKBuilderCli')->execute();
