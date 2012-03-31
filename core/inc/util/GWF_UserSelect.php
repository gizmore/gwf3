<?php
final class GWF_UserSelect
{
	public static function getUsers($groupname, $orderby='user_name ASC')
	{
		$groupname = GDO::escape($groupname);
		return GDO::table('GWF_UserGroup')->selectAll('user.*', "group_name='{$groupname}'", $orderby, array('user','group'), -1, -1, GDO::ARRAY_A);
	}
}
