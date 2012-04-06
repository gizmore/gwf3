<?php
$headers = array(
	array('', 'user_countryid'),
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_user_level'), 'user_level'),
	array($tLang->lang('th_user_email'), 'user_email'),
	array($tLang->lang('th_user_regdate'), 'user_regdate'),
	array($tLang->lang('th_user_birthdate'), 'user_birthdate'),
	array($tLang->lang('th_user_lastactivity'), 'user_lastactivity'),
);

echo $tVars['module']->getUserGroupButtons();

if (isset($tVars['lettermenu'])) {
	echo $tVars['lettermenu'];
}

echo $tVars['pagemenu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

foreach ($tVars['users'] as $user)
{
	$user instanceof GWF_User;
	echo GWF_Table::rowStart();
?>
		<td><?php echo $user->displayCountryFlag(); ?></td>
		<td><a href="<?php echo GWF_WEB_ROOT.'profile/'.$user->urlencode('user_name'); ?>"><?php echo $user->displayUsername(); ?></a></td>
		<td class="gwf_num"><?php echo $user->getVar('user_level'); ?></td>
		<td><?php echo $user->isOptionEnabled(GWF_User::SHOW_EMAIL) ? $user->displayEMail() : ''; ?></td>
		<td class="gwf_date"><?php echo $user->displayRegdate(); ?></td>
		<td class="gwf_date"><?php $user->isBirthdayShown() ? $user->displayBirthday() : ''; ?></td>
		<td class="gwf_date"><?php echo $user->isOnlineHidden() ? GWF_HTML::lang('unknown') : GWF_Time::displayAge(GWF_Time::getDate(GWF_Date::LEN_SECOND, $user->getVar('user_lastactivity'))); ?></td>
<?php echo GWF_Table::rowEnd(); ?>
<?php } ?>
<?php echo GWF_Table::end(); ?>
