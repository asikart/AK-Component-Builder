<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * {COMPONENT_NAME_UCFIRST} helper.
 */
class {COMPONENT_NAME_UCFIRST}HelperInclude
{
	static $bootstrap ;
	static $bluestork ;
	
	/*
	 * function core
	 * @param 
	 */
	
	public static function core($js = true)
	{
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication() ;
		
		$prefix = $app->isAdmin() ? '../' : '' ;
		
		JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/css/{COMPONENT_NAME}-core.css');
		JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/css/{COMPONENT_NAME}.css');
		
		if($js){
			JHtml::_('behavior.framework', true);
			JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/js/{COMPONENT_NAME}-core.js', true);
			JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/js/{COMPONENT_NAME}.js', true);
		}
	}
	
	
	/*
	 * function foundation
	 * @param 
	 */
	
	public static function foundation($app = true, $js = true)
	{
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication() ;
		
		$prefix = $app->isSite() ? 'administrator/' : '' ;
		
		JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/foundation/stylesheets/foundation.min.css');
		if($app) JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/foundation/stylesheets/app.css');
		
		if($js){
			JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/foundation/javascripts/modernizr.foundation.js');
			JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/foundation/javascripts/foundation.min.js');
			if($app) JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/foundation/javascripts/app.js');
		}
	}
	
	/*
	 * function bootstrap
	 * @param 
	 */
	
	public static function bootstrap($responsive = false, $js = true)
	{	
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication() ;
		
		$prefix = $app->isSite() ? 'administrator/' : '' ;
		
		JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/bootstrap/css/bootstrap.min.css');
		
		if($responsive){
			JHtml::_('stylesheet', $prefix.'components/com_{COMPONENT_NAME}/includes/bootstrap/css/bootstrap-responsive.min.css');
		}
		
		if($js){
			JHtml::_('script', $prefix.'components/com_{COMPONENT_NAME}/includes/bootstrap/javascripts/bootstrap.min.js');
		}
		
		self::$bootstrap = true ;
	}
	
	
	/*
	 * function bluestork
	 * @param 
	 */
	
	public static function bluestork()
	{
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication() ;
		
		$doc->addStylesheet('administrator/templates/bluestork/css/template.css');
		
		$prefix = $app->isSite() ? 'administrator/' : '' ;
		
		self::$bluestork = true ;
	}
	
	
	/*
	 * function fixBluestorkAndBootstrap
	 * @param 
	 */
	
	public static function fixBootstrapToJoomla()
	{
		JHtml::_('stylesheet', 'components/com_{COMPONENT_NAME}/includes/css/fix-bootstrap-to-joomla.css');
		
		JHtml::_('behavior.framework', true);
		JHtml::_('script', 'components/com_{COMPONENT_NAME}/includes/js/fix-bootstrap-to-joomla.js', true);
	}
	
	
	
}