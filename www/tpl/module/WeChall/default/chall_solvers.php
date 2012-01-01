<?php
$headers = array(
	array(), #$tLang->lang('th_user_cid'), 'user_countyid'),
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_user_level'), 'user_level'),
	array($tLang->lang('th_csolve_date'), 'csolve_date'),
);
$is_staff = GWF_User::isStaffS();

if ($is_staff) {
	$headers[] = array($tLang->lang('th_csolve_time_taken'), 'csolve_time_taken');
}

$chall = $tVars['chall']; $chall instanceof WC_Challenge;
Module_WeChall::includeForums();

$chall->showHeader(true);

$title = $chall->display('chall_title');
$href = $chall->hrefChallenge();
echo GWF_Box::box($tLang->lang('solved_by_text', array($title)), $tLang->lang('solved_by_title', array($href, $title)));

echo $tVars['pagemenu'];

echo '<table>'.PHP_EOL;
echo GWF_Table::displayHeaders2($headers, $tVars['sort_url']);
foreach ($tVars['users'] as $user)
{
	$user instanceof GWF_User;
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $user->displayCountryFlag());
	echo sprintf('<td>%s</td>', $user->displayProfileLink());
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('user_level'));
	echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::displayDate($user->getVar('csolve_date')));
	if ($is_staff) {
		echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::humanDuration($user->getVar('csolve_time_taken')));
	}
	echo GWF_Table::rowEnd();
}
echo '</table>'.PHP_EOL;

echo $tVars['pagemenu'];

?>