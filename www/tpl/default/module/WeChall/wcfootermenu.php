<?php
$module = $tVars['module'];
echo
'<nav id="gwf_foot_menu">'.PHP_EOL.
'<a href="'.GWF_WEB_ROOT.'news">'.$module->lang('menu_news').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'changes.txt">'.$module->lang('menu_changes').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'about_wechall">'.$module->lang('menu_about').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'join_us">'.$module->lang('menu_join').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'links">'.$module->lang('menu_links').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'active_sites">'.$module->lang('menu_sites').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'forum">'.$module->lang('menu_forum').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'ranking">'.$module->lang('menu_ranking').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'challs">'.$module->lang('menu_challs').'</a>'.PHP_EOL.
// 			'| <a href="'.GWF_WEB_ROOT.'register">'.$module->lang('menu_register').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'irc_chat">'.$module->lang('menu_chat').'</a>'.PHP_EOL.
'| <a href="'.GWF_WEB_ROOT.'contact">'.$module->lang('menu_contact').'</a>'.PHP_EOL.
'</nav>'.PHP_EOL;

?>