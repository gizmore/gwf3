<?php
/**
 * @return GDO_Database
 */
function merge_db($argv)
{
	$db = gdo_db_instance('localhost', $argv[1], $argv[2], $argv[3]);
	return $db;
}

function merge_usage()
{
	echo "user pass db prefix prevar\n";
	die(0);
}

/**
 * Assume all users are new. Add them to real db with a prefix_
 */
function merge_core(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
{
	GDO::setCurrentDB($db_to);
	merge_calc_offset($db_from, $db_to, $db_offsets, 'GWF_User');

	merge_gids($db_from, $db_to, $db_offsets, $prefix, $prevar);
	merge_users($db_from, $db_to, $db_offsets, $prefix, $prevar);

	merge_add_offset($db_from, $db_to, 'GWF_UserGroup', 'ug_userid', $db_offsets['GWF_User']);
	merge_use_mapping($db_from, $db_to, 'GWF_UserGroup', 'ug_groupid', $db_offsets['GWF_Group']);
	merge_table($db_from, $db_to, 'GWF_UserGroup');
}

function merge_calc_offset(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $classname)
{
	GDO::setCurrentDB($db_to);
	$db_offsets[$classname] = GDO::table($classname)->autoIncrement();
}

function merge_add_offset(GDO_Database $db_from, GDO_Database $db_to, $classname, $colname, $add)
{
	GDO::setCurrentDB($db_from);
	$add = ''.($add > 0 ? '+' : '-').$add;
	return GDO::table($classname)->update("`$colname` = `$colname` $add", "`$colname` > 0");
}

function merge_use_mapping(GDO_Database $db_from, GDO_Database $db_to, $classname, $colname, array $map, $numerical=true)
{
	GDO::setCurrentDB($db_from);
	$table = GDO::table($classname);
	foreach ($map as $from => $to)
	{
		if (Common::isNumeric($from))
		{
			if (false === $table->update("`$colname` = 0x40000000|$to", "`$colname` = $from"))
			{
				return false;
			}
		}
	}
	return $table->update("`$colname` = `$colname` - 0x40000000", "`$colname` >= 0x40000000");
}

function merge_clear_column(GDO_Database $db_from, GDO_Database $db_to, $classname, $colname, $with='0')
{
	GDO::setCurrentDB($db_from);
	return GDO::table($classname)->update("`$colname`=$with");
}

function merge_table(GDO_Database $db_from, GDO_Database $db_to, $classname)
{
	GWF_Cronjob::notice(sprintf('Merging table %s', $classname));
	
	GDO::setCurrentDB($db_from);
	$fromtable = GDO::table($classname);

	if (false === ($result = $fromtable->select('*')))
	{
		return false;
	}

	GDO::setCurrentDB($db_to);
	$totable = GDO::table($classname);

	while (false !== ($row = $fromtable->fetch($result)))
	{
		GWF_Cronjob::notice(sprintf('Merging table %s ID %s', $classname, reset($row)));
		$totable->insertAssoc($row, GDO::ARRAY_A);
	}

	$fromtable->free($result);
	return true;
}

function merge_fix_uname(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $classname, $colname)
{
	GDO::setCurrentDB($db_from);
	$table = GDO::table($classname);
	if (false === ($result = $table->select('*')))
	{
		echo GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}
	while (false !== ($row = $table->fetch($result, GDO::ARRAY_O)))
	{
		$oldname = $row->getVar($colname);
		if (isset($db_offsets['user_name'][$oldname]))
		{
			$row->saveVar($colname, $db_offsets['user_name'][$oldname]);
		}
	}
	$table->free($result);
}

function merge_fix_uid_blob(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $classname, $colname, $splitter=':')
{
	GDO::setCurrentDB($db_from);
	$table = GDO::table($classname);
	
	if (false === ($result = $table->select('*')))
	{
		echo GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}
	
	$offset = $db_offsets['GWF_User'];
	
	while (false !== ($row = $table->fetch($result, GDO::ARRAY_O)))
	{
		$col = $row->getVar($colname);
		if ($col !== $splitter)
		{
			$newcol = $splitter;
			$uids = explode($splitter, $col);
			foreach ($uids as $uid)
			{
				$uid += $offset;
				$newcol .= $uid.$splitter;
			}
			$row->saveVar($colname, $newcol);
		}
	}

	$table->free($result);
}

function merge_fix_uname_blob(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $classname, $colname, $splitter=':')
{
	GDO::setCurrentDB($db_from);
	$table = GDO::table($classname);
	
	if (false === ($result = $table->select('*')))
	{
		echo GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}
	
	while (false !== ($row = $table->fetch($result, GDO::ARRAY_O)))
	{
		$col = $row->getVar($colname);
		if ($col !== $splitter)
		{
			$newcol = $splitter;
			$names = explode($splitter, $col);
			foreach ($names as $name)
			{
				if (isset($db_offsets['user_name'][$name]))
				{
					$newcol .= $db_offsets['user_name'][$name];
				}
				else
				{
					$newcol .= $name;
				}
				$newcol .= $splitter;
			}
			$row->saveVar($colname, $newcol);
		}
	}
	$table->free($result);
}



function merge_gids(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
{
	$db_offsets['GWF_Group'] = array();

	GDO::setCurrentDB($db_from);
	$fromgroups = GDO::table('GWF_Group');
	if (false === ($result = $fromgroups->select('*', '', 'group_id ASC')))
	{
		echo GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}

	GDO::setCurrentDB($db_to);
	$togroups = GDO::table('GWF_Group');
	while (false !== ($row = $fromgroups->fetch($result, GDO::ARRAY_A)))
	{
		$gname = $row['group_name'];
		$egname = GDO::escape($gname);
		if (false === ($oldgid = $togroups->selectVar('group_id', "group_name='$egname'")))
		{
			$row['group_id'] = '0';
			$togroups->insertAssoc($row);
			// 			$db_offsets['GWF_Group'][$gname] = $db_to->insertID();
			$newgid = $db_to->insertID();
			$db_offsets['GWF_Group'][(string)$row['group_id']] = $newgid;
			GWF_Cronjob::log("Group {$row['group_id']} => $newgid");
		}
		else
		{
			// 			$db_offsets['GWF_Group'][$gname] = $oldgid;
			$db_offsets['GWF_Group'][(string)$row['group_id']] = $oldgid;
			GWF_Cronjob::log("Group {$row['group_id']} => $oldgid");
		}
	}
}

function merge_users(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
{
	$db_offsets['user_name'] = array();

	GDO::setCurrentDB($db_from);
	$users = GDO::table('GWF_User');
	if (false === ($result = $users->select('*', '', 'user_id ASC')))
	{
		echo GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}

	GDO::setCurrentDB($db_to);
	$to_users = GDO::table('GWF_User');
	$off = $db_offsets['GWF_User'];
	while (false !== ($user = $users->fetch($result, GDO::ARRAY_A)))
	{
		$oldname = $user['user_name'];
		$newname = merge_user_name($user['user_name'], $to_users, $prefix, $prevar);
		$user['user_name'] = $newname;
		if ($oldname !== $newname)
		{
			$db_offsets['user_name'][$oldname] = $newname;
		}
		$user['user_id'] += $off;
		$to_users->insertAssoc($user);
		GWF_Cronjob::log('Added user '.$user['user_name'].' with id '.$user['user_id']);
	}

	$users->free($result);

	return true;
}

function merge_user_name($oldname, GDO $to_users, $prefix, $prevar)
{
	// Try with prefix
	$oldname = $prefix.$oldname;
	$eoldname = GDO::escape($oldname);
	if (false === $to_users->selectVar('1', "user_name='$eoldname'"))
	{
		return $oldname;
	}

	// Try with prevar
	$oldname = $prevar.$oldname;
	$eoldname = GDO::escape($oldname);
	if (false === $to_users->selectVar('1', "user_name='$eoldname'"))
	{
		return $oldname;
	}

	// now while with numbers
	$n = 2;
	while (true)
	{
		$name = $oldname.$n;
		$eoldname = GDO::escape($name);
		if (false === $to_users->selectVar('1', "user_name='$eoldname'"))
		{
			return $name;
		}
		$n++;
	}
}

