<?php
function Upgrade_WeChall_5_06(Module_WeChall $module)
{
	GWF_Website::addDefaultOutput(GWF_HTML::message('WC5', "Database additions for speedy warboxes."));
	
	gdo_db()->setDieOnError(false);
	GWF_Debug::setDieOnError(false);
	
	$back = '';

	# Copy warchalls to warflags table
	$module->includeClass('WC_Warchall');
	$module->includeClass('WC_Warchalls');
	$module->includeClass('WC_Warflag');
	$module->includeClass('WC_Warflags');
	
	$flag = GDO::table('WC_Warflag');
	$flags = GDO::table('WC_Warflags');
	
	#
	if (!$flag->createColumn('wf_solvers'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$flag->createColumn('wf_options'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$flag->dropColumn('wf_flag'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	$flag->update("wf_options=1");
	
	$now = GWF_Time::getDate();
	
	$chall = GDO::table('WC_Warchall');
	$challs = GDO::table('WC_Warchalls');
	
	foreach ($chall->selectAll('*', '', '', NULL, -1, -1, GDO::ARRAY_O) as $c)
	{
		$c instanceof WC_Warchall;
		
		$boxid = $c->getVar('wc_boxid');
		
		$newflag = new WC_Warflag(array(
			'wf_id' => '0',
			'wf_wbid' => $boxid,
			'wf_order' => '0',
			'wf_cat' => 'exploit',
			'wf_score' => '1',
			'wf_solvers' => '0',
			'wf_title' => $c->getVar('wc_level'),
			'wf_url' => '',
			'wf_authors' => 'Steven',
			'wf_status' => 'up',
			'wf_login' => '',
			'wf_flag_enc' => NULL,
			'wf_created_at' => $now,
			'wf_last_solved_at' => NULL,
			'wf_last_solved_by' => NULL,
			'wf_options' => WC_Warflag::WARCHALL,
		));
		
		$newflag->replace();
		
		$nfid = $newflag->getID();
		
		foreach ($challs->selectAll('*', "wc_wcid={$c->getID()}", '', NULL, -1, -1, GDO::ARRAY_O) as $entry)
		{
			$entry instanceof WC_Warchalls;
			
			$flags->insertAssoc(array(
				'wf_wfid' => $nfid,
				'wf_uid' => $entry->getVar('wc_uid'),
				'wf_solved_at' => $entry->getVar('wc_solved_at'),
				'wf_attempts' => '1',
				'wf_last_attempt' => NULL,
			));
		}
	}
	
	
	$flag->update("wf_solvers = (SELECT COUNT(*) FROM wc4_wc_warflags WHERE wf_wfid=wf_id)");
	$flag->update("wf_last_solved_at = (SELECT MAX(wf_solved_at) FROM wc4_wc_warflags WHERE wf_wfid=wf_id)");
	$flag->update("wf_last_solved_by = (SELECT wf_uid FROM wc4_wc_warflags WHERE wf_wfid=wf_id ORDER BY wf_solved_at DESC LIMIT 1)");

	$module->includeClass('WC_Warbox');
	$boxes = GDO::table('WC_Warbox');
	if (!$boxes->createColumn('wb_players'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$boxes->createColumn('wb_flags'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$boxes->createColumn('wb_challs'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	if (!$boxes->createColumn('wb_totalscore'))
	{
		$back .= GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	foreach ($boxes->selectAll('*', "", "", NULL, -1, -1, GDO::ARRAY_O) as $box)
	{
		$box instanceof WC_Warbox;
		$box->recalcPlayersAndScore();
	}
	
	$box->update("wb_challs=(SELECT COUNT(*) FROM wc4_wc_warflag WHERE wf_wbid=wb_id)");
	$box->update("wb_levels=(SELECT COUNT(*) FROM wc4_wc_warflag WHERE wf_wbid=wb_id AND wf_options&2)");
	$box->update("wb_flags=(SELECT COUNT(*) FROM wc4_wc_warflag WHERE wf_wbid=wb_id AND wf_options&1)");
	
	$chall->dropTable();
	$challs->dropTable();
	
	return $back;
}
