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
foreach ($tVars['langs'] as $lang)
{
//	var_dump($lang);
	$lang = GWF_Language::getByID($lang);
	$href = GWF_WEB_ROOT.'lang_ranking/'.$lang->getISO();
	$head = sprintf('<a href="%s">%s</a>', $href, $lang->displayName());
	$headers[] = array($head);
}

//$headers = GWF_Table::getHeaders2($headers, '');

$rank = $tVars['rank'];
$highlight_rank = $tVars['highlight_rank'];
$samerank = $rank;
$samescore = 0;

echo $tVars['pagemenu'];

echo '<table>'.PHP_EOL;
echo GWF_Table::displayHeaders2($headers);
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
	echo GWF_Table::rowStart($style);
	echo sprintf('<td><a name="rank_%s">%s</a></td>', $rank, $samerank).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayCountryFlag()).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayProfileLink()).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('nlinks'));
	echo sprintf('<td class="gwf_num">%s</td>', $user->getLevel()).PHP_EOL;
	foreach ($tVars['langs'] as $i => $lang)
	{
		if ($user->hasVar('grank_'.$lang)) {
			$anchor = GWF_HTML::anchor(GWF_WEB_ROOT.'lang_ranking/'.$tVars['isos'][$i].'/for/'.$user->urlencode2('user_name'), $user->getVar('grank_'.$lang, ''));
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
