<?php
Module_WeChall::includeForums();

$chall = $tVars['chall']; $chall instanceof WC_Challenge;

$headers = array(
	array($tLang->lang('th_length'), 'wmc_length'),
	array($tLang->lang('th_csolve_date'), 'wmc_date'),
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_solution'), 'wmc_solution'),
);
$chall->showHeader(true);

echo GWF_Box::box($tVars['table_title']);

echo $tVars['page_menu'];

echo GWF_Table::start();
//echo GWF_Table::displayHeaders1($headers, $tVars['sort_url'], 'wmc_date', 'ASC', 'by', 'dir', $tVars['table_title']);
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
$guest = GWF_Guest::getGuest();
$userr = new GWF_User(false);
foreach ($tVars['data'] as $row)
{
	if ($row['user_name'] === NULL) {
		$username = GWF_HTML::lang('guest');
	} else {
		$userr->setGDOData($row);
		$username = $userr->displayProfileLink();
	}
	echo GWF_Table::rowStart();
	echo GWF_Table::column($row['wmc_length'], 'gwf_num');
	echo GWF_Table::column(GWF_Time::displayDate($row['wmc_date']), 'gwf_date');
	echo GWF_Table::column($username);
	echo GWF_Table::column($row['wmc_solution']);
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();

echo $tVars['page_menu'];
?>
