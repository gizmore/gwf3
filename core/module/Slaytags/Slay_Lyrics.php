<?php
final class Slay_Lyrics extends GDO
{
	const MAX_LENGTH = 8192;
	
	const ENABLED = 0x01;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_lyrics'; }
	public function getOptionsName() { return 'ssl_options'; }
	public function getColumnDefines()
	{
		return array(
			'ssl_sid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL), # song id
			'ssl_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL), # user id
			'ssl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND), # Create date
			'ssl_edit_date' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND), # Edit date
			'ssl_lyrics' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ssl_options' => array(GDO::UINT, 0),
		
			'user' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'ssl_uid', 'user_id')),
		);
	}
	
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	public function isEdited() { return $this->getVar('ssl_edit_date') !== NULL; }
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Slaytags&me=EditLyrics&uid='.$this->getVar('ssl_uid').'&sid='.$this->getVar('ssl_sid'); }
	
	public static function getByIDs($sid, $uid)
	{
		return self::table(__CLASS__)->getRow($sid, $uid);
	}
	
	public static function getLyrics(Slay_Song $song, GWF_User $user)
	{
		if (false === ($row = self::getByIDs($song->getID(), $user->getID())))
		{
			return '';
		}
		return $row->getVar('ssl_lyrics');
	}
	
	public static function isEnabledLyrics(Slay_Song $song, GWF_User $user)
	{
		if (false === ($row = self::getByIDs($song->getID(), $user->getID())))
		{
			return true;
		}
		return $row->isOptionEnabled(self::ENABLED);
	}

	public static function getAllLyrics(Slay_Song $song)
	{
		$sid = $song->getID();
		return self::table(__CLASS__)->selectAll('*', "ssl_sid={$sid}", 'ssl_uid ASC', NULL, -1, -1, GDO::ARRAY_A);
	}
	
	public static function getLyricsCount(Slay_Song $song, $enabled_only=true)
	{
		$sid = $song->getID();
		$enabled = $enabled_only ? ('ssl_options&'.self::ENABLED) : '1';
		return self::table(__CLASS__)->selectVar('count(ssl_uid)', "ssl_sid={$sid} AND ($enabled)");
	}
}
?>