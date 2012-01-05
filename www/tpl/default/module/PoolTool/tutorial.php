<?php
printf('<h1>%s</h1>', $tLang->lang('pt_tut'));
$i = 1;
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));

printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/start_playray.jpg', $tLang->lang('start_pr'), $tLang->lang('start_pr'));
echo '<hr/>';
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/start_pooltool.jpg', $tLang->lang('start_pt'), $tLang->lang('start_pt'));
echo '<hr/>';
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/load_table.jpg', $tLang->lang('load_table'), $tLang->lang('load_table'));
echo '<hr/>';
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/select_ball.jpg', $tLang->lang('select_ball'), $tLang->lang('select_ball'));
echo '<hr/>';
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/select_pocket.jpg', $tLang->lang('select_pocket'), $tLang->lang('select_pocket'));
echo '<hr/>';
printf('<p>%s</p>', $tLang->lang('tut_'.$i++));
printf('<p><img src="%s" alt="%s" title="%s"/></p>', GWF_WEB_ROOT.'tpl/pt/img/tut/aim_or_shoot.jpg', $tLang->lang('aim_or_shoot'), $tLang->lang('aim_or_shoot'));

?>
