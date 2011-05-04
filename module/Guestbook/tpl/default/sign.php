<?php
if (isset($tVars['in_reply'])) {
	$m = $tVars['module'];
	$allow_url = $m->cfgAllowURL();
	$allow_email = $m->cfgAllowEMail();
	
	$e = $tVars['in_reply'];
	echo '<div class="gwf_gb_entry">';
	
	echo '<div>';
		echo sprintf('<div class="gwf_date">%s</div>', $e->displayDate());
		echo sprintf('<div>%s</div>', $e->displayUsername());
		if ($allow_email) { echo sprintf('<div>%s</div>', $e->displayEMail($tVars['can_mod'])); }
		if ($allow_url) { echo sprintf('<div>%s</div>', $e->displayURL()); }
	echo '</div>';

	echo sprintf('<hr/><div>%s</div>', $e->displayMessage());

	echo '</div>'; # gb_entry
	
}

echo $tVars['form'];
?>