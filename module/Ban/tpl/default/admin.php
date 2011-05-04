<?php
echo $tVars['form_ban'];
$headers = array(
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_ban_type'), 'ban_options&3'),
	array($tLang->lang('th_ban_date'), 'ban_date'),
	array($tLang->lang('th_ban_ends'), 'ban_ends'),
	array($tLang->lang('th_ban_msg'), 'ban_msg'),
);
echo $tVars['page_menu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['bans'] as $ban)
{
	$ban instanceof GWF_Ban;
	$user = $ban->getUser();
	$href = GWF_WEB_ROOT.'profile/'.$user->urlencode('user_name');
	echo GWF_Table::rowStart();
	echo sprintf('<td><a href="%s">%s</a></td>', $href, $user->displayUsername());
	echo sprintf('<td>%s</td>', $tLang->lang('type_'.$ban->getType()));
	echo sprintf('<td>%s</td>', $ban->displayDate());
	echo sprintf('<td>%s</td>', $ban->displayEndDate());
	echo sprintf('<td>%s</td>', $ban->display('ban_msg'));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo $tVars['page_menu'];
?>
