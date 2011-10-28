<?php

$lang = array(

	# Default GB Name
	'default_title' => GWF_SITENAME.' Vendégkönyv',
	'default_descr' => 'A(z) '.GWF_SITENAME.' Vendégkönyve',

	# Errors
	'err_gb' => 'A vendégkönyv nem létezik.',
	'err_gbm' => 'A vendégkönyv bejegyzés nem működik.',
	'err_gbm_username' => 'Érvénytelen felhasználói név. Minimum %1$s és maximum %2$s karakter hosszúságú lehet.',
	'err_gbm_message' => 'Érvénytelen üzenet. Minimum %1$s és maximum %2$s karakter hosszúságú lehet.',
	'err_gbm_url' => 'A weboldalad nem elérhető, vagy hibás az URL.',
	'err_gbm_email' => 'Érvénytelen e-mail cím.',
	'err_gb_title' => 'Érvénytelen cím. Minimum %1$s és maximum %2$s karakter hosszúságú lehet.',
	'err_gb_descr' => 'Érvénytelen leírás. Minimum %1$s és maximum %2$s karakter hosszúságú lehet.',

	# Messages
	'msg_signed' => 'Sikeresen aláírtad a vendégkönyvet.',
	'msg_signed_mod' => 'Sikeresen aláírtad a vendégkönyvet, de a megjelenítés előtt egy moderátornak jóvá kell hagynia.',
	'msg_gb_edited' => 'A vendégkönyv sikeresen szerkesztve lett.',
	'msg_gbm_edited' => 'A vendégkönyv bejegyzés sikeresen szerkesztve lett.',
	'msg_gbm_mod_0' => 'A vendégkönyv bejegyzés már látható.',
	'msg_gbm_mod_1' => 'A vendégkönyv bejegyzés bekerült a moderálási sorba.',
	'msg_gbm_pub_0' => 'A vendégkönyv bejegyzés nem látható a vendégek számára.',
	'msg_gbm_pub_1' => 'A vendégkönyv bejegyzés látható a vendégek számára.',

	# Headers
	'th_gbm_username' => 'Beceneved',
	'th_gbm_email' => 'E-mail címed',
	'th_gbm_url' => 'Weboldalad',
	'th_gbm_message' => 'Üzeneted',
	'th_opt_public' => 'Publikus az üzenet?',
	'th_opt_toggle' => 'Engedélyezed a publikus kapcsolót?',
	'th_gb_title' => 'Cím',
	'th_gb_locked' => 'Zárolva?',
	'th_gb_moderated' => 'Moderálva?',
	'th_gb_guest_view' => 'Publikus nézet?',
	'th_gb_guest_sign' => 'Vendég aláírás?',
	'th_gb_bbcode' => 'Engedélyezzem a BBCode-ot?',
	'th_gb_urls' => 'Engedélyezzem a felhasználói URL-eket?',
	'th_gb_smiles' => 'Engedélyezzem a szmájlikat?',
	'th_gb_emails' => 'Engedélyezzem a felhasználók e-mail címét?',
	'th_gb_descr' => 'Leírás',
	'th_gb_nesting' => 'Beágyazás engedélyezve?',

	# Tooltips
	'tt_gbm_email' => 'Az e-mail címed mindenki számára látható lesz, ha beállítasz egyet!',
	'tt_gb_locked' => 'Kattints ide, hogy ideiglenesen letiltsd a vendégkönyvet',

	# Titles
	'ft_sign' => 'Aláír %1$s',
	'ft_edit_gb' => 'Vendégkönyv szerkesztése',
	'ft_edit_entry' => 'Vendégkönyv bejegyzés szerkesztése',

	# Buttons
	'btn_sign' => 'Aláír %1$s',
	'btn_edit_gb' => 'Vendégkönyv szerkesztése',
	'btn_edit_entry' => 'Bejegyzés szerkesztése',
	'btn_replyto' => 'Válasz neki: %1$s',
	'btn_public_hide' => 'Bejegyzés elrejtése a vendégek elől',
	'btn_public_show' => 'Bejegyzés megjelenítése vendégek számára is',
	'btn_moderate_no' => 'Bejegyzés megjelenítésének engedélyezése',
	'btn_moderate_yes' => 'Rejtsd el ezt az üzenetet, és tedd bele a moderálási sorba',

	# Admin Config
	'cfg_gb_allow_email' => 'Engedélyezed és megmutatod az e-maileket?',
	'cfg_gb_allow_url' => 'Engedélyezed és megmutatod a weboldalakat?',
	'cfg_gb_allow_guest' => 'Engedélyezed a vendégbejegyzéseket?',
	'cfg_gb_captcha' => 'Captcha a vendégek számára?',
	'cfg_gb_ipp' => 'Bejegyzések száma oldalanként',
	'cfg_gb_max_msglen' => 'Max. üzenet hosszúság',
	'cfg_gb_max_ulen' => 'Max. vendégnév hossz',
	'cfg_gb_max_titlelen' => 'Max. vendégkönyv cím hossz',
	'cfg_gb_max_descrlen' => 'Max. vendégkönyv leírás hossz',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Minimum szint a vendégkönyv szerkesztéséhez',
	'mails_signed' => GWF_SITENAME.': Vendégkönyv aláírva',
	'mailb_signed' => 
		'Kedves %1$s'.PHP_EOL.
		PHP_EOL.
		'A %2$s vendégkönyvet aláírta: %3$s (%4$s)'.PHP_EOL.
		'Üzenet:'.PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'Automatikusan meg tudod jeleníteni ezt a bejegyzést azáltal, hogy ráklikkelsz az alábbi linkre:'.PHP_EOL.
		'%6$s'.PHP_EOL,
		
	# v2.02 Mail on Sign
	'th_mailonsign' => 'E-mail küldése új bejegyzés esetén?',
	'mails2_signed' => GWF_SITENAME.': Vendégkönyv aláírva',
	'mailb2_signed' => 
		'Kedves %1$s'.PHP_EOL.
		PHP_EOL.
		'A %2$s vendégkönyv alá lett írva %3$s (%4$s)'.PHP_EOL.
		'Üzenet:'.PHP_EOL.
		'%5$s'.PHP_EOL,
		
	# v2.03 (Delete entry)
	'btn_del_entry' => 'Bejegyzés törlése',
	'msg_e_deleted' => 'A bejegyzés törölve lett.',

	# v2.04 (finish)
	'cfg_gb_menu' => 'Megjelenítés a menüben?',
	'cfg_gb_nesting' => 'Beágyazás engedélyezése?',
	'cfg_gb_submenu' => 'Almenüben is megjeleníteni?',
	'err_locked' => 'Vendégkönyv zárolva.',

	# v2.05 (showmail)
	'th_opt_showmail' => 'Show EMail to public?',
);

?>