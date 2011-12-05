<?php

$lang = array(
	
	# Messages
	'msg_news_added' => 'Uudised on edukalt lisatud.',
	'msg_translated' => 'Sa tõlkisid uudiste ühiku \'%s\'  %s lingiks. Tubli töö.',
	'msg_edited' => 'Uudiste ühik \'%s\'  %s sees on muudetud.',
	'msg_hidden_1' => 'Uudiste ühik on nüüd peidetud.',
	'msg_hidden_0' => 'Uudiste ühik on nüüd nähtav.',
	'msg_mailme_1' => 'Uudiste ühik on nüüd pandud meilide järjekorda.',
	'msg_mailme_0' => 'Uudiste ühik on eemaldatud meilide järjekorrast.',
	'msg_signed' => 'Liitusid uudistekirjaga.',
	'msg_unsigned' => 'Sa ei ole tellinud uudistekirja.',
	'msg_changed_type' => 'Muutsid oma uudistekirja tellimise formaati',
	'msg_changed_lang' => 'Muutsid valitud keele uudistekirja tellimises.',

	# Errors
	'err_email' => 'Su email on vigane.',
	'err_news' => 'See uudiste ühik on tundmatu.',
	'err_title_too_short' => 'Pealkiri on liiga lühike.',
	'err_msg_too_short' => 'Sõnum on liiga lühike.',
	'err_langtrans' => 'Seda keelt ei toetata.',
	'err_lang_src' => 'See keel on tundmatu.',
	'err_lang_dest' => 'Soovitud keel on tundmatu.',
	'err_equal_translang' => 'Allikas ja soovitud keel on võrdsed (Mõlemad %s).',
	'err_type' => 'Uudistelehe formaat on vigane.',
	'err_unsign' => 'Viga avastatud.',


	# Main
	'title' => 'Uudised',
//	'info' => 'Teie õnneks meie sissekanne ainult produktidele mõeldud.<br/>Üks osa meie teadmistest on teie käsutuses.<br/>Mõned artiklid on ainult registreerunutele mõeldud.',
	'pt_news' => 'Uudised %s',
	'mt_news' => 'Uudised, '.GWF_SITENAME.', %s',
	'md_news' => GWF_SITENAME.' Uudised, leht %s of %s.',

	# Table Headers
	'th_email' => 'Sinu email',
	'th_type' => 'Uudistelehe formaat',
	'th_langid' => 'Uudistelehe keel',
	'th_category' => 'Kategooria',
	'th_title' => 'Pealkiri',
	'th_message' => 'Sõnum',
	'th_date' => 'Kuupäev',
	'th_userid' => 'Kasutaja',
	'th_catid' => 'Kategooria',
	'th_newsletter' => 'Saada uudisteleht<br/>Palun vaata ja tee eelvaate(d)!',

	# Preview
	'btn_preview_text' => 'Teksti versioon',
	'btn_preview_html' => 'HTML versioon',
	'preview_info' => 'Võid näha uudistelehtede eelvaateid siit:<br/>%s and %s.',

	# Show 
	'unknown_user' => 'Tundmatu kasutaja',
	'title_no_news' => '----',
	'msg_no_news' => 'Selles kategoorias pole veel uudiseid.',

	# Newsletter
	'newsletter_title' => GWF_SITENAME.': Uudised',
	'anrede' => 'Dear %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Sa registreerisid '.GWF_SITENAME.' uudistelehele ja neil on sulle uudiseid.'.PHP_EOL.
		'Et eemaldada ennast uudistelehest külasta järgnevat linki:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'Uudiste artikkel on all:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Vali formaat',
	'type_text' => 'Lihtne tekst',
	'type_html' => 'Lihtne HTML',
		
	# Sign
	'sign_title' => 'Telli uudisteleht',
	'sign_info_login' => 'Sa ei ole sisse logitud, seega ei saa me avastada, kui sa tellisid uudistelehe.',
	'sign_info_none' => 'Sa ei ole tellinud uudistelehte.',
	'sign_info_html' => 'Sa oled juba tellinud uudistelehe lihtsas html formaadis.',
	'sign_info_text' => 'Sa juba tellisid uudistelehe plain text formaadis.',
	'ft_sign' => 'Telli uudisteleht',
	'btn_sign' => 'Telli uudisteleht',
	'btn_unsign' => 'Ära telli uudistelehte',
		
	# Edit
	'ft_edit' => 'Muuda uudiste seadeid (in %s)',
	'btn_edit' => 'Muuda',
	'btn_translate' => 'Tõlgi',
	'th_transid' => 'Tõlge',
	'th_mail_me' => 'Saada see uudistelehena',
	'th_hidden' => 'Peidetud?',

	# Add
	'ft_add' => 'Lisa uudiste ühik',
	'btn_add' => 'Lisa uudis',
	'btn_preview' => 'Eelvaade (Esimesena!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Luba uudistelehele registreerimist külalistele',
	'cfg_news_per_adminpage' => 'Uudiseid admini lehe kohta',
	'cfg_news_per_box' => 'Uudiseid inline-kasti kohta',
	'cfg_news_per_page' => 'Uudiseid uudiste lehe kohta',
	'cfg_newsletter_mail' => 'Uudistelehe meilisaatja',
	'cfg_newsletter_sleep' => 'Maga peale igat meili',
	'cfg_news_per_feed' => 'Uudiseid ette antud lehe kohta',
	
	# RSS2 Feed
	'rss_title' => GWF_SITENAME.' Ette antud uudised',
		
	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Post news in forum',
	'board_lang_descr' => 'News in %s',
	'btn_admin_section' => 'Admin section',
	'th_hidden' => 'Hidden',
	'th_visible' => 'Visible',
	'btn_forum' => 'Discuss in forum',
);

?>
