<?php
/**
 * Clan storage.
 * @author gizmore
 */
final class SR_ClanBank extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_bank'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cb_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4cb_iname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 255),
			'sr4cb_iamt' => array(GDO::UINT, 1),
		);
	}
	
	public function getClanID() { return $this->getVar('sr4cb_cid'); }
	public function getIName() { return $this->getVar('sr4cb_iname'); }
	public function getAmt() { return $this->getVar('sr4cb_iamt'); }

	public static function isEmpty($cid)
	{
		return 0 === self::table(__CLASS__)->countRows("sr4cb_cid={$cid}");
	}
	
	/**
	 * Get a clanbank row by clanid and itemname.
	 * @param int $cid
	 * @param string $itemname
	 * @return SR_ClanBank
	 */
	public static function getByCIDINAME($cid, $itemname)
	{
		return self::table(__CLASS__)->getRow($cid, $itemname);
	}

	/**
	 * Push items into the clan bank.
	 * @param SR_Clan $clan
	 * @param string $itemname
	 * @param int $amt
	 * @param int $weight
	 * @return boolean
	 */
	public static function push(SR_Clan $clan, $itemname, $amt, $weight)
	{
		$cid = $clan->getID();
		
		if (false !== ($row = self::getByCIDINAME($cid, $itemname)))
		{
			if (false === $row->increase('sr4cb_iamt', $amt))
			{
				return false;
			}
		}
		else
		{
			if (false === self::table(__CLASS__)->insertAssoc(array(
				'sr4cb_cid' => $cid,
				'sr4cb_iname' => $itemname,
				'sr4cb_iamt' => $amt,
			)))
			{
				return false;
			}
		}
		
		return $clan->increase('sr4cl_storage', $weight);
	}
	
	/**
	 * Remove items from the clan bank.
	 * @param SR_Clan $clan
	 * @param string $itemname
	 * @param int $amt
	 * @param int $weight
	 * @return boolean
	 */
	public function pop(SR_Clan $clan, $amt, $weight)
	{
		if ($this->getAmt() > $amt)
		{
			if (false === $this->increase('sr4cb_iamt', -$amt))
			{
				return false;
			}
		}
		else
		{
			if (false === $this->delete())
			{
				return false;
			}
		}
		
		return $clan->increase('sr4cl_storage', -$weight);
	}
}
?>
