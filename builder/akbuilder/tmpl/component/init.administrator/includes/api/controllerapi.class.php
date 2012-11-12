<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

class AKControllerApi extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{	
		
		$class	= JRequest::getVar('class') ;
		$method = JRequest::getVar( 'method' );
		
		// save all request logs
		//$this->setLog();
		
		// get session key and detete user
		$s = JFactory::getSession();
		
		$key 	=  JRequest::getVar('session_key') ;
		$db 	= JFactory::getDbo();
		$q 		= $db->getQuery(true);
		$q->select('userid')
			->from('#__session')
			->where("session_id='{$key}'")
			;
			
		$db->setQuery($q,0,1);
		$uid = $db->loadResult();
		
		// if user has loged in, set it in session.
		if( $uid ){
			$user = JFactory::getUser($uid);
			$s->set('user',$user);
		}
		
		// API Function
		// ============================================================================
		
		// Access check.
		
		/* 這裡的權限判定太嚴格，留待日後重新整理
		if (!JFactory::getUser()->authorise('core.manage', 'com_ipos') && $method[0] != 'user' ) {
			//ApiError::raiseError(404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		*/
		$user = JFactory::getUser();
		if ( $user->guest && $method[0] != 'user' ) {
			//ApiError::raiseError(404, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		
		// Execute API
		$view 	= $this->getView('api','json');
		
		if( !JRequest::getCmd( 'api' ) ){
			//ApiError::raiseError( 601 , "Invaild API path." , "Example: api/category/getitems" );
		}
		
		if( !isset($method[1]) ){
			$method[1] = '_default' ;
			////ApiError::raiseError( 601 , "Invalid method." , "Example: api/category/getitems" );
		}
		
		$model 	= $this->getModel( $class );
		if( !$model || !method_exists( $model , $method[1] ) ){
			//ApiError::raiseError( 602 , "invalid method: {$method[0]}::{$method[1]}" );
		}
		
		$view->ctrl		= $class;
		$view->method 	= $method;
		$view->setModel( $model , true );
		$view->display();
	}
	
	/*
	 * function setLog
	 * @param $
	 */
	
	public function setLog() {
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$uri = JFactory::getURI();
		
		// delete old
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$date = $date->toUnix(true);
		$date = $date - ( 60 * 60 * 24 * 3 ) ;
		$date = JFactory::getDate( $date )->toSQL(true) ;
		
		$q->delete('#__{COMPONENT_NAME}_request_logs')
			->where(" created <  '{$date}'")
			;
		$db->setQuery($q);
		$db->query();
		
		
		// insert new
		$i = new JObject();
		$i->created = JFactory::getDate( JFactory::getConfig()->get('offset') )->toMySQL();
		$i->uri = $uri->getPath();
		$i->request = json_encode(array_merge( JRequest::get('get') , JRequest::get('post') ) );
		
		$db->insertObject( '#__{COMPONENT_NAME}_request_logs' , $i );
	}
	
	public function login()
	{
		
	}
}
