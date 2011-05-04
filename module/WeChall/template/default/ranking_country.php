<?php
$headers = array(
	array('#'),
	array($tLang->lang('th_user_name')),
	array($tLang->lang('th_score')),
);
$headers = GWF_Table::getHeaders2($headers);

echo GWF_Box::box($tLang->lang('pi_crank', $tVars['cname']), GWF_Country::displayFlagS($tVars['cid']).' '.$tLang->lang('pt_crank', $tVars['cname'], $tVars['page']));

WC_HTML::rankingPageButtons();

echo $tVars['page_menu'];
echo '<table>'.PHP_EOL;
echo GWF_Table::displayHeaders($headers);
$rank = $tVars['rank'];
$hlrank = $tVars['hl_rank'];
foreach ($tVars['data'] as $user)
{
//	$user instanceof GWF_User;
	$style = $hlrank == $rank ? WC_HTML::styleSelected() : '';
	
	echo GWF_Table::rowStart($style);
	echo sprintf('<td class="gwf_num"><a name="rank_%s">%s</a></td>', $rank, $rank);
	echo sprintf('<td>%s</td>', $user->displayProfileLink());
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('user_level'));
	echo GWF_Table::rowEnd();
	$rank++;
}
echo '</table>'.PHP_EOL;
echo $tVars['page_menu'];
echo GWF_Box::box($tLang->lang('scorefaq_box', GWF_WEB_ROOT.'scoring_faq'));
?>