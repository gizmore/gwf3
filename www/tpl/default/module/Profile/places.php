<h1><?php echo $tLang->lang('ph_places'); ?></h1>
<?php
$userid = GWF_Session::getUserID();
$can = $tVars['module']->cfgAllowedPOIs();
$have = GWF_ProfilePOI::getPOICount($userid);
$left = $can - $have;
$href_settings = GWF_WEB_ROOT.'profile_settings';
$href_whitelist = GWF_WEB_ROOT.'index.php?mo=Profile&amp;me=POISWhitelist';
echo GWF_Box::box($tLang->lang('poi_info', array($left, $can, $href_settings, $href_whitelist)));
// $usage = '<ul><li>'.implode('</li><li>', $tLang->lang('poi_usage_data')).'</li></ul>'.PHP_EOL;
$usage = '';
echo GWF_Box::box($usage, $tLang->lang('poi_usage'));
?>
<div id="profile_map"></div>
<script type="text/javascript">
window.gwf.profile = new window.gwf.Profile('profile_map', <?php echo $tVars['user_id']; ?>, <?php echo $tVars['js_trans']; ?>);
</script>
