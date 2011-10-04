<?php
require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_SiteFavorites.php';
require_once GWF_CORE_PATH.'module/Profile/tpl/wc4/_profile_funcs.php';
$wechall = Module_WeChall::instance();
$u = $tVars['user']; $u instanceof GWF_User;
$p = $tVars['profile']; $p instanceof GWF_Profile;
$user = GWF_User::getStaticOrGuest();
$by = Common::getGet('by', 'regat_solved');
$dir = Common::getGet('dir', 'DESC');
$orderby = GDO::table('WC_Regat')->getMultiOrderby($by, $dir);
$is_admin = $user->isAdmin();

$data = $u->getUserData();
$priv = isset($data['WC_PRIV_HIST']) && !$is_admin;


# Head
$buttons = '';
if ($tVars['jquery']) {
	$onclick = "wcjsHideJQueryAll(); return false;";
	$buttons .= GWF_Button::delete('#', WC_HTML::lang('btn_close'), '', $onclick);
	$buttons .= GWF_Button::link($u->getProfileHREF(), WC_HTML::lang('btn_view_profile'));
}

echo '<h1>'.$buttons.$tLang->lang('pt_profile', array( $u->displayUsername())).'</h1>';


# Permission
if ($p->isHidden($user))
{
	echo '<h2>'.$tLang->lang('err_hidden').'</h2>';
	return;
}



# About Me
if ('' !== ($v = $p->displayAboutMe())) {
	echo GWF_Box::box($v, $tLang->lang('title_about_me', array( $u->displayUsername())));
}

# Default Profile
echo '<div class="fl">'.PHP_EOL;
echo '<table>'.PHP_EOL;
if ($u->hasAvatar()) {
	echo gwfProfileRow($tLang->lang('th_user_avatar'), $u->displayAvatar());
}
if ($u->hasCountry()) {
	echo gwfProfileRow($tLang->lang('th_user_country'), $u->displayCountryFlag(true));
}
echo gwfProfileRow($tLang->lang('th_user_name'), $u->displayUsername());


if (isset($data['WC_HIDE_SCORE'])) {
	echo gwfProfileRow(WC_HTML::lang('th_score'), $wechall->lang('hidden'));
}
else {
	echo gwfProfileRow(WC_HTML::lang('th_score'), GWF_HTML::anchor(GWF_WEB_ROOT.'stats/'.$u->urlencode('user_name'), $u->getVar('user_level')));
}

if (isset($data['WC_HIDE_RANK'])) {
	echo gwfProfileRow(WC_HTML::lang('th_rank2'), $wechall->lang('hidden'));
}
else {
	$rank = WC_RegAt::calcRank($u);
	echo gwfProfileRow(WC_HTML::lang('th_rank2'), GWF_HTML::anchor(GWF_WEB_ROOT.'ranking/player/'.$u->urlencode2('user_name').'#rank_'.$rank, $rank));
}
if ($u->getVar('user_countryid') !== '0') {
	if (isset($data['WC_HIDE_RANK'])) {
		echo gwfProfileRow(WC_HTML::lang('th_crank'), $wechall->lang('hidden'));
	} else {
		$cRank = WC_Regat::calcCountryRank($u);
		$href_crank = GWF_WEB_ROOT.'country_ranking/player/'.$u->urlencode2('user_name').'#rank_'.$cRank;
		echo gwfProfileRow(WC_HTML::lang('th_crank'), GWF_HTML::anchor($href_crank, $cRank));
	}
}
echo gwfProfileRow($tLang->lang('th_registered'), GWF_Time::displayDate($u->getVar('user_regdate')));
if ($u->isOptionEnabled(GWF_User::HIDE_ONLINE)) {
	$lastactivity = GWF_HTML::lang('unknown');
} else {
	$lastactivity = GWF_Time::displayTimestamp($u->getVar('user_lastactivity'));
}
echo gwfProfileRow($tLang->lang('th_last_active'), $lastactivity);
echo gwfProfileRow($tLang->lang('th_views'), $p->getVar('prof_views'));
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
if ('' !== ($v = $p->display('prof_street'))) {
	echo gwfProfileRow($tLang->lang('th_street'), $v);
}
if (' ' !== ($v = ($p->display('prof_zip').' '.$p->display('prof_city')))) {
	echo gwfProfileRow($tLang->lang('th_city'), $v);
}
if ('' !== ($v = $p->getVar('prof_website', ''))) {
	echo gwfProfileRow($tLang->lang('th_website'), GWF_HTML::anchor($v, $v));
}
if (!$p->isContactHidden($user) || $is_admin)
{
	if ($u->isOptionEnabled(GWF_User::SHOW_EMAIL) || $is_admin) {
		if ('' !== ($v = $u->displayEMail())) {
			echo gwfProfileRow($tLang->lang('th_email'), $v);
		}
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
	if ('' !== ($v = $p->display('prof_irc'))) {
		echo gwfProfileRow($tLang->lang('th_irc'), $v);
	}
	
	$buttons = '';
	if ('' !== ($email = $u->getValidMail())) {
		$txt = $tLang->lang('at_mailto', array( $u->displayUsername()));
		if ($u->isOptionEnabled(GWF_User::ALLOW_EMAIL)) {
			$buttons .= GWF_Button::mail(GWF_WEB_ROOT.'send/email/to/'.$u->urlencode('user_name'), $txt);
		}
	}
	if (GWF_Session::isLoggedIn()) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_pm'), $u->getPMHref());
	}
	
	if ($buttons !== '') {
		echo GWF_Table::rowStart();
		echo "<td colspan=\"2\" class=\"ce\">$buttons</td>".PHP_EOL;
		echo GWF_Table::rowEnd();
	}
	
	
}
# Fav Sites
echo wcProfileFavSites($u->getID());
echo wcProfileFavCats($u->getID());
echo '</table>'.PHP_EOL;
echo '</div>'.PHP_EOL;

# Regats
$regats = WC_RegAt::getRegats($u->getID(), $orderby);
if (count($regats) > 0)
{
	echo '<div class="oa fl">'.PHP_EOL;
	wcProfileRegats($regats, GWF_WEB_ROOT.'index.php?mo=Profile&me=Profile&username='.$u->urlencode('user_name').'&by=%BY%&dir=%DIR%', $priv, isset($data['WC_HIDE_SCORE']));
	echo '</div>'.PHP_EOL;
}


# Break on jquery
if ($tVars['jquery']) { echo '<div class="cb"></div>'.PHP_EOL; return; }

require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';

# Graphs and Activity
if ($u->getLevel() > 0)
{
	echo wcProfileLastActivity($u, 10, $priv);
	echo '<div class="cb"></div>'.PHP_EOL;
	echo '<div>';
	echo wcProfileGraphRank($u);
	echo wcProfileGraphScore($u);
	echo '</div>';
}
else {
	echo '<div class="cb"></div>'.PHP_EOL;
}

# Links
//if ( (false !== ($mod_links = GWF_Module::getModule('Links'))) && (false !== ($mod_votes = GWF_Module::getModule('Votes'))) )
if ( (false !== ($mod_links = GWF_Module::loadModuleDB('Links', true, true))) && (false !== ($mod_votes = GWF_Module::loadModuleDB('Votes', true))) )
{
//	$mod_votes->onInclude();
//	$mod_links->onInclude();
//	$mod_links->onLoadLanguage();
	echo wcProfileFavLinks($u, $mod_links);
	echo wcProfileOwnLinks($u, $mod_links);
}

# Challs
if (WC_Challenge::getScoreForUser($u) > 0)
{
	Module_WeChall::includeForums();
//	GWF_Module::getModule('Forum')->onInclude();
	# Profile Challs
	$method = $wechall->getMethod('ChallsProfile');
	$method instanceof WeChall_ChallsProfile;
	echo $method->templateChalls($wechall, $u);
	# Created By
	$method = $wechall->getMethod('Challs');
	$method instanceof WeChall_Challs;
	echo $method->templateChalls($wechall, false, $u->getID(), '', '', '', false, false);
}

# Guestbook
echo wcProfileGuestbook($u);

# Groups
echo wcProfileUsergroup($u, GWF_User::isLoggedIn());

GWF_Website::setPageTitle($tLang->lang('pt_profile', array($u->displayUsername())));
GWF_Website::setMetaDescr($tLang->lang('md_profile', array($u->displayUsername())));
GWF_Website::addMetaDescr(' '.GWF_Module::getModule('WeChall')->getMethod('API_Bot')->showGlobal($wechall, $u->getVar('user_name')));
//$tags = '';
//foreach ($regats as $regat)
//{
//	$regat instanceof WC_RegAt;
//	$tags .= ', '.$regat->getSite()->displayName();
//}
//GWF_Website::addMetaTags($tags);
?>