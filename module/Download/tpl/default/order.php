<?php
$dl = $tVars['dl']; $dl instanceof GWF_Download;

echo '<table>';

echo sprintf('<tr><th colspan="2">%s</th></tr>', $tLang->lang('th_paid_download'));

echo GWF_Table::rowStart();
echo sprintf('<td>%s</td>', $tLang->lang('th_dl_filename'));
echo sprintf('<td>%s</td>', $dl->display('dl_filename'));
echo GWF_Table::rowEnd();

if ($dl->expires()) {
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $tLang->lang('th_dl_expiretime'));
	echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::humanDuration($dl->getVar('dl_expire')));
	echo GWF_Table::rowEnd();
}

echo '</table>';

?>