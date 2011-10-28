<?php

$lang = array(
	'hello' => 'Szép napot %1$s',
	'sel_username' => 'Válassz felhasználó nevet',
	'sel_folder' => 'Válassz könyvtárat',

	# Info
	'pt_guest' => GWF_SITENAME.' Vendég privát üzenet',
	'pi_guest' => GWF_SITENAME.'-on lehetséges, hogy privát üzenetet küldj valakinek anélkül, hogy be lennél jelentkezve, de ilyenkor természetesen nem tud majd visszajelezni. De arra jó, hogy egy hibát gyorsan be lehessen jelenteni.',
	'pi_trashcan' => 'Ez itt a szemetesed, üzeneteket nem tudsz törölni, de vissza tudod állítani őket.',
	
	# Buttons
	'btn_ignore' => 'Tedd %1$s -et a "figyelmen kívül hagyottak" listájára',
	'btn_ignore2' => 'Hagyd figyelmen kívül',
	'btn_save' => 'Beállítások mentése',
	'btn_create' => 'Új privát üzenet',
	'btn_preview' => 'Előzetes',
	'btn_send' => 'Privát üzenet küldése',
	'btn_delete' => 'Törlés',
	'btn_restore' => 'Visszaállítás',
	'btn_edit' => 'Szerkesztés',
	'btn_autofolder' => 'Automatikusan helyezd a könyvtárakba',
	'btn_reply' => 'Válasz',
	'btn_quote' => 'Idéz',
	'btn_options' => 'Privát üzenet opciók',
	'btn_search' => 'Keresés',
	'btn_trashcan' => 'A szemetesed',
	'btn_auto_folder' => 'Automatikusan szortírozd az üzeneteket',

	# Errors
	'err_pm' => 'A privát üzenet nem létezik.',
	'err_perm_read' => 'Nem engedélyezett a számodra ezen privát üzenet olvasása.',
	'err_perm_write' => 'Nem engedélyezett a számodra ezen privát üzenet szerkesztése.',
	'err_no_title' => 'Elfelejtettél címet adni a privát üzenetedhez.',
	'err_title_len' => 'Túl hosszúa címed. Maximum %1$s karakter engedélyezett.',
	'err_no_msg' => 'Elfelejtettél üzenetet írni.',
	'err_sig_len' => 'Túl hosszú az aláírásod. Maximum %1$s karakter engedélyezett.',
	'err_msg_len' => 'Túl hosszú az üzeneted. Maximum %1$s karakter engedélyezett.',
	'err_user_no_ppm' => 'Ez a felhasználó nem kíván privát üzenetet kapni vendégtől.',
	'err_no_mail' => 'Nincs jóváhagyott e-mail cím a felhasználói fiókodhoz.',
	'err_pmoaf' => 'Az automatikus mappákhoz rendelt érték érvénytelen.',
	'err_limit' => 'Elérted a napi maximális privát üzenet limitedet. Maximum %1$s privát üzenetet küldhetsz ennyi idő alatt: %2$s.',
	'err_ignored' => '%1$s a tiltólistájára tett.',
	'err_delete' => 'Hiba történt az üzenet törlése közben.',
	'err_folder_exists' => 'A mappa már létezik.',
	'err_folder_len' => 'A mappa hossza 1 - %1$s karakter kell, hogy legyen.',
	'err_del_twice' => 'Már törölted ezt a privát üzenetet.',
	'err_folder' => 'Ismeretlen mappa.',
	'err_pm_read' => 'A privát üzenetedet már elolvasták, így már nem tudod módosítani azt.',

	# Messages
	'msg_sent' => 'A privát üzeneted sikeresen el lett küldve. Mindaddig szerkesztheted, amíg el nem olvassák.',
	'msg_ignored' => 'Az alábbi felhasználót tetted a tiltólistára: %1$s .',
	'msg_unignored' => 'Az alábbi felhasználót vetted le a tiltólistáról: %1$s .',
	'msg_changed' => 'A beállításaid megváltoztak.',
	'msg_deleted' => 'Sikeresen törölted %1$s privát üzenetét.',
	'msg_moved' => 'Sikeresen áthelyezted %1$s privát üzenetét.',
	'msg_edited' => 'A privát üzeneted szerkesztve.',
	'msg_restored' => 'Sikeresen visszaállítva %1$s privát üzenete.',
	'msg_auto_folder_off' => 'Az automatikus mappák nincsenek a számodra engedélyezve. A privát üzenet olvasottként lett megjelölve.',
	'msg_auto_folder_none' => 'Csak %1$s üzenet van a felhasználótól. Semmi sem került áthelyezésre. A privát üzenet olvasottként lett megjelölve.',
	'msg_auto_folder_created' => 'A mappa létrehozva: %1$s.',
	'msg_auto_folder_moved' => ' %1$s üzenet lett áthelyezve a(z) %2$s mappába. A privát üzenetek olvasottként lettek megjelölve.',
	'msg_auto_folder_done' => 'Automatikus mappák kész.',


	# Titles
	'ft_create' => '%1$s részére új privát üzenet írása',
	'ft_preview' => 'Előnézet',
	'ft_options' => 'Privát üzenet beállításaid',
	'ft_ignore' => 'Tegyél fel valakit a tiltólistádra',
	'ft_new_pm' => 'Új privát üzenet írása',
	'ft_reply' => 'Válasz erre: %1$s',
	'ft_edit' => 'Privát üzenet szerkesztése',
	'ft_quicksearch' => 'Gyorskeresés',
	'ft_advsearch' => 'Összetett keresés',

	# Tooltips
	'tt_pmo_auto_folder' => 'Ha egy felhasználó legalább ennyi üzenetet küld neked, helyezd át a leveleket egy automatikus mappába.',
	
	# Table Headers
	'th_pmo_options&1' => 'E-mail értesítés új privát üzenet esetén',
	'th_pmo_options&2' => 'Privát üzenetet küldhetnek a vendégek is',
	'th_pmo_auto_folder' => 'Felhasználói mappák készítése x darab privát üzenet után',
	'th_pmo_signature' => 'A privát üzenet aláírásod',

	'th_pm_options&1' => 'Új',
	'th_actions' => ' ',
	'th_user_name' => 'Felhasználói név',
	'th_pmf_name' => 'Mappa',
	'th_pmf_count' => 'Darab',
	'th_pm_id' => 'ID',
	'th_pm_to' => 'Címzett',
	'th_pm_from' => 'Feladó',
//	'th_pm_to_folder' => 'Címzett mappa',
//	'th_pm_from_folder' => 'Feladó mappa',
	'th_pm_date' => 'Dátum',
	'th_pm_title' => 'Cím',
	'th_pm_message' => 'Üzenet',
//	'th_pm_options' => 'Beállítások',

	# Welcome PM
//	'wpm_title' => 'Üdvözlünk a(z) '.GWF_SITENAME.' oldalán',
//	'wpm_message' => 
//		'Kedves %1$s'.PHP_EOL.
//		PHP_EOL.
//		'Üdvözlünk a(z) '.GWF_SITENAME.' oldalán.'.PHP_EOL.
//		PHP_EOL.
//		'Reméljük tetszik az oldal, és sok örömet okoz majd.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.' Új privát üzeneted érkezett, melynek feladója: %1$s',
	'mail_body' =>
		'Kedves %1$s'.PHP_EOL.
		PHP_EOL.
		'Új privát üzeneted érkezett, feladója: '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Feladó: %2$s'.PHP_EOL.
		'Cím: %3$s'.PHP_EOL.
		PHP_EOL.
		'%4$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Innen egyszerűen tudod:'.PHP_EOL.
		'Automatikusan mappába helyezni az üzenetet:'.PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'Törölni az üzenetet:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Baráti üdvözlettel,'.PHP_EOL.
		'A(z) '.GWF_SITENAME.' levelező-programja.'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Captcha használata vendégek számára?',
	'cfg_pm_causes_mail' => 'E-mal engedélyezése a privát üzeneteken?',
	'cfg_pm_for_guests' => 'Egedélyezett, hogy vendégek is privát üzenetet küldjenek?',
	'cfg_pm_welcome' => 'Küldjünk üdvözlő privát üzenetet?',
	'cfg_pm_limit' => 'Maximális privát üzenetek száma a megadott időn belül',
	'cfg_pm_maxfolders' => 'Maximális mappák száma felhasználónként',
	'cfg_pm_msg_len' => 'Maximális üzenet hossz',
	'cfg_pm_per_page' => 'Privát üzenetek száma oldalanként',
	'cfg_pm_sig_len' => 'Maximális aláírás hossz',
	'cfg_pm_title_len' => 'Maximális cím hossz',
	'cfg_pm_bot_uid' => 'Üdvözlő privát üzenet feladó ID-je',
	'cfg_pm_sent' => 'Privát üzenet számláló',
	'cfg_pm_mail_sender' => 'E-mail küldése privát üzenet írójának(???)',
	'cfg_pm_re' => 'Elő - cím',
	'cfg_pm_limit_timeout' => 'Privát üzenet időkorlát',
	'cfg_pm_fname_len' => 'Maximális mappa hossz',

	# v2.01
	'err_ignore_admin' => 'Nem tudod az admint figyelmen kívül hagyni.',
	'btn_new_folder' => 'Új mappa',
		
	# v2.02
	'msg_mail_sent' => 'Egy e-mailt küldtünk, címzett: %1$s . A levél tartalmazza az eredeti üzenetedet.',
				
	# v2.03 SEO
	'pt_pm' => 'Privát Üzenet',
		
	# v2.04 fixes
	'ft_new_folder' => 'Új mappa létrehozása',

	# v2.05 (prev+next)
	'btn_prev' => 'Előző üzenet',
	'btn_next' => 'Következő üzenet',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'A másik felhasználó törölte ezt a privát üzenetet.',
	'gwf_pm_read' => 'A másik felhasználó elolvasta a privát üzenetedet.',
	'gwf_pm_unread' => 'A másik felhasználó még nem olvasta el a privát üzenetedet.',
	'gwf_pm_old' => 'Ez a privát üzenet még régi a számodra.',
	'gwf_pm_new' => 'Új üzenet a számodra.',
	'err_bot' => 'A bot-ok számára nem engedélyezett az üzenet küldése.',

	# v2.07 (fixes)
	'err_ignore_self' => 'Nem tudod magad letiltani.',
	'err_folder_perm' => 'Ez nem a te mappád.',
	'msg_folder_deleted' => 'A(z) %1$s mappa és %2$s üzenet a kukába került.',
	'cfg_pm_delete' => 'Megengeded az azonnali üzenet törlését?',
	'ft_empty' => 'Kuka ürítése',
	'msg_empty' => 'A kukád (%1$s üzenet) ki lett ürítve.<br/>%2$s üzenet lett törölve az adatbázisból.<br/>%3$s üzenet továbbra is az adatbázisban maradt a másik felhasználónál.',
		
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
		
	# Welcome PM
	'wpm_title' => 'Üdvözlünk a WeChall-on',
	'wpm_message' =>
		'Dear Challenger, Welcome to WeChall.'.PHP_EOL.
		PHP_EOL.
		'The site\'s ultimate goal is to provide an universal ranking for the hacker challenge sites.'.PHP_EOL.
		'That\'s why you have to [url=/linked_sites]link your challenge site accounts[/url] to WeChall.'.PHP_EOL.
		'You can do this under Account -> Linked Sites.'.PHP_EOL.
		'There are also some [url=/challs]WeChall challenges[/url], and your account is already linked to WeChall itself.'.PHP_EOL.
		'If you like our site, don\'t forget to frequently visit it and [url=/linked_sites]update your progress[/url].'.PHP_EOL.
		'If you are new to challenge sites, feel free to ask in the Forum, we will help you.'.PHP_EOL.
		'If you have any other question or suggestion, please provide feedback to us.'.PHP_EOL.
		PHP_EOL.PHP_EOL.
		'Here are a few hints how to setup your account (press the [url=/account]Account[/url] button in menu for that):'.PHP_EOL.
		'1) It\'s about solving challenges. so solve a few riddles on the [url=/active_sites]sites[/url] and link to your account. If you encounter problems, please tell.'.PHP_EOL.
		'2) You can toggle [url=/forum/options]Forum Settings[/url], [url=/pm/options]PM Settings[/url] and [url=/profile_settings]Change profile options[/url] if you would like to allow getting contacted. All contacting is off by default.'.PHP_EOL.
		'3) [b]WeChall is capable of SSL[/b], but does not force it anywhere. However you should be able to use SSL all over the site.'.PHP_EOL.
		PHP_EOL.
		'Happy Challenging'.PHP_EOL.
		'The WeChall Team'.PHP_EOL,
);
?>