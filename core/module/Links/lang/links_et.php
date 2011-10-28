<?php

$lang = array(
	# Admin Config
	'cfg_link_guests' => 'Luba külalistel lisada linke?',
	'cfg_link_guests_captcha' => 'Näita Captchat külalistele?',
	'cfg_link_guests_mod' => 'Modereeri külaliste linke?',
	'cfg_link_guests_votes' => 'Luba külalistel hääletada?',
	'cfg_link_long_descr' => 'Kasuta teist/pikemat kirjeldust?',
	'cfg_link_cost' => 'Skoor lingi kohta',
	'cfg_link_max_descr2_len' => 'Maksimum pikkusega Pikk kirjeldus.',
	'cfg_link_max_descr_len' => 'Maksimum pikkusega Väike kirjeldus.',
	'cfg_link_max_tag_len' => 'Maksimum märksõna pikkus',
	'cfg_link_max_url_len' => 'Maksimum URLi pikkus',
	'cfg_link_min_descr2_len' => 'Miinimum Pika kirjelduse pikkus',
	'cfg_link_min_descr_len' => 'Miinimum Väikse kirjelduse pikkus',
	'cfg_link_min_level' => 'Miinimum tase, et muuta linki',
	'cfg_link_per_page' => 'Linke lehe kohta',
	'cfg_link_tag_min_level' => 'Miinimum tase, et lisada märksõna',
	'cfg_link_vote_max' => 'Maksimum hääletusskoor',
	'cfg_link_vote_min' => 'Miinimum hääletusskoor',
	'cfg_link_guests_unread' => 'Lingi kestvus salvestub külalistele uuena',
	
	# Info`s
//	'pi_links' => '',
	'info_tag' => 'Täpsusta vähemalt ühte märksõna. Eralda märksõnad komaga. Proovi kasutada olemasolevaid märksõnu:',
	'info_newlinks' => 'Sulle on %1$s uut linki.',
	'info_search_exceed' => 'Sinu otsing ületab tulemuste limiidi %1$s.',

	# Titles
	'ft_add' => 'Lisa link',
	'ft_edit' => 'Muuda linki',
	'ft_search' => 'Otsi linke',
	'pt_links' => 'Kõik lingid',
	'pt_linksec' => '%1$s lingid',
	'pt_new_links' => 'Uued lingid',
	'mt_links' => GWF_SITENAME.', Link, List, kõik lingid',
	'md_links' => 'Kõik lingid '.GWF_SITENAME.'.',
	'mt_linksec' => GWF_SITENAME.', Link, List, Lingid %1$s kohta',
	'md_linksec' => '%1$s linke '.GWF_SITENAME.'.',

	# Errors
	'err_gid' => 'Kasutajagrupp on vigane.',
	'err_score' => 'Vigane väärtus skooril.',
	'err_no_tag' => 'Palun täpsusta vähemalt ühte märksõna.',
	'err_tag' => 'Märksõna %1$s on vigane ja eemaldatud. Märksõna peab olema %2$s - %3$s baiti.',
	'err_url' => 'URL on vigane.',
	'err_url_dup' => 'URL on juba olemas.',
	'err_url_down' => 'URLi pole võimalik avada.',
	'err_url_long' => 'Sinu URL on liiga pikk. Maksimum  %1$s baiti.',
	'err_descr1_short' => 'Sinu kirjeldus on liiga lühike. Miinimum %1$s baiti.',
	'err_descr1_long' => 'Sinu kirjeldus on liiga pikk. Maksimum %1$s baiti.',
	'err_descr2_short' => 'Sinu detailne kirjeldus on liiga lühike. Miinimum %1$s baiti.',
	'err_descr2_long' => 'Sinu detailne kirjeldus on liiga pikk. Maksimum %1$s baiti.',
	'err_link' => 'Linki ei leitud.',
	'err_add_perm' => 'Pole lubatud linki järgida.',
	'err_edit_perm' => 'Pole lubatud linki muuta.',
	'err_view_perm' => 'Pole lubatud linki vaadata.',
	'err_add_tags' => 'Pole lubatud lisada uusi märksõnu.',
	'err_score_tag' => 'Sinu kasutajatase(%1$s) ei ole piisavalt kõrge uue märksõna lisamiseks. Nõutud tase: %2$s.',
	'err_score_link' => 'Sinu kasutajatase(%1$s) ei ole piisavalt kõrge uue lingi lisamiseks. Nõutud tase: %2$s.',
	'err_approved' => 'Link oli juba heakskiidetud. Palun kasuta staff sektsiooni, et midagi muuta.',
	'err_token' => 'Vigane valik.',

	# Messages
//	'msg_redirecting' => 'Ümbersuunan sind %1$s.',
	'msg_added' => 'Sinu link on lisatud databaasi.',
	'msg_added_mod' => 'Sinu link on lisatud databaasi, aga moderaator peab selle enne üle vaatama.',
	'msg_edited' => 'Link on muudetud.',
	'msg_approved' => 'Link on heakskiidetud ja teistele näha.',
	'msg_deleted' => 'Link on eemaldatud.',
	'msg_counted_visit' => 'Sinu klikk on loetud.',
	'msg_marked_all_read' => 'Märgitud kõik uued lingid loetuks.',
	'msg_fav_no' => 'Link on eemaldatud sinu favoriitidest.',
	'msg_fav_yes' => 'Link on lisatud sinu favoriitidesse.',

	# Table Headers
	'th_link_score' => 'Skoor',
	'th_link_gid' => 'Grupp',
	'th_link_tags' => 'Märksõnad',
	'th_link_href' => 'HREF',
	'th_link_descr' => 'Kirjeldus',
	'th_link_descr2' => 'Detailne kirjeldus',
	'th_link_options&1' => 'Kleepekas?',
	'th_link_options&2' => 'Modereeritud?',
	'th_link_options&4' => 'Ära näita kasutajanime?',
	'th_link_options&8' => 'Näita ainult liikmetele?',
	'th_link_options&16' => 'On see link privaatne?',
	'th_link_id' => 'ID',
	'th_showtext' => 'Link',
	'th_favs' => 'Favcount',
	'th_link_clicks' => 'Visiidid',
	'th_vs_avg' => 'Avg',
	'th_vs_sum' => 'Sum',
	'th_vs_count' => 'Hääled',
	'th_vote' => 'Hääl',
	'th_link_date' => 'Sisesta kuupäev',
	'th_user_name' => 'Kasutajanimi',

	# Tooltips
	'tt_link_gid' => 'Piira linki kasutajagruppidele (või jäta tühjaks)',
	'tt_link_score' => 'Täpsusta miinimum kasutajate taset (0-NNNN)',
	'tt_link_href' => 'Esita täispikk URL, alustades http://',

	# Buttons
	'btn_add' => 'Lisa link',
	'btn_delete' => 'Kustuta link',
	'btn_edit' => 'Muuda linki',
	'btn_search' => 'Otsi',
	'btn_preview' => 'Eelvaade',
	'btn_new_links' => 'Uued lingid',
	'btn_mark_read' => 'Märgi kõik loetuks',
	'btn_favorite' => 'Märgi favoriitidesse',
	'btn_un_favorite' => 'Eemalda favoriitidest',
	'btn_search_adv' => 'Täpsem otsing',

	# Staff EMail
	'mail_subj' => GWF_SITENAME.': Uus Link',
	'mail_body' =>
		'Lugupeetud Staff,'.PHP_EOL.
		PHP_EOL.
		'Ühe külalise poolt, kes vajab modereerimist, on postitatud uus link:'.PHP_EOL.
		PHP_EOL.
		'Kirjeldus: %1$s'.PHP_EOL.
		'Detailne Kirjeldus.: %2$s'.PHP_EOL.
		'HREF / URL : %3$s'.PHP_EOL.
		PHP_EOL.
		'Sa võid kas: '.PHP_EOL.
		'1) Heakskiita lingi külastades %4$s'.PHP_EOL.
		'Or:'.PHP_EOL.
		'2) Tagasi võtta lingi külastades %5$s'.PHP_EOL.
		PHP_EOL.
		'Parimate soovidega,'.PHP_EOL.
		'The '.GWF_SITENAME.' Script'.PHP_EOL,
		
	# v2.01 (SEO)
	'pt_search' => 'Search links',
	'md_search' => 'Search links on the '.GWF_SITENAME.' website.',
	'mt_search' => 'Search,'.GWF_SITENAME.',Links',
		
	# v2.02 (permitted)
	'permtext_in_mod' => 'This link is in moderation',
	'permtext_score' => 'You need a userlevel of %1$s to see this link',
	'permtext_member' => 'This link is only for members',
	'permtext_group' => 'You need to be in the %1$s group to see this link',
	'cfg_show_permitted' => 'Show forbidden links reason?',
);

?>