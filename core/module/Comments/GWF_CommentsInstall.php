<?php
final class GWF_CommentsInstall
{
	public static function onInstall(Module_Comments $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'moderated' => array('1', 'bool'),
			'guest_captcha' => array('1', 'bool'),
			'member_captcha' => array('0', 'bool'),
			'max_msg_len' => array('2048', 'int', '128', '65535'),
		));
	}
	
}
?>