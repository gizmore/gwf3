<?php
$lang = array (
	'pt_login' => 'Giriş '. GWF_SITENAME,
	'title_login' => 'Giriş',
	
	'th_username' => 'Kullanıcı Adı',
	'th_password' => 'Şifre',
	'th_login' => 'Giriş',
	'btn_login' => 'Giriş',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Bilinmeyen Kullanıcı Adı',
	'err_login2' => 'Yanlış Şifre. Artık %2% engellenmiş kadar %1% sol çalışır% var.',
	'err_blocked' => 'Seni tekrar deneyin kadar %1% Lütfen bekleyiniz.',
	
	'welcome' =>
		'Hoşgeldiniz için '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Biz site gibi umut ve tarama yaparken eğlenin.<br/>'.
		'Eğer bizimle irtibata geçmekten çekinmeyin sorularım var!',
	'welcome_back' =>
		'Geri'. GWF_SITENAME.' hoş geldiniz, %1%.<br/><br/>'.
		'Son aktivitesi %2% bu IP adresinden oldu: %3%.',
	
	'logout_info' => 'Şimdi çıktınız.',
	
	# Admin Config
	'cfg_captcha' => 'kullan kaptan?',
	'cfg_max_tries' => 'Maksimum Giriş Denemeleri',
	'cfg_try_exceed' => 'içinde bu Süresi',
	
	'info_no_cookie' => 'Tarayıcınız veya çerezleri desteklemiyor için '.GWF_SITENAME.' onlara izin vermez. Ama aşçı giriş için gereklidir.',
	
	'th_bind_ip' => 'için sınırla Session Bu IP',
	'tt_bind_ip' => 'bir güvenlik ölçüm çerez hırsızlığı önlemek için.',
	
	'err_failures' => 'Bunun sebebi% 1% hatalı giriş ve başarısız bir veya gelecekteki saldırı konusu olabilir.',
	
	# V1.01 (hatalı giriş)
	'cfg_lf_cleanup_i' => 'giriş yaptıktan sonra Temizleme kullanıcı hataları?',
	'cfg_lf_cleanup_t' => 'Temizleme eski hataları defalarca',
	
	# V2.00 (giriş tarih)
	'msg_last_login' => 'Son Girişiniz %1% %2% (%3%) değildi. Ayrıca <a href="%4%">burada </a> giriş tarihini gözden.<br/>',
	'th_loghis_time' => 'Tarih',
	'th_loghis_ip' => 'IP ',
	'th_hostname' => 'Sunucu',
	
	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1% from this IP: %2% / %3%',
);
?>