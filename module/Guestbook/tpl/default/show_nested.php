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
	$e instanceof GWF_GuestbookMSG;
	gwfGBNested($e, $allow_email, $allow_url, $can_sign, $gb, $tLang, $tVars, $m);
}

echo $tVars['page_menu'];

if ($can_sign) {
	echo GWF_Button::reply($tVars['href_sign'], $tLang->lang('btn_sign', array( $gb->displayTitle())));
}


function gwfGBNested(GWF_GuestbookMSG &$e, &$allow_email, &$allow_url, &$can_sign, &$gb, &$tLang, &$tVars, &$m)
{
//	echo '<div class="gwf_gbe_nested" style="border: 1px solid black; margin: 10px; padding: 10px;" >';
	
	echo '<div class="gwf_gb_entry gwf_gb_entry_nested">'.PHP_EOL;
	
	echo '<div class="gwf_gbe_head">'.PHP_EOL;
		echo sprintf('<div class="gwf_date">%s</div>', $e->displayDate()).PHP_EOL;
		echo sprintf('<div>%s</div>', $e->displayUsernameLink()).PHP_EOL;
		if ($allow_email) { echo sprintf('<div>%s</div>', $e->displayEMail($tVars['can_moderate'])).PHP_EOL; }
		if ($allow_url) { echo sprintf('<div>%s</div>', $e->displayURL()).PHP_EOL; }
	echo '</div>'.PHP_EOL;
	
//	echo '<div>';
//	echo sprintf('<div class="gwf_date">%s</div>', $e->displayDate());
//	echo sprintf('<div>%s</div>', $e->displayUsername());
//	if ($allow_email) { echo sprintf('<div>%s</div>', $e->displayEMail()); }
//	if ($allow_url) { echo sprintf('<div>%s</div>', $e->displayURL()); }
//	echo '</div>';
	
	echo sprintf('<div class="gwf_gbe_msg">%s', $e->displayMessage()).PHP_EOL;
//	echo sprintf('<hr/><div>%s</div>', $e->displayMessage());
	if ($can_sign) {
//		echo '<hr/>';
		echo '<div class="gwf_buttons_outer gwf_buttons">'.PHP_EOL;
		echo GWF_Button::quote(GWF_WEB_ROOT.'guestbook/sign/'.$gb->getID().'/in/reply/to/'.$e->getID(), $tLang->lang('btn_replyto', array( $e->displayUsername())));
		echo '</div>'.PHP_EOL;
	}
	if ($tVars['can_moderate'])
	{
//		echo '<hr/>';
		echo '<div class="gwf_buttons_outer gwf_buttons">';
			echo $e->getToggleModButton($m);
			echo $e->getTogglePublicButton($m);
			echo $e->getEditButton($m);
		echo '</div>';
	}
	
	foreach ($e->getVar('childs', array()) as $child)
	{
		gwfGBNested($child, $allow_email, $allow_url, $can_sign, $gb, $tLang, $tVars, $m);
	}

	echo '</div>'.PHP_EOL;
	echo '</div>'.PHP_EOL;
}
?>