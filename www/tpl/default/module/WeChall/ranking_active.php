<?php
echo GWF_Box::box($tLang->lang('pi_activerank', array()));

WC_HTML::rankingPageButtons();

$headers = array(
		array($tLang->lang('th_rank')),
		array(), # country
		array($tLang->lang('th_user_name')),
		array($tLang->lang('th_score')),
		array($tLang->lang('th_progress')),
);

echo $tVars['page_menu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
$rank = $tVars['rank'];
$sameRank = $rank;
$hlrank = $tVars['highlight_rank'];
$lastSum = -1;
$solvetext = ' solved ';
$ontxt = ' on ';
foreach ($tVars['userdata'] as $user)
{
	$user instanceof GWF_User;
	
	$sum = $user->getVar('user_level');
	if ($sum !== $lastSum) {
		$showRank = $rank;
		$sameRank = $rank;
	} else {
		$showRank = $sameRank;
	}
	
	$style = $hlrank == $rank ? WC_HTML::styleSelected() : '';
	echo GWF_Table::rowStart(true, '', '', $style);
	echo sprintf('<td>%d</td>', $rank).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayCountryFlag()).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayProfileLink()).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('user_level')).PHP_EOL;
	
	$username = $user->displayUsername();
	echo '<td>';
	foreach ($tVars['sites'] as $site)
	{
		$site instanceof WC_Site;
		$sid = $site->getVar('site_id');
		$var = 'ss_'.$sid;
		if ($user->hasVar($var))
		{
			$solved = $user->getVar($var);
			$percent = round($solved*100, 2);
			$txt = $username.$solvetext.$percent.'%'.$ontxt.$site->display('site_name');
			echo $site->displayLogo(round(30*$solved+2), $txt, $solved>=1, 32, $username);
		}
		else
		{
			echo '<span class="stublogo"></span>';
		}
		//		echo $site->displayLogoU($user, $solved, 2, 32, true);
		
	}
	echo '</td>'.PHP_EOL;
	echo GWF_Table::rowEnd();
	$rank++;
}
echo GWF_Table::end();

echo $tVars['page_menu'];
echo GWF_Box::box($tLang->lang('scorefaq_box', array(GWF_WEB_ROOT.'scoring_faq')));
?>

<div id="wcrl_slide"></div>
