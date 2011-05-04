
<?php echo $tVars['form']; ?>

<?php echo $tVars['form_add']; ?>



<?php echo $tVars['pagemenu']; ?>

<?php
$headers = array(
	array($tLang->lang('th_user_name')),
	array(''),
);

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
$gid = $tVars['group']->getID();
$guest = GWF_Guest::getGuest();
foreach ($tVars['userids'] as $userid)
{
	if (false === ($user = GWF_User::getByID($userid))) {
		$user = $guest;
	}
	echo GWF_Table::rowStart();
	echo GWF_Table::column($user->displayProfileLink());
	$hrefDelete = $tVars['module']->getMethodURL('GroupEdit', '&rem='.$userid.'&gid='.$gid);
	echo GWF_Table::column(GWF_Button::delete($hrefDelete, $tLang->lang('btn_rem_from_group')));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo $tVars['pagemenu'];
?>
