<?php
final class GWF_EMailOnPM
{
	public static function deliver(Module_PM $module, GWF_PM $pm)
	{
		if (false === ($pmo = GWF_PMOptions::getPMOptions($pm->getReceiver()))) {
			return 0;
		}
		
		if (!$pmo->isOptionEnabled(GWF_PMOptions::EMAIL_ON_PM)) {
			return 0;
		}
		
		$sender = $pm->getSender();
		$receiver = $pm->getReceiver();
		if ('' === ($rec = $receiver->getValidMail())) {
			return 0;
		}
		
		$sendername = $sender->getID() !== '0' ? $sender->display('user_name') : GWF_HTML::langUser($receiver, 'guest');
		
		$email = new GWF_Mail();
		$email->setSender($module->cfgEmailSender());
		$email->setReceiver($rec);
		$email->setSubject($module->langUser($receiver, 'mail_subj', array($sendername)));
		
		$autofolder = sprintf('index.php?mo=PM&me=AutoFolder&pmid=%s&uid=%s&token=%s', $pm->getID(), $receiver->getID(), $pm->getHashcode());
		$autofolder = Common::getAbsoluteURL($autofolder);
		$autofolder = GWF_HTML::anchor($autofolder, $autofolder);
		
		$delete = sprintf('index.php?mo=PM&me=Delete&pmid=%s&uid=%s&token=%s', $pm->getID(), $receiver->getID(), $pm->getHashcode());
		$delete = Common::getAbsoluteURL($delete);
		$delete = GWF_HTML::anchor($delete, $delete);
		
		$email->setBody($module->langUser($receiver, 'mail_body', array(
			$receiver->displayUsername(),
			$sendername,
			$pm->display('pm_title'),
			$pm->display('pm_message'),
			$autofolder,
			$delete
		)));
		if (false === $email->sendToUser($receiver)) {
			return -4;
		}
		return 1;
	}
}
?>