<?php
$may_del = GWF_User::isInGroupS('moderator');
$btn_del = $tLang->lang('btn_delete');
$action = GWF_WEB_ROOT.'index.php?mo=Shoutbox&me=History';
$csrf = GWF_CSRF::hiddenForm('shout');

$headers = array(
	array($tLang->lang('th_shout_date'), 'shout_date'),
	array($tLang->lang('th_shout_uname'), 'shout_uname'),
	array($tLang->lang('th_shout_message')),
);
if ($may_del) {
	$headers[] = array($btn_del);
}
echo $tVars['page_menu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['data'] as $row)
{
	$row instanceof GWF_Shoutbox;
	$user = $row->getUser();
	$style = wcStyleForUser($user);
//	$style = 'background: #'.$color.'!important;';
	
	echo GWF_Table::rowStart(false, '', '', $style);
	echo GWF_Table::column($row->displayDate());
	echo GWF_Table::column($row->displayUsername());
	echo GWF_Table::column($row->displayMessage());
	if ($may_del) {
		$form = sprintf('<form method="post" action="%s"><div><input type="submit" name="delete[%s]" value="%s" />%s</div></form>', GWF_HTML::display($action), $row->getID(), $btn_del, $csrf);
		echo GWF_Table::column($form);
	}
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo $tVars['page_menu'];

function wcStyleForUser($user)
{
	static $swap = 1;
	$swap = 1 - $swap;

	if ($user === false || $user->getID() == 0) {
		$color = $swap ? 'eee' : 'fff';
		return "background: #$color!important; color #000";
	}

	$user->loadGroups();
	
	if ($user->isAdmin()) {
		$color = $swap ? 'FF8' : 'EE7';
		return "background-color: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('siteadmin')) {
		$color = $swap ? '8F8' : '6D6';
		return "background: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('moderator')) {
		$color = $swap ? 'F88' : 'F77';
		return "background: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('betatester')) {
		$color = $swap ? '77F' : '66F';
		return "background: #$color!important; font-weight: bold; color: #FFF;";
	}
	
	
	$color = $swap ? 'AAF' : 'CCF';
	return "background: #$color!important;";
}
?>