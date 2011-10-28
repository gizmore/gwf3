<?php
/** BY Z **/
$lang = array(

	'pt_login' => 'Belépés '.GWF_SITENAME,
	'title_login' => 'Belépés',
	
	'th_username' => 'Felhasználói név',
	'th_password' => 'Jelszó',
	'th_login' => 'Belépés',
	'btn_login' => 'Belépés',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Ismeretlen felhasználói név',
	'err_login2' => 'Hibás jelszó. Már csak %1$s próbálkozásod maradt mielőtt %2$s zárolnánk.',
	'err_blocked' => 'Kérlek várj %1$s mielőtt belépnél.',

	'welcome' => 
		'Üdvözlünk a(z) '.GWF_SITENAME.' oldalán, %1$s.<br/><br/>'.
		'Reméljük tetszeni fog az oldal és örömmel fogod használni.<br/>'.
		'Ha kérdésed van, vedd fel velünk a kapcsolatot!',

	'welcome_back' => 
		'Üdvözlünk újra a(z) '.GWF_SITENAME.' oldalon, %1$s.<br/><br/>'.
		'Az utolsó ténykedésed ekkor volt: %2$s erről az IP címről: %3$s.',

	'logout_info' => 'Sikeres kijelentkezés.',

	# Admin Config
	'cfg_captcha' => 'Legyen CAPTCHA?',	
	'cfg_max_tries' => 'Maximális belépési próbálkozás',	
	'cfg_try_exceed' => 'a megadott időtartamon belül.',

	'info_no_cookie' => 'A böngésződ vagy nem támogatja a sütiket, nincs engedélyezve a(z) '.GWF_SITENAME.' oldal számára, pedig a sütik nélkül nem tudod használni az oldalt.',
	
	'th_bind_ip' => 'Munkamenet korlátozása erre az IP-re.',
	'tt_bind_ip' => 'Biztonsági intézkedés a süti lopás ellen.',

	# v1.01 (login failures)
	'err_failures' => '%1$s darab hibás bejelentkezés volt, lehetséges, hogy egy sikertelen, vagy a jövőben sikeres támadás áldozata vagy.',
	'cfg_lf_cleanup_i' => 'Hibás bejelentkezések törlése sikeres belépés után?',
	'cfg_lf_cleanup_t' => 'Hibás bejelentkezések törlése bizonyos idő után',

	# v2.00 (login history)
	'msg_last_login' => 'Utolsó bejelentkezés: %1$s Innen: %2$s (%3$s).<br/>Természetesen megnézheted <a href="%4$s">a bejelentkezési aktivitásaidat</a>.',
	'th_loghis_time' => 'Dátum',
	'th_loghis_ip' => 'IP cím',
	'th_hostname' => 'Hosztnév',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1$s from this IP: %2$s / %3$s',
);
?>