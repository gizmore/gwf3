<?php
final class SR_BazarItem extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bazar'; }
	public function getColumnDefines()
	{
		return array(
			'sr4ba_id' => array(GDO::AUTO_INCREMENT),
			'sr4ba_pname' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'sr4ba_iname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'sr4ba_price' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4ba_iamt' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}

	/**
	 * Get a bazar item.
	 * @param string $pname
	 * @param string $iname
	 * @return SR_BazarItem
	 */
	public static function getBazarItem($pname, $iname)
	{
		$pname = GDO::escape($pname);
		$iname = GDO::escape($iname);
		return self::table(__CLASS__)->selectFirstObject('*', "sr4ba_pname='{$pname}' AND sr4ba_iname='{$iname}'");
	}
	
	public static function insertBazarItem($pname, $iname, $price, $amt=1)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4ba_id' => 0,
			'sr4ba_pname' => $pname,
			'sr4ba_iname' => $iname,
			'sr4ba_price' => $price,
			'sr4ba_iamt' => $amt,
		));
	}
	
	/**
	 * Create an item from the stored name.
	 * @return SR_Item
	 */
	public function createItemClass()
	{
		return SR_Item::createByName($this->getVar('sr4ba_iname'), 1, false);
	}
	
	public function onPurchased($amt)
	{
		$have = $this->getVar('sr4ba_iamt');
		if ($have <= $amt)
		{
			return $this->delete();
		}
		return $this->increase('sr4ba_iamt', -$amt);
	}

	public function onPayOwner(SR_Player $buyer, $amt)
	{
		$price = $this->getVar('sr4ba_price') * $amt;
		
		$pname = $this->getVar('sr4ba_pname');
		
		if (false === ($seller = Shadowrun4::getPlayerByName($pname)))
		{
			if (false === ($seller = SR_Player::getByLongName($pname)))
			{
				return false;
			}
		}
		
		if (false === $seller->giveBankNuyen($price))
		{
			return false;
		}
		
		$iname = $this->getVar('sr4ba_iname');
		
		$seller->message(sprintf('%s have been booked to your bank account for selling %s %s to %s.', Shadowfunc::displayNuyen($price), $amt, $iname, $buyer->getName()));
		
		return true;
	}
	
	public static function getUsedSlots($pname)
	{
		$pname = self::escape($pname);
		return self::table(__CLASS__)->countRows("sr4ba_pname='$pname'");
	}
}

?>