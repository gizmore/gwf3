<?php

final class GWF_PMIgnore extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'pm_ignore'; }
	public function getColumnDefines()
	{
		return array(
			'pmi_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'pmi_uid_ignore' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'pmi_uid_ignore', 'user_id')),
			'pmi_user' => array(GDO::JOIN, 0, array('GWF_User', 'pmi_uid', 'user_id')),
		);
	}
	
	##################
	### Is Ignored ###
	##################
	public static function isIgnored($userid, $userid_ignored)
	{
		return self::table(__CLASS__)->getRow($userid, $userid_ignored) !== false;
	}
	
	
	##############
	### Ignore ###
	##############
	public static function ignore($userid, $userid_ignored)
	{
		$row = new self(array(
			'pmi_uid' => $userid,
			'pmi_uid_ignore' => $userid_ignored,
		));
		return $row->replace();
	}
	
	#################
	### Un-Ignore ###
	#################
	public static function unignore($userid, $userid_ignored)
	{
		$userid = (int) $userid;
		$userid_ignored = (int) $userid_ignored;
		return self::table(__CLASS__)->deleteWhere("pmi_uid=$userid AND pmi_uid_ignore=$userid_ignored") !== false;
	}
	
}

?>