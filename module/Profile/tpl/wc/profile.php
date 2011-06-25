<?php
$u = $tVars['user']; $u instanceof GWF_User;
$p = $tVars['profile']; $p instanceof GWF_Profile;
$user = GWF_User::getStaticOrGuest();
$wechall = Module_WeChall::instance();

$rank = WC_RegAt::calcRank($u);

GWF_Website::setMetaTags(WC_HTML::lang('md_profile', array($u->displayUsername(), $rank, WC_RegAt::countRegats($u->getID()))));
GWF_Website::setMetaDescr(WC_HTML::lang('md_profile', array($u->displayUsername(), $rank, WC_RegAt::countRegats($u->getID()))));

WC_HTML::$LEFT_PANEL = false;
WC_HTML::$RIGHT_PANEL = false;

echo '<h1>'.$tLang->lang('pt_profile', array( $u->displayCountryFlag(false).'  '.$u->displayUsername())).'</h1>';

if ($p->isHidden($user))
{
	echo '<h2>'.$tLang->lang('err_hidden').'</h2>';
}
else
{
	if ('' !== ($p->getVar('prof_about_me'))) {
		echo GWF_Box::box($p->displayAboutMe());
	}
	
	
	echo '<div class="fl">';
	echo '<table>';
	
	if ($u->hasAvatar()) {
		echo wcProfile2($tLang->lang('th_user_avatar'), $u->displayAvatar());
	}

	echo wcProfile2($tLang->lang('th_user_name'), $u->displayUsername());
	
	$href_stats = GWF_WEB_ROOT.'stats/'.$u->urlencode('user_name');
	echo wcProfile2(WC_HTML::lang('th_score'), GWF_HTML::anchor($href_stats, $u->getVar('user_level')));
	
	$href_grank = GWF_WEB_ROOT.'ranking/player/'.$u->urlencode2('user_name').'#rank_'.$rank;
	echo wcProfile2(WC_HTML::lang('th_rank2'), GWF_HTML::anchor($href_grank, $rank));
	
	if ($u->getVar('user_countryid') !== '0') {
		$cRank = WC_Regat::calcCountryRank($u);
		$href_crank = GWF_WEB_ROOT.'country_ranking/player/'.$u->urlencode2('user_name').'#rank_'.$cRank;
		echo wcProfile2(WC_HTML::lang('th_crank'), GWF_HTML::anchor($href_crank, $cRank));
	}
	
	echo wcProfile2($tLang->lang('th_registered'), $u->displayRegdate());
	
	if ($u->isOnlineHidden()) {
		$lastactivity = GWF_HTML::lang('unknown');
	} else {
		$lastactivity = $u->displayLastActivity();
	}
	echo wcProfile2($tLang->lang('th_last_active'), $lastactivity);
	
	echo wcProfile2($tLang->lang('th_views'), $p->getVar('prof_views'));
	
	
	if ('' !== ($v = $p->display('prof_firstname'))) {
		echo wcProfile2($tLang->lang('th_firstname'), $v);
	}
	if ('' !== ($v = $p->display('prof_lastname'))) {
		echo wcProfile2($tLang->lang('th_lastname'), $v);
	}
	if ('no_gender' !== ($v = $u->getGender())) {
		echo wcProfile2($tLang->lang('th_gender'), $u->displayGender());
	}
	if ('' !== ($v = $p->display('prof_street'))) {
		echo wcProfile2($tLang->lang('th_street'), $v);
	}
	if (' ' !== ($v = ($p->display('prof_zip').' '.$p->display('prof_city')))) {
		echo wcProfile2($tLang->lang('th_city'), $v);
	}
	if ('' !== ($v = $p->display('prof_tel'))) {
		echo wcProfile2($tLang->lang('th_tel'), $v);
	}
	if ('' !== ($v = $p->display('prof_mobile'))) {
		echo wcProfile2($tLang->lang('th_mobile'), $v);
	}

	wcProfile1('<hr/>');
	
	if (!$p->isContactHidden($user))
	{
		if (0 != ($v = $p->display('prof_icq'))) {
			echo wcProfile2($tLang->lang('th_icq'), $v);
		}
		if ('' !== ($v = $p->display('prof_msn'))) {
			echo wcProfile2($tLang->lang('th_msn'), $v);
		}
		if ('' !== ($v = $p->display('prof_jabber'))) {
			echo wcProfile2($tLang->lang('th_jabber'), $v);
		}
		if ('' !== ($v = $p->display('prof_skype'))) {
			echo wcProfile2($tLang->lang('th_skype'), $v);
		}
		if ('' !== ($v = $p->display('prof_yahoo'))) {
			echo wcProfile2($tLang->lang('th_yahoo'), $v);
		}
		if ('' !== ($v = $p->display('prof_aim'))) {
			echo wcProfile2($tLang->lang('th_aim'), $v);
		}
	}
	
	if ('' !== ($v = $p->getVar('prof_website'))) {
		echo wcProfile2($tLang->lang('th_website'), GWF_HTML::anchor($v, $v));
	}
	
	echo wcProfileFavSites($u->getID());
	
	GWF_Module::getModule('PM')->onInclude();
	if (false !== ($pmo = GWF_PMOptions::getPMOptions($u))) {
		echo '<tr><td colspan="2">';
		if (GWF_User::isLoggedIn() || $pmo->isGuestPMAllowed()) {
			echo GWF_Button::generic(WC_HTML::lang('btn_pm', array($u->displayUsername())), GWF_WEB_ROOT.'pm/send/to/'.$u->urlencode('user_name')).PHP_EOL;
		}
		if ($u->isEmailAllowed()) {
			echo GWF_Button::mail(GWF_WEB_ROOT.'send/email/to/'.$u->urlencode('user_name'), WC_HTML::lang('btn_email', array($u->displayUsername()))).PHP_EOL;
		}
		echo '</td></tr>'.PHP_EOL;
	}
	
	echo '</table>';
	echo '</div>';
	
	$by = Common::getGet('by', 'regat_solved');
	$dir = Common::getGet('dir', 'DESC');
	
	$orderby = GDO::table('WC_Regat')->getMultiOrderby($by, $dir);
		
	$regats = WC_RegAt::getRegats($u->getID(), $orderby);
	if (count($regats) > 0)
	{
		echo '<div>';
		wcProfileRegats($regats, GWF_WEB_ROOT.'index.php?mo=Profile&amp;me=Profile&amp;username='.$u->urlencode('user_name').'&amp;by=%BY%&amp;dir=%DIR%');
		echo '</div>';
	}
	
	echo '<div class="cl"></div>';
	
	if ($u->getLevel() > 0)
	{
		echo '<hr/>';
		echo wcProfileLastActivity($u, 10);
		
		echo '<hr/>';
		echo '<div>';
		echo wcProfileGraphRank($u);
		echo wcProfileGraphScore($u);
		echo '</div>';
	}
	
	echo '<hr/>';
	echo wcProfileFavLinks($u);

	echo '<hr/>';
	echo wcProfileOwnLinks($u);
	
	
	if ($u->getLevel() > 0) {
		$method = $wechall->getMethod('Challs');
		
		echo '<hr/>';
		echo $method->templateChalls($wechall, $u->getID(), false, '', '', '', false, false);
		
		echo '<hr/>';
		echo $method->templateChalls($wechall, false, $u->getID(), '', '', '', false, false);
	}
	
	echo '<hr/>';
	echo wcProfileGuestbook($u);
	
	echo '<hr/>';
	echo wcProfileUsergroup($u, GWF_User::isLoggedIn());
	
}

function wcProfileRegats(array $regats, $sort_url)
{
	$headers = array(
		array(WC_HTML::lang('th_site_name')),
		array(WC_HTML::lang('th_score'), 'regat_score'),
		array(WC_HTML::lang('th_regat_onsitename')),
		array(WC_HTML::lang('th_progress'), 'regat_solved'),
		array(WC_HTML::lang('th_regat_lastdate'), 'regat_lastdate'),
	);
	$headers = GWF_Table::getHeaders2($headers, $sort_url);
	echo '<table>';
	echo GWF_Table::displayHeaders($headers);
//	echo '<tr>';
//	echo sprintf('<th>%s</th>', WC_HTML::lang('th_site_name'));
//	echo sprintf('<th>%s</th>', WC_HTML::lang('th_score'));
//	echo sprintf('<th>%s</th>', WC_HTML::lang('th_regat_onsitename'));
//	echo sprintf('<th>%s</th>', WC_HTML::lang('th_progress'));
//	echo sprintf('<th>%s</th>', WC_HTML::lang('th_regat_lastdate'));
//	echo '</tr>';
	foreach ($regats as $regat)
	{
		$regat instanceof WC_RegAt;
		$site = $regat->getSite();
		$color = GWF_Color::interpolatBound(0, 1, $site->calcPercent($regat), 0xff0000, 0x008800);
		echo GWF_Table::rowStart('color:#'.$color.';');
		echo sprintf('<td>%s</td>', $site->displayLink());
		echo sprintf('<td class="gwf_num">%s</td>', $site->calcScore($regat));
		echo sprintf('<td>%s</td>', $regat->displayOnsiteProfileLink($site));
		echo sprintf('<td class="gwf_num">%s</td>', $regat->displayPercent($site->getOnsiteScore()));
		echo sprintf('<td class="nowrap gwf_date">%s</td>', $regat->displayLastDate());
		echo GWF_Table::rowEnd();
	}
	echo '</table>';
}

function wcProfileOwnLinks(GWF_User $user)
{
	if (false === ($mod_links = GWF_Module::getModule('Links'))) {
		return '';
	}
	$linksT = GDO::table('GWF_Links');
	$user_browsing = GWF_Session::getUser();
	$perm_query = $mod_links->getPermQuery($user_browsing);
	$mod_query = $linksT->getModQuery($user_browsing);
	$member_query = $linksT->getMemberQuery($user_browsing);
	$private_query = $linksT->getPrivateQuery($user_browsing);
	$aff_query = $linksT->getUnaffQuery($user_browsing);
	$conditions = "($perm_query) AND ($mod_query) AND ($member_query) AND ($private_query) AND ($aff_query)";
//	$mod_links->onInclude();
//	$mod_links->onLoadLanguage();
	$links = $linksT->getTableName();
	$votes = GDO::table('GWF_VoteScore')->getTableName();
	$private = GWF_Links::ONLY_PRIVATE;
	$userid = $user->getID();
	$query = "SELECT $links.*, $votes.* FROM $links JOIN $votes ON vs_id=link_voteid WHERE link_user=$userid AND $conditions";
//	var_dump($query);
	$db = gdo_db();
	if (false === ($result = $db->queryRead($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$links = array();
	while (false !==($row = $db->fetchAssoc($result)))
	{
		$links[] = $linksT->createClass($row);
	}
	
	if (0 === ($count = count($links))) {
		return '';
	}

	return '<h2>'.WC_HTML::lang('own_links', array($user->displayUsername(), $count)).'</h2>'.$mod_links->templateLinks($links, '', '', '', false, false, false, false);
}

function wcProfileFavLinks(GWF_User $user)
{
	if (false === ($mod_links = GWF_Module::getModule('Links'))) {
		return '';
	}
	$mod_links->onInclude();
	$mod_links->onLoadLanguage();
	$linksT = GDO::table('GWF_Links');
	$user_browsing = GWF_Session::getUser();
	$perm_query = $mod_links->getPermQuery($user_browsing);
	$mod_query = $linksT->getModQuery($user_browsing);
	$member_query = $linksT->getMemberQuery($user_browsing);
	$private_query = $linksT->getPrivateQuery($user_browsing);
	$conditions = "($perm_query) AND ($mod_query) AND ($member_query) AND ($private_query)";
	$links = $linksT->getTableName();
	$favs = GDO::table('GWF_LinksFavorite')->getTableName();
	$votes = GDO::table('GWF_VoteScore')->getTableName();
	
	$userid = $user->getID();
	$query = "SELECT $links.*, $votes.* FROM $links JOIN $favs ON lf_lid=link_id JOIN $votes ON vs_id=link_voteid WHERE lf_uid=$userid AND $conditions";
	$db = gdo_db();
	if (false === ($result = $db->queryRead($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$links = array();
	while (false !==($row = $db->fetchAssoc($result)))
	{
		$links[] = $linksT->createClass($row);
	}
	
	if (0 === ($count = count($links))) {
		return '';
	}

	return '<h2>'.WC_HTML::lang('fav_links', array($user->displayUsername(), $count)).'</h2>'.$mod_links->templateLinks($links, '', '', '', false, false, false, false);
}

function wcProfileUsergroup(GWF_User $user, $is_logged_in)
{
	if (false === ($mod_ug = GWF_Module::getModule('Usergroups'))) {
		return '';
	}
	
	$mod_ug instanceof Module_Usergroups;
	
	$groups = $mod_ug->getGroups($user);

	foreach ($groups as $group)
	{
		if ($group->isAskToJoin())
		{
			echo sprintf('<h2>%s</h2>', WC_HTML::lang('pi_ug_info', array($user->displayUsername(), $group->display('group_name'), $group->getVar('group_memberc'))));
			if ($is_logged_in) {
				echo sprintf('<h3>%s</h3>', WC_HTML::lang('pi_ug_join', array(GWF_WEB_ROOT.'index.php?mo=Usergroups&amp;me=Join&amp;gid='.$group->getID())));
			} else {
				echo sprintf('<h3>%s</h3>', WC_HTML::lang('pi_ug_register', array(GWF_WEB_ROOT.'register')));
			}
		} else {
			
		}
	}
	return '';
}

function wcProfileGuestbook(GWF_User $user)
{
	if (false === ($mod_gb = GWF_Module::getModule('Guestbook'))) {
		return '';
	}
	$mod_gb->onInclude();
	if (false === ($gb = $mod_gb->getGuestbook($user->getID()))) {
		return '';
	}
	$mod_gb->onLoadLanguage();
	return $mod_gb->getMethod('Show')->templateShow($mod_gb, $gb);
}

function wcProfileGraphRank(GWF_User $user)
{
	return wcProfileGraph($user, 'totalscore');
}

function wcProfileGraphScore(GWF_User $user)
{
	return wcProfileGraph($user, 'rank');
}

function wcProfileGraph(GWF_User $user, $type)
{
	if ( (false === ($tu = GWF_Session::getUser())) || ($tu->getLevel() === 0 || ($tu->getID()===$user->getID())) )
	{
		$href = GWF_WEB_ROOT.'graph/wc_'.$type.'.'.$user->urlencode('user_name').'.png';
		$alt = WC_HTML::lang('alt_graph_'.$type, array($user->displayUsername()));
		return sprintf('<img src="%s" alt="%s" title="%s" />', $href, $alt, $alt);
	}
	else {
		$href = GWF_WEB_ROOT.'graph/wc_'.$type.'.'.$user->urlencode('user_name').'.vs.'.$tu->urlencode('user_name').'.png';
		$alt = WC_HTML::lang('alt_graph_'.$type.'_vs', array($user->displayUsername(), $tu->displayUsername()));
		return sprintf('<img src="%s" alt="%s" title="%s" />', $href, $alt, $alt);
	}
} 

function wcProfileLastActivity(GWF_User $user, $ipp)
{
	$uid = $user->getID();
	$uh = GDO::table('WC_HistoryUser2');
	$entries = $uh->select("userhist_uid=$uid", 'userhist_date DESC', $ipp);
//	$entries = array_reverse($entries);
	$back = '';
	$back .= '<table>';
	$href_txt_history = GWF_WEB_ROOT.'history/for/'.$user->urlencode2('user_name');
	$anchor = GWF_HTML::anchor($href_txt_history, WC_HTML::lang('th_last_activites', array($user->displayUsername())));
	$back .= sprintf('<tr><th colspan="2">%s</th></tr>', $anchor);
	foreach ($entries as $entry)
	{
		$entry instanceof WC_HistoryUser2;
		$back .= GWF_Table::rowStart();
		$back .= sprintf('<td class="gwf_date">%s</td>', $entry->displayDate());
		$back .= sprintf('<td>%s</td>', $entry->displayComment());
		$back .= GWF_Table::rowEnd();
	}
	$back .= '</table>';
	return $back;
}

function wcProfileFavSites($userid)
{
	$sites = WC_SiteFavorites::getFavoriteSites($userid);
	if (count($sites) === 0) {
		return '';
	}
	$back = 
		wcProfile1('<hr/>').
//		wcProfile1(WC_HTML::lang('th_favsites'));
		sprintf('<tr><th colspan="2">%s</th></tr>', WC_HTML::lang('th_favsites'));
	
	foreach ($sites as $site)
	{
		$site instanceof WC_Site;
		$back .= wcProfile1($site->getLink());
	}
	
	return $back;
}

function wcProfile1($a)
{
	return GWF_Table::rowStart().'<td colspan="2">'.$a.'</td>'.GWF_Table::rowEnd(); 
}
function wcProfile2($a, $b)
{
	return GWF_Table::rowStart().'<td>'.$a.'</td><td>'.$b.'</td>'.GWF_Table::rowEnd(); 
}

?>
