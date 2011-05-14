<?php
function module_PM_unread(array $args, $format='[%s]')
{
	$user = $args[0]; $user instanceof GWF_User;
	if ('0' !== ($userid = $user->getID()))
	{
		$pattern = isset($args[1]) ? $args[1] : '[%s]';
		require_once 'GWF_PM.php';
		$read = GWF_PM::READ;
		$count = GDO::table('GWF_PM')->countRows("pm_owner=$userid AND pm_to=$userid AND pm_options&$read=0");
		if ($count > 0)
		{
			return sprintf($pattern, $count);
		}
	}
}
?>
