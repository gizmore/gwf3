<?php
function gwfProfileRow($head, $value='')
{
	return
		GWF_Table::rowStart().
		($value === '' ? sprintf('<td colspan="2">%s</td>', $head) : sprintf('<th>%s</th><td>%s</td>', $head, $value)).PHP_EOL.
		GWF_Table::rowEnd();
}

function wcProfileFavSites($userid)
{
	$sites = WC_SiteFavorites::getFavoriteSites($userid);
	if (count($sites) === 0) {
		return '';
	}
	$back = 
		gwfProfileRow('<hr/>').
		sprintf('<tr><th colspan="2">%s</th></tr>', WC_HTML::lang('th_favsites'));
	
	foreach ($sites as $site)
	{
		$site instanceof WC_Site;
		$back .= gwfProfileRow($site->getLink());
	}
	
	return $back;
}

function wcProfileFavCats($userid)
{
	require_once GWF_CORE_PATH.'module/WeChall/WC_FavCats.php';
	$cats = WC_FavCats::getFavCats($userid);
	if (count($cats) === 0) {
		return '';
	}
	$back = gwfProfileRow('<hr/>').sprintf('<tr><th colspan="2">%s</th></tr>', WC_HTML::lang('th_favcats'));
	foreach ($cats as $cat)
	{
		$back .= gwfProfileRow(htmlspecialchars($cat));
	}
	return $back;
}

function wcProfileRegats(array $regats, $sort_url, $priv=false, $hide_score=false)
{
	$unknown = GWF_HTML::lang('unknown');
	$headers = array(
		array(WC_HTML::lang('th_site_name')),
		array(WC_HTML::lang('th_score'), 'regat_score'),
		array(WC_HTML::lang('th_regat_onsitename')),
		array(WC_HTML::lang('th_progress'), 'regat_solved'),
		array(WC_HTML::lang('th_regat_lastdate'), 'regat_lastdate'),
	);
	echo '<table>';
	echo GWF_Table::displayHeaders1($headers);
	foreach ($regats as $regat)
	{
		$regat instanceof WC_RegAt;
		$site = $regat->getSite();
		$color = GWF_Color::interpolatBound(0, 1, $site->calcPercent($regat), 0xff0000, 0x008800);
		if ($hide_score)
		{
			$score = $percent = '???';
		}
		else
		{
			$score = $regat->getVar('regat_score');
			$percent = $regat->displayPercent($site->getOnsiteScore());
		}
		echo GWF_Table::rowStart(true, '', '', 'color:#'.$color.';');
		echo sprintf('<td>%s</td>', $site->displayLink());
		echo sprintf('<td class="gwf_num">%s</td>', $score);
		echo sprintf('<td>%s</td>', $regat->displayOnsiteProfileLink($site));
		echo sprintf('<td class="gwf_num">%s</td>', $percent);
		echo sprintf('<td class="nowrap gwf_date">%s</td>', ($priv ? $unknown : $regat->displayLastDate()) );
		echo GWF_Table::rowEnd();
	}
	echo '</table>';
}

function wcProfileLastActivity(GWF_User $user, $ipp, $priv=false)
{
	$uid = $user->getID();
	$uh = GDO::table('WC_HistoryUser2');
	$entries = $uh->selectObjects('*', "userhist_uid=$uid", 'userhist_date DESC', $ipp);
//	$entries = array_reverse($entries);
	$back = '';
	$back .= '<table class="cl">';
	$href_txt_history = GWF_WEB_ROOT.'history/for/'.$user->urlencode2('user_name');
	$anchor = GWF_HTML::anchor($href_txt_history, WC_HTML::lang('th_last_activites', array($user->displayUsername())));
	$back .= sprintf('<thead><tr><th colspan="2">%s</th></tr></thead>', $anchor);
	$unknown = GWF_HTML::lang('unknown');
	foreach ($entries as $entry)
	{
		$entry instanceof WC_HistoryUser2;
		$back .= GWF_Table::rowStart();
		$back .= sprintf('<td class="gwf_date">%s</td>', ($priv ? $unknown : $entry->displayDate()) );
		$back .= sprintf('<td>%s</td>', $entry->displayComment());
		$back .= GWF_Table::rowEnd();
	}
	$back .= '</table>';
	return $back;
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
	else
	{
		$href = GWF_WEB_ROOT.'graph/wc_'.$type.'.'.$user->urlencode('user_name').'.vs.'.$tu->urlencode('user_name').'.png';
		$alt = WC_HTML::lang('alt_graph_'.$type.'_vs', array($user->displayUsername(), $tu->displayUsername()));
		return sprintf('<img src="%s" alt="%s" title="%s" />', $href, $alt, $alt);
	}
}

function wcProfileFavLinks(GWF_User $user, Module_Links $mod_links)
{
	$linksT = GDO::table('GWF_Links');
	$user_browsing = GWF_Session::getUser();
	$perm_query = $mod_links->cfgShowPermitted() ? '1' : $mod_links->getPermQuery($user_browsing);
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
	while (false !== ($row = $db->fetchAssoc($result)))
	{
		$links[] = new GWF_Links($row);#$linksT->createClass($row);
	}
	
	if (0 === ($count = count($links))) {
		return '';
	}

	return '<h2>'.WC_HTML::lang('fav_links', array($user->displayUsername(), $count)).'</h2>'.$mod_links->templateLinks($links, '', '', '', false, false, false, false);
}

function wcProfileOwnLinks(GWF_User $user, Module_Links $mod_links)
{
	$linksT = GDO::table('GWF_Links');
	$user_browsing = GWF_Session::getUser();
	$perm_query = $mod_links->cfgShowPermitted() ? '1' : $mod_links->getPermQuery($user_browsing);
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
		$links[] = new GWF_Links($row);# $linksT->createClass($row);
	}
	
	if (0 === ($count = count($links))) {
		return '';
	}

	return '<h2>'.WC_HTML::lang('own_links', array($user->displayUsername(), $count)).'</h2>'.$mod_links->templateLinks($links, '', '', '', false, false, false, false);
}

function wcProfileGuestbook(GWF_User $user)
{
	$gb = GWF_TABLE_PREFIX.'guestbook';
	$userid = $user->getID();
	if ( (false === gdo_db()->queryFirst("SELECT 1 FROM $gb WHERE gb_uid=$userid AND gb_options&1=0"))) {
		return '';
	}
	
	if (false === ($mod_gb = GWF_Module::getModule('Guestbook'))) {
		return '';
	}
	$mod_gb->onInclude();
	if (false === ($gb = $mod_gb->getGuestbook($userid))) {
		return '';
	}
	$mod_gb->onLoadLanguage();
	return $mod_gb->getMethod('Show')->templateShow($mod_gb, $gb);
}

function wcProfileUsergroup(GWF_User $user, $is_logged_in)
{
	$ug = GWF_TABLE_PREFIX.'usergroup';
	$userid = $user->getVar('user_id');
	if ( (false === gdo_db()->queryFirst("SELECT 1 FROM $ug WHERE ug_userid=$userid"))) {
		return '';
	}
	
	
	if (false === ($mod_ug = GWF_Module::loadModuleDB('Usergroups'))) {
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
?>