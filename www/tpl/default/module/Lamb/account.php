<?php
echo $tVars['form_link'];
echo $tVars['form_create'];

$headers = array(
	array($tLang->lang('th_player_id')),
	array($tLang->lang('th_player_name')),
	array($tLang->lang('th_level')),
);


echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['chars'] as $char)
{
	$char = $char->getVar('ll_pid'); $char instanceof SR_Player;
	$user = Lamb_User::getByID($char->getVar('sr4pl_uid'));
	$char->setVar('sr4pl_uid', $user);
	echo GWF_Table::rowStart();
	echo GWF_Table::column($user->getVar('lusr_sid'));
	echo GWF_Table::column($char->getName());
	echo GWF_Table::column($char->getBase('level'));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
?>