<?php
$l = $tVars['join'];
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo '</div></div>'.PHP_EOL;

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
$code_7_1 = htmlspecialchars(file_get_contents('core/module/WeChall/tpl/default/join_us/code_7_1.php'));
$code_7_2 = htmlspecialchars(file_get_contents('core/module/WeChall/tpl/default/join_us/code_7_2.php'));
$url_7_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_7_1';
$url_7_2 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=optional&amp;show=example_7_2';
$hidden_7_1 = Common::getGet('show') === 'example_7_1' ? 'block' : 'none';
$hidden_7_2 = Common::getGet('show') === 'example_7_2' ? 'block' : 'none';
echo '<a name="join_7"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_7b', array($url_7_1, $hidden_7_1, $code_7_1, $url_7_2, $hidden_7_2, $code_7_2)), '7) '.$l->lang('join_7t'));

echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo '</div></div>'.PHP_EOL;
?>
