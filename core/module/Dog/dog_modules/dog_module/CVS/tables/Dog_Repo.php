<?php
final class Dog_Repo extends GDO
{
	public static function baseDir() { return GWF_WWW_PATH.'dbimg/dogrepo/'; }
	public static function repoDir($name) { return self::baseDir().$name.'/'; }
	public static function isValidName($name) { return preg_match('/[a-z0-9_]+/iD', $name) === 1; }
	public static function isValidType($type) { return in_array($type, self::$TYPES, true); }
	
	const VALID = 0x01;
	const SECRET = 0x02;
	const CHECKED_OUT = 0x04;
	const DEFAULT_OPTIONS = self::SECRET;
	
	private static $TYPES = array('git', 'svn');
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_repos'; }
	public function getOptionsName() { return 'repo_options'; }
	public function getColumnDefines()
	{
		return array(
			'repo_id' => array(GDO::AUTO_INCREMENT),
			'repo_uid' => array(GDO::UINT, GDO::NOT_NULL),
			'repo_url' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 255),
			'repo_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 64),
			'repo_type' => array(GDO::ENUM, GDO::NOT_NULL, self::$TYPES),
			'repo_revision' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NULL, 128),
			'repo_priv' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, 'p', 1),
			'repo_branch' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, 'master', 64),
			'repo_files' => array(GDO::UINT, 0),
			'repo_size' => array(GDO::UINT, 0),
			'repo_commits' => array(GDO::UINT, 0),
			'repo_created_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'repo_updated_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'repo_options' => array(GDO::UINT, self::DEFAULT_OPTIONS),
		);
	}
	
	public function getURL() { return $this->getVar('repo_url'); }
	public function getName() { return $this->getVar('repo_name'); }
	public function getType() { return $this->getVar('repo_type'); }
	public function getDir() { return self::repoDir($this->getName()); }
	public function getUID() { return $this->getVar('repo_uid'); }
	public function isOwner(Dog_User $user) { return $user->getID() === $this->getUID(); }
	public function isSecret() { return $this->isOptionEnabled(self::SECRET); }
			
	public static function exists($name)
	{
		return self::getByName($name) !== false;
	}
	
	/**
	 * @param string $name
	 * @return Dog_Repo
	 */
	public static function getByName($name)
	{
		return self::table(__CLASS__)->getBy('repo_name', $name);
	}
	
	/**
	 * @param int $id
	 * @return Dog_Repo
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getBy('repo_id', $id);
	}
	
	public static function create($url, $name, $type, $branch='master')
	{
		$repo = new self(array(
			'repo_id' => '0',
			'repo_uid' => Dog::getUser()->getID(),
			'repo_url' => $url,
			'repo_name' => $name,
			'repo_type' => $type,
			'repo_revision' => null,
			'repo_priv' => 'p',
			'repo_branch' => $branch,
			'repo_files' => '0',
			'repo_size' => '0',
			'repo_commits' => '0',
			'repo_created_at' => GWF_Time::getDate(),
			'repo_updated_at' => GWF_Time::getDate(),
			'repo_options' => self::DEFAULT_OPTIONS,
		));
		return $repo->insert() ? $repo : false;
	}
	
	public function updated()
	{
		return $this->saveVar('repo_updated_at', GWF_Time::getDate());
	}
	
	public function canRead(Dog_User $user)
	{
		if (!($this->isSecret()))
		{
			return true;
		}
		if ($this->isOwner($user))
		{
			return true;
		}
		if ($user->isHoster())
		{
			return true;
		}
		return Dog_RepoUsers::canRead($this, $user);
	}
	
	public function canWrite(Dog_User $user)
	{
		return false;
	}
	
	public function purge()
	{
		return GWF_File::removeDir($this->getDir());
	}
	
	
}
