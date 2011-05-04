<?php
$u = $tVars['user']; $u instanceof GWF_User;
$p = $tVars['profile']; $p instanceof GWF_Profile;
$user = GWF_User::getStaticOrGuest();
echo '<h1>'.$tLang->lang('pt_profile', array( $u->displayUsername())).'</h1>';
if ($p->isHidden($user))
{
	echo '<h2>'.$tLang->lang('err_hidden').'</h2>';
	return;
}

# About me
if ('' !== ($v = $p->displayAboutMe())) {
	echo GWF_Box::box($v, $tLang->lang('title_about_me', array( $u->displayUsername())));
}

# Profile
echo GWF_Table::start();
if ($u->isOptionEnabled(GWF_User::HAS_AVATAR)) {
	echo gwfProfileRow($tLang->lang('th_user_avatar'), $u->displayAvatar());
}
echo gwfProfileRow($tLang->lang('th_user_name'), $u->displayUsername());
if ($u->getCountryID() > 0) {
	echo gwfProfileRow($tLang->lang('th_user_country'), $u->displayCountryFlag(true));
}
if ('' !== ($v = $p->display('prof_firstname'))) {
	echo gwfProfileRow($tLang->lang('th_firstname'), $v);
}
if ('' !== ($v = $p->display('prof_lastname'))) {
	echo gwfProfileRow($tLang->lang('th_lastname'), $v);
}
if (($u->isOptionEnabled(GWF_User::SHOW_BIRTHDAY)) && ('00000000' !== ($v = $u->getVar('user_birthdate'))) ) {
	echo gwfProfileRow($tLang->lang('th_age'), GWF_Time::displayAge($v));
	echo gwfProfileRow($tLang->lang('th_birthdate'), GWF_Time::displayDate($v));
}
$v = $p->getVar('prof_website');
if ($v !== NULL && $v !== '') {
	echo gwfProfileRow($tLang->lang('th_website'), GWF_HTML::anchor($v, $v));
}
# Hidden Contact
if (!$p->isContactHidden($user))
{
	if ('' !== ($v = $p->display('prof_street'))) {
		echo gwfProfileRow($tLang->lang('th_street'), $v);
	}
	if (' ' !== ($v = ($p->display('prof_zip').' '.$p->display('prof_city')))) {
		echo gwfProfileRow($tLang->lang('th_city'), $v);
	}
	$v = $p->display('prof_tel');
	if ($v !== '0' && $v !== '') {
		echo gwfProfileRow($tLang->lang('th_tel'), $v);
	}
	$v = $p->display('prof_mobile');
	if ($v !== '0' && $v !== '') {
		echo gwfProfileRow($tLang->lang('th_mobile'), $v);
	}
	if ('' !== ($v = $p->display('prof_icq'))) {
		echo gwfProfileRow($tLang->lang('th_icq'), $v);
	}
	if ('' !== ($v = $p->display('prof_msn'))) {
		echo gwfProfileRow($tLang->lang('th_msn'), $v);
	}
	if ('' !== ($v = $p->display('prof_jabber'))) {
		echo gwfProfileRow($tLang->lang('th_jabber'), $v);
	}
	if ('' !== ($v = $p->display('prof_skype'))) {
		echo gwfProfileRow($tLang->lang('th_skype'), $v);
	}
	if ('' !== ($v = $p->display('prof_yahoo'))) {
		echo gwfProfileRow($tLang->lang('th_yahoo'), $v);
	}
	if ('' !== ($v = $p->display('prof_aim'))) {
		echo gwfProfileRow($tLang->lang('th_aim'), $v);
	}
}
echo GWF_Table::end();
#################
### Functions ###
#################
function gwfProfileRow($head, $value)
{
	return
		GWF_Table::rowStart().
		sprintf('<th>%s</th><td>%s</td>', $head, $value).
		GWF_Table::rowEnd();
}
?>