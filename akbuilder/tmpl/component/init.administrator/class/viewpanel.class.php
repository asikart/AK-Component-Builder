<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class AKView extends JView
{
	public function displayWithPanel($tpl=null)
	{
		$this->innerLayout = JRequest::getVar('layout','default');
		$this->setLayout('panel');
		
		$this->addTemplatePath({COMPONENT_NAME_UC}_SITE.DS.'tmpl');
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