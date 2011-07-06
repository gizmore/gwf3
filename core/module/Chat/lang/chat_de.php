<?php

$lang = array(
	# page.php
	'pt_chat' => 'Chat ',
	'pi_chat' => 'Willkommen zum '.GWF_SITENAME.' Chat.',
	'ft_chat' => 'Nachricht senden',
	'mt_chat' => GWF_SITENAME.', Echtzeit, Web, Chat, Firefox, Ajax, BSD',
	'md_chat' => GWF_SITENAME.'. Ajax basierter echtzeit chat. unlizensiert / BSD lizens.',

	# history.php
	'pt_history' => 'Chat Logbuch',
	'pi_history' => GWF_SITENAME.' Chat Log',
	'mt_history' => GWF_SITENAME.', Chat, Javascript, Echtzeit, HTTP push, Firefox, Netscape, HTTP, Ajax, Chat',
	'md_history' => GWF_SITENAME.' Chat Logbuch, aka Chat History',
	
	# Buttons
	'btn_history' => 'Chat Logbuch',

	# Errors
	'err_msg_short' => 'Sie haben ihre Nachricht vergessen.',
	'err_msg_long' => 'Ihre Nachricht ist zu lang. Maximal sind %1% Zeichen erlaubt.',
	'err_private' => 'Private Nachrichten sind zur zeit deaktiviert.',
	'err_guest_public' => 'Gäste dürfen nicht öffentliche Nachrichten senden.',
	'err_guest_private' => 'Gäste dürfen keine privaten Nachrichten senden.',
	'err_target' => 'Unbekannter Empfänger. Lassen sie dieses Feld frei für den öffentlichen Kanal.',
	'err_target_invalid' => 'Ungültiges Ziel. Sie dürfen sich selbst keine Nachrichten senden.',
	'err_nick_syntax' => 'Ihr Spitzname ist ungültig. Bitte erst a-z dann a-z09_.', # we could be more verbose
	'err_nick_taken' => 'Ihr Spitzname ist bereits vergeben.',
	'err_nick_tamper' => 'Bitte nicht den Spitznamen ändern, Betrugsversuch wurde aufgezeichnet!'.'<br/>msg_log_imp', # <-- scareware
	
	# Messages
	'msg_posted' => 'Ihre Nachricht wurde gesendet.',

	# Table Headers
	'th_yournick' => 'Spitzname',
	'th_message' => 'Nachricht',
	'th_target' => 'Empfänger',

	# Tooltips
	'tt_target' => 'Frei-lassen für den öffentlichen Kanal.',

	'btn_post' => 'Absenden',

	# v2.01 (Mibbit+finish)
	'cfg_bbcode' => 'BBCode erlauben?',
	'cfg_chat_menu' => 'Im Hauptmenu anzeigen?',
	'cfg_chat_submenu' => 'Im Untermenu anzeigen?',
	'cfg_guest_private' => 'Private Nachrichten für Gäste erlauben?',
	'cfg_guest_public' => 'Öffentliche Nachrichten für Gäste erlauben?',
	'cfg_mibbit' => 'Mibbit Ajax chat benutzen?',
	'cfg_private' => 'Private Nachrichten erlauben?',
	'cfg_chanmsg_per_page' => 'Öffentliche Nachrichten Pro Tag/User',
	'cfg_histmsg_per_page' => 'Nachrichten pro History Seite',
	'cfg_msg_len' => 'Maximale Länge einer Nachricht',
	'cfg_privmsg_per_page' => 'Private Nachrichten pro Seite',
	'cfg_mibbit_channel' => 'Mibbit Kanal',
	'cfg_mibbit_server' => 'Mibbit Server',
	'cfg_chat_lag_ping' => 'Seite nach N Zeit neu laden (pull mode)',
	'cfg_message_peak' => 'Nachricht veschwindet nach (Zeit)',
	'cfg_online_time' => 'Online Zeit',

	'btn_webchat' => 'Web Chat',
	'btn_ircchat' => 'IRC Chat',
	'btn_ircchat_full' => 'IRC Vollbild',
	'pt_irc_chat' => 'IRC Chat ',
	'pi_irc_chat' => 'IRC WebChat, unterstützt von <a href="%1%">Mibbit</a>.',
	'mt_irc_chat' => GWF_SITENAME.',IRC,Chat,WebChat,Mibbit,Vollbild',
	'md_irc_chat' => 'Chatten mit '.GWF_SITENAME.' Benutzern und Besuchern.',
	'err_iframe' => 'Ihr Browser unterstützt keine iframes.',

	# v2.02 (fixes)
	'cfg_gwf_chat' => 'GWF Webchat verwenden',

	# v2.03 (Mibbit SSL)
	'cfg_mibbit_ssl' => 'SSL im Mibbit IRC Chat benutzen',
	'cfg_mibbit_port' => 'Port für den Mibbit IRC Chat',
);

?>