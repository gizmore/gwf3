<?php
final class WC_Merge
{
	private static function calcOffsets(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		$classnames = array('WC_Challenge', 'WC_Site', 'WC_Warbox', 'WC_Warflag', 'WC_MathChall');
		foreach ($classnames as $classname)
		{
			merge_calc_offset($db_from, $db_to, $db_offsets, $classname);
		}
	}
	
	private static function includeClasses()
	{
		$module = GWF_Module::getModule('WeChall');
		$module->includeClass('WC_ChallSolved');
		$module->includeClass('WC_FavCats');
		$module->includeClass('WC_FirstLink');
		$module->includeClass('WC_Freeze');
		$module->includeClass('WC_HistorySite');
		$module->includeClass('WC_HistoryUser2');
		$module->includeClass('WC_MathChall');
		$module->includeClass('WC_RegAt');
		$module->includeClass('WC_SiteAdmin');
		$module->includeClass('WC_SiteCats');
		$module->includeClass('WC_SiteDescr');
		$module->includeClass('WC_SiteFavorites');
		$module->includeClass('WC_Warflag');
		$module->includeClass('WC_Warflags');
		$module->includeClass('WC_WarToken');
	}
	
	public static function onMerge(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		self::includeClasses();
		
		self::calcOffsets($db_from, $db_to, $db_offsets, $prefix, $prevar);
		
		// WC_Challenge
		merge_add_offset($db_from, $db_to, 'WC_Challenge', 'chall_id', $db_offsets['WC_Challenge']);
		merge_add_offset($db_from, $db_to, 'WC_Challenge', 'chall_vote_dif', $db_offsets['GWF_VoteScore']);
		merge_add_offset($db_from, $db_to, 'WC_Challenge', 'chall_vote_edu', $db_offsets['GWF_VoteScore']);
		merge_add_offset($db_from, $db_to, 'WC_Challenge', 'chall_vote_fun', $db_offsets['GWF_VoteScore']);
		merge_use_mapping($db_from, $db_to, 'WC_Challenge', 'chall_board', $db_offsets['GWF_ForumBoard']);
		merge_use_mapping($db_from, $db_to, 'WC_Challenge', 'chall_sboard', $db_offsets['GWF_ForumBoard']);
		merge_fix_uid_blob($db_from, $db_to, $db_offsets, 'WC_Challenge', 'chall_creator', ',');
		merge_fix_uname_blob($db_from, $db_to, $db_offsets, 'WC_Challenge', 'chall_creator_name', ',');
		merge_use_mapping($db_from, $db_to, 'WC_Challenge', 'chall_gid', $db_offsets['GWF_Group']);
		merge_table($db_from, $db_to, 'WC_Challenge');
		
		// WC_ChallSolved
		merge_add_offset($db_from, $db_to, 'WC_ChallSolved', 'csolve_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_ChallSolved', 'csolve_cid', $db_offsets['WC_Challenge']);
		merge_table($db_from, $db_to, 'WC_ChallSolved');
		
		// WC_FavCats
		merge_add_offset($db_from, $db_to, 'WC_FavCats', 'wcfc_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_FavCats');
		
		// WC_FirstLink
		merge_add_offset($db_from, $db_to, 'WC_FirstLink', 'fili_sid', $db_offsets['WC_Site']);
		merge_add_offset($db_from, $db_to, 'WC_FirstLink', 'fili_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_FirstLink');
		
		// WC_Freeze
		merge_add_offset($db_from, $db_to, 'WC_Freeze', 'wcf_sid', $db_offsets['WC_Site']);
		merge_add_offset($db_from, $db_to, 'WC_Freeze', 'wcf_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_Freeze');
		
		// WC_HistorySite
		merge_add_offset($db_from, $db_to, 'WC_HistorySite', 'sitehist_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_HistorySite');
		
		// WC_HistoryUser # DEPRECATED
// 		merge_add_offset($db_from, $db_to, 'WC_HistoryUser', 'userhist_uid', $db_offsets['GWF_User']);
// 		merge_add_offset($db_from, $db_to, 'WC_HistoryUser', 'userhist_sid', $db_offsets['WC_Site']);
// 		merge_table($db_from, $db_to, 'WC_HistoryUser');
		
		// WC_HistoryUser2
		merge_add_offset($db_from, $db_to, 'WC_HistoryUser2', 'userhist_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_HistoryUser2', 'userhist_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_HistoryUser2');
		
		// WC_MathChall
		merge_add_offset($db_from, $db_to, 'WC_MathChall', 'wmc_id', $db_offsets['WC_MathChall']);
		merge_add_offset($db_from, $db_to, 'WC_MathChall', 'wmc_cid', $db_offsets['WC_Challenge']);
		merge_add_offset($db_from, $db_to, 'WC_MathChall', 'wmc_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_MathChall');
		
		// WC_RegAt
		merge_add_offset($db_from, $db_to, 'WC_RegAt', 'regat_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_RegAt', 'regat_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_RegAt');
		
		// WC_Site
		merge_add_offset($db_from, $db_to, 'WC_Site', 'site_id', $db_offsets['WC_Site']);
		merge_add_offset($db_from, $db_to, 'WC_Site', 'site_vote_dif', $db_offsets['GWF_VoteScore']);
		merge_add_offset($db_from, $db_to, 'WC_Site', 'site_vote_fun', $db_offsets['GWF_VoteScore']);
		merge_use_mapping($db_from, $db_to, 'WC_Site', 'site_boardid', $db_offsets['GWF_ForumBoard']);
		merge_add_offset($db_from, $db_to, 'WC_Site', 'site_threadid', $db_offsets['GWF_ForumThread']);
		merge_table($db_from, $db_to, 'WC_Site');
		self::fix_missing_site_threads($db_from, $db_to, $db_offsets);
		
		// WC_SiteAdmin
		merge_add_offset($db_from, $db_to, 'WC_SiteAdmin', 'siteadmin_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_SiteAdmin', 'siteadmin_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_SiteAdmin');
		
		// WC_SiteCats
		merge_add_offset($db_from, $db_to, 'WC_SiteCats', 'sitecat_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_SiteCats');
		
		// WC_SiteDescr
		merge_add_offset($db_from, $db_to, 'WC_SiteDescr', 'site_desc_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_SiteDescr');
		
		// WC_SiteFavorites
		merge_add_offset($db_from, $db_to, 'WC_SiteFavorites', 'sitefav_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_SiteFavorites', 'sitefav_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_SiteFavorites');
		
		// WC_SiteMaster
		merge_add_offset($db_from, $db_to, 'WC_SiteMaster', 'sitemas_uid', $db_offsets['GWF_User']);
		merge_add_offset($db_from, $db_to, 'WC_SiteMaster', 'sitemas_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_SiteMaster');
		
		// WC_SolutionBlock
		# NOT NEEDED
		
		// WC_Warbox
		merge_add_offset($db_from, $db_to, 'WC_Warbox', 'wb_id', $db_offsets['WC_Warbox']);
		merge_add_offset($db_from, $db_to, 'WC_Warbox', 'wb_sid', $db_offsets['WC_Site']);
		merge_table($db_from, $db_to, 'WC_Warbox');
		
		// WC_Warchall  # DEPRECATED
		// WC_Warchalls # DEPRECATED
		
		// WC_Warflag
		merge_add_offset($db_from, $db_to, 'WC_Warflag', 'wf_id', $db_offsets['WC_Warflag']);
		merge_add_offset($db_from, $db_to, 'WC_Warflag', 'wf_wbid', $db_offsets['WC_Warbox']);
		merge_add_offset($db_from, $db_to, 'WC_Warflag', 'wf_last_solved_by', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_Warflag');
		
		// WC_Warflags
		merge_add_offset($db_from, $db_to, 'WC_Warflags', 'wf_wfid', $db_offsets['WC_Warflag']);
		merge_add_offset($db_from, $db_to, 'WC_Warflags', 'wf_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_Warflags');
		
		// WC_WarToken
		merge_add_offset($db_from, $db_to, 'WC_WarToken', 'wt_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'WC_WarToken');
	}

	private static function fix_missing_site_threads(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets)
	{
		GDO::setCurrentDB($db_to);
		$table = GDO::table('WC_Site');
		$module = GWF_Module::getModule('WeChall');

		// Boards
// 		if (false === ($result = $table->select('*')))
// 		{
// 			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
// 			return false;
// 		}
// 		while (false !== ($site = $table->fetch($result, GDO::ARRAY_O)))
// 		{
// 			$site instanceof WC_Site;
// 			if (false === GDO::table('GWF_ForumBoard')->select('1', "board_id={$site->getBoardID()}"))
// 			{
// 				GWF_Cronjob::notice(sprintf('Site %s has no board!', $site->getClassName()));
// 				$site->onCreateBoard();
// 			}
// 		}
// 		$table->free($result);

		// Threads
		if (false === ($result = $table->select('*')))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		while (false !== ($site = $table->fetch($result, GDO::ARRAY_O)))
		{
			$site instanceof WC_Site;
			if (false === $site->getThread())
			{
				GWF_Cronjob::notice(sprintf('Site %s has no thread!', $site->getClassName()));
				$site->onCreateThread($module);
			}
		}
		$table->free($result);
	}
	
}
