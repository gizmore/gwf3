<h1><?php echo $tVars['page_title']; ?></h1>

<?php echo $tVars['site_quickjump']; ?>

<?php if ($tVars['which']===2) { echo GWF_Box::box($tLang->lang('pi_graveyard')); } ?>

<?php
$user = GWF_Session::getUser();

$headers = array(
	array(),
	array($tLang->lang('ID'), 'site_id', 'ASC', 5),
	array($tLang->lang('th_site_language'), 'site_language', 'ASC', 3),
	array($tLang->lang('th_site_country'), 'site_country', 'ASC', 5),
	array($tLang->lang('th_site_name'), 'site_name', 'ASC', 1),
//	array($tLang->lang('th_site_score'), 'site_score', 'ASC'),
	array($tLang->lang('th_site_usercount'), 'site_usercount', 'DESC', 2),
	array($tLang->lang('th_site_challcount'), 'site_challcount', 'DESC', 1),
	array($tLang->lang('th_site_avg'), 'site_avg', 'DESC', 2),
	array($tLang->lang('th_site_vote_dif'), 'site_dif', 'DESC', 4),
	array($tLang->lang('th_site_vote_fun'), 'site_fun', 'DESC', 3),
	array($tLang->lang('th_site_description'), null, null, 6), #, 'site_description'),
);

echo $tVars['pagemenu'];

echo GWF_Table::start('');
echo GWF_Table::displayHeaders1($headers, $tVars['sortURL']);
foreach ($tVars['sites'] as $site)
{
	$site instanceof WC_Site;
	echo GWF_Table::rowStart();
	printf('<td>%s</td>', $site->getEditButton($tVars['module'], $user));
	printf('<td class="gwf_num">%s</td>', $site->getVar('site_id'));
	printf('<td>%s</td>', $site->displayLanguage());
	printf('<td class="gwf_nobiga nowrap">%s', $site->displayCountry());
	printf('%s</td>', $site->displayLogo(20, $tLang->lang('logo_hover', array($site->displayName()))));
	printf('<td class="gwf_nobiga nowrap">%s</td>', $site->displayLink());
	if ($site->isScored())
	{
//		printf('<td class="gwf_num">%s</td>', $site->displayScore());
		printf('<td class="gwf_num">%s</td>', $site->getVar('site_usercount'));
		printf('<td class="gwf_num">%s</td>', $site->getVar('site_challcount'));
		printf('<td class="gwf_num">%s</td>', $site->displayAvg());
	}
	else
	{
		echo str_repeat('<td></td>', 3);
	}
	printf('<td class="gwf_num">%s</td>', $site->displayDif());
	printf('<td class="gwf_num">%s</td>', $site->displayFun());
	$desc = Common::stripMessage($tVars['descrs'][$site->getID()], 120);
	
	printf('<td><a href="%s">%s</a></td>', $site->hrefDetail(), $desc);
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Box::box($tLang->lang('sites_join_b', array(GWF_WEB_ROOT.'join_us')), $tLang->lang('sites_join_t'));

if (GWF_User::isAdminS())
{
	echo GWF_Button::wrapStart();
	echo GWF_Button::add($tLang->lang('btn_add_site'), GWF_WEB_ROOT.'site/add');
	echo GWF_Button::wrapEnd();
}
