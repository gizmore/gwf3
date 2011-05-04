<?php
$gb = $tVars['gb'];
$m = $tVars['module'];
$can_sign = $gb->canSign(GWF_Session::getUser(), $m->cfgAllowGuest());
$allow_url = $m->cfgAllowURL();
$allow_email = $m->cfgAllowEMail();

$btn_edit = $tVars['can_moderate'] ? GWF_Button::options($tVars['href_moderate'], $tLang->lang('btn_edit_gb')) : '';

echo '<h1>'.$btn_edit.$gb->displayTitle().'</h1>';
echo '<h2>'.$gb->displayDescr().'</h2>';

echo $tVars['page_menu'];

foreach ($tVars['entries'] as $e)
{
	include '_entry.php';
}

echo $tVars['page_menu'];

if ($can_sign) {
	echo '<div class="gwf_buttons_outer gwf_buttons">'.PHP_EOL;
	echo GWF_Button::reply($tVars['href_sign'], $tLang->lang('btn_sign', array( $gb->displayTitle())));
	echo '</div>'.PHP_EOL;
}