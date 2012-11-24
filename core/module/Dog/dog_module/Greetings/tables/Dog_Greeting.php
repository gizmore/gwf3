<?php
final class Dog_Greeting extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_greetings'; }
	public function getColumnDefines()
	{
		return array(
			'dogreet_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'dogreet_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
		);
	}
	
	###################
	### Convinience ###
	###################
	public static function hasBeenGreeted($user_id, $channel_id)
	{
		return self::table(__CLASS__)->selectFirst('1', "dogreet_uid=$user_id AND dogreet_cid=$channel_id", '', NULL, GDO::ARRAY_N) !== false;
	}
	
	public static function markGreeted($user_id, $channel_id)
	{
		return self::table(__CLASS__)->insertAssoc(array('dogreet_uid'=>$user_id, 'dogreet_cid'=>$channel_id), true);
	}
	
	public static function dropChannel($channel_id)
	{
		$table = self::table(__CLASS__);
		
		if (false === $table->deleteWhere("dogreet_cid=$channel_id"))
		{
			return -1;
		}
		
		return $table->affectedRows();
	}
}
?>