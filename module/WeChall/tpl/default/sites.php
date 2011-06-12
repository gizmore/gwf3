<h1><?php echo $tVars['page_title']; ?></h1>

<?php echo $tVars['site_quickjump']; ?>

<?php if ($tVars['which']===2) { echo GWF_Box::box($tLang->lang('pi_graveyard')); } ?>

<?php
$user = GWF_Session::getUser();

$headers = array(
	array($tLang->lang('ID'), 'site_id'),
	array($tLang->lang('th_site_country'), 'site_country'),
	array($tLang->lang('th_site_language'), 'site_language'),
	array($tLang->lang('th_site_name'), 'site_name'),
//	array($tLang->lang('th_site_score'), 'site_score'),
	array($tLang->lang('th_site_usercount'), 'site_usercount', 'DESC'),
	array($tLang->lang('th_site_challcount'), 'site_challcount', 'DESC'),
	array($tLang->lang('th_site_avg'), 'site_avg', 'DESC'),
	array($tLang->lang('th_site_vote_dif'), 'site_dif', 'DESC'),
	array($tLang->lang('th_site_vote_fun'), 'site_fun', 'DESC'),
	array($tLang->lang('th_site_description')), #, 'site_description'),
);

//$headers = GWF_Table::getHeaders2($headers, $tVars['sortURL']);
echo GWF_Table::start('');
//echo GWF_Table::displayHeaders($headers);
echo GWF_Table::displayHeaders1($headers, $tVars['sortURL']);
foreach ($tVars['sites'] as $site)
{
	$site instanceof WC_Site;
	$editbtn = $site->getEditButton($tVars['module'], $user);
	echo GWF_Table::rowStart();
	echo sprintf('<td class="gwf_num">%s</td>', $site->getVar('site_id'));
	echo sprintf('<td>%s</td>', $site->displayCountry());
	echo sprintf('<td>%s</td>', $site->displayLanguage());
	echo sprintf('<td class="gwf_nobiga nowrap">%s%s%s</td>', $editbtn, $site->displayLogo(20, $tLang->lang('logo_hover', array($site->displayName()))), $site->displayLink());
	if ($site->isScored())
	{
//		echo sprintf('<td class="gwf_num">%s</td>', $site->displayScore());
		echo sprintf('<td class="gwf_num">%s</td>', $site->getVar('site_usercount'));
		echo sprintf('<td class="gwf_num">%s</td>', $site->getVar('site_challcount'));
		echo sprintf('<td class="gwf_num">%s</td>', $site->displayAvg());
	}
	else
	{
		echo str_repeat('<td></td>', 3);
	}
	echo sprintf('<td class="gwf_num">%s</td>', $site->displayDif());
	echo sprintf('<td class="gwf_num">%s</td>', $site->displayFun());
	$desc = Common::stripMessage($tVars['descrs'][$site->getID()], 120);
	
	echo sprintf('<td><a href="%s">%s</a></td>', $site->hrefDetail(), $desc);
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Box::box($tLang->lang('sites_join_b', GWF_WEB_ROOT.'join_us'), $tLang->lang('sites_join_t'));

if (GWF_User::isAdminS()) {
	echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
	echo GWF_Button::add($tLang->lang('btn_add_site'), GWF_WEB_ROOT.'site/add');
	echo '</div></div>'.PHP_EOL;
}
?>