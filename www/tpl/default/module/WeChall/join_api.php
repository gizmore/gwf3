<?php
$l = $tVars['join'];
$user = GWF_Session::getUser();
$udata = $user === false ? array() : $user->getUserData(); 
$uname = $user === false ? 'Gizmore' : $user->urlencode('user_name');

echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api', 'generic', '', true);
echo GWF_Button::wrapEnd();

# API 1)
$href_opt_7 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional#join_7';
echo '<a name="api_1"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('api_1b', array($href_opt_7, $href_opt_7)), $l->lang('api_1t'));

# API 2)
$example_6_1 = 'https://www.wechall.net/wechall.php?username='.$uname;
$example_6_2 = 'https://www.wechall.net/wechall.php?username=!sites%20'.$uname;
$example_6_3 = 'https://www.wechall.net/wechall.php?username=!TBS%20'.$uname;
$example_6_4 = 'https://www.wechall.net/wechall.php?username=!sites';
$href_opt_6 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional#join_6';
echo '<a name="api_2"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('api_2b', array($href_opt_6, $example_6_1, $example_6_1, $example_6_2, $example_6_2, $example_6_3, $example_6_3, $example_6_4, $example_6_4)), $l->lang('api_2t'));

# API 3)
$xss_url = sprintf('%s://%s%sindex.php?mo=WeChall&me=API_History&no_session=1&', Common::getProtocol(), GWF_DOMAIN, GWF_WEB_ROOT);
$usage_3_1 = htmlspecialchars($xss_url.'<parameters>');
require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
$event_types = implode(', ', WC_HistoryUser2::$HISTORY_TYPES);
$examples = array(
	'username=hds',
	'username=hds&limit=50',
	'username=hds&sitename=Yashira',
	'username=hds&sitename=Yashira&datestamp=20100403204635&limit=10',
);
foreach ($examples as $i => $e) {
	$href = $xss_url.$e;
	$anchor = GWF_HTML::anchor($href, '...'.$e);
	$examples[$i] = ('- '.$anchor);
}
$examples = implode("<br/>\n", $examples);
// $href_api_3 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=api#api_3';

echo '<a name="api_3"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('api_3b', array($usage_3_1, $usage_3_1, $usage_3_1, $event_types, $examples)), $l->lang('api_3t'));


# API 4)
$href_api_4 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=api#api_4';
$url = sprintf('%s://%s%sindex.php?mo=WeChall&me=API_User&no_session=1&', Common::getProtocol(), GWF_DOMAIN, GWF_WEB_ROOT);
$usage_4_1 = htmlspecialchars($url.'username=<username>[&apikey=<your_api_key>]');
$example_4_1 = GWF_HTML::anchor($url.'username='.$uname, $url.'username='.$uname);
if ($user !== false && isset($udata['WC_NO_XSS_PASS'])) {
	$api_key = urlencode($udata['WC_NO_XSS_PASS']);
	$example_4_2 = GWF_HTML::anchor($url."username=$uname&apikey=$api_key", $url."username=$uname&apikey=$api_key");
} else {
	$example_4_2 = '';
}
echo '<a name="api_4"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('api_4b', array($usage_4_1, $usage_4_1, $example_4_1, $example_4_2)), $l->lang('api_4t'));

# API 5)
$href_api_5 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=api#api_5';
$url = sprintf('%s://%s%sindex.php?mo=WeChall&me=API_Site&no_session=1', Common::getProtocol(), GWF_DOMAIN, GWF_WEB_ROOT);
$usage_5_1 = htmlspecialchars($url.'[&sitename=<sitename>]');
$example_5_1 = GWF_HTML::anchor($url, $url);
$example_5_2 = GWF_HTML::anchor($url.'&sitename=WeChall', $url.'&sitename=WeChall');
echo '<a name="api_5"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('api_5b', array($usage_5_1, $usage_5_1, $example_5_1, $example_5_2)), $l->lang('api_5t'));


# Buttons
echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api', 'generic', '', true);
echo GWF_Button::wrapEnd();
