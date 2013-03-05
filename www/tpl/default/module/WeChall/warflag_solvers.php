<?php
$headers = array(
	array('Rank'),
	array(),
	array('Username', 'user_name'),
	array('SolvedAt', 'wf_solved_at'),
);

$flag = $tVars['flag']; $flag instanceof WC_Warflag;
$box = $flag->getWarbox();
$site = $box->getSite();

echo $tVars['site_quickjump'];

echo $tVars['pagemenu'];

$vars = array($tVars['solvercount'], $flag->displayName(), $box->displayName(), $site->displayName());
echo GWF_Box::box($tLang->lang('info_warflag_solvers', $vars), $tLang->lang('title_warflag_solvers', $vars));

$pos = $tVars['rank'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

foreach ($tVars['solvers'] as $row)
{
	echo GWF_Table::rowStart();
	
	echo GWF_Table::column($pos, 'gwf_num');
	
	echo GWF_Table::column(GWF_Country::displayFlagS($row['user_countryid']));
	
	echo GWF_Table::column(GWF_User::displayProfileLinkS($row['user_name']));
	
	echo GWF_Table::column(GWF_Time::displayDate($row['wf_solved_at']), 'gwf_date');
	
	echo GWF_Table::rowEnd();
	
	$pos++;
}

echo GWF_Table::end();

echo $tVars['pagemenu'];
