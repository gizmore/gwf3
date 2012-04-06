<?php
$user1 = $tVars['user1']; $user1 instanceof GWF_User;
$user2 = $tVars['user2']; $user2 instanceof GWF_User;
$name1 = $user1 === false ? '' : $user1->displayUsername();
$name2 = $user2 === false ? '' : $user2->displayUsername();

echo sprintf('<form action="%s" method="post">', $tVars['form_action']).PHP_EOL;

echo '<div class="box"><div class="box_c">'.PHP_EOL;
//echo sprintf('<input type="submit" name="clear" onclick="return wcStatsClearSites();" value="%s" />', $tLang->lang('btn_stats_clear')).PHP_EOL;

echo sprintf('<input type="text" id="wc_stat_user1" name="wc_stat_user1" value="%s" />', $name1).PHP_EOL;
echo ' vs. '.PHP_EOL;
echo sprintf('<input type="text" id="wc_stat_user2" name="wc_stat_user2" value="%s" />', $name2).PHP_EOL;


wcstatsSitegroup($tVars['sites']['high'], $tLang->lang('stat_high'));
wcstatsSitegroup($tVars['sites']['med'], $tLang->lang('stat_med'));
wcstatsSitegroup($tVars['sites']['low'], $tLang->lang('stat_low'));
//wcstatsSitegroup($tVars['sites']['null'], $tLang->lang('stat_null'));
wcstatsSitegroup($tVars['sites']['vs'], $tLang->lang('stat_vs'));

function wcstatsSitegroup(array &$sites, $text)
{
	if (count($sites)===0) {
		return '';
	}
	echo sprintf('<div><b>%s</b>:&nbsp;', $text).PHP_EOL;
	foreach ($sites as $site)
	{
		$site instanceof WC_Site;
		$siteid = $site->getVar('site_id');
		$sitename = $site->display('site_name');
		$sel = GWF_HTML::checked($site->hasVar('sel'));# === true);
		echo sprintf('<input type="checkbox" %s name="site[%s]" onclick="wcStatsCheckSite(this)" value="%s" />%s', $sel, $siteid, $siteid, $sitename).PHP_EOL;
	}
	echo '</div>';
}


//echo $tVars['select_month'];

#echo sprintf('<div>%s: <input type="text" name="user2" value="%s" id="wcstatvs" /></div>', $tLang->lang('vs'), $name2);
echo '<hr/>'.PHP_EOL;

echo sprintf('<div><input id="wcstatcbx_ico" type="checkbox" name="icons" %s onclick="wcStatsRefresh();" />%s</div>', GWF_HTML::checked($tVars['icons']), $tLang->lang('chk_icons'));
echo sprintf('<div><input id="wcstatcbx_num" type="checkbox" name="values" %s onclick="wcStatsRefresh();" />%s</div>', GWF_HTML::checked($tVars['values']), $tLang->lang('chk_values'));
echo sprintf('<div><input id="wcstatcbx_zoom" type="checkbox" name="zoom" %s onclick="wcStatsRefresh();" />%s</div>', GWF_HTML::checked($tVars['zoom']), $tLang->lang('chk_zoom'));
//echo sprintf('<div><input type="text" name="months" size="1" value="%s" />%s</div>', $tVars['months'], GWF_HTML::lang('months'));

echo sprintf('<div><input type="submit" name="display" value="%s" />', $tLang->lang('btn_show_stats'));
echo sprintf('<input type="submit" name="displayall" value="%s" />', $tLang->lang('btn_show_stats_all')).PHP_EOL;
echo sprintf('<input type="submit" name="displaynone" value="%s" /></div>', $tLang->lang('btn_show_stats_none'));
echo '</div></div>'.PHP_EOL;

echo '</form>'.PHP_EOL;

echo '<div id="wcstatbox">'.PHP_EOL;
echo '<div class="box box_c">'.PHP_EOL;
echo '<script type="text/javascript">'.PHP_EOL;
echo 'wcstatgraphInit(\''.$name1.'\', \''.$name2.'\')'.PHP_EOL;
echo '</script>'.PHP_EOL;
echo '<noscript>'.PHP_EOL;
echo '<div>'.PHP_EOL;
echo sprintf('<img id="wc_statgraph" src="%s" alt="%s" />', $tVars['img_src'], $tVars['img_alt']);
echo '</div>'.PHP_EOL;
echo '</noscript>'.PHP_EOL;
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

?>