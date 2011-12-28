<?php
function module_Links_unread(array $args)
{
	$user = array_shift($args); $user instanceof GWF_User;
	$pattern = count($args) ? array_shift($args) : '[%s]';
	if (false === $user->isGuest())
	{
		$links = GWF_Module::loadModuleDB('Links'); $links instanceof Module_Links;
		require_once 'GWF_Links.php';
		if (0 < ($unread = $links->countUnread($user)))
		{
			printf($pattern, $unread);
		}
	}
}
?>
