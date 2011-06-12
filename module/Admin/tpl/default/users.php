<?php
echo $tVars['search_form'];
$headers = array(
	array($tLang->lang('th_userid'), 'user_id', 'ASC'),
	array($tLang->lang('th_user_credits'), 'user_credits', 'ASC'),
	array($tLang->lang('th_user_level'), 'user_level', 'ASC'),
	array($tLang->lang('th_country'), 'user_countryid', 'ASC'),
	array($tLang->lang('th_user_name'), 'user_name', 'ASC'),
	array($tLang->lang('th_regdate'), 'user_regdate', 'ASC'),
	array($tLang->lang('th_email'), 'user_email', 'ASC'),
	array($tLang->lang('th_birthdate'), 'user_birthdate', 'ASC'),
	array($tLang->lang('th_regip'), 'user_regip', 'ASC'),
	array($tLang->lang('th_lastactivity'), 'user_lastactivity', 'DESC'),
);
echo $tVars['pagemenu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['users'] as $user)
{
	echo GWF_Table::rowStart();
	$user instanceof GWF_User;
	$href = Module_Admin::getUserEditURL($user->getID());
	echo GWF_Table::column(GWF_HTML::anchor($href, $user->getID()), 'gwf_num');
	echo GWF_Table::column(GWF_HTML::anchor($href, round($user->getVar('user_credits')), 2), 'gwf_num');
	echo GWF_Table::column(GWF_HTML::anchor($href, $user->getLevel()), 'gwf_num');
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $user->displayCountryFlag()));
	echo GWF_Table::column(GWF_HTML::anchor($href, $user->display('user_name')));
	echo GWF_Table::column(GWF_HTML::anchor($href, GWF_Time::displayDate($user->getVar('user_regdate'))), 'gwf_date');
	echo GWF_Table::column(GWF_HTML::anchor($href, $user->display('user_email')));
	echo GWF_Table::column(GWF_HTML::anchor($href, GWF_Time::displayDate($user->getVar('user_birthdate'))), 'gwf_date');
	echo GWF_Table::column(GWF_HTML::anchor($href, GWF_IP6::displayIP($user->getVar('user_regip'), GWF_IP_EXACT)));
	echo GWF_Table::column(GWF_HTML::anchor($href, GWF_Time::displayTimestamp($user->getVar('user_lastactivity'))), 'gwf_date');
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo $tVars['pagemenu'];
?>