<?php
final class Merge_Forum
{
	private static function calcOffsets(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		$classnames = array('GWF_ForumAttachment', 'GWF_ForumPost', 'GWF_ForumPostHistory', 'GWF_ForumThread');
		foreach ($classnames as $classname)
		{
			merge_calc_offset($db_from, $db_to, $db_offsets, $classname);
		}
	}
	
	private static function includeClasses()
	{
		$module = GWF_Module::getModule('Forum');
		$classnames = array(
		);
		foreach ($classnames as $classname)
		{
			$module->includeClass($classname);
		}
	}
	
	private static function calcMaps(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		$classname = 'GWF_ForumBoard';
		$db_offsets[$classname] = array();
		
		GDO::setCurrentDB($db_from);
		$table_from = GDO::table($classname);
		if (false === ($result = $table_from->select('*', '', 'board_bid ASC')))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		GDO::setCurrentDB($db_to);
		$table_to = GDO::table($classname);
		while (false !== ($row = $table_from->fetch($result, GDO::ARRAY_A)))
		{
			$bid_from = $row['board_bid'];
			$title_from = $row['board_title'];
			$etitle_from = GDO::escape($title_from);
			
			if (false !== ($oldbid = $table_to->selectVar('board_bid', "board_title='$etitle_from'")))
			{
				$db_offsets[$classname][$bid_from] = $oldbid;
				echo "BID $bid_from => $oldbid\n";
				$table_to->update("board_postcount = board_postcount + {$row['board_postcount']}", "board_bid = $oldbid");
				$table_to->update("board_threadcount = board_threadcount + {$row['board_threadcount']}", "board_bid = $oldbid");
			}
			else
			{
				if ($row['board_pid'] > 0) // Skip the root if it could not get merged
				{
					$row['board_bid'] = '0';
					$row['board_pid'] |= 0x40000000; // PID HAS TO GET CONVERTED after this run
					$row['board_gid'] = $db_offsets['GWF_Group'][$row['board_gid']];
					$row['board_pos'] = $table_to->selectVar('COUNT(*)') + 1;
					$table_to->insertAssoc($row);
					$newbid = $db_to->insertID();
					$db_offsets[$classname][$bid_from] = $newbid;
					echo "BID $bid_from => $newbid\n";
				}
				else // Merge root counts.
				{
					$db_offsets[$classname][$bid_from] = $oldbid;
					echo "BID $bid_from => $oldbid\n";
					$table_to->update("board_postcount = board_postcount + {$row['board_postcount']}", "board_pid = 0");
					$table_to->update("board_threadcount = board_threadcount + {$row['board_threadcount']}", "board_pid = 0");
				}
			}
		}
		$table_from->free($result);
		return true;
	}
	
	private static function fixPIDs(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		$classname = 'GWF_ForumBoard';
		GDO::setCurrentDB($db_to);
		$boards = GDO::table($classname);
		if (false === ($result = $boards->select('board_bid, board_pid', 'board_pid > 0x40000000')))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		while (false !== ($row = $boards->fetch($result, GDO::ARRAY_N)))
		{
			list($bid, $pid) = $row;
			$pid = $db_offsets[$classname][(string)($pid-0x40000000)];
			$boards->update("board_pid=$pid", "board_bid=$bid");
		}
		$boards->free($result);
	}
	
	public static function onMerge(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		self::includeClasses();
		self::calcOffsets($db_from, $db_to, $db_offsets, $prefix, $prevar);
		self::calcMaps($db_from, $db_to, $db_offsets, $prefix, $prevar);
		self::fixPIDs($db_from, $db_to, $db_offsets, $prefix, $prevar);
		
		// GWF_ForumAttachment
		merge_add_offset($db_from, $db_to, 'GWF_ForumAttachment', 'fatt_aid', $db_offsets['GWF_ForumAttachment']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumAttachment', 'fatt_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumAttachment', 'fatt_pid', $db_offsets['GWF_ForumPost']);
		merge_table($db_from, $db_to, 'GWF_ForumAttachment');
		
		// GWF_ForumBoard # DONE WITH MAPS AND FIX-PID
		
		// GWF_ForumOptions
		merge_add_offset($db_from, $db_to, 'GWF_ForumOptions', 'fopt_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'GWF_ForumOptions');
		
		// GWF_ForumPost
		merge_add_offset($db_from, $db_to, 'GWF_ForumPost', 'post_pid', $db_offsets['GWF_ForumPost']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumPost', 'post_tid', $db_offsets['GWF_ForumThread']);
		merge_use_mapping($db_from, $db_to, 'GWF_ForumPost', 'post_gid', $db_offsets['GWF_Group']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumPost', 'post_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumPost', 'post_euid', $db_offsets['GWF_User']);
		merge_fix_uname($db_from, $db_to, $db_offsets, 'GWF_ForumPost', 'post_eusername');
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'GWF_ForumPost', 'post_thanks_by');
		merge_fix_uname_blob($db_from, $db_to, $db_offsets, 'GWF_ForumPost', 'post_thanks_txt');
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'GWF_ForumPost', 'post_voted_up');
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'GWF_ForumPost', 'post_voted_down');
		merge_table($db_from, $db_to, 'GWF_ForumPost');
		
		// GWF_ForumPostHistory
		merge_add_offset($db_from, $db_to, 'GWF_ForumPostHistory', 'fph_id', $db_offsets['GWF_ForumPostHistory']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumPostHistory', 'fph_pid', $db_offsets['GWF_ForumPost']);
		merge_use_mapping($db_from, $db_to, 'GWF_ForumPostHistory', 'fph_gid', $db_offsets['GWF_Group']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumPostHistory', 'fph_euid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'GWF_ForumPostHistory');

		// GWF_ForumSubscrBoard
		merge_add_offset($db_from, $db_to, 'GWF_ForumSubscrBoard', 'subscr_uid', $db_offsets['GWF_User']);
		merge_use_mapping($db_from, $db_to, 'GWF_ForumSubscrBoard', 'subscr_bid', $db_offsets['GWF_ForumBoard']);
		merge_table($db_from, $db_to, 'GWF_ForumSubscrBoard');
		
		// GWF_ForumSubscription
		merge_add_offset($db_from, $db_to, 'GWF_ForumSubscription', 'subscr_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumSubscription', 'subscr_tid', $db_offsets['GWF_ForumThread']);
		merge_table($db_from, $db_to, 'GWF_ForumSubscription');
		
		// GWF_ForumThread
		merge_add_offset($db_from, $db_to, 'GWF_ForumThread', 'thread_tid', $db_offsets['GWF_ForumThread']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumThread', 'thread_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumThread', 'thread_lastpost', $db_offsets['GWF_ForumPost']);
		merge_add_offset($db_from, $db_to, 'GWF_ForumThread', 'thread_pollid', $db_offsets['GWF_VoteMulti']);
		merge_use_mapping($db_from, $db_to, 'GWF_ForumThread', 'thread_bid', $db_offsets['GWF_ForumBoard']);
		merge_use_mapping($db_from, $db_to, 'GWF_ForumThread', 'thread_gid', $db_offsets['GWF_Group']);
		merge_fix_uname($db_from, $db_to, $db_offsets, 'GWF_ForumThread', 'thread_firstposter');
		merge_fix_uname($db_from, $db_to, $db_offsets, 'GWF_ForumThread', 'thread_lastposter');
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'GWF_ForumThread', 'thread_unread');
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'GWF_ForumThread', 'thread_force_unread');
		merge_table($db_from, $db_to, 'GWF_ForumThread');
	}
}
