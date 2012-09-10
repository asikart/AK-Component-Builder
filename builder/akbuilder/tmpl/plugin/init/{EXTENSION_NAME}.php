<?php
/**
 * @version		$Id: {EXTENSION_NAME}.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2012 Asikart.com. All rights reserved.
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * {EXTENSION_NAME_UCFIRST} {GROUP_NAME_UCFIRST} Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Content.{EXTENSION_NAME}
 * @since		1.5
 */
class plg{GROUP_NAME_UCFIRST}{EXTENSION_NAME_UCFIRST} extends JPlugin
{
	
	public static $_self ;
	
	/**
	 * Constructor
	 *
	 * @access      public
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.6
	 */
    public function __construct(&$subject, $config)
    {
		parent::__construct( $subject, $config );
		$this->loadLanguage();
		$this->app = JFactory::getApplication();
		
		self::$_self = $this ;
    }
	
	
	
	/*
	 * function getInstance
	 */
	
	public static function getInstance()
	{
		return self::$_self ;
	}
	
	
	public function getFunction( $func ) {
		$func_name = explode( '.' , $func );
		$func_name = array_pop($func_name);
		$func_path = str_replace( '.' , '/' , $func );
		
		$include_path = JPATH_ROOT.'/'.$this->params->get('include_path', 'easyset');
		
		if( !function_exists ( $func_name ) ) :			
			$file = trim($include_path, '/').'/'.$func_path.'.php' ;
			
			if( !file_exists($file) ) 
				$file = dirname(__FILE__).'/lib/'.$func_path.'.php' ;
			
			if( file_exists($file) ) 
				include_once( $file ) ;
		endif;
		
		$args = func_get_args();
        array_shift( $args );
        
		if( function_exists ( $func_name ) )
			return call_user_func_array( $func_name , $args );
	}
	
	
	
	public function includeEvent($func) {
		$include_path = JPATH_ROOT.'/'.$this->params->get('include_path', 'easyset');
		$event = trim($include_path, '/').'/'.'events'.DS.$func.'.php' ;
		if(file_exists( $event )) return $event ;
	}
	
	
	
	public function resultBool($result = array()) {
		foreach( $result as $result ):
			if(!$result) return false ;
		endforeach;
		
		return true ;
	}
	
	
	
	// Events
	// ======================================================================================
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$app = JFactory::getApplication();
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
	}
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} after display title method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterTitle($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} before display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	

	/**
	 * {EXTENSION_NAME_UCFIRST} after display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} before save content method
	 *
	 * Method is called right before content is saved into the database.
	 * Article object is passed by reference, so any changes will be saved!
	 * NOTE:  Returning false will abort the save with an error.
	 *You can set the error by calling $article->setError($message)
	 *
	 * @param	string		The context of the content passed to the plugin.
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @return	bool		If false, abort the save
	 * @since	1.6
	 */
	public function onContentBeforeSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @since	1.6
	 */
	public function onContentAfterSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * {EXTENSION_NAME_UCFIRST} before delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that is to be deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentBeforeDelete($context, $data)
	{
		$result = array() ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * {EXTENSION_NAME_UCFIRST} after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that was deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentAfterDelete($context, $data)
	{
		$result = array() ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * {EXTENSION_NAME_UCFIRST} after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	array	A list of primary key ids of the content that has changed state.
	 * @param	int		The value of the state that the content has been changed to.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentChangeState($context, $pks, $value)
	{
		$result = array() ;
		
		// Your Code Here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}

	
}
