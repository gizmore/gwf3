<?php
$l = $tVars['join'];
echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Button::wrapEnd();

echo '<h2>'.$l->lang('join_summary_opt').'</h2>'.PHP_EOL;

# 4
echo '<a name="join_4">permalink</a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_4b'), '4) '.$l->lang('join_4t'));

# 5
$url_5_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_5_1';
$url_5_2 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_5_2';
$hidden_5_1 = Common::getGet('show') === 'example_5_1' ? 'block' : 'none';
$hidden_5_2 = Common::getGet('show') === 'example_5_2' ? 'block' : 'none';
echo '<a name="join_5"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_5b', array($url_5_1, $hidden_5_1, $url_5_2, $hidden_5_2)), '5) '.$l->lang('join_5t'));

# 6
echo '<a name="join_6"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_6b'), '6) '.$l->lang('join_6t'));

# 7
$code_7_1 = htmlspecialchars(file_get_contents(GWF_WWW_PATH.'tpl/default/module/WeChall/join_us/code_7_1.php'));
$code_7_2 = htmlspecialchars(file_get_contents(GWF_WWW_PATH.'tpl/default/module/WeChall/join_us/code_7_2.php'));
$url_7_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_7_1';
$url_7_2 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_7_2';
$hidden_7_1 = Common::getGet('show') === 'example_7_1' ? 'block' : 'none';
$hidden_7_2 = Common::getGet('show') === 'example_7_2' ? 'block' : 'none';
$href3p = 'https://github.com/gizmore/gwf3/tree/master/extra/3p_irc_forum_plugins';
echo '<a name="join_7"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_7b', array($url_7_1, $hidden_7_1, $code_7_1, $url_7_2, $hidden_7_2, $code_7_2, $href3p)), '7) '.$l->lang('join_7t'));


echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Button::wrapEnd();
