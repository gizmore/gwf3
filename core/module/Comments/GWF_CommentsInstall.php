<?php
final class GWF_CommentsInstall
{
	public static function onInstall(Module_Comments $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'moderated' => array(true, 'bool'),
			'guest_captcha' => array(true, 'bool'),
			'member_captcha' => array(false, 'bool'),
			'max_msg_len' => array('2048', 'int', '128', '65535'),
		));
	}
	
}
?>