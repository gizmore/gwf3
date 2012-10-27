<?php
echo $tVars['module']->getUserGroupButtons();

$user = GWF_User::getStaticOrGuest();

$tVars['module'] instanceof Module_Usergroups;

$btn_part = $tLang->lang('btn_part');
$btn_join = $tLang->lang('btn_join');

$headers = array(
		array($tLang->lang('th_group_name'), 'group_name'),
		array($tLang->lang('th_group_memberc'), 'group_memberc'),
		array($tLang->lang('th_group_founder'), 'user_name'),
		array($btn_part),
);

echo $tVars['page_menu'];

$user instanceof GWF_User;

echo '<form method="post" action="'.htmlspecialchars($tVars['form_action']).'">'.PHP_EOL;
echo sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('partgrp'));
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['groups'] as $group)
{
	$group instanceof GWF_Group;
	$groupname = $group->getVar('group_name');
	$founder = $group->getFounder();
	$in_grp = $user->isInGroupName($groupname);

	if ($in_grp) {
		$ugopt = $user->getUserGroupOptions($group->getID());#getGroupByName($groupname)->getInt('group_options');
		//		$ugopt = $user->getUserGroupOptions($groupname);
	} else {
		$ugopt = 0;
	}
	if (($ugopt&(GWF_UserGroup::LEADER|GWF_UserGroup::CO_LEADER)) > 0) {
		$edit = GWF_Button::edit(GWF_WEB_ROOT.'edit_usergroup/'.$group->getID().'/'.$group->urlencodeSEO('group_name'));
	} else {
		$edit = '';
	}

	$parent_board = $tVars['module']->getForumBoard();

	if (false !== ($board = GWF_ForumBoard::getByID($group->getVar('group_bid')))) {
		$href = $board->getShowBoardHREF();
		$forum = GWF_HTML::anchor($href, $group->getVar('group_name'));
	} else {
		$forum = $group->display('group_name');
	}

	$members = GWF_HTML::anchor(GWF_WEB_ROOT.'users_in_group/'.$group->getID().'/'.$group->urlencodeSEO('group_name'), $group->getVar('group_memberc'));

	echo GWF_Table::rowStart();
	echo GWF_Table::column($edit.$forum, 'nowrap');
	echo GWF_Table::column($members, 'gwf_num');
	echo GWF_Table::column($founder->displayProfileLink());
	if ($user->isGuest())
	{
		echo '<td></td>'.PHP_EOL;
	}
	elseif ($in_grp)
	{
		echo GWF_Table::column(sprintf('<input type="submit" name="part[%s]" value="%s" />', $group->getVar('group_id'), $btn_part));
	}
	elseif ($group->isOptionEnabled(GWF_Group::FREE))
	{
		echo GWF_Table::column(sprintf('<input type="submit" name="join[%s]" value="%s" />', $group->getVar('group_id'), $btn_join));
	}
	else
	{
		echo '<td></td>'.PHP_EOL;
	}
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo '</form>'.PHP_EOL;
echo $tVars['page_menu'];

echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
if ($tVars['module']->canCreateGroup($user)) {
	echo GWF_Button::generic($tLang->lang('btn_add_group'), $tVars['href_add_group']);
}
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;
?>