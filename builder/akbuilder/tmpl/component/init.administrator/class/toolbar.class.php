<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

include_once JPATH_ADMINISTRATOR.'/includes/toolbar.php' ;

class AKToolBarHelper extends JToolBarHelper
{
	static function title ($title, $icon = 'generic.png')
	{
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication();
		
		$doc->setTitle($title) ;
		
		// Strip the extension.
		$icons = explode(' ', $icon);
		foreach($icons as &$icon) {
			$icon = 'icon-48-'.preg_replace('#\.[^.]*$#', '', $icon);
		}

		$html = '<div class="pagetitle '.htmlspecialchars(implode(' ', $icons)).'"><h2>'.$title.'</h2></div>';		
		
		$app->set('JComponentTitle', $html);
		
	}
	
	
	/*
	 * function __callStatic
	 */
	
	public static function __callStatic($name, $args)
	{
		$app = JFactory::getApplication() ;
		
		$app->triggerEvent('onAKToolbarAppendButton', array($name, &$args) ) ;
		call_user_func_array( array('JToolBarHelper', $name), $args );
	}
}