<?php
final class SR_BazarShop extends GDO
{
	const MAX_SLOGAN_LEN = 148;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bazar_shop'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bs_pname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'sr4bs_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'sr4bs_itemcount' => array(GDO::UINT, 0),
		);
	}
	
	public static function fixAllItemCounts()
	{
		$items = GWF_TABLE_PREFIX.'sr4_bazar';
		return self::table(__CLASS__)->update("sr4bs_itemcount=(SELECT SUM(sr4ba_iamt) FROM $items WHERE sr4ba_pname=sr4bs_pname)");
	}
	
	public function fixItemCount()
	{
		$epname = self::escape($this->getVar('sr4bs_pname'));
		if (false === ($count = GDO::table('SR_BazarItem')->selectVar('SUM(sr4ba_iamt)', "sr4ba_pname='$epname'")))
		{
			return false;
		}
		return $this->saveVar('sr4bs_itemcount', $count);
	}
	
	public function getSlogan()
	{
		if ('' === ($slogan = $this->getVar('sr4bs_message')))
		{
			return Shadowrun4::lang('stub_shop_slogan', array($this->getVar('sr4bs_pname')));
		}
		return $slogan;
	}
	
	/**
	 * Create a shop for a player.
	 * @param string $pname
	 * @return true|false
	 */
	public static function createShop($pname)
	{
		if (false !== ($shop = self::getShop($pname)))
		{
			return true;
		}
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4bs_pname' => $pname,
			'sr4bs_message' => '',
			'sr4bs_itemcount' => 0,
		));
	}
	
	/**
	 * Get a shop by player name.
	 * @param string $pname
	 * @return SR_BazarShop;
	 */
	public static function getShop($pname)
	{
		$pname = GDO::escape($pname);
		return self::table(__CLASS__)->selectFirstObject('*', "sr4bs_pname='$pname'");
	}
	
	/**
	 * Get the overall shop count.
	 * @return int
	 */
	public static function getShopCount()
	{
		return self::table(__CLASS__)->selectVar('COUNT(*)', "sr4bs_itemcount>0");
	}

	/**
	 * Get the overall shop item count.
	 * @return int
	 */
	public static function getTotalItemCount()
	{
		return self::table(__CLASS__)->selectVar('SUM(sr4bs_itemcount)');
	}
	
}
?>