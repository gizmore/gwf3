<?php
$SITE = WC_Site::getByID(Common::getGetString('sid'));
if ($SITE === false)
{	# fallback
	$SITE = GDO::table('WC_Site')->selectRandom('*', "site_status='up'", 1, NULL, GDO::ARRAY_O);
	$SITE = $SITE[0];
}

# Put in cats.
//$types = array(); # Row types
$langs = array(); # Row languages
$cats = array(); # Row cats
//$types['all'] = array();
//$types['active'] = array();
foreach ($tVars['sites'] as $site)
{
	$site instanceof WC_Site;
//	var_dump($site->getGDOData());
	if ($site->isScored())
	{
		$langid = $site->getLangID();
		if (!isset($langs[$langid])) {
			$langs[$langid] = array();
		}
		$langs[$langid][] = $site;
//		$types['active'][] = $site;
	}
//	else
//	{
//		$type = $site->getTypeID();
//		if (!isset($types[$type])) {
//			$types[$type] = array();
//		}
//		$types[$type][] = $site;
//	}
	
	foreach ($site->getTagArray() as $tag)
	{
		if ($tag === '') {
			continue;
		}
		if (!(isset($cats[$tag]))) {
			$cats[$tag] = array($site);
		} else {
			$cats[$tag][] = $site;
		}
	}
	
//	$types['all'][] = $site;
}

ksort($cats);

### Now output all the selects in one single form
###
echo '<div id="wc_site_qj">'.PHP_EOL;

$nqj=1;

#- 2nd Row
//echo '<div>';
//foreach ($types as $typeid => $sites)
//{
//	$text = $tLang->lang('site_type_'.$typeid);
//	wcSiteQJSel($text, $sites, $tVars['mode'], $nqj++);
//}
//echo '</div>';

#- 1st row
echo sprintf('<form action="%s" method="post">', GWF_HTML::display($tVars['form_action']));
echo '<div>';
foreach ($langs as $langid => $sites)
{
	$text = $sites[0]->getLang()->displayName();
	wcSiteQJSel($text, $sites, $tVars['mode'], $nqj++);
}
echo '</div>';

#- 3rd Row (and more)
echo '<div>';
foreach ($cats as $cat => $sites)
{
	wcSiteQJSel($cat, $sites, $tVars['mode'], $nqj++);
}

#- 4th Row (boxes)
$boxes = WC_Warbox::getBoxes($SITE, 'wb_name ASC');
if (count($boxes) > 0)
{
	$data = array(array('0', 'Warboxes'));
	foreach ($boxes as $box)
	{
		$box instanceof WC_Warbox;
		$data[] = array($box->getID(), $box->displayName());
	}
// 	var_dump($data);
	echo GWF_Select::display('wc_boxes_quickjump', $data, Common::getGetString('bid'), "wcSiteQuickqump(this, '{$tVars['mode']}', 2)");
}


# - Button
echo '<noscript><div class="i"><input type="submit" name="quickjump" value="'.$tLang->lang('btn_quickjump').'" /></div></noscript>';
echo '</div>';

echo '</form>';
echo '</div>'.PHP_EOL;

# - Tabs
$which = Common::getGet('which', '0');
echo '<div class="gwf_buttons_outer gwf_buttons">'.PHP_EOL;


$btn_boxes = count($boxes) === 0 ? '' : WC_HTML::button('btn_warboxes', $SITE->hrefWarboxes());

switch(Common::getGetString('me'))
{
	case 'WarboxDetails':
	case 'WarboxesDetails':
		echo WC_HTML::button('btn_site_details', $SITE->hrefDetail());
		echo $btn_boxes;
		echo WC_HTML::button('btn_ranking', $SITE->hrefRanking(true));
		echo WC_HTML::button('btn_site_history', $SITE->hrefHistory());
		break;
	case 'WarboxPlayers':
	case 'SiteRankings':
		echo WC_HTML::button('btn_site_details', $SITE->hrefDetail());
		echo $btn_boxes;
		echo WC_HTML::button('btn_site_history', $SITE->hrefHistory());
		break;
	case 'SiteDetails':
		echo $btn_boxes;
		echo WC_HTML::button('btn_ranking', $SITE->hrefRanking(true));
		echo WC_HTML::button('btn_site_history', $SITE->hrefHistory());
		break;
	case 'SiteHistory': 
		echo WC_HTML::button('btn_site_details', $SITE->hrefDetail());
		echo $btn_boxes;
		echo WC_HTML::button('btn_ranking', $SITE->hrefRanking(true));
		break;
	default:
		echo WC_HTML::button('btn_site_details', $SITE->hrefDetail());
		echo $btn_boxes;
		echo WC_HTML::button('btn_ranking', $SITE->hrefRanking(true));
		echo WC_HTML::button('btn_site_history', $SITE->hrefHistory());
		break;
}

echo '&nbsp;|&nbsp;'.PHP_EOL;

echo WC_HTML::button('btn_all_sites', GWF_WEB_ROOT.'all_sites', $which==='5' );
echo WC_HTML::button('btn_active_sites', GWF_WEB_ROOT.'active_sites', $which==='1');
echo WC_HTML::button('btn_graveyard', GWF_WEB_ROOT.'graveyard', $which==='2');
echo WC_HTML::button('btn_not_ranked', GWF_WEB_ROOT.'not_ranked', $which==='4');
echo WC_HTML::button('btn_coming_soon', GWF_WEB_ROOT.'coming_soon', $which==='3');
echo '</div>'.PHP_EOL;

### Helper
# Output 1 select
function wcSiteQJSel($text, $sites, $mode, $nqj)
{
	
	echo '<select name="quickjumps['.$nqj.']" onchange="wcSiteQuickqump(this, \''.$mode.'\', 1);">'.PHP_EOL;
	echo '<option value="0">'.$text.'</option>';

	foreach ($sites as $site)
	{
		$site instanceof WC_Site;
	
// 		switch ($mode)
// 		{
// 			case 'detail':
// 				$href = $site->hrefDetail();
// 				break;
// 			case 'ranking':
// 				$href = $site->hrefRanking();
// 				break;
// 			case 'history':
// 				$href = $site->hrefHistory();
// 				break;
// 		}
		
		echo sprintf('<option value="%s">%s</option>', $site->getVar('site_id'), $site->displayName()).PHP_EOL;
	}
	echo '</select>'.PHP_EOL;
}

?>
