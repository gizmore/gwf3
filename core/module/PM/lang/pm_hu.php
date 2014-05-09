<?php

$lang = array(
	'hello' => 'Szép napot %s',
	'sel_username' => 'Válassz felhasználó nevet',
	'sel_folder' => 'Válassz könyvtárat',

	# Info
	'pt_guest' => GWF_SITENAME.' Vendég privát üzenet',
	'pi_guest' => GWF_SITENAME.'-on lehetséges, hogy privát üzenetet küldj valakinek anélkül, hogy be lennél jelentkezve, de ilyenkor természetesen nem tud majd visszajelezni. De arra jó, hogy egy hibát gyorsan be lehessen jelenteni.',
	'pi_trashcan' => 'Ez itt a szemetesed, üzeneteket nem tudsz törölni, de vissza tudod állítani őket.',
	
	# Buttons
	'btn_ignore' => 'Tedd %s -et a "figyelmen kívül hagyottak" listájára',
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
	'err_title_len' => 'Túl hosszúa címed. Maximum %s karakter engedélyezett.',
	'err_no_msg' => 'Elfelejtettél üzenetet írni.',
	'err_sig_len' => 'Túl hosszú az aláírásod. Maximum %s karakter engedélyezett.',
	'err_msg_len' => 'Túl hosszú az üzeneted. Maximum %s karakter engedélyezett.',
	'err_user_no_ppm' => 'Ez a felhasználó nem kíván privát üzenetet kapni vendégtől.',
	'err_no_mail' => 'Nincs jóváhagyott e-mail cím a felhasználói fiókodhoz.',
	'err_pmoaf' => 'Az automatikus mappákhoz rendelt érték érvénytelen.',
	'err_limit' => 'Elérted a napi maximális privát üzenet limitedet. Maximum %s privát üzenetet küldhetsz ennyi idő alatt: %s.',
	'err_ignored' => '%s a tiltólistájára tett.<br/>%s',
	'err_delete' => 'Hiba történt az üzenet törlése közben.',
	'err_folder_exists' => 'A mappa már létezik.',
	'err_folder_len' => 'A mappa hossza 1 - %s karakter kell, hogy legyen.',
	'err_del_twice' => 'Már törölted ezt a privát üzenetet.',
	'err_folder' => 'Ismeretlen mappa.',
	'err_pm_read' => 'A privát üzenetedet már elolvasták, így már nem tudod módosítani azt.',

	# Messages
	'msg_sent' => 'A privát üzeneted sikeresen el lett küldve. Mindaddig szerkesztheted, amíg el nem olvassák.',
	'msg_ignored' => 'Az alábbi felhasználót tetted a tiltólistára: %s .',
	'msg_unignored' => 'Az alábbi felhasználót vetted le a tiltólistáról: %s .',
	'msg_changed' => 'A beállításaid megváltoztak.',
	'msg_deleted' => 'Sikeresen törölted %s privát üzenetét.',
	'msg_moved' => 'Sikeresen áthelyezted %s privát üzenetét.',
	'msg_edited' => 'A privát üzeneted szerkesztve.',
	'msg_restored' => 'Sikeresen visszaállítva %s privát üzenete.',
	'msg_auto_folder_off' => 'Az automatikus mappák nincsenek a számodra engedélyezve. A privát üzenet olvasottként lett megjelölve.',
	'msg_auto_folder_none' => 'Csak %s üzenet van a felhasználótól. Semmi sem került áthelyezésre. A privát üzenet olvasottként lett megjelölve.',
	'msg_auto_folder_created' => 'A mappa létrehozva: %s.',
	'msg_auto_folder_moved' => ' %s üzenet lett áthelyezve a(z) %s mappába. A privát üzenetek olvasottként lettek megjelölve.',
	'msg_auto_folder_done' => 'Automatikus mappák kész.',


	# Titles
	'ft_create' => '%s részére új privát üzenet írása',
	'ft_preview' => 'Előnézet',
	'ft_options' => 'Privát üzenet beállításaid',
	'ft_ignore' => 'Tegyél fel valakit a tiltólistádra',
	'ft_new_pm' => 'Új privát üzenet írása',
	'ft_reply' => 'Válasz erre: %s',
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
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'Címzett',
	'th_pm_from' => 'Feladó',
//	'th_pm_to_folder' => 'Címzett mappa',
//	'th_pm_from_folder' => 'Feladó mappa',
	'th_pm_date' => 'Dátum',
	'th_pm_title' => 'Cím',
	'th_pm_message' => 'Üzenet',
//	'th_pm_options' => 'Beállítások',

	# Welcome PM
	'wpm_title' => 'Üdvözlünk a(z) '.GWF_SITENAME.' oldalán',
	'wpm_message' => 
		'Kedves %s'.PHP_EOL.
		PHP_EOL.
		'Üdvözlünk a(z) '.GWF_SITENAME.' oldalán.'.PHP_EOL.
		PHP_EOL.
		'Reméljük tetszik az oldal, és sok örömet okoz majd.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Új privát üzeneted érkezett, melynek feladója: %s',
	'mail_body' =>
		'Kedves %s'.PHP_EOL.
		PHP_EOL.
		'Új privát üzeneted érkezett, feladója: '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Feladó: %s'.PHP_EOL.
		'Cím: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Innen egyszerűen tudod:'.PHP_EOL.
		'Automatikusan mappába helyezni az üzenetet:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Törölni az üzenetet:'.PHP_EOL.
		'%s'.PHP_EOL.
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
	'msg_mail_sent' => 'Egy e-mailt küldtünk, címzett: %s . A levél tartalmazza az eredeti üzenetedet.',
				
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
	'msg_folder_deleted' => 'A(z) %s mappa és %s üzenet a kukába került.',
	'cfg_pm_delete' => 'Megengeded az azonnali üzenet törlését?',
	'ft_empty' => 'Kuka ürítése',
	'msg_empty' => 'A kukád (%s üzenet) ki lett ürítve.<br/>%s üzenet lett törölve az adatbázisból.<br/>%s üzenet továbbra is az adatbázisban maradt a másik felhasználónál.',
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
	# monnino fixes
	'cfg_pm_limit_per_level' => 'PM limit per level',
	'cfg_pm_own_bot' => 'PM own bot',
	'th_reason' => 'Reason',
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);
