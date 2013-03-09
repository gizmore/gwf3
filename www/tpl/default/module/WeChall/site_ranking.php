<?php
$site = $tVars['site']; $site instanceof WC_Site;
$logo = $site->displayLogo(42, $tLang->lang('hover_logo', array($site->displayName())));
$link = $site->displayLink();
$title = $tVars['page_title'];
?>
<h1><?php echo "$logo $title ($link)"; ?></h1>
<?php echo $tVars['site_quickjump']; ?>
<?php

$headers = array(
	array(),
	array(),
	array($tLang->lang('th_user_name')),
//	array($tLang->lang('th_user_level')),
	array($tLang->lang('th_score')),
	array($tLang->lang('th_regat_onsitescore')),
	array($tLang->lang('th_progress')),
);

$rank = $tVars['rank'];
$same_rank = $rank;
$same_score = 0;
$maxscore = $tVars['site']->getOnsiteScore();

echo $tVars['page_menu'];

$has_osr = $site->isOptionEnabled(WC_Site::ONSITE_RANK);

echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers);
$solvetext = ' solved ';
$ontxt = ' on ';
$sid = $tVars['site']->getVar('site_id');
foreach ($tVars['userdata'] as $user)
{
	$user instanceof GWF_User;
//	var_dump($user);
	$var = 'site_'.$sid;
	if ($user->hasVar($var)) {
		$solved = $user->getVar($var);
//		$solved = $user->getVar('regat_solved');
		$logo = $tVars['site']->displayLogoU($user, $user->getVar($var), 2, 32, true);
	} 
	else {
		$solved = 0;
		$logo = '<span class="stublogo"></span>';
	}
	$score = $user->getLevel();
	if ($solved !== $same_score) {
		$same_rank = $rank;
		$same_score = $solved;
	}
	
	if ($has_osr === true)
	{
		$osr = $user->getVar('regat_onsiterank');
		if ($osr === '0') {
			$osr = '?';
		}
		$onsiterank = "&nbsp;($osr)"; 
	}
	else {
		$onsiterank = '';
	}
	
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $same_rank );
//	echo sprintf('<td>%s</td>', GWF_Country::displayFlagS($data['user_countryid']));
	echo sprintf('<td>%s</td>', $user->displayCountryFlag());
	echo sprintf('<td>%s</td>', GWF_HTML::anchor($user->getProfileHREF(), $user->getVar('user_name')));
//	echo sprintf('<td class="gwf_num">%s</td>', $score);
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('regat_score'));
	echo sprintf('<td class="gwf_num">%.02f%%</td>', $user->getVar('regat_solved')*100);
	echo '<td>';
	
	echo $logo;
	$username = $user->display('user_name');
	foreach ($tVars['sites'] as $site)
	{
		$site instanceof WC_Site;
		$sid2 = $site->getVar('site_id');
		$var = 'site_'.$sid2;
		if ($user->hasVar($var)) {
			$solved = $user->getVar($var);
			$percent = round($solved*100,2);
			$txt = $username.$solvetext.$percent.'%'.$ontxt.$site->display('site_name');
			echo $site->displayLogo(round(30*$solved+2), $txt, $solved>=1, 32, $username);
		}
		else {
			echo '<span class="stublogo"></span>';
		}
//		echo $site->displayLogoU($user, $user->getVar('site_'.$sid), 2, 32, true);
	}
	echo '</td>';
	echo GWF_Table::rowEnd();
	$rank++;
}
echo GWF_Table::end();

echo $tVars['page_menu'];
?>

<div id="wcrl_slide"></div>
