<?php
final class Dog_RepoUsers extends GDO
{
	const SUBSCRIBED = 0x100000;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_repo_users'; }
	public function getOptionsName() { return 'repu_options'; }
	public function getColumnDefines()
	{
		return array(
			'repu_rid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'repu_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'repu_options' => array(GDO::UINT, 0),
		);
	}

	public function subscribe() { return $this->saveOption(self::SUBSCRIBED, true); }
	public function unsubscribe() { return $this->saveOption(self::SUBSCRIBED, false); }
	public function isSubscribed() { return $this->isOptionEnabled(self::SUBSCRIBED); }
	
	public static function getForRepoAndUser(Dog_Repo $repo, Dog_User $user)
	{
		return self::table(__CLASS__)->selectFirstObject('*', "repu_rid={$repo->getID()} AND repu_uid={$user->getID()}");
	}
	
	public static function getOrCreateForRepoAndUser(Dog_Repo $repo, Dog_User $user)
	{
		if (false !== ($ru = self::getForRepoAndUser($repo, $user)))
		{
			return $ru;
		}
		$ru = new self(array(
			'repu_rid' => $repo->getID(),
			'repu_uid' => $user->getID(),
			'repu_options' => '0',
		));
		return $ru->insert() ? $ru : false;
	}
	
	public static function canRead(Dog_Repo $repo, Dog_User $user)
	{
		if (!($ru = self::getForRepoAndUser($repo, $user)))
		{
			return false;
		}
		return true;
	}
	
}
