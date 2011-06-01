<?php
final class SR_PlayerVar extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_player_vars'; }
	public function getColumnDefines()
	{
		return array(
			'sr4pv_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'sr4pv_key' => array(GDO::VARCHAR|GDO::PRIMARY_KEY|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 255),
			'sr4pv_val' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 255),
		);
	}
	
	public static function getVal(SR_Player $player, $key, $default=false)
	{
		$uid = $player->getID();
		$key = self::escape($key);
		if (false === ($val = self::table(__CLASS__)->selectVar('', "sr4pv_uid={$uid} AND sr4pv_key='{$key}'")))
		{
			return $default;
		}
		return $val;
	}
	
	public static function setVal(SR_Player $player, $key, $value)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4pv_uid' => $player->getID(),
			'sr4pv_key' => $key,
			'sr4pv_val' => $value,
		), true);
	}
	
}
?>