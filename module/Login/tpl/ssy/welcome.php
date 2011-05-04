<?php
SSYHTML::$menuID = SSY_MENU_MAIN2; 
$text = $tVars['first_time'] ? 'welcome' : 'welcome_back';
$text = $tLang->lang($text, $tVars['username']);
echo SSYHTML::getBox($text);
?>
