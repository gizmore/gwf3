<?php

$lang = array(

	'link_contact' => 'Kontakt',
	'link_impress' => 'Impressum',
	'link_disclaimer' => 'Disclaimer',
	'link_sitemap' => 'Sitemap',
	'link_roadmap' => 'Roadmap',
	'link_changelog' => 'Changelog',
	'link_credits' => 'Credits',
	'link_helpdesk' => 'Report Bug',
	'link_todo' => 'TODO Liste',
	'link_project' => 'Space-Framework',
	'link_bookmark' => 'Bookmark',

	###########
	## month ##
	###########
	'monthnames' => array(
		1 => 'Januar',
		2 => 'Februar',
		3 => 'M&auml;rz',
		4 => 'April',
		5 => 'Mai',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'August',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Dezember',
	),
	##########
	## days ##
	##########
	'daynames' => array(
		0 => 'Sonntag',
		1 => 'Montag',
		2 => 'Dienstag',
		3 => 'Mittwoch',
		4 => 'Donnerstag',
		5 => 'Freitag',
		6 => 'Samstag'
	),
	'days_to_weekend' => array(
		0 => "Und es ist Wochenende!!!        ",
		1 => "Noch 5 Tage bis zum Wochenende. ",
		2 => "Noch 4 Tage bis zum Wochenende. ",
		3 => "Noch 3 Tage bis zum Wochenende. ",
		4 => "Noch 2 Tage bis zum Wochenende. ",
		5 => date('G') < 13 ? "Endlich fängt das Wochenende an." : "Morgen fängt das Wochenende an! ",
		6 => "Und es ist Wochenende!!!        ",
	),
	'day' => 'Tag',
	'month' => 'Monat',
	'year' => 'Jahr',
	'hour' => 'Stunde',
	'second' => 'Sekunde',
	'minute' => 'Minute',
	'request_time' => 'Zugriffszeit',
	'space' => 'Speicher',
	'free_space' => 'Frei',
	'total_space' => 'Gesamt',
	'used_space' => 'Benutzt',
	'admin' => 'Admin',
	'mail' => 'E-Mail',
	'back' => 'Zur&uuml;ck',
	'change_language' => 'Sprache ändern',

	//SURFER INFOS
	'operating_system' => 'Betriebssystem',
	'browser' => 'Browser',
	'provider' => 'Provider',
	'referer' => 'Referer',
	'host' => 'Host',
	'hostname' => 'Hostname',
	'user_agent' => 'UserAgent',

	'country' => 'Land',
	'ip' => 'IP',
	'ipaddr' => 'IP-Adresse',
	'visitor' => 'Besucher',
	'donations' => 'Spenden',
	'server' => 'Server',
	'today' => 'Heute',
	'today_is_the' => 'Heute ist %s, der %s. %s (%s), %s.',
	'statistics' => 'Statistiken',
	'surfer_infos' => 'Surfer Infos',
	'guest' => 'Gast',
	
	'si' => array(
		'operating_system' => 'Betriebssystem: %s %s',
		'browser' => 'Browser: %s %s',
		'provider' => 'Provider: %s %s',
		'referer' => 'Referer: %s',
		'host' => 'Host: %s',
		'hostname' => 'Hostname: %s',
		'user_agent' => 'UserAgent: %s',
		'country' => 'Land: %s %s',
		'ip' => 'IP: %s',
		'ipaddr' => 'IP-Adresse: %s',
		
	),
	
	//COUNTER TODO: move to gwf counter
	'ct_vis_total' => 'Besucher gesamt: %s',
	'ct_vis_today' => 'Besucher heute: %s',
	'ct_vis_yesterday' => 'Besucher gestern: %s',
	
	'ct_online_today' => 'Online heute: %s',
	'ct_online_total' => 'Online gesamt: %s',
	'ct_online_yesterday' => 'Online gestern: %s',
	'ct_online_atm' => 'Online: %s',

	# TODO: tell a friend form in Contact?
	# contact, tell a friend
	'contactform' => 'Kontaktformular',
	'contact' => 'Kontakt',
	'tell_a_friend' => 'weiterempfehlen',
	'from_email' => 'Absender E-Mail',
	'to_email' => 'Empfänger E-mail',
	'subject' => 'Betreff',
	'message' => 'Nachricht',
	'send_copy_to_me' => 'Eine Kopie an mich senden',

	# Color switcher
	'designcolor' => 'Designfarbe: %s',
	'switch_color_of_layout' => 'Layoutfarbe wechseln',
	'red' => 'Rot',
	'green' => 'Grün',
	'blue' => 'Blau',
	'orange' => 'Orange',
	'purple' => 'lila',
	'yellow' => 'Gelb',
	'white' => 'Weiß',
	'black' => 'Schwarz',
	'brown' => 'Braun',
	'change_layout' => 'Layout ändern',

	'screen_resolution' => 'Bildschirmaufl&ouml;sung',
	'last_change' => 'Letzte Aktualisierung am %s',

	#greeting
	'good_morning' => 'Guten Morgen!',
	'good_day' => 'Guten Tag!&nbsp;&nbsp;&nbsp;',
	'good_evening' => 'Guten Abend!&nbsp;',
	'good_night' => 'Du solltest schlafen gehen!',
);

switch($h = date('G'))
{
	case ($h >= 8 && $h <= 12):
		$lang['greeting'] = $lang['good_morning'];
		break;
	case ($h >= 13 && $h <= 18):
		$lang['greeting'] = $lang['good_day'];
		break;
	case ($h >= 19 && $h <= 23):
		$lang['greeting'] = $lang['good_evening'];
		break;
	default:
		$lang['greeting'] = $lang['good_night'];
}
