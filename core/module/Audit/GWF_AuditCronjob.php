<?php
/**
 * This cronjob runs as client on gizmore.org
 * @author gizmore
 */
final class GWF_AuditCronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_Audit $module)
	{
		self::start('Audit');
		self::parseSudosh($module);
		self::end('Audit');
	}
	
	private static function parseSudosh(Module_Audit $module)
	{
		$filename = $module->cfgLogfile();
		$filename2 = GWF_WWW_PATH.'protected/logs/local2';
		if (false === ($fh = @fopen($filename, 'r+')))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array($filename));
		}
		elseif (false === ($fh2 = @fopen($filename2, 'a')))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array($filename));
		}
		elseif (false === flock($fh, LOCK_EX))
		{
			self::error('Cannot flock '.$filename);
		}
		else
		{
			self::parseSudoshB($module, $fh, $fh);
		}
		
		@fclose($fh);
		@fclose($fh2);
	}
	
	private static function parseSudoshB(Module_Audit $module, $fh, $fh2)
	{
		while (false !== ($row = fgets($fh)))
		{
			self::parseSudoshRow($module, $row, $fh2);
		}
		
		if (false === ftruncate($fh, 0))
		{
			self::error('Cannot ftruncate sudosh logs.');
		}
	}
	
	private static function parseSudoshRow(Module_Audit $module, $row, $fh2)
	{
// 		echo $row;
		if (false === ($row2 = Common::substrFrom($row, '-sudosh: ', false)))
		{
			return self::error('Invalid line: '.$row);
		}
		elseif (Common::startsWith($row2, 'created')) # livinsh
		{
			return self::parseSudoCreated($module, $row2);
		}
		elseif (Common::startsWith($row2, 'destroyed')) # livinsh
		{
			return self::parseSudoDestroyed($module, $row2);
		}
		elseif (Common::startsWith($row2, 'st')) # started stopped (original sudosh2) 
		{
			return true; # skip
		}
		elseif (false === ($id = Common::substrUntil($row2, ':', false)))
		{
			return self::error('Invalid line: '.$row);
		}
		elseif (false === ($row2 = Common::substrFrom($row2, ':', false)))
		{
			return self::error('Invalid line: '.$row);
		}
// 		elseif (false === ($log = GWF_AuditLog::getByID($id)))
// 		{
// 			fwrite($fh2, $row2);
// 			return false;
// 		}
		else
		{
			return self::appendToLog($module, $id, $row2);
		}
	}
	
	private static function parseSudoCreated(Module_Audit $module, $row)
	{
		$data = explode(':', trim($row));
		if (count($data) !== 3)
		{
			return self::error('Invalid row: '.$row);
		}
		
		$id = $data[1];
		$filename = $data[2];
		$filename = substr($filename, strrpos($filename, '/')+1);
		$data = explode('-', $filename);
		
		if (count($data) !== 5)
		{
			return self::error('Invalid row: '.$row);
		}
		
		$log = new GWF_AuditLog(array(
			'al_id' => $id,
			'al_eusername' => $data[0],
			'al_username' => $data[1],
			'al_type' => $data[2],
			'al_time_start' => $data[3],
			'al_time_end' => NULL,
			'al_rand' => $data[4],
			'al_data' => NULL,
		));
		if (false === $log->replace())
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$filename = $log->getFileName();
		if (false === GWF_File::touch($filename))
		{
			echo GWF_HTML::err('ERR_WRITE_FILE', array($filename));
			return false;
		}
		
		return self::sendMails($module, $log, 1);
	}

	private static function parseSudoDestroyed(Module_Audit $module, $row)
	{
		$data = explode(':', trim($row));
		if (count($data) !== 3)
		{
			return self::error('Invalid row: '.$row);
		}
		if (false === ($log = GWF_AuditLog::getByID($data[1])))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}

		self::notice('Destroy session'.$log->getID());
		
		if (false === self::copySudoDestroyed($module, $log))
		{
			return false;
		}
		if (false === $log->saveVar('al_time_end', time()))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		return self::sendMails($module, $log, 2);
	}

	private static function copySudoDestroyed(Module_Audit $module, GWF_AuditLog $log)
	{
		$filename = $log->getFileName();
		if (false === ($file = @file_get_contents($filename)))
		{
			return self::error('Cannot read file: '.$filename);
		}
		
		if (false === $log->saveVar('al_data', ''))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$len = strlen($file);
		$chunksize = 1024*1024; # 1MB
		for ($i = 0; $i < $len; $i += $chunksize)
		{
			if (false === self::appendToDB($module, $log, substr($file, $i, $chunksize)))
			{
				return false;
			}
			
		}
		
		if (false === @unlink($filename))
		{
			return self::error('Cannot delete file: '.$filename);
		}
		
		return true;
	}
	
	private static function appendToDB(Module_Audit $module, GWF_AuditLog $log, $chunk)
	{
// 		var_dump($chunk);
		$chunk = $log->escape($chunk);
		if (false === ($log->updateRow("al_data=CONCAT(al_data, '$chunk')")))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		return true;
	}
	
	private static function appendToLog(Module_Audit $module, $id, $row)
	{
		$filename = GWF_AuditLog::getFilenameS($id);
		if (false === ($fh = @fopen($filename, 'a')))
		{
			return self::error('Cannot open '.$filename);
		}
		
		if (false === @fprintf($fh, '%s', $row))
		{
			return self::error('Cannot append to '.$filename);
		}
		
		if (false === @fclose($fh))
		{
			return self::error('Cannot close '.$filename);
		}
		
		return true;
	}

	private static function sendMails(Module_Audit $module, GWF_AuditLog $log, $mode=1)
	{
		if (!$log->isScript())
		{
			return true;
		}
		$gid1 = GWF_Group::getByName('auditor')->getID();
		
		
		if ($log->isRoot())
		{
			$gid2 = GWF_Group::getByName('sysmin');
			$where = "(ug_groupid={$gid1} OR ug_groupid={$gid2})";
		}
		elseif ($mode === 1)
		{
			$gid3 = GWF_Group::getByName('live')->getID();
			$where = "(ug_groupid={$gid3})";
		}
		else
		{
			$where = "(ug_groupid={$gid1})";
		}
		
		$users = GDO::table('GWF_UserGroup');
		if (false === ($result = $users->select('DISTINCT(ug_userid),user.*', $where, '', array('user'))))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		while (false !== ($user = $users->fetch($result, 'GWF_User')))
		{
			switch ($mode)
			{
				case 1: self::sendMailGo($module, $user, $log); break;
				case 2:
					self::sendMailDone($module, $user, $log);
					self::sendMailDoneUser($module, $log);
					break;
			}
			
		}
		
		$users->free($result);
		
		return true;
	}
	
	private static function sendMailGo(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		if ('' === ($email = $user->getValidMail()))
		{
// 			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject(self::getMailSubjGo($module, $user, $log));
		$mail->setBody(self::getMailBodyGo($module, $user, $log));
		return $mail->sendToUser($user);
	}
	
	private static function sendMailDone(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		if ('' === ($email = $user->getValidMail()))
		{
// 			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject(self::getMailSubjDone($module, $user, $log));
		$mail->setBody(self::getMailBodyDone($module, $user, $log));
		return $mail->sendToUser($user);
	}
	
	private static function sendMailDoneUser(Module_Audit $module, GWF_AuditLog $log)
	{
		if (false === ($email = GWF_AuditMails::getEMail($log)))
		{
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject(self::getMailSubjUser($module, $log));
		$mail->setBody(self::getMailBodyUser($module, $log));
		return $mail->sendAsHTML();
	}
	
	private static function getMailSubjGo(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		return sprintf('Warchall Audit %d GO: %s_%s', $log->getID(), $log->getVar('al_eusername'), $log->getVar('al_username'));
	}
	
	private static function getMailSubjDone(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		return sprintf('Warchall Audit %d DONE: %s_%s', $log->getID(), $log->getVar('al_eusername'), $log->getVar('al_username'));
	}
	
	private static function getMailSubjUser(Module_Audit $module, GWF_AuditLog $log)
	{
		return sprintf('Warchall logfile %d', $log->getID());
	}
	
	private static function getMailBodyGo(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		$url = Common::getAbsoluteURL($log->hrefReplay(), false);
		$link = GWF_HTML::anchor($url, $url);
		
		return sprintf(
			"Hello %s\n\nA user has just created a sudosh2-skullified session.\nReplay: %s\nFrom: %s-%s (%s)\n",
			$user->getVar('user_name'),
			$link,
			$log->getVar('al_eusername'), $log->getVar('al_username'), $log->displayDate()
		);
	}

	private static function getMailBodyDone(Module_Audit $module, GWF_User $user, GWF_AuditLog $log)
	{
		$url = Common::getAbsoluteURL($log->hrefReplay(), false);
		$link = GWF_HTML::anchor($url, $url);
		
		return sprintf(
			"Hello %s\n\nThere is a new warchall script that needs audit\nReplay: %s\n\nFrom: %s-%s (%s)\n",
			$user->getVar('user_name'),
			$link,
			$log->getVar('al_eusername'), $log->getVar('al_username'), $log->displayDate()
		);
	}

	private static function getMailBodyUser(Module_Audit $module, GWF_AuditLog $log)
	{
		$url = Common::getAbsoluteURL($log->hrefReplay(), false);
		$link = GWF_HTML::anchor($url, $url);
		
		return sprintf(
				"Hello %s\n\nTo review or share your logfiles on warchall, you may use these links:\nReplay: %s\n\nFrom: %s-%s (%s)\n",
				$log->getVar('al_eusername'),
				$link,
				$log->getVar('al_eusername'), $log->getVar('al_username'), $log->displayDate());
		
	}
}
?>
