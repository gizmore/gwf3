<?php
$lang = array(

	# Titles
	'form_title' => 'Fiók beállítások',
	'chmail_title' => 'Pötyögd be az új e-mail címed',

	# Headers
	'th_username' => 'Felhasználói neved',
	'th_email' => 'E-mail címed',
	'th_demo' => 'Földrajzi beállítások - csak egyszer változtathatod meg %1% belül.',
	'th_countryid' => 'Ország',	
	'th_langid' => 'Elsődleges nyelv',	
	'th_langid2' => 'Másodlagos nyelv',
	'th_birthdate' => 'Születésnapod',
	'th_gender' => 'Nemed',
	'th_flags' => 'Opciók - bármikor megváltoztathatod',
	'th_adult' => 'Szeretnél felnőtt tartalmat látni?',
	'th_online' => 'Elrejtsük-e az online állapotodat?',
	'th_show_email' => 'Publikus az e-mail címed?',
	'th_avatar' => 'Az avatárod',
	'th_approvemail' => '<b>Az e-mail címed<br/>nincs elfogadva.</b>',
	'th_email_new' => 'Az új e-mail címed.',
	'th_email_re' => 'E-mail újrapötyögése.',

	# Buttons
	'btn_submit' => 'Változtatások elmentése',
	'btn_approvemail' => 'E-mail elfogadása',
	'btn_changemail' => 'Új e-mail cím beállítása',
	'btn_drop_avatar' => 'Avatar törlése',

	# Errors
	'err_token' => 'Érvénytelen token.',
	'err_email_retype' => 'Újra kell pötyögni az e-mail címed, most már helyesen.',
	'err_delete_avatar' => 'Hiba történt az avatárod törlése közben.',
	'err_no_mail_to_approve' => 'Nincs olyan e-mail cím, amit jóvá kellene hagyni.',
	'err_already_approved' => 'Az e-mail címed már jóvá van hagyva.',
	'err_no_image' => 'A feltöltött kép nem kép, vagy túl kicsi.',
	'err_demo_wait' => 'Mostanában változtattad meg a földrajzi beállításodat. Várj %1%.',
	'err_birthdate' => 'Érvénytelen születési idő.',

	# Messages
	'msg_mail_changed' => 'A kapcsolattartó e-mail címed megváltozott erre változott: <b>%1%</b>',
	'msg_deleted_avatar' => 'Az avatár képed törölve lett.',
	'msg_avatar_saved' => 'Az új avatár képed mentésre került.',
	'msg_demo_changed' => 'A földrajzi beállításaid megváltoztak.',
	'msg_mail_sent' => 'E-mailt küldtünk neked a változtatás elvégzéséhez. Kérlek kövesd az e-mailben található utasításokat.',
	'msg_show_email_on' => 'Az e-mail címed mostantól publikus.',
	'msg_show_email_off' => 'Az e-mail cíed mostantól nem publikus.',
	'msg_adult_on' => 'A felhasználói fiókod mostantól felnőtt tartalmat is megjeleníthet.',
	'msg_adult_off' => 'A felnőtt tartalma mostantól nem jelennek meg számodra.',
	'msg_online_on' => 'Az online állapotod mostantól rejtve marad.',
	'msg_online_off' => 'Az online állapotod mostantól publikus.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatár maximális szélesség',
	'cfg_avatar_max_y' => 'Avatár maximális magasság',
	'cfg_avatar_min_x' => 'Avatár minimális szélesség',
	'cfg_avatar_min_y' => 'Avatár minimális magasság',
	'cfg_adult_age' => 'Mimimális kor felnőtt tartalomhoz.',
	'cfg_demo_changetime' => 'Földrajzi változtatás lejárati idő.',
	'cfg_mail_sender' => 'Fiók változtatás, e-mail küldő',
	'cfg_show_adult' => 'Az oldal tartalmaz felnőtt tartalmat?',
	'cfg_show_gender' => 'Mutasd a kiválasztott nemet?',
	'cfg_use_email' => 'Kell e-mail a fiók változtatásához?',
	'cfg_show_avatar' => 'Mutasd az avatár feltöltést?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Változtass e-mail címet',
	'chmaila_body' => 
		'Kedves %1%,'.PHP_EOL.
		PHP_EOL.
		'Kezdeményezted az e-mail címed változtatását a(z) '.GWF_SITENAME.' oldalon.'.PHP_EOL.
		'Ehhez látogasd meg az alábbi URL-t: '.PHP_EOL.
		'Amennyiben nem te kérted a változtatást, hagyd figyelmen kívül ezt az e-mail vagy értesítsd az oldal adminisztrátorait az eseményről.'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Üdvözlettel'.PHP_EOL.
		GWF_SITENAME.' csapata',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': E-mail cím megerősítése',
	'chmailb_body' => 
		'Kedves %1%,'.PHP_EOL.
		PHP_EOL.
		'Ahhoz, hogy et az e-mail címet használhasd elsődleges címként, vissza kell igazolnod úgy, hogy meglátogatod az alábbi URl-t:'.PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Üdvözlettel'.PHP_EOL.
		GWF_SITENAME.' csapata',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Földrajzi beállítások megváltoztatása',
	'chdemo_body' =>
		'Kedves %1%'.PHP_EOL.
		PHP_EOL.
		'Kérted a földrajzi beállításod megváltoztatását.'.PHP_EOL.
		'Ezt csak egyszer teheted meg %2%, így kérlek győzödj meg arról, hogy valóban ezt szeretnéd tenni.'.PHP_EOL.
		PHP_EOL.
		'Nem: %3%'.PHP_EOL.
		'Ország: %4%'.PHP_EOL.
		'Elsődleges nyelv: %5%'.PHP_EOL.
		'Másodlagos nyelv: %6%'.PHP_EOL.
		'Születésnap: %7%'.PHP_EOL.
		PHP_EOL.
		'Ha szeretnéd megtartani ezeket a beállításokat, kérlek látogasd meg az alábbi URL-t:'.PHP_EOL.
		'%8%'.
		PHP_EOL.
		'Üdvözlettel'.PHP_EOL.
		GWF_SITENAME.' csapata',

	# New Flags 
	'th_allow_email' => 'Mások is küldhetnek neked e-mailt',
	'msg_allow_email_on' => 'Így már mások is tudnak e-mailt küldeni neked anélkül, hogy felfednéd a valós e-mail címedet.',
	'msg_allow_email_off' => 'E-mail kontakt kikapcsolva.',
		
	'th_show_bday' => 'Látható a születésnapod',
	'msg_show_bday_on' => 'A születésnapod mostantól ki lesz hirdetve azok számára, akiket ez érdekel.',
	'msg_show_bday_off' => 'A születésnapod nem lesz kihirdetve a késöbbiekben.',
		
	'th_show_obday' => 'Mutasd mások születésnapját',
	'msg_show_obday_on' => 'Most már láthatod mások születésnapját a hírekben.',
	'msg_show_obday_off' => 'Mostantól nem fogod látni mások születésnapját a hírekben.',
		
	# v2.02 Account Deletion
	'pt_accrm' => 'Saját felhasználó törlése',
	'mt_accrm' => 'Saját felhasználó törlése a WeChall-ról',
	'pi_accrm' => 'Úgy tűnik szeretnéd törölni a felhasználói fiókodat a Wechall-on. <br/>Szomorúak vagyunk, hogy ezt halljuk, illetve a felhasználói fiókod nem lesz törölve, csak le lesz tiltva.<br/>Minden link, ami a felhasználói fiókodhoz köthető, használhatatlan lesz, vagy "vendég" névvel fog megjelenni. A folyamat visszafordíthatatlan.<br/>Mielőtt folytatnád a fiók törlését, hagyhatsz nekünk egy üzenetet arról, miért törölted a felhasználói fiókodat.<br/>',
	'th_accrm_note' => 'Jegyzet',
	'btn_accrm' => 'Fiók törlése',
	'msg_accrm' => 'A fiókod töröltként lett megjelölve, és minden hivatkozás törölve lett.<br/>Automatikusan ki lettél léptetve.',
	'ms_accrm' => 'WeChall: %1% felhasználói fiók törlése',
	'mb_accrm' =>
		'Kedves Admin'.PHP_EOL.
		''.PHP_EOL.
		'A(z) %1% felhasználó törölte a felhasználói fiókját és az alábbi üzenetet hagyta (lehet, hogy üres):'.PHP_EOL.PHP_EOL.
		'%2%',

	# v2.03 Email Options
	'th_email_fmt' => 'Preferált e-mail formátum',
	'email_fmt_text' => 'Egyszerû szöveg',
	'email_fmt_html' => 'Egyszerû HTML',
	'err_email_fmt' => 'Kérlek válassz egy valós e-mail formátumot.',
	'msg_email_fmt_0' => 'Ezentúl az e-mail-eket egyszerû html formátumban kapod meg.',
	'msg_email_fmt_4096' => 'Ezentúl az e-mail-eket egyszerû szöveges formátumban kapod meg.',
	'ft_gpg' => 'GPG/GPG Rejtjelezés beállítása',
	'th_gpg_key' => 'Töltsd fel a publikus kulcsodat.',
	'th_gpg_key2' => 'Vagy illeszd be ide',
	'tt_gpg_key' => 'Ha beállítottál GPG kulcsot, minden neked küldött üzenet rejtjelezve lesz a publikus kulcsoddal',
	'tt_gpg_key2' => 'Ne felejtsd a GPG kulcsot.',
	'btn_setup_gpg' => 'Kulcs feltöltése',
	'btn_remove_gpg' => 'Kulcs eltávolítása',
	'err_gpg_setup' => 'Ne felejtsd a GPG kulcsot.',
	'err_gpg_key' => 'Érvénytelen GPG kulcs.',
	'err_gpg_token' => 'A gpg ujjlenyomat nem egyezik az általunk rögzített értékkel.',
	'err_no_gpg_key' => 'A %1%felhasználó még nem küldött be semmilyen GPG kulcsot.',
	'err_no_mail' => 'Nincs elfogadott e-mail címed.',
	'err_gpg_del' => 'Nincs gpg kulcs, amit törölhetnénk.',
	'err_gpg_fine' => 'Már van GPG kulcsod.',
	'msg_gpg_del' => 'GPG kulcs sikeresen törölve.',
	'msg_setup_gpg' => 'GPG kulcs tárolva, használható.',
	'mails_gpg' => 'WeChall: GPG rejtjelezés',
	'mailb_gpg' => 'Kedves %1%,

Úgy döntöttél, hogy bekapcsolod a rejtjelezést az e-mail-eidre.
Ehhez kattints az alábbi linkre:

%2%

Üdvözlettel
WeChall csapata',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%1%">Change your password</a>',
	'err_gpg_raw' => GWF_SITENAME.' does only support ascii armor format for your public GPG key.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',

	# v3.00 (fixes3)
	'err_email_taken' => 'This email address is already in use.',
);


?>