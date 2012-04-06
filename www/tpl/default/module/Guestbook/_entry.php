<?php
echo '<div class="gwf_gb_entry">';
	
	echo '<div class="gwf_gbe_head">'.PHP_EOL;
		echo sprintf('<div class="gwf_date">%s</div>', $e->displayDate()).PHP_EOL;
		echo sprintf('<div>%s</div>', $e->displayUsernameLink()).PHP_EOL;
		if ($allow_email) { echo sprintf('<div>%s</div>', $e->displayEMail($tVars['can_moderate'])).PHP_EOL; }
		if ($allow_url) { echo sprintf('<div>%s</div>', $e->displayURL()).PHP_EOL; }
	echo '</div>'.PHP_EOL;

	echo sprintf('<div class="gwf_gbe_msg">%s</div>', $e->displayMessage()).PHP_EOL;
	
	if ($tVars['can_moderate'])
	{
		echo '<div class="gwf_gbe_foot">'.PHP_EOL;
		echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
		echo $e->getToggleModButton($m);
		echo $e->getTogglePublicButton($m);
		echo $e->getEditButton($m);
		echo '</div></div>'.PHP_EOL;
		echo '</div>'.PHP_EOL;
	}

echo '</div>'.PHP_EOL; # gb_entry
?>