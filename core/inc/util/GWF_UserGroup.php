<?php
final class GWF_UserGroup extends GDO
{
	const LEADER = 0x01;
	const CO_LEADER = 0x02;
	const MODERATOR = 0x04;
	const HIDDEN = 0x08;

	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'usergroup'; }
	public function getOptionsName() { return 'ug_options'; }
	public function getColumnDefines()
	{
		return array(
			'ug_userid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'ug_groupid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'ug_options' => array(GDO::UINT, 0),
			'user' => array(GDO::JOIN, 0, array('GWF_User', 'ug_userid', 'user_id')),
			'group' => array(GDO::JOIN, 0, array('GWF_Group', 'ug_groupid', 'group_id')),
		);
	}

	public static function show_groups($username)
	{
		return GDO::table(__CLASS__)->selectColumn('group_name', "user_name='$username'", '', array('user', ''));
	}

	# Add a user to a group
	public static function addToGroup($userid, $groupid, $options=0)
	{
		if (false === self::table(__CLASS__)->insertAssoc(array(
			'ug_userid' => $userid,
			'ug_groupid' => $groupid,
			'ug_options' => $options,
		)))
		{
			return false;
		}
		return self::fixGroupMC();
	}

	public static function fixGroupMC()
	{
		$ug = GWF_TABLE_PREFIX.'usergroup';
		return GDO::table('GWF_Group')->update("group_memberc=(SELECT COUNT(*) FROM $ug WHERE ug_groupid=group_id)");
	}

	public static function removeFromGroup($userid, $groupid)
	{
		$userid = (int)$userid;
		$groupid = (int)$groupid;
		return self::table(__CLASS__)->deleteWhere("ug_userid={$userid} AND ug_groupid={$groupid}");
	}
}
