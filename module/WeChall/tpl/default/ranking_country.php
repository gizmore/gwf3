<?php
$headers = array(
	array('#'),
	array($tLang->lang('th_user_name')),
	array($tLang->lang('th_score')),
);

echo GWF_Box::box($tLang->lang('pi_crank', array($tVars['cname'])), GWF_Country::displayFlagS($tVars['cid']).' '.$tLang->lang('pt_crank', array($tVars['cname'], $tVars['page'])));

WC_HTML::rankingPageButtons();

echo $tVars['page_menu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
$rank = $tVars['rank'];
$hlrank = $tVars['hl_rank'];
foreach ($tVars['data'] as $user)
{
//	$user instanceof GWF_User;
	$style = $hlrank == $rank ? WC_HTML::styleSelected() : '';
	
	echo GWF_Table::rowStart(true, '', '', $style);
	echo sprintf('<td class="gwf_num"><a name="rank_%s">%s</a></td>', $rank, $rank);
	echo sprintf('<td>%s</td>', $user->displayProfileLink());
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('user_level'));
	echo GWF_Table::rowEnd();
	$rank++;
}
echo GWF_Table::end();
echo $tVars['page_menu'];
echo GWF_Box::box($tLang->lang('scorefaq_box', array(GWF_WEB_ROOT.'scoring_faq')));
?>