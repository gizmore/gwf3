<?php
/**
 *  Get Forum Unread Counter - Quickhook for topmenu.
 * @param array(GWF_User $user)
 * @return string the counter enclosed in [counter]
 */
function module_Forum_unread(array $args, $out = false)
{
	$user = $args[0]; $user instanceof GWF_User;
	if ( ($user->isGuest()) || ($user->isWebspider()) ) {
		return '';
	}
	require_once 'module/Forum/GWF_ForumThread.php';
	$uid = $user->getID();
	$data = $user->getUserData();
	$grp = GWF_TABLE_PREFIX.'usergroup';
	$permquery = "(thread_gid=0 OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=thread_gid))";
	$stamp = isset($data['GWF_FORUM_STAMP']) ? $data['GWF_FORUM_STAMP'] : $user->getVar('user_regdate');
	$regtimequery = sprintf('thread_lastdate>=\'%s\'', $stamp);
	$conditions = "( (thread_postcount>0) AND ($permquery) AND ($regtimequery OR thread_force_unread LIKE '%:$uid:%') AND (thread_unread NOT LIKE '%:$uid:%') AND (thread_options&4=0) )";
	if (false === ($count = GDO::table('GWF_ForumThread')->selectVar('COUNT(*)', $conditions))) {
		return '';
	}
	return $out ? "[$count]" : ( ($count==='0') ? '' : "[$count]" );
}
?>