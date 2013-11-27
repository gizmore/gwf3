<?php
final class Dog_RepoSubscribes extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_repo_subscribes'; }
	public function getColumnDefines()
	{
		return array(
			'reps_rid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'reps_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
		);
	}
	
	public static function subscribe(Dog_Repo $repo, Dog_Channel $chan)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'reps_rid' => $repo->getID(),
			'reps_cid' => $chan->getID(),
		));
	} 

	public static function isSubscribed(Dog_Repo $repo, Dog_Channel $chan)
	{
		return self::table(__CLASS__)->selectVar('1', "reps_rid={$repo->getID()} AND reps_cid={$chan->getID()}") === '1';
	}
	
	public static function unsubscribe(Dog_Repo $repo, Dog_Channel $chan)
	{
		return self::table(__CLASS__)->deleteWhere("reps_rid={$repo->getID()} AND reps_cid={$chan->getID()}");
	} 
}
