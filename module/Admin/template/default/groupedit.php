<?php echo $tVars['form']; ?>

<?php echo $tVars['form_add']; ?>

<?php echo $tVars['pagemenu']; ?>

<?php
$headers = array(
	array($tLang->lang('th_user_name')),
	array(''),
);
$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);



$gid = $tVars['group']->getID();
$data = array();
foreach ($tVars['userids'] as $userid)
{
	$hrefDelete = $tVars['module']->getMethodURL('GroupEdit', '&rem='.$userid.'&gid='.$gid);
	$remove = GWF_Button::delete($hrefDelete, $tLang->lang('btn_rem_from_group'));
	$data[] = array(
		GWF_User::getByIDOrGuest($userid)->displayUsername(),
		$remove,
	);
}

echo GWF_Table::display2($headers, $data, $tVars['sort_url']);
?>