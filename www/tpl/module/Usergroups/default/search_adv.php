<?php
echo $tVars['form'];

if (count($tVars['result']) === 0) {
	return;
}

$headers = array(
	array($tLang->lang('th_country'), 'user_country'),
	array($tLang->lang('th_user_name'), 'user_name'),
);
if (isset($_GET['minlevel'])) { $headers[] = array($tLang->lang('th_user_level', array( 'user_level'))); }
if (isset($_GET['hasmail']) || isset($_GET['email'])) { $headers[] = array($tLang->lang('th_user_email'), 'user_email'); }
if (isset($_GET['haswww'])) { $headers[] = array($tLang->lang('th_haswww'), 'prof_website'); }
if (isset($_GET['icq'])) { $headers[] = array($tLang->lang('th_icq'), 'prof_icq'); }
if (isset($_GET['msn'])) { $headers[] = array($tLang->lang('th_msn'), 'prof_msn'); }
if (isset($_GET['jabber'])) { $headers[] = array($tLang->lang('th_jabber'), 'prof_jabber'); }
if (isset($_GET['skype'])) { $headers[] = array($tLang->lang('th_skype'), 'prof_skype'); }
if (isset($_GET['yahoo'])) { $headers[] = array($tLang->lang('th_yahoo'), 'prof_yahoo'); }
if (isset($_GET['aim'])) { $headers[] = array($tLang->lang('th_aim'), 'prof_aim'); }

echo $tVars['pagemenu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

$user = new GWF_User(false);
foreach ($tVars['result'] as $row)
{
	$user->setGDOData($row);
	echo GWF_Table::rowStart();
	echo GWF_Table::column($user->displayCountryFlag(false));
	echo GWF_Table::column($user->displayProfileLink());
	if (isset($_GET['minlevel'])) { echo GWF_Table::column($row['user_level'], 'gwf_num'); }
	if (isset($_GET['hasmail'])||isset($_GET['email'])) { echo GWF_Table::column($user->displayEMail()); }
	if (isset($_GET['haswww'])) { $a = htmlspecialchars($row['prof_website']); echo GWF_Table::column(sprintf('<a href="%s">%s</a>',$a,$a)); }
	if (isset($_GET['icq'])) { echo GWF_Table::column(htmlspecialchars($row['prof_icq']), 'gwf_num'); }
	if (isset($_GET['msn'])) { echo GWF_Table::column(htmlspecialchars($row['prof_msn']), 'gwf_num'); }
	if (isset($_GET['jabber'])) { echo GWF_Table::column(htmlspecialchars($row['prof_jabber']), 'gwf_num'); }
	if (isset($_GET['skype'])) { echo GWF_Table::column(htmlspecialchars($row['prof_skype']), 'gwf_num'); }
	if (isset($_GET['yahoo'])) { echo GWF_Table::column(htmlspecialchars($row['prof_yahoo']), 'gwf_num'); }
	if (isset($_GET['aim'])) { echo GWF_Table::column(htmlspecialchars($row['prof_aim']), 'gwf_num'); }
	
	
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();

echo $tVars['pagemenu'];

?>