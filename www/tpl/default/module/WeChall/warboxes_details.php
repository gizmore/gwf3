<?php
$headers = array(
	array('ID', 'wb_id'),
	array('Points', 'wb_totalscore'),
	array('Name', 'wb_name'),
	array('Levels', 'wb_challs'),
	array('Players', 'wb_players'),
	array('Status', 'wb_status'),
	array(''),
);

// $box = $tVars['box']; $box instanceof WC_Warbox;
$site = $tVars['site']; $site instanceof WC_Site;

echo $tVars['site_quickjump'];

echo GWF_Box::box($tLang->lang('info_warboxes_details', array($site->displayName(), count($tVars['boxes']))), $tLang->lang('title_warboxes_details', array($site->displayName(), count($tVars['boxes']))));

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

// $pos = 1;
foreach ($tVars['boxes'] as $box)
{
	$box instanceof WC_Warbox;
	
// 	var_dump($box);
	
	echo GWF_Table::rowStart();
	
// 	echo GWF_Table::column($pos);

	echo GWF_Table::column($box->getID(), 'gwf_num');
	
	echo GWF_Table::column($box->getVar('wb_totalscore'), 'gwf_num');
	
	echo GWF_Table::column(GWF_HTML::anchor($box->getWebURL(), $box->getVar('wb_name')));
	
	echo GWF_Table::column(GWF_HTML::anchor($box->hrefDetails(), $box->getVar('wb_challs')), 'gwf_num');
	
	echo GWF_Table::column(GWF_HTML::anchor($box->hrefPlayers(), $box->getVar('wb_players')), 'gwf_num');
	
	echo GWF_Table::column($box->getVar('wb_status'));
	
// 	if ($box->getVar('flagcount') > 0)
	{
// 		echo GWF_Table::column(GWF_Button::forward($box->hrefFlags(), 'Enter Solutions'));
	}
// 	else
	{
		echo GWF_Table::column();
	}
	
	echo GWF_Table::rowEnd();
// 	$pos++;
}

echo GWF_Table::end();
