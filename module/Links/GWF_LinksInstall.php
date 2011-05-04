<?php

final class GWF_LinksInstall
{
	public static function onInstall(Module_Links $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'link_long_descr' => array('NO', 'bool'),
			'link_guests' => array('YES', 'bool'),
			'link_guests_mod' => array('YES', 'bool'),
			'link_guests_votes' => array('NO', 'bool'),
			'link_guests_captcha' => array('YES', 'bool'),
			'link_guests_unread' => array('7 days', 'time', '0', GWF_Time::ONE_YEAR),
			'link_per_page' => array('50', 'int', '1', '512'),
			'link_min_level' => array('0', 'int', '0'),
			'link_tag_min_level' => array('0', 'int', '0'),
			'link_cost' => array('0', 'int', '0'),
			'link_max_tag_len' => array('32', 'int', '8'),
			'link_max_url_len' => array('255', 'int', '32'),
			'link_min_descr_len' => array('8', 'int', '0', '32'),
			'link_max_descr_len' => array('255', 'int', '32'),
			'link_min_descr2_len' => array('0', 'int', '0', '32'),
			'link_max_descr2_len' => array('512', 'int', '32'),
			'link_vote_min' => array('1', 'int', '-100', '100'),
			'link_vote_max' => array('5', 'int', '-100', '100'),
			'show_permitted' => array('YES', 'bool'),
			'link_check_int' => array('0', 'time', '0'),
//			'link_last_check' => array('0', 'script', '0'),
			'link_check_amt' => array('5', 'int', '1', '200'),
		));
	}
}

?>