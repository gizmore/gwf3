<?php
final class Shoutbox_Ajax extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$tVars = array(
			'form_action' => $module->hrefShout(),
			'href_history' => $module->hrefHistory(),
			'msgs' => array_reverse(GDO::table('GWF_Shoutbox')->selectAll('*', '', 'shout_date DESC', array('shout_uid'), $module->cfgIPPBox(), 0, GDO::ARRAY_O)),
			'captcha' => $module->getCaptcha(),
		);
		return $module->templatePHP('_inner_box.php', $tVars);
	}
}
?>