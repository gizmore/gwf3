<?php
$l = $tVars['join'];
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo '</div></div>'.PHP_EOL;

$url_api = htmlspecialchars(GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Box::box($l->lang('join_0_b', array($url_api)), $l->lang('join_0_t'));
echo GWF_Box::box($l->lang('join_1_b'), $l->lang('join_1_t'));
echo GWF_Box::box($l->lang('join_2_b'), $l->lang('join_2_t'));

echo '<h2>'.$l->lang('join_summary').'</h2>'.PHP_EOL;

$url_1_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=join&amp;show=example_1_1';
$hidden_1_1 = Common::getGet('show') === 'example_1_1' ? 'block' : 'none';

$url_2_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=join&amp;show=example_2_1';
$hidden_2_1 = Common::getGet('show') === 'example_2_1' ? 'block' : 'none';

echo '<a name="join_1"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_1b', array($url_1_1, $hidden_1_1)), '1) '.$l->lang('join_1t'));
echo '<a name="join_2"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_2b', array($url_2_1, $hidden_2_1)), '2) '.$l->lang('join_2t'));
echo '<a name="join_3"></a>'.PHP_EOL;
echo GWF_Box::box($l->lang('join_3b'),  '3) '.$l->lang('join_3t'));

echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo '</div></div>'.PHP_EOL;
?>
