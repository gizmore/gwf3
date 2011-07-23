<?php
final class SR_BazarHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bazar_hist'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bh_id' => array(GDO::AUTO_INCREMENT),
			'sr4bh_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sr4bh_seller' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'sr4bh_buyer' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'sr4bh_iname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'sr4bh_price' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4bh_iamt' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function insertPurchase($buyer, $seller, $iname, $price, $amt=1)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4bh_id' => 0,
			'sr4bh_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'sr4bh_seller' => $seller,
			'sr4bh_buyer' => $buyer,
			'sr4bh_iname' => $iname,
			'sr4bh_price' => $price,
			'sr4bh_iamt' => $amt
		));
	}
	
}
?>