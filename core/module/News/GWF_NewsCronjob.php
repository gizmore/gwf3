<?php
final class GWF_NewsCronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_News $module)
	{
		self::start('News');
		self::sendNewsletters($module);
		self::end('News');
	}
	
	private static function sendNewsletters(Module_News $module)
	{
		require_once GWF_CORE_PATH.'module/News/GWF_Newsletter.php';
		$news = GDO::table('GWF_News');
		$newsletter = GDO::table('GWF_Newsletter');
		
		$mailme = GWF_News::MAIL_ME;
		$mailed = GWF_News::MAILED;
		$items = $news->selectObjects('*', "news_options&$mailme AND news_options&$mailed=0", "news_date ASC");
		$item_count = count($items);
		if ($item_count === 0) {
			return;
		}
		
		$dest_count = $newsletter->countRows();
		
		self::notice("Sending $item_count NewsItems to $dest_count EMails ...");
		
		foreach ($items as $item)
		{
			self::sendNewsletter($module, $item);
		}
	}

	private static function sendNewsletter(Module_News $module, GWF_News $item)
	{
		$ft = $item->getFirstTranslation();
		$ts = $item->getTranslations();
		$first_id = (int) $ft['newst_langid'];
		$newsid = $item->getID();
		$sender_mail = $module->cfgSender();
		$micros = $module->cfgSleepMillis() * 1000;
//		$newsletter = GDO::table('GWF_Newsletter');
		
		
		$db = gdo_db();
		$nlt = GWF_TABLE_PREFIX.'newsletter';
		$query = "SELECT * FROM $nlt";
		if (false === ($result = $db->queryRead($query))) {
			return;
		}
		
//		self::log('Sender email is: '.$sender_mail);
		
		
//		$recs = $newsletter->selectAll();
//		$recs = $newsletter->queryAll();
		while (false !== ($row = $db->fetchAssoc($result)))
		{
//		foreach ($recs as $rec)
//		{
//			$rec instanceof GWF_Newsletter;
			$rec = new GWF_Newsletter($row);
			if ($rec->hasBeenMailed($newsid)) {
				continue;
			}
			
			$langid = $rec->getVar('nl_langid');
			$uselid = $first_id;
			foreach ($ts as $tlid => $t)
			{
				if ($langid === $tlid)
				{
					$uselid = $tlid;
					break;
				}
			}
			
			$iso = GWF_Language::getISOByID($uselid);
			
			$receive_mail = $rec->getVar('nl_email');
			self::notice("Sending EMail to $receive_mail ($iso)");
			
			$title = GWF_HTML::display($ts[$uselid]['newst_title']);
			$message = GWF_Message::display($ts[$uselid]['newst_message'], true, false, false);
			$username = GWF_HTML::display($rec->getUsername());
			$unsign = $unsign = $rec->getUnsignAnchor();
			$body = $module->langISO($iso, 'newsletter_wrap', array($username, $unsign, $title, $message));
			
			$mail = new GWF_Mail();
			$mail->setSender($sender_mail);
			$mail->setReceiver($receive_mail);
			$mail->setSubject($module->langISO($iso, 'newsletter_title'));
			$mail->setBody($body);
			
//			if (GWF_DEBUG_EMAIL) {
//				$success = true;
//			}
//			else
//			{
				if (false !== ($user = $rec->getUser())) {
					$success = $mail->sendToUser($user);
				}
				
//			}
//			else if ($rec->isHTML()) {
//				$success = $mail->sendAsHTML();
//			} else {
//				$success = $mail->sendAsText();
//			}
			
			if (!$success) {
				self::error("Can not send email to $receive_mail.");
				return;
			}
			else {
				$rec->setBeenMailed($newsid);
			}

			usleep($micros);
			
//			return;
		}
		
		$db->free($result);
		
		$item->saveOption(GWF_News::MAILED, true);
	}
}

?>