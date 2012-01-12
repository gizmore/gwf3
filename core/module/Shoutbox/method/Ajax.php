<?php
final class Shoutbox_Ajax extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$tVars = array(
			'form_action' => $this->_module->hrefShout(),
			'href_history' => $this->_module->hrefHistory(),
			'msgs' => array_reverse(GDO::table('GWF_Shoutbox')->selectAll('*', '', 'shout_date DESC', array('shout_uid'), $this->_module->cfgIPPBox(), 0, GDO::ARRAY_O)),
			'captcha' => $this->_module->getCaptcha(),
		);
		return $this->_module->templatePHP('_inner_box.php', $tVars);
	}
}
?>