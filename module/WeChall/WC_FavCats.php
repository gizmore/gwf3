<?php
final class WC_FavCats extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_fav_cat'; }
	public function getColumnDefines()
	{
		return array(
			'wcfc_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'wcfc_cat' => array(GDO::VARCHAR|GDO::PRIMARY_KEY|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
		);
	}
	
	public static function insertFavCat($userid, $cat)
	{
		return self::table(__CLASS__)->insertAssoc(array('wcfc_uid'=>$userid, 'wcfc_cat'=>$cat), true);
	}

	public static function getFavCats($userid, $orderby='wcfc_cat ASC')
	{
		$userid = (int)$userid;
		return self::table(__CLASS__)->selectColumn('wcfc_cat', "wcfc_uid=$userid", $orderby);
	}

	public static function removeFavCat($userid, $cat)
	{
		$userid = (int)$userid;
		$cat = self::escape($cat);
		$table = self::table(__CLASS__);
		if (false === ($table->deleteWhere("wcfc_uid=$userid AND wcfc_cat='$cat'"))) {
			return false;
		}
		return $table->affectedRows() === 1;
	}
}
?>