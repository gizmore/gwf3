<?php
final class Lamb_SLChar extends GWF_Method
{
	public function getHTAccess()
	{
		return '';
	}
	
	public function execute()
	{
		return $this->templateSLChar($this->module);
	}
	
	public function templateSLChar()
	{
		return $this->module->template('slchar.tpl');
	}
}
?>
