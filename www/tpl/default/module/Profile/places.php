<h1><?php echo $tLang->lang('ph_places'); ?></h1>
<?php
$userid = GWF_Session::getUserID();
$can = $tVars['module']->cfgAllowedPOIs();
$have = GWF_ProfilePOI::getPOICount($userid);
$left = $can - $have;
$href_settings = GWF_WEB_ROOT.'profile_settings';
$href_whitelist = GWF_WEB_ROOT.'index.php?mo=Profile&amp;me=POISWhitelist';
echo GWF_Box::box($tLang->lang('poi_info', array($left, $can, $href_settings, $href_whitelist)));

echo GWF_Box::box($tLang->lang('poi_privacy'), $tLang->lang('poi_privacy_t'));

echo GWF_Box::box($tLang->lang('poi_stats', array($tVars['total'], $tVars['visible'])), $tLang->lang('poi_stats_t'));

$usage = '<ul><li>'.implode('</li><li>', $tLang->lang('poi_usage_data')).'</li></ul>'.PHP_EOL;
echo GWF_Box::box($usage, $tLang->lang('poi_usage'));

$helper  = '<div id="poi_init">';
$helper .= sprintf('<button onclick="window.gwf.profile.init(false)" >%s</button>', $tLang->lang('btn_poi_init'));
$helper .= sprintf('<button onclick="window.gwf.profile.init(true)" >%s</button>', $tLang->lang('btn_poi_init_sensor'));
$helper .= '</div>';
$helper .= sprintf('<div><input id="jump_address" type="text" placeholder="%s" /></div>', $tLang->lang('ph_poi_jump'));


echo '<div id="poi_helper">'.GWF_Box::box($helper, $tLang->lang('poi_helper')).'</div>'.PHP_EOL;
?>
<div id="profile_map"></div>
<script type="text/javascript">
window.gwf.profile = new window.gwf.Profile('profile_map',
<?php echo $tVars['user_id']; ?>,
<?php echo $tVars['js_trans']; ?>,
<?php echo $left; ?>,
<?php echo $tVars['is_admin']; ?>,
'<?php echo $tVars['api_key']; ?>',
'<?php echo $tVars['protocol']; ?>',
<?php echo $tVars['init_lat']; ?>,
<?php echo $tVars['init_lon']; ?>
);
</script>
<!-- When you can read this you really need to get laid. -->