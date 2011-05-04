<?php
echo $tVars['module']->getUserGroupButtons();

$user = GWF_User::getStaticOrGuest();

$tVars['module'] instanceof Module_Usergroups;

$btn_part = $tLang->lang('btn_part');
$headers = array(
	array($tLang->lang('th_group_name'), 'group_name'),
	array($tLang->lang('th_group_memberc'), 'group_memberc'),
	array($tLang->lang('th_group_founder'), 'user_name'),
	array($btn_part),
);
$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);

echo $tVars['page_menu'];


echo '<form method="post" action="'.htmlspecialchars($tVars['form_action']).'">'.PHP_EOL;
echo sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('partgrp'));
echo GWF_Table::start();
echo GWF_Table::displayHeaders($headers);
foreach ($tVars['groups'] as $group)
{
	$group instanceof GWF_Group;
	$groupname = $group->getVar('group_name');
	$founder = $group->getFounder();
	$in_grp = $user->isInGroup($groupname);
	
	if ($in_grp) {
		$ugopt = $user->getUserGroupOptions($groupname);
	} else {
		$ugopt = 0;
	}
	if (($ugopt&(GWF_UserGroup::LEADER|GWF_UserGroup::CO_LEADER)) > 0) {
		$edit = GWF_Button::edit($group->hrefEdit2());
	} else {
		$edit = '';
	}
	
	$parent_board = $tVars['module']->getForumBoard();

	if (false !== ($board = GWF_ForumBoard::getByID($group->getBoardID()))) {
		$href = $board->getShowBoardHREF();
		$forum = GWF_HTML::anchor($href, $group->getVar('group_name'));
	} else {
		$forum = $group->display('group_name');
	}
	
	$members = GWF_HTML::anchor($group->hrefMembers(), $group->getVar('group_memberc'));
	 
	echo GWF_Table::rowStart();
	echo GWF_Table::column($edit.$forum, 'nowrap');
	echo GWF_Table::column($members, 'gwf_num');
	echo GWF_Table::column($founder->displayProfileLink());
	if ($in_grp) {
		echo GWF_Table::column(sprintf('<input type="submit" name="part[%s]" value="%s" />', $group->getVar('group_id'), $btn_part));
	} else {
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