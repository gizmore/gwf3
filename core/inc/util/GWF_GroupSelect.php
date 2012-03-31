<?php
final class GWF_GroupSelect
{
	public static function single($name, $selected=true, $allow_empty=true, $own_groups_only=true)
	{
		$user = GWF_User::getStaticOrGuest();

		if (false === ($groups = GDO::table('GWF_Group')->select('group_id, group_name')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		if ($selected === true)
		{
			$selected = Common::getPostString($name, '0');
		}

		$data = array();

		if ($allow_empty)
		{
			$data[] = array('0', GWF_HTML::lang('sel_group'));
		}

		while (false !== ($group = GDO::table('GWF_Group')->fetch($groups, GDO::ARRAY_N)))
		{
			if ($own_groups_only && !$user->isInGroupName($group[1]))
			{
				continue;
			}
			$data[] = $group;
		}

		return GWF_Select::display($name, $data, $selected);
	}

	public static function multi($name, $selected=true, $allow_empty=true, $own_groups_only=true)
	{
		$user = GWF_User::getStaticOrGuest();

		if (false === ($groups = GDO::table('GWF_Group')->select('group_id, group_name')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		if ($selected === true)
		{
			$selected = Common::getPostArray($name, array());
		}

		$data = array();
		if ($allow_empty)
		{
			$data[] = array('0', GWF_HTML::lang('sel_group'));
		}
		while (false !== ($group = GDO::table('GWF_Group')->fetch($groups, GDO::ARRAY_N)))
		{
			if ($own_groups_only && !$user->isInGroupName($group[1]))
			{
				continue;
			}
			$data[] = $group;
		}
		return GWF_Select::multi($name, $data, $selected);
	}

	public static function isValidViewFlag($bit)
	{
		$bits = array(GWF_Group::VISIBLE, GWF_Group::COMUNITY, GWF_Group::HIDDEN, GWF_Group::SCRIPT);
		return in_array((int)$bit, $bits, true);
	}

	public static function isValidJoinFlag($bit)
	{
		$bits = array(GWF_Group::FULL, GWF_Group::INVITE, GWF_Group::MODERATE, GWF_Group::FREE, GWF_Group::SYSTEM);
		return in_array((int)$bit, $bits, true);
	}
}

