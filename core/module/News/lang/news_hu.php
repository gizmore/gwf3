<?php

$lang = array(
	
	# Messages
	'msg_news_added' => 'A hír-ele, sikeresen hozzá lett adva.',
	'msg_translated' => 'Lefordítottad a hírt erről a nyelvről: \'%s\' erre: %s. Szép munka.',
	'msg_edited' => 'A hír: \'%s\' itt: %s szerkesztve lett.',
	'msg_hidden_1' => 'A hír most már nem látható.',
	'msg_hidden_0' => 'A hír most már látható.',
	'msg_mailme_1' => 'A hír bekerült az e-mail küldési sorba.',
	'msg_mailme_0' => 'A hír kikerült az e-mail küldési sorból.',
	'msg_signed' => 'Előfizettél a hírfolyamra.',
	'msg_unsigned' => 'Leiratkoztál a hírfolyamról.',
	'msg_changed_type' => 'Megváltoztattad a hírlevelek formátumát.',
	'msg_changed_lang' => 'Megváltoztattad a hírlevelek nyelvét.',

	# Errors
	'err_title_too_short' => 'Túl rövid a cím.',
	'err_msg_too_short' => 'Túl rövid az üzeneted.',
	'err_email' => 'Érvénytelen e-mail cím.',
	'err_news' => 'Ez a hír ismeretlen.',
	'err_langtrans' => 'Ez a nyelv nem támogatott.',
	'err_lang_src' => 'A forrás nyelv ismeretlen.',
	'err_lang_dest' => 'A cél nyelv ismeretlen.',
	'err_equal_translang' => 'A forrás és a cél nyelv azonos (Mindkettő %s).',
	'err_type' => 'A hírfolyam formátum ismeretlen.',
	'err_unsign' => 'Hiba történt.',


	# Main
	'title' => GWF_SITENAME.' Hírek',
	'pt_news' => GWF_SITENAME.' Hírek innen: %s',
	'mt_news' => 'Hírek, '.GWF_SITENAME.', %s',
	'md_news' => 'WeChall Hírek, Oldal: %s / %s.',

	# Table Headers
	'th_email' => 'E-mail címed',
	'th_type' => 'Hírújság formája',
	'th_langid' => 'Hírújság nyelve',
	'th_category' => 'Kategória',
	'th_title' => 'Cím',
	'th_message' => 'Üzenet',
	'th_newsletter' => 'Küldj egy hírlevelet<br/>Kérlek mutass előnézetet!',
	'th_date' => 'Dátum',
	'th_userid' => 'Felhasználó',
	'th_catid' => 'Kategória',

	# Preview
	'btn_preview_text' => 'Szöveg alapú',
	'btn_preview_html' => 'HTML alapú',
	'preview_info' => 'A hírújságok előnézetét itt tudod megtekinteni:<br/>%s és %s.',

	# Show 
	'unknown_user' => 'Ismeretlen felhasználói név',
	'title_no_news' => '----',
	'msg_no_news' => 'Nincs még hír ebben a kategóriában.',

	# Newsletter
	'newsletter_title' => 'WeChall: Hírek',
	'anrede' => 'Kedves %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Feliratkoztál a hírújságra, és némi hír akad a számodra.'.PHP_EOL.
		'A leiratkozáshoz kattints az alábbi linkre:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Az újság cikkek itt vannak felsorolva:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Válassz formátumot',
	'type_text' => 'Egyszerű szöveges',
	'type_html' => 'Egyszerű HTML',
				
	# Sign
	'sign_title' => 'Felíratkozás a hírújságra',
	'sign_info_login' => 'Még nem jelentkeztél be, így nem tudjuk, előfizettél-e a hírlevélre, vagy sem.',
	'sign_info_none' => 'Még nem fizettél elő a hírlevélre.',
	'sign_info_html' => 'Feliratkoztál a hírlevelekre, egyszerű html formátumban.',
	'sign_info_text' => 'Feliratkoztál a hírlevelekre, egyszerű szöveges formátumban.',
	'ft_sign' => 'Feliratkozás hírlevélre',
	'btn_sign' => 'Feliratkozás',
	'btn_unsign' => 'Leiratkozás a hírlevelekről',
		
	# Edit
	'ft_edit' => 'Hír szerkesztése (itt: %s)',
	'btn_edit' => 'Szerkesztés',
	'btn_translate' => 'Fordítás',
	'th_transid' => 'Fordítás',
	'th_mail_me' => 'Küldés hírlevélként',
	'th_hidden' => 'Rejtett',

	# Add
	'ft_add' => 'Hír felvétele',
	'btn_add' => 'Hír hozzáadása',
	'btn_preview' => 'Előnézet (Első!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Engedélyezd a hírújság előfizetást a vendégek számára',
	'cfg_news_per_adminpage' => 'Hírek száma admin oldalanként',
	'cfg_news_per_box' => 'Hírek száma inline-szöveges dobozonként',
	'cfg_news_per_page' => 'Hírek száma híroldalanként',
	'cfg_newsletter_mail' => 'Hírújság levél feladója',
	'cfg_newsletter_sleep' => 'Aludj el N milliszekundumra minden e-mail után',
	'cfg_news_per_feed' => 'Hírek száma oldalanként',
		
	# RSS2 Feed
	'rss_title' => 'WeChall Hírek - hírharsona',
		
	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Hírek küldése a fórumba',
	'board_lang_descr' => 'Hírek itt: %s',
	'btn_admin_section' => 'Admin szekció',
	'th_visible' => 'Látható',
	'btn_forum' => 'Megbeszélés a fórumban',
);



?>
