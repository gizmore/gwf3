<?php
$user = $tVars['user']; $user instanceof GWF_User;

echo $tVars['form_add'];
?>

<form action="<?php echo $tVars['form_action']; ?>" method="post">
<?php
echo GWF_CSRF::hiddenForm('');
foreach ($tVars['groups'] as $name => $group)
{
	$group instanceof GWF_UserGroup;
	$founderid = $group->getVar('group_founder');
	echo '<div>';
	if ($founderid === $user->getID()) {
		echo sprintf('<input type="submit" name="remgroup[%s]" disabled="disabled" value="%s" />', $group->getVar('group_id'), $group->display('group_name'));
	} else {
		echo sprintf('<input type="submit" name="remgroup[%s]" value="%s"/>', $group->getVar('group_id'), $group->display('group_name'));
	}
	echo '</div>'.PHP_EOL;
}
?>
</form>
