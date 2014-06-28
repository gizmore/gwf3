<?php
$headers = array(
array($tLang->lang('th_date')),
array($tLang->lang('th_ua')),
array($tLang->lang('th_ip')),
array($tLang->lang('th_isp')),
);

echo $tVars['page_menu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

while ($access = $tVars['table']->fetch($tVars['result'], GDO::ARRAY_O))
{
	$access instanceof GWF_AccountAccess;
	echo GWF_Table::rowStart();
	echo GWF_Table::column($access->displayDate(), 'gwf_date');
	echo GWF_Table::column($access->displayUAHex(), 'gwf_num');
	echo GWF_Table::column($access->displayIP(), 'gwf_num');
	echo GWF_Table::column($access->displayISPHex(), 'gwf_num');
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();

echo $tVars['page_menu'];
