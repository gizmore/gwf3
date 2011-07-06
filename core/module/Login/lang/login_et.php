<?php
$lang = array(

	'pt_login' => 'Logi sisse'.GWF_SITENAME,
	'title_login' => 'Logi sisse',
	
	'th_username' => 'Kasutajanimi',
	'th_password' => 'Salasõna',
	'th_login' => 'Logi sisse',
	'btn_login' => 'Logi sisse',

	'err_login' => 'Kasutajanime ei leitud',
	'err_login2' => 'Vale salasõna. Teil on veel %1% katset, enne kui sind blokeeritakse %2%.',
	'err_blocked' => 'Palun oodake %1% enne kui proovite uuesti.',

	'welcome' => 
		'Tere tulemast '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Me loodame, et teile meeldib meie lehekülg ja teil ei hakka igav seda lehitsedes.<br/>'.
		'Juhul kui teil on küsimusi, ärge kõhelge meiega kontakteerumises!',

	'welcome_back' => 
		'Tere tulemast tagasi '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Teie viimased tegevused toimusid %2% sellelt IP-lt: %3%.',

	'logout_info' => 'Väljalogimine õnnestus.',

	# Admin Config
	'cfg_captcha' => 'Kasuta Captcha?',	
	'cfg_max_tries' => 'Maksimaalne sisselogimiste arv',	
	'cfg_try_exceed' => 'selles ajavahemikus',

	'info_no_cookie' => 'Teie brauser ei toeta küpsiseid või ei ole need lubatud '.GWF_SITENAME.', kuid küpsised peavad olema sisselogimiseks lubatud.',
	
	'th_bind_ip' => 'Piira sessioon sellele IP-le',
	'tt_bind_ip' => 'Turvameetod, et ära hoida küpsiste vargust.',

	'err_failures' => 'On olnud %1% sisselogimise ebaõnnestumist ja te võite olla ebaõnnestunud rünnaku põrjuseks.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Puhasta kasutaja ebaõnnestunud sisselogimised pärast sisselogimist ?',
	'cfg_lf_cleanup_t' => 'Puhasta ebaõnnestunud logimised ajapikku',

	# v2.00 (login history)
	'msg_last_login' => 'Your last login was %1% from %2% (%3%).<br/>You can also <a href="%4%">review your login history here</a>.',
	'th_loghis_time' => 'Date',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1% from this IP: %2% / %3%',
);
?>