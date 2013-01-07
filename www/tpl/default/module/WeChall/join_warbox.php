<?php
$l = $tVars['join'];
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($l->lang('btn_join'), GWF_WEB_ROOT.'join_us');
echo GWF_Button::generic($l->lang('btn_join_war'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox', 'generic', '', true);
echo GWF_Button::generic($l->lang('btn_join_opt'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=optional');
echo GWF_Button::generic($l->lang('btn_api'), GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=wechall_api');
echo '</div></div>'.PHP_EOL;

echo GWF_Box::box($l->lang('war_1b'), $l->lang('war_1t'));

$box = "";
$box .= $l->lang('war_2b')."\n<br/>\n";
foreach ($l->lang('war_2b_os') as $os => $code)
{
	$box .= $os."<br/>\n";
	$box .= $code."\n";
}
$box .= "<br/>\n";
echo GWF_Box::box($box, $l->lang('war_2t'));

echo GWF_Box::box($l->lang('war_3b'), $l->lang('war_3t'));

#echo GWF_Box::box($l->lang('war_4b'), $l->lang('war_4t'));

?>
