<?php
$lang = array(
	# Messages
	'msg_news_added' => 'Uutiset lisätty onnistuneesti.',
	'msg_translated' => 'Käänsit uutiset kielestä \'%s\' -> %s. Hyvää työtä.',
	'msg_edited' => 'Uutiset \'%s\' sisällä %s on muokattu onnistuneesti.',
	'msg_hidden_1' => 'Uutiset piiloitettu.',
	'msg_hidden_0' => 'Uutiset näkyvissä.',
	'msg_mailme_1' => 'Uutiset siirretty postiin.',
	'msg_mailme_0' => 'Uutiset poistettu postista.',
	'msg_signed' => 'Allekirjoitit uutiskirjeen.',
	'msg_unsigned' => 'Et allekirjoittanut uutiskirjettä.',
	'msg_changed_type' => 'Muutit uutiskirjeen muotoa.',
	'msg_changed_lang' => 'Vaihdoit uutiskirjeen kielen.',

	# Errors
	'err_email' => 'Sähköposti ei ole oikea.',
	'err_news' => 'Uutiset epätiedossa.',
	'err_title_too_short' => 'Otsikko on liian lyhyt.',
	'err_msg_too_short' => 'Viestisi on liian lyhyt.',
	'err_langtrans' => 'Kieltä ei löydy tietokannasta.',
	'err_lang_src' => 'Koodin kieltä ei löydy tietokannasta.',
	'err_lang_dest' => 'Kieltä ei löydy tietokannasta.',
	'err_equal_translang' => 'The source and destination language are equal (Both %s).',
	'err_type' => 'Uutiskirjeen formaatti on väärä.',
	'err_unsign' => 'Virhe.',


	# Main
	'title' => 'Uutiset',
	'pt_news' => 'Uutiset %s',
	'mt_news' => 'Uutiset, '.GWF_SITENAME.', %s',
	'md_news' => GWF_SITENAME.' Uutiset, sivu %s / %s.',

	# Table Headers
	'th_email' => 'Sähköpostiosoitteesi',
	'th_type' => 'Uutiskirjeen formaatti',
	'th_langid' => 'Uutiskirjeen kieli',
	'th_category' => 'Kategoria',
	'th_title' => 'Otsikko',
	'th_message' => 'Viesti',
	'th_date' => 'Päivä',
	'th_userid' => 'Käyttäjä',
	'th_catid' => 'Kategoria',
	'th_newsletter' => 'Lähetä uutiskirje<br/>Tarkista ja esikatsele!',

	# Esikatselu	'btn_preview_text' => 'Tekstiversio',
	'btn_preview_html' => 'HTML-versio',
	'preview_info' => 'Voit katsella uutiskirjeen esikatselua täällä:<br/>%s ja %s.',

	# Show 
	'unknown_user' => 'Tuntematon käyttäjä',
	'title_no_news' => '----',
	'msg_no_news' => 'Ei uutisia tässä kategoriassa.',

	# Uutiskirje
	'newsletter_title' => GWF_SITENAME.': Uutiset',
	'anrede' => 'Arvoisa %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Kirjauidut sisään sivulle '.GWF_SITENAME.' uutiskirjeeseen ja tässä muutama tuore uutinen.'.PHP_EOL.
		'Jos haluat erota uutiskirjeesta klikkaa:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'Uutiset on arkistoitu näin:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Valitse formaatti',
	'type_text' => 'Normaali tekstit',
	'type_html' => 'Normaali HTML',
		
	# Sign
	'sign_title' => 'Liity uutiskirjeeseen',
	'sign_info_login' => 'Et ole kirjautunut sisään, joten emme tiedä oletko kirjautunut uutiskirjeeseen.',
	'sign_info_none' => 'Et ole liittynyt uutiskirjeen tilaajaksi.',
	'sign_info_html' => 'Olet jo kirjautunut uutiskirjeen HTMl-formaattiin.',
	'sign_info_text' => 'Olet jo kirjautunut uutiskirjeeseen normaalilla tekstillä.',
	'ft_sign' => 'Liity uutiskirjeeseen',
	'btn_sign' => 'Liity uutiskirjeeseen',
	'btn_unsign' => 'Eroa uutiskirjeestä',
		
	# Edit
	'ft_edit' => 'Muokkaa uutisia (-> %s)',
	'btn_edit' => 'Muokkaa',
	'btn_translate' => 'Käännä',
	'th_transid' => 'Käännös',
	'th_mail_me' => 'Lähetä tämä uutiskirjeenä',
	'th_hidden' => 'Piiloitettu?',

	# Lisää
	'ft_add' => 'Lisää uutinen',
	'btn_add' => 'Lisää uutinen',
	'btn_preview' => 'Esikatsele (Ensin!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Salli vieraiden liittyä uutiskirjeeseen',
	'cfg_news_per_adminpage' => 'Uutisia per ylläpitäjän sivu',
	'cfg_news_per_box' => 'Uutisia per sisältösivu',
	'cfg_news_per_page' => 'Uutisia per sivu',
	'cfg_newsletter_mail' => 'Uutiskirjeen lähettäjä',
	'cfg_newsletter_sleep' => 'Odota hetki ennen seuraavaa kirjettä',
	'cfg_news_per_feed' => 'Uutisia per tilaussivu',
	
	# RSS2 Feed
	'rss_title' => GWF_SITENAME.' Tilaa uutiset',
		
	# V2.03 (Uutiset + Foorumi)
	'cfg_news_in_forum' => 'Lähetä uutisia foorumille',
	'board_lang_descr' => 'Uutisia -> %s',
	'btn_admin_section' => 'Ylläpitäjän sivu',
	'th_hidden' => 'Piiloitettu',
	'th_visible' => 'Näkyvissä',
	'btn_forum' => 'Juttele foorumilla',
);
?>
