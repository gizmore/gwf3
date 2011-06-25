<?php
echo $tVars['module']->getUserGroupButtons();
echo $tVars['form_edit'];
echo $tVars['form_delete'];
if ($tVars['group']->isOptionEnabled(GWF_Group::INVITE)) {
	echo $tVars['form_invite'];
}
echo $tVars['pagemenu_members'];
if (count($tVars['users']) > 0) {
	$rem = $tLang->lang('btn_kick');
	$co = $tLang->lang('btn_co');
	$unco = $tLang->lang('btn_unco');
	$mod = $tLang->lang('btn_mod');
	$unmod = $tLang->lang('btn_unmod');
	$hide = $tLang->lang('btn_hide');
	$unhide = $tLang->lang('btn_unhide');
?>
<form action="<?php echo $tVars['form_action']; ?>" method="post">
<table>
<?php foreach($tVars['users'] as $user) { $user instanceof GWF_User; $username = $user->displayUsername(); $user->loadGroups(); $gd = $user->getUserGroupOptions($tVars['group']->getID());  ?>
	<tr>
		<td><a href="<?php echo $user->getProfileHREF(); ?>"><?php echo $username; ?></a></td>
		
		<?php if ($gd&GWF_UserGroup::CO_LEADER) { ?>
		<td><input type="submit" name="unco[<?php echo $username; ?>]" value="<?php echo $unco; ?>" /></td>
		<?php } else { ?>
		<td><input type="submit" name="co[<?php echo $username; ?>]" value="<?php echo $co; ?>" /></td>
		<?php } ?>
		
		<?php if ($gd&GWF_UserGroup::MODERATOR) { ?>
		<td><input type="submit" name="unmod[<?php echo $username; ?>]" value="<?php echo $unmod; ?>" /></td>
		<?php } else { ?>
		<td><input type="submit" name="mod[<?php echo $username; ?>]" value="<?php echo $mod; ?>" /></td>
		<?php } ?>
		
		<?php if ($gd&GWF_UserGroup::HIDDEN) { ?>
		<td><input type="submit" name="unhide[<?php echo $username; ?>]" value="<?php echo $unhide; ?>" /></td>
		<?php } else { ?>
		<td><input type="submit" name="hide[<?php echo $username; ?>]" value="<?php echo $hide; ?>" /></td>
		<?php } ?>
		
		<td><input type="submit" name="kick[<?php echo $username; ?>]" value="<?php echo $rem; ?>" /></td>
	</tr>
<?php } ?>
</table>
</form>
<?php } ?>

<?php echo $tVars['pagemenu_requests']; ?>

<?php if (count($tVars['requests']) > 0) { $accept = $tLang->lang('btn_accept'); ?>
<form action="<?php echo $tVars['form_action']; ?>" method="post">
<table>
<?php foreach($tVars['requests'] as $user) { $user instanceof GWF_User; $username = $user->displayUsername(); ?>
	<tr>
		<td><a href="<?php echo $user->getProfileHREF(); ?>"><?php echo $username; ?></a></td>
		<td><input type="submit" name="accept[<?php echo $username; ?>]" value="<?php echo $accept; ?>" /></td>
	</tr>
<?php } ?>
</table>
</form>
<?php } ?>
