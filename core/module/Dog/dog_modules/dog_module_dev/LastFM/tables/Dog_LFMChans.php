<?php
class Dog_LFMChans extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_lfm_chans'; }
	public function getColumnDefines()
	{
		return array(
			'lfmc_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'lfmc_cid' => array(GDO::UINT|GDO::PRIMARY_KEY),
		);
	}
	
	public static function isLinked(Dog_User $user, Dog_Channel $chan)
	{
		return self::table(__CLASS__)->selectVar('1', "lfmc_uid={$user->getID()} AND lfmc_cid={$chan->getID()}") === '1';
	}

	public static function link(Dog_User $user, Dog_Channel $chan)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lfmc_uid' => $user->getID(),
			'lfmc_cid' => $chan->getID(),
		), true);
	}
	
	public static function clear(Dog_User $user)
	{
		return self::table(__CLASS__)->deleteWhere("lfmc_uid={$user->getID()}");
	}
}
