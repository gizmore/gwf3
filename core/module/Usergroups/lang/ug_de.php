<?php
$lang = array(

	'alt_flag' => '%1%',

	# Page Info
	'pi_invited' => 'Sie in die %1% Benutzergruppe eingeladen.  d to <a href="%3%">join %1%s usergroup &quot;%2%&quot;</a>.<br/><br/><br/>Or <a href="%4%">click here to refuse the request</a>.',

	# Avatar Gallery
	'pt_avatars' => 'Benutzerbilder.',
	'pi_avatars' => 'Die '.GWF_SITENAME.' Avatar Gallerie.',
	'mt_avatars' => GWF_SITENAME.', Avatar, Gallerie, Benutzerbilder',
	'md_avatars' => 'Die Benutzerbildgalerie auf '.GWF_SITENAME,

	# Table Headers 
	'th_name' => 'Gruppe',
	'th_join' => 'Wie tritt man bei',
	'th_view' => 'Sichtbarkeit',
	'th_user_name' => 'Benutzer',
	'th_user_level' => 'Level ',
	'th_user_email' => 'EMail ',
	'th_user_regdate' => 'Registriert am',
	'th_user_birthdate' => 'Geburtstag',
	'th_user_lastactivity' => 'Letzte Aktivität',
	'th_group_name' => 'Gruppenname',
	'th_group_memberc' => 'Mitglieder',
	'th_group_founder' => 'Gründer',

	# Form Titles
	'ft_edit' => 'Bearbeiten',
	'ft_create' => 'Neue Gruppe erzeugen',
	'ft_invite' => 'Jemanden in die Gruppe einladen',

	# Buttons
	'btn_kick' => 'Rausschmeissen',
	'btn_edit' => 'Bearbeiten',
	'btn_delete' => 'Gruppe Entfernen',
	'btn_create' => 'Gruppe Erzeugen',
	'btn_invite' => 'Benutzer Einladen',
	'btn_accept' => 'Einladung Annehmen',
	'btn_gallery' => 'Avatar Gallerie',
	'btn_search' => 'Benutzer Suchen',
	'btn_part' => 'Gruppe Verlassen',
	'btn_add_group' => 'Gruppe Erzeugen',

	# Errors
	'err_perm' => 'Sie dürfen keine neue Gruppe erzeugen.',
	'err_join' => 'Die Einstellung für \'Gruppe Beitreten\' ist ungültig.',
	'err_view' => 'Die Sichtbarkeits-Einstellungen sind ungültig.',
	'err_name' => 'Der Gruppenname ist ungültig. Dieser muss zwischen %1%-%2% Zeichen lang sein, und mit einem Buchstaben beginnen.',
	'err_group_exists' => 'Sie haben bereits zu viele Gruppen gegründet.',
	'err_group' => 'Sie haben noch keine Benutzergruppe gegründet.',
	'err_kick_leader' => 'Sie können den Gründer nicht aus der Gruppe entfernen.',
	'err_kick' => 'Der Benutzer %1% ist nicht in dieser Gruppe.',
	'err_unk_group' => 'Diese Gruppe ist unbekannt.',
	'err_no_join' => 'Sie können dieser Gruppe nicht von selbst beitreten',
	'err_join_twice' => 'Sie sind bereits in dieser Gruppe.',
	'err_request_twice' => 'Sie haben bereits angefragt dieser Gruppe beizutreten.',
	'err_not_invited' => 'Sie wurden nicht in diese Gruppe eingeladen.',

	# Messages
	'msg_created' => 'Ihre Benutzergruppe wurde erstellt.',
	'msg_edited' => 'Die Gruppe wurde erfolgreich bearbeitet.',
	'msg_kicked' => '%1% wurde aus der Gruppe ausgeschlossen.',
	'msg_joined' => 'Sie sind der &quot;%1%&quot; Gruppe beigetreten.',
	'msg_requested' => 'Sie haben angefragt der Gruppe &quot;%1%&quot; beizutreten.',
	'msg_accepted' => 'Der Benutzer %1% ist nun Mitglied der Gruppe &quot;%2%&quot;.',
	'msg_invited' => 'Sie haben %1% in die Gruppe eingeladen.',
	'msg_refused' => 'Sie haben die Einladung in die Gruppe &quot;%1%&quot; abgelehnt.',

	# Selects
	'sel_join_type' => 'Wie können neue Benutzer beitreten?',
	'sel_join_1' => 'Die Gruppe ist voll',
	'sel_join_2' => 'Durch eine Einladung',
	'sel_join_4' => 'Durch Moderation',
	'sel_join_8' => 'Klicken und \'Einfach Beitreten\'',
	'sel_join_16' => 'Durch ein Skript',
	'sel_view_type' => 'Sichtbarkeit der Gruppe',
	'sel_view_'.(0x100) => 'Öffentliches Forum',
	'sel_view_'.(0x200) => 'Nur Mitglieder von '.GWF_SITENAME,
	'sel_view_'.(0x400) => 'Nur Mitglieder der Gruppe',
	'sel_view_'.(0x800) => 'Nur Skripte',

	# Admin
	'cfg_ug_level' => 'Benötigter Level zum erzeugen einer Gruppe',
	'cfg_ug_maxlen' => 'Max.Länge eines Gruppennamens',
	'cfg_ug_minlen' => 'Min.Länge eines Gruppennamens',
//	'cfg_ug_bid' => 'Parent Board for Usergroup',

	# EMails
	'mail_subj_req' => GWF_SITENAME.': %1% möchte der Gruppe %2% beitreten',
	'mail_body_req' =>
		'Hallo %1%,'.PHP_EOL.
		PHP_EOL.
		'Der Benutzer %2% möchte der Gruppe, &quot;%3%&quot; beitreten.'.PHP_EOL.
		'Um den Benutzer aufzunehmen, rufen sie bitte den folgenden Link auf:'.PHP_EOL.
		PHP_EOL.
		'%4%',
		
		
	# V2.01 finish + your groups
	'cfg_ug_menu' => 'Im Menü Anzeigen',
	'cfg_ug_submenu' => 'Im Untermenü Anzeigen',
	'cfg_ug_ax' => 'Anzahl Bilder in der Galerie (X)',	
	'cfg_ug_ay' => 'Anzahl Bilder in der Galerie (Y)',	
	'cfg_ug_grp_per_usr' => 'Maximale Anzahl Gruppen pro User',	
	'cfg_ug_ipp' => 'Zeilen pro Seite',	
	'cfg_ug_lvl_per_grp' => 'Level pro Gruppe',
	'cfg_ug_submenugroup' => 'Name des Subemenüs',

	# V2.02 finish2
	'btn_groups' => 'Gruppen',
		
	# V2.03 finish3
	'btn_users' => 'Benutzer',
		
	# v2.04
	'invite_title' => 'Einladung in die Gruppe %1%',
	'invite_message' =>
		'Hallo %1%,'.PHP_EOL.
		PHP_EOL.
		'%2% hat Dich eingeladen der Gruppe \'%3%\' beizutreten.'.PHP_EOL.
		'Um dieser Gruppe beizutreten, rufe bitte folgende Seite auf: %4%'.PHP_EOL.
		PHP_EOL.
		'Falls Du nicht dieser Gruppe beitreten möchtest, ignoriere diese Nachricht, oder rufe diese Seite auf: %5%',
		
	# v2.05 (Jinx Edition)
	'err_not_in_group' => 'Der Benutzer %1% ist nicht in dieser Gruppe.',
	'btn_unco' => 'Co-Leader ',
	'btn_co' => 'Kein Co-Leader',
	'btn_unhide' => 'Versteckt',
	'btn_hide' => 'Angezeigt',
	'btn_unmod' => 'Moderator ',
	'btn_mod' => 'Kein Moderator',
	'msg_ugf_2_0' => 'Das Mitglied %1% ist kein Co-Leader mehr.',
	'msg_ugf_2_1' => 'Das Mitglied %1% ist nun Co-Leader mehr.',
	'msg_ugf_4_0' => 'Das Mitglied %1% ist kein Moderator mehr.',
	'msg_ugf_4_1' => 'Das Mitglied %1% ist nun Moderator mehr.',
	'msg_ugf_8_0' => 'Der Benutzer %1% ist nun als Mitglied aufgezeigt.',
	'msg_ugf_8_1' => 'Der Benutzer %1% ist nun ein verstecktes Mitglied.',
	'th_vis_grp' => 'Gruppe immer in der Liste sichtbar',
	'th_vis_mem' => 'Mitlglieder immer sichtbar',
	'tt_vis_grp' => 'Falls diese Einstellung aktiviert ist, ist diese Gruppe immer in der Gruppenliste sichtbar.',
	'tt_vis_mem' => 'Falls diese Einstellung aktiviert ist, ist die Mitgliederliste für alle sichtbar.',
		
	# v2.06 (delete usergroup BAAL)
	'ft_del_group' => 'Do you really want to delete the usergroup %1%?',
	'th_del_groupname' => 'Retype groupname',
	'tt_del_groupname' => 'Please type the name of the group to confirm.',
	'btn_del_group' => 'Yes, I want to delete the usergroup %1%!',
	'msg_del_group' => 'The usergroup %1% has been deleted. %3% permissions have been revoked.',
		
	# v2.07 (Adv Search)
	'btn_adv_search' => 'Advanced Search',
	'ft_search_adv' => 'Advanced Usersearch',
	'th_country' => 'Country',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo',
	'th_aim' => 'AIM',
	'th_language' => 'Language',			
	'th_hasmail' => 'EMail',
	'th_haswww' => 'Website',
	'th_gender' => 'Gender',
	'err_minlevel' => 'Your specified minimum level is invalid.',
);
?>