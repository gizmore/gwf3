<?php
final class Slay_PlayHistory extends GDO
{
	const IPP = 50;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_play_hist'; }
	public function getColumnDefines()
	{
		return array(
			'sph_id' => array(GDO::AUTO_INCREMENT),
			'sph_sid' => array(GDO::UINT|GDO::INDEX, 0), # song id
			'sph_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND), # Play date
		
			'songs' => array(GDO::JOIN, GDO::NULL, array('Slay_Song', 'sph_sid', 'ss_id')),
		);
	}
	
	public static function getLastPlayed($amt=1)
	{
		$table = GDO::table(__CLASS__);
		if (false === ($result = $table->select('*', '', 'sph_date DESC', array('songs'), $amt)))
		{
			return false;
		}
		$back = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$back[] = new Slay_Song($row);
		}
		$table->free($result);
		return $back;
	}

	/**
	 * Insert a song into the play history.
	 * @param Slay_Song $song
	 * @param int $time_end
	 */
	public static function insertPlayed(Slay_Song $song, $time_end)
	{
		if (self::getLastID() === $song->getID())
		{
			return true;
		}
		
		$date = GWF_Time::getDate(GWF_Date::LEN_SECOND, $time_end-$song->getVar('ss_duration'));
		
		if (false === $song->saveVar('ss_last_played', $date))
		{
			return false;
		}
		
		return # true
			self::table(__CLASS__)->insertAssoc(array(
				'sph_id' => 0,
				'sph_sid' => $song->getID(),
				'sph_date' => $date,
			), false);
	}
	
	public static function getLastID()
	{
		return self::table(__CLASS__)->selectVar('sph_sid', '', 'sph_date DESC');
	}
	
	public static function getNumPages($where='')
	{
		$nItems = self::table(__CLASS__)->countRows($where);
		return GWF_PageMenu::getPagecount(self::IPP, $nItems);
	}
}
?>