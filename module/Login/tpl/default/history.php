<?php

if ($tVars['cleared'] !== false)
{
	$c = $tVars['cleared'];
	echo GWF_Box::box($tLang->lang('info_cleared', array( $c->displayDate(), $c->displayIP(), $c->displayHost())));
}

$headers = array(
	array($tLang->lang('th_loghis_time'), 'loghis_time'),
	array($tLang->lang('th_loghis_ip'), 'loghis_ip'),
	array($tLang->lang('th_hostname')),
);
echo $tVars['page_menu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['history'] as $h)
{
	$h instanceof GWF_LoginHistory;
	echo GWF_Table::rowStart();
	echo GWF_Table::column($h->displayDate(), 'gwf_date');
	echo GWF_Table::column($h->displayIP());
	echo GWF_Table::column($h->displayHostname());
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo $tVars['page_menu'];

echo $tVars['form'];
?>