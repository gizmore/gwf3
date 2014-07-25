<?php
$l = $tVars['join'];
echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Button::wrapEnd();

$url_api = htmlspecialchars(GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Box::box($l->lang('join_0_b', array($url_api)), $l->lang('join_0_t'));
echo GWF_Box::box($l->lang('join_1_b'), $l->lang('join_1_t'));
echo GWF_Box::box($l->lang('join_2_b'), $l->lang('join_2_t'));

echo '<h2>'.$l->lang('join_summary').'</h2>'.PHP_EOL;

$url_1_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=join&amp;show=example_1_1';
$hidden_1_1 = Common::getGet('show') === 'example_1_1' ? 'block' : 'none';

$url_2_1 = GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=join&amp;show=example_2_1';
$hidden_2_1 = Common::getGet('show') === 'example_2_1' ? 'block' : 'none';

echo GWF_Box::box($l->lang('join_1b', array($url_1_1, $hidden_1_1)), '1) <a name="join_1" href="#join_1">'.$l->lang('join_1t').'</a>');
echo GWF_Box::box($l->lang('join_2b', array($url_2_1, $hidden_2_1)), '2) <a name="join_2" href="#join_2">'.$l->lang('join_2t').'</a>');
echo GWF_Box::box($l->lang('join_3b'),  '3) <a name="join_3" href="#join_3">'.$l->lang('join_3t').'</a>');
echo GWF_Box::box($l->lang('join_4b'),  '4) <a name="join_4" href="#join_4">'.$l->lang('join_4t').'</a>');
echo GWF_Box::box($l->lang('join_process_b', array(GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional')),  '4) <a name="joining_process" href="#joining_process" title="WeChall Joining Process">'.$l->lang('join_process_t').'</a>');

echo GWF_Button::wrapStart();
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox');
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo GWF_Button::wrapEnd();
