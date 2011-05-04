<?php

final class GWF_ChatOnline extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'chatonline'; }
	public function getColumnDefines()
	{
		return array(
			'chaton_sessid' => array(GDO::ASCII|GDO::CASE_S|GDO::VARCHAR|GDO::PRIMARY_KEY, true, 17),
			'chaton_name' => array(GDO::UTF8|GDO::CASE_I|GDO::VARCHAR, true, 63),
			'chaton_timejoin' => array(GDO::UINT, true), # join time.
			'chaton_timeaccess' => array(GDO::UINT, true), # last access time.
			'chaton_timeleft' => array(GDO::UINT, 0), # time when kicked.
		);
	}
	
	public static function getRandomNickS($sessid)
	{
		return 'U#'.abs(crc32(md5($sessid)));
	}
	
	/**
	 * Someone requested chat stuff.
	 * @param Module_Chat $module
	 * @return unknown_type
	 */
	public static function onRequest(Module_Chat $module)
	{
//		GWF_ChatMsg::cleanupTable($module);
		
		$time = time();
		$sessid = GWF_Session::getSessID();
		
		if (false === ($nick = $module->getNickname())) {
			$nick = self::getRandomNickS($sessid);
		}
		
		$table = self::table(__CLASS__);
		if (false === ($row = $table->getRow($sessid))) { # Unknown row
			$row = new self(array(
				'chaton_sessid' => $sessid,
				'chaton_name' => $nick,
				'chaton_timejoin' => $time,
				'chaton_timeaccess' => $time,
			));
			$row->replace();
		}
		else {
			if ($row->getVar('chaton_timeleft') > 0) # He has left before
			{
				$row->saveVars(array(
					'chaton_timejoin' => $time,
					'chaton_timeaccess' => $time,
					'chaton_timeleft' => 0,
				));
			}
			else if ($row->getVar('chaton_name') !== $nick)
			{
				$row->saveVars(array(
//					'chaton_sessid' => 'x'.$sessid, # Common::randomKey(rand(1, 15)), # High entropy, but never a sessid
					'chaton_timeleft' => $time, # and quit me
				));
				$row = new self(array(
					'chaton_sessid' => $sessid, # similar row
					'chaton_name' => $nick, # but all fine now
					'chaton_timejoin' => $time,
					'chaton_timeaccess' => $time,
				));
				$row->replace();
			}
			else
			{
				$row->saveVars(array(
					'chaton_timeaccess' => $time,
				));
			}
		}

		self::cleanupTable($module);
		
		return '';
	}
	
	public static function setSessOnline(Module_Chat $module)
	{
		self::onRequest($module);
		return true;
	}

	public static function setSessOffline(Module_Chat $module)
	{
		$sessid = GWF_Session::getSessID();
		$table = new self(false);
		if (false === ($row = $table->getRow($sessid))) { # Unknown row
			return true;
		}
		return $row->saveVar('chaton_timeleft', time());
	}

	/**
	 * Delete guys that are not online anymore.
	 * @param Module_Chat $module
	 * @return boolean
	 */
	private static function cleanupTable(Module_Chat $module)
	{
		$cut = time() - $module->getOnlineTime();
		$time = time();
		return self::table(__CLASS__)->update("chaton_timeleft=$time", "chaton_timeleft=0 AND chaton_timeaccess<=$cut");
	}
	
	/**
	 * Get all users that are online.
	 * @return array
	 */
	public static function getOnlineUsers()
	{
		$chaton = new self(false);
		return $chaton->select("chaton_timeleft=0", 'chaton_name ASC');
	}
	
	public static function getJoined($cut)
	{
		$cut = (int) $cut;
		$online = new self(false);
		return $online->select("chaton_timejoin>$cut");
	}

	public static function getKicked($cut)
	{
		$cut = (int) $cut;
		$online = new self(false);
		return $online->select("chaton_timeleft>$cut");
	}
}

?>