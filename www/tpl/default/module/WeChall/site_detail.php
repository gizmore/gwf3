<?php $site = $tVars['site']; $site instanceof WC_Site; $is_ranked = $site->isScored(); $siteid = $site->getID(); ?>

<?php
if (!$tVars['jquery']) {
	echo $tVars['site_quickjump'];
}
?>

<?php
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
if ($tVars['jquery']) {
	$onclick = "wcjsHideJQuery('#wcrl_slide'); return false;";
	echo GWF_Button::delete('#', $tLang->lang('btn_close'), '', $onclick);
}
//echo WC_HTML::button($tLang->lang('btn_ranking'), $site->hrefRanking(true));
echo '</div></div>'.PHP_EOL;
?>

<?php
if (false === ($user = GWF_User::getByName(Common::getGet('username', '')))) {
}
if ($user !== false) {
	$userid = $user->getID();
	if (false !== ($regat = WC_RegAt::getRegatRow($userid, $siteid))) {
		$max = $site->getOnsiteScore();
		echo GWF_Box::box($tLang->lang('site_detail_uinfo', array($user->displayUsername(), $regat->getOnsiteScore(), $max, $site->displayName(), round($regat->getPercent($max),2), WC_RegAt::calcExactSiteRank($user, $siteid), $site->calcScore($regat))));
	}
}
?>

<div class="ib"><?php echo GWF_Box::box(GWF_Message::display($tVars['descr'])); ?></div>

<table>
	<thead>
		<tr>
			<th colspan="2" id="wc_site_detail_head"><?php echo $site->displayLogo(32, $tLang->lang('hover_logo', array($site->displayName()))).$site->displayLink(); ?></th>
		</tr>
	</thead>
	<?php 
	if (GWF_User::isStaffS() || WC_SiteAdmin::isSiteAdmin(GWF_Session::getUserID(), $siteid)) {
		echo WC_HTML::tableRowForm($tLang->lang('ft_edit_site', array($site->displayName())), $site->getEditButton($tVars['module'], GWF_Session::getUser()));
	}
	echo WC_HTML::tableRowForm($tLang->lang('th_site_country_detail'), $site->displayCountry());
	$href = GWF_WEB_ROOT.'all_sites/'.$site->getLangISO();
	echo WC_HTML::tableRowForm($tLang->lang('th_site_language'), GWF_HTML::anchor($href, $site->displayLanguage()));
	echo WC_HTML::tableRowForm($tLang->lang('th_site_tags'), $site->displayTags(true));
	$warboxes = $tVars['boxcount'] > 0 ? $tVars['boxcount'].GWF_Button::forward($site->hrefWarboxes(), 'Show Wargames') : '0';
	if ($is_ranked)
	{
		echo WC_HTML::tableRowForm($tLang->lang('th_site_admins'), $site->displaySiteAdmins());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_autoup'), $site->displayAutoUpdate());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_has_osr'), $site->displayOnSiteRank());
// 		if ($warboxes !== '')
		{
			echo WC_HTML::tableRowForm($tLang->lang('btn_warboxes'), $warboxes);
		}
		echo WC_HTML::tableRowForm($tLang->lang('th_site_score'), $site->getScore());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_basescore'), $site->getBasescore());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_usercount'), $site->getUsercount());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_challcount'), $site->getChallcount());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_linkcount'), $site->getLinkCount());
		echo WC_HTML::tableRowForm($tLang->lang('th_site_avg'), $site->displayAvg());
	}
	else
	{
		echo WC_HTML::tableRowForm($tLang->lang('btn_warboxes'), $warboxes);
	}

	# Diff Votes
	$vdif = $site->getVotesDif();
	echo GWF_Table::rowStart().
		'<th>'.$tLang->lang('th_site_dif').'</th>'.PHP_EOL.
		'<td><span id="gwf_vsba_'.$vdif->getID().'">'.$vdif->displayPercent().'</span></td>'.PHP_EOL.
		GWF_Table::rowEnd();

	if ($tVars['can_vote'])
	{
		echo WC_HTML::tableRowForm($tLang->lang('th_site_vote_dif'), $site->getVotesDif()->displayButtons());
	}
	
	# Fun Votes
	$vfun = $site->getVotesFun();
	echo GWF_Table::rowStart().
		'<th>'.$tLang->lang('th_site_fun').'</th>'.PHP_EOL.
		'<td><span id="gwf_vsba_'.$vfun->getID().'">'.$vfun->displayPercent().'</span></td>'.PHP_EOL.
		GWF_Table::rowEnd();
		
	if ($tVars['can_vote'])
	{
		echo WC_HTML::tableRowForm($tLang->lang('th_site_vote_fun'), $site->getVotesFun()->displayButtons());
	}

	echo WC_HTML::tableRowForm($tLang->lang('th_site_irc'), $site->displayIRC());
?>
</table>

<?php if ($tVars['jquery']) { return;} ?>

<?php
$count = count($tVars['latest_players']);
$cols = 7;
if ($count > 0)
{
	echo '<table>';
	echo sprintf('<tr><th colspan="%d">%s</th></tr>', $cols, $tLang->lang('th_latest_players', array($count, $tVars['latest_players_time'])));
	
	echo '<tr>';
	
	$i = 0;
	foreach ($tVars['latest_players'] as $username)
	{
		echo sprintf('<td class="gwf_td_%d">%s</td>', $i%2, GWF_HTML::anchor(GWF_WEB_ROOT.'profile/'.urlencode($username), $username));
		if (($i % $cols) === ($cols-1)) {
			echo '</tr><tr>';
		}
		$i++;
	}
	echo '</tr>';
	echo '</table>';
}
?>

<?php if ($site->isScored()) { 
	$name = $site->displayName();
?>
		<?php if ($site->getScore() > 0) { ?>
			<div class="wc_graph fl"><img src="<?php echo $site->hrefGraphScore(); ?>" title="<?php echo $tLang->lang('it_graph_sitescore', array($name)); ?>" alt="<?php echo $tLang->lang('it_graph_sitescore', array($name)); ?>"></img></div>
		<?php }?>
		<?php if ($site->getUsercount() > 0) { ?>
			<div class="wc_graph fl"><img src="<?php echo $site->hrefGraphUsers(); ?>" title="<?php echo $tLang->lang('it_graph_siteusers', array($name)); ?>" alt="<?php echo $tLang->lang('it_graph_siteusers', array($name)); ?>"></img></div>
		<?php }?>
		<?php if ($site->getChallcount() > 0) { ?>
			<div class="wc_graph fl"><img src="<?php echo $site->hrefGraphChalls(); ?>" title="<?php echo $tLang->lang('it_graph_sitechalls', array($name)); ?>" alt="<?php echo $tLang->lang('it_graph_sitechalls', array($name)); ?>"></img></div>
		<?php }?>
		<?php #} ?>
	<div class="cl"></div>
<?php } ?>

<?php
if ('0' !== ($tid = $site->getVar('site_threadid')))
{
	$_GET['tid'] = $tid;
	$_GET['last_page'] = true;
	if (false !== ($forum = GWF_Module::loadModuleDB('Forum', true, true)))
	{
		GWF_ForumBoard::init(true, false);
		echo $forum->requestMethodB('ShowThread');
	}
} 

$dtitle = $site->getVar('site_name');
$args = array($dtitle);
GWF_Website::setPageTitle($tLang->lang('pt_site_detail', $args));
GWF_Website::setMetaTags($tLang->lang('mt_site_detail', $args));
GWF_Website::setMetaDescr($tLang->lang('md_site_detail', $args));
?>