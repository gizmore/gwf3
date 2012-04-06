<?php
final class Shoutbox_Ajax extends GWF_Method
{
	public function execute()
	{
		$tVars = array(
			'form_action' => $this->module->hrefShout(),
			'href_history' => $this->module->hrefHistory(),
			'msgs' => array_reverse(GDO::table('GWF_Shoutbox')->selectAll('*', '', 'shout_date DESC', array('shout_uid'), $this->module->cfgIPPBox(), 0, GDO::ARRAY_O)),
			'captcha' => $this->module->getCaptcha(),
		);
		return $this->module->templatePHP('_inner_box.php', $tVars);
	}
}
?>