<?php
if (count($tVars['matches']) > 0)
{
	echo '<table>'.PHP_EOL;
	echo sprintf('<tr><th>%s</th></tr>', $tLang->lang('matches', array( count($tVars['matches'])))).PHP_EOL;
	foreach ($tVars['matches'] as $ip)
	{
		echo GWF_Table::rowStart();
		echo sprintf('<td>%s</td>', GWF_IP6::displayIP($ip, GWF_IP_QUICK)).PHP_EOL;
		echo GWF_Table::rowEnd();
	}
	echo '</table>'.PHP_EOL;
}

echo $tVars['form'];
?>
