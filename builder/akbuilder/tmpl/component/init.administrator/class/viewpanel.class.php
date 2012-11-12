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


jimport('joomla.application.component.view');

class AKView extends JViewLegacy
{
	public function displayWithPanel($tpl=null)
	{
		$this->innerLayout = JRequest::getVar('layout','default');
		$this->setLayout('panel');
		
		$this->addTemplatePath(JPATH_COMPONENT_SITE.'/tmpl');
		$result = $this->loadTemplate($tpl);
		
		if (JError::isError($result)) {
			return $result;
		}
 
        echo $result;
	}
	
	public function loadInnerTemplate($tpl=null)
	{
		$innerLayout = $this->setLayout($this->innerLayout);
		$result = $this->loadTemplate();
		
		return $result;
	}
}