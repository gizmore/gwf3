<?php
$lang = array(
	# Box
	'box_title' => GWF_SITENAME.' Huutoloota',

	# History
	'pt_history' => GWF_SITENAME.' Huutoloodan historia (Sivu %1% / %2%)',
	'pi_history' => ' '.GWF_SITENAME.' Huutoloota',
	'mt_history' => GWF_SITENAME.', Huutoloota, Historia',
	'md_history' => ''.GWF_SITENAME.' huutoloota on pienille viesteille mitkä eivät tarvitse foorumilla omaa aihetta.',

	# Virheet
	'err_flood_time' => 'Odota %1% ennen kuin huudat uudestaan.',
	'err_flood_limit' => 'Olet ylittänyt rajasi %1% viestiä päivässä.',
	'err_message' => 'Viestisi täytyy olla %1%:stä %2%:een merkkiä pitkä.',
	
	# Viestit
	'msg_shouted' => 'Huuto lähetetty.<br/>Go back to <a href="%1%">%1%</a>.',
	'msg_deleted' => 'Viesti poistettu.',

	# Pöydän päät
	'th_shout_date' => 'Päivä',
	'th_shout_uname' => 'Käyttäjä',
	'th_shout_message' => 'Viesti',

	# Napit
	'btn_delete' => 'Poista',
	'btn_shout' => 'Huuda!',

	# Ylläpitäjän muokkaukset
	'cfg_sb_guests' => 'Hyväksy vieraiden huudot',	
	'cfg_sb_ipp' => 'Huutoja historiassa',
	'cfg_sb_ippbox' => 'Huutoja loodassa',
	'cfg_sb_maxlen' => 'Max. merkkiä pitkä',
	'cfg_sb_maxdayg' => 'Max viestiä päivässä vierailla',
	'cfg_sb_maxdayu' => 'Max viestiä päivässä jäsenillä',
	'cfg_sb_timeout' => 'Aikaväli 2 viestillä',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'EMail moderation',
	'emod_subj' => GWF_SITENAME.': New shoutbox entry',
	'emod_body' =>
		'Dear staff,'.PHP_EOL.
		''.PHP_EOL.
		'There is a new entry in the shoutbox.'.PHP_EOL.
		''.PHP_EOL.
		'From: %1%'.PHP_EOL.
		'%2%'.PHP_EOL.
		''.PHP_EOL.
		'You can delete it via %3%'.PHP_EOL.
		''.PHP_EOL.
		'Regards'.PHP_EOL.
		'The GWF3 script',
);
?>