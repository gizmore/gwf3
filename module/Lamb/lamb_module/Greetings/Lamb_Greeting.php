<?php
final class Lamb_Greeting extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_greetings'; }
	public function getColumnDefines()
	{
		return array(
			'lagreet_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lagreet_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
		);
	}
	
	###################
	### Convinience ###
	###################
	public static function hasBeenGreeted($user_id, $channel_id)
	{
		return self::table(__CLASS__)->selectFirst('1', "lagreet_uid=$user_id AND lagreet_cid=$channel_id", '', NULL, GDO::ARRAY_N) !== false;
	}
	
	public static function markGreeted($user_id, $channel_id)
	{
		return self::table(__CLASS__)->insertAssoc(array('lagreet_uid'=>$user_id, 'lagreet_cid'=>$channel_id), true);
	}
	
	public static function dropChannel($channel_id)
	{
		$table = self::table(__CLASS__);
		$table->deleteWhere("lagreet_cid=$channel_id");
		return $table->affectedRows();
	}
	
}
?>