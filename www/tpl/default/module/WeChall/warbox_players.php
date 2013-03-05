<?php
$headers = array(
	array('Rank'),
	array(''),
	array('Points'),
	array('Username'),
	array('Solved'),
	array('Last Activity'),
);

$box = $tVars['box']; $box instanceof WC_Warbox;
$site = $box->getSite();

echo $tVars['site_quickjump'];

echo $tVars['pagemenu'];

$vars = array($tVars['playercount'], $box->displayName(), $site->displayName());

echo GWF_Box::box($tLang->lang('info_warbox_players', $vars), $tLang->lang('title_warbox_players', $vars));

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);

$rank = $tVars['rank'];

foreach ($tVars['data'] as $row)
{
	echo GWF_Table::rowStart();
	
	echo GWF_Table::column($rank++, 'gwf_num');
	
	echo GWF_Table::column(GWF_Country::displayFlagS($row['country']));
	
	echo GWF_Table::column($row['score'], 'gwf_num');
	
	echo GWF_Table::column(GWF_User::displayProfileLinkS($row['user_name']));
	
	echo GWF_Table::column(sprintf('%s (%.02f%%)', $row['solved'], $row['percent']), 'gwf_num');
	
	echo GWF_Table::column(GWF_Time::displayDate($row['solvedate']), 'gwf_date');
	
	echo GWF_Table::rowEnd();
	
}

echo GWF_Table::end();

echo $tVars['pagemenu'];