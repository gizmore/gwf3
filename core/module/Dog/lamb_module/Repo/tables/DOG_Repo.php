<?php
final class Dog_Repo extends GDO
{
	###########
	### GDO ###
	###########
	public static $TYPES = array('svn', 'git');

	const NAME_MAXLEN = 15;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_repos'; }
	public function getOptionsName() { return 'repo_options'; }
	public function getColumnDefines()
	{
		return array(
			'repo_id' => array(GDO::AUTO_INCREMENT),
			'repo_type' => array(GDO::ENUM, GDO::NOT_NULL, self::$TYPES),
			'repo_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, self::NAME_MAXLEN),
			'repo_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'repo_user' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'repo_pass' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'repo_options' => array(GDO::UINT, 0),
		);
	}
	
	public static function isValidType($type)
	{
		return in_array($type, self::$TYPES, true);
	}
	
	public static function isNameValid($name)
	{
		return strlen($name) <= self::NAME_MAXLEN;
	}
	
	public static function repoExists($name, $url)
	{
		$name = self::escape($name);
		$url = self::escape($url);
		return self::table(__CLASS__)->selectVar('1', "repo_name='$name' OR repo_url='$url'") !== false;
	}
	
	public function checkout()
	{
		$thread = new Repo_Checkout(Dog::getReplyObject(), $this);
		$thread->start();
	}
}
