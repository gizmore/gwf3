<?php

echo GWF_Box::box($tLang->lang('pi_ranking'), $tLang->lang('pit_ranking'));

WC_HTML::rankingPageButtons();

$headers = array(
	array($tLang->lang('th_rank')),
	array(),
	array($tLang->lang('th_user_name')),
	array($tLang->lang('th_num_linked')),
	array($tLang->lang('th_user_level')),
);
$isos = array();
foreach ($tVars['langs'] as $lang)
{
	$lang = GWF_Language::getByID($lang);
	$iso = $lang->getISO();
	$href = GWF_WEB_ROOT.'lang_ranking/'.$iso;
	$head = sprintf('<a href="%s">%s</a>', $href, $lang->displayName());
	$headers[] = array($head);
	$isos[] = $iso;
}

$rank = $tVars['rank'];
$highlight_rank = $tVars['highlight_rank'];
$samerank = $rank;
$samescore = 0;

echo $tVars['pagemenu'];

echo '<table>'.PHP_EOL;
// echo '<thead>'.PHP_EOL;
echo GWF_Table::displayHeaders2($headers);
// echo '</thead>'.PHP_EOL;
foreach ($tVars['userdata'] as $user)
{
	$user instanceof GWF_User;
//	var_dump($user->getGDOData());
	$score = $user->getLevel();
	if ($score !== $samescore) {
		$samerank = $rank;
		$samescore = $score;
	}
	
	$style = $samerank === $highlight_rank ? WC_HTML::styleSelected() : '';
	echo GWF_Table::rowStart(true, '', 'rank_'.$rank, $style);
	echo sprintf('<td>%s</td>', $samerank).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayCountryFlag()).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayProfileLink()).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('nlinks'));
	echo sprintf('<td class="gwf_num">%s</td>', $user->getLevel()).PHP_EOL;
	foreach ($tVars['langs'] as $i => $lang)
	{
		if ($user->hasVar('grank_'.$lang)) {
			$anchor = GWF_HTML::anchor(GWF_WEB_ROOT.'lang_ranking/'.$isos[$i].'/for/'.$user->urlencode2('user_name'), $user->getVar('grank_'.$lang, ''));
		} else {
			$anchor = '';
		}
		echo sprintf('<td class="gwf_num">%s</td>', $anchor).PHP_EOL;
	}
	
	echo GWF_Table::rowEnd();
	$rank++;
}
echo '</table>'.PHP_EOL;
echo $tVars['pagemenu'];

echo GWF_Box::box($tLang->lang('scorefaq_box', array(GWF_WEB_ROOT.'scoring_faq')));

?>
