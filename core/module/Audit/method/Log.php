<?php
final class Audit_Log extends GWF_Method
{
	public function execute()
	{
		if (false === ($username = Common::getPostString('uname', false)))
		{
			return GWF_HTML::err(ERR_PARAMETER, array(__FILE__, __LINE__, 'uname'));
		}
		
		$log = new GWF_AuditLog(array(
			'al_username' => $username,
			'al_time_start' => time(),
			'al_time_end' => time(),
			'al_cmds' => Common::getPostString('cmds'),
			'al_times' => Common::getPostString('times'),
			'al_script' => Common::getPostString('script'),
		));
		
		if (false === $log->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$this->sendLog($log);
		return 'THX!';
	}
	
	private function sendLog(GWF_AuditLog $log)
	{
		$mail = new GWF_Mail();
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject('WarChall audit log');
		$mail->setBody($this->getMailBody($log)); # TODO: gizmore fix it, method does not exist
		$mail->sendAsText($this->_module->cfgAuditCC());
	}
}
?>
