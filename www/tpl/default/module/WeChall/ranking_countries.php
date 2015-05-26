<?php
echo GWF_Box::box($tLang->lang('pi_csrank'), $tLang->lang('pt_csrank'));

WC_HTML::rankingPageButtons();

$headers = array(
	array('#', null, null, 2),
	array('', null, null, 1),
	array($tLang->lang('th_user_countryid'), 'countryname', 'ASC', 3),
	array($tLang->lang('th_players'), 'users', 'DESC', 6),
	array($tLang->lang('th_score'), 'totalscore', 'DESC', 4),
	array($tLang->lang('th_spc'), 'spc', 'DESC', 7),
	array($tLang->lang('th_avg'), 'avg', 'DESC', 8),
	array($tLang->lang('th_sumtop3'), 'top3', 'DESC', 9),
	array($tLang->lang('th_top_player'), 'topuser', 'ASC', 5),
);
$rank = 1;
$hlc = $tVars['highlight_country'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
$sl = WC_HTML::styleSelected();
foreach ($tVars['data'] as $row)
{
	$cid = $row['country_id'];
	$topuser = $row['topuser'];
	$style = $hlc == $cid ? $sl : '';
	$href = GWF_WEB_ROOT.'country_ranking/for/'.$cid.'/'.Common::urlencodeSEO($row['countryname']);
	echo GWF_Table::rowStart(true, '', '', $style);
	echo sprintf('<td class="gwf_num">%d</td>', $rank++);
	echo sprintf('<td>%s</td>', GWF_Country::displayFlagS2($cid, $row['countryname']));
	echo sprintf('<td><a href="%s">%s</a></td>', $href, GWF_HTML::display($row['countryname']));
	echo sprintf('<td class="gwf_num">%d</td>', $row['users']);
	echo sprintf('<td class="gwf_num">%d</td>', $row['totalscore']);
	echo sprintf('<td class="gwf_num">%s</td>', $row['spc']);
	echo sprintf('<td class="gwf_num">%d</td>', $row['avg']);
	echo sprintf('<td class="gwf_num">%d</td>', $row['top3']);
	echo sprintf('<td><a href="%s" title="%s">%s</a></td>', GWF_WEB_ROOT.'profile/'.urlencode($topuser), $tLang->lang('a_title', array($row['topscore'])), GWF_HTML::display($topuser));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Box::box($tLang->lang('scorefaq_box', GWF_WEB_ROOT.'scoring_faq'));
