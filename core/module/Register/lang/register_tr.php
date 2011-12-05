<?php
$lang = array (
'pt_register' => 'Kayıt Ol güncellenmiştir'. GWF_SITENAME,

'title_register' => 'Kayıt',

'th_username' => 'Kullanıcı Adı',
'th_password' => 'Şifre',
'th_email' => 'E-posta',
'th_birthdate' => 'Doğum Günü',
'th_countryid' => 'Ülke',
'th_tos' => 'Ben kullanın Koşullarını kabul',
'th_tos2' => 'I kullanın <a href="%s">Şartlarını kabul ediyorum</a><br/>' ,
'th_register' => 'Kayıt',

'btn_register' => 'Kayıt',


'err_register' => 'bir hata kayıt işlemi sırasında oluştu.',
'err_name_invalid' => 'Seçili kullanıcı adı geçersiz.',
'err_name_taken' => 'kullanıcı adı önceden alınmış.',
'err_country' => 'Seçili kullanıcı adı geçersiz.',
'err_pass_weak' => 'Şifreniz çok zayıftır. Ayrıca, <b>yeniden önemli şifreler kullanmayın</b>.',
'err_token' => 'Etkinleştirme kodu geçersiz. Belki de zaten aktif hale gelir.',
'err_email_invalid' => 'E-posta adresiniz geçersiz.',
'err_email_taken' => 'E-posta adresiniz zaten alınır.',
'err_activate' => 'Bir hata etkinleştirme sırasında oluştu.',

'msg_activated' => 'yoru hesabı artık etkin. Lütfen şimdi giriş çalışın.',
'msg_registered' => 'Kayıt olduğunuz için teşekkürler.',

'regmail_subject' => 'Kayıt Ol güncellenmiştir '.GWF_SITENAME,
'regmail_body' =>
	'Merhaba %s<br/>'.
	'<br/>'.
	'Güncellenmiştir '.GWF_SITENAME.' kayıt için teşekkür ederiz.<br/>'.
	'Kaydı tamamlamak için, var öncelikle aşağıdaki bağlantıyı ziyaret ederek hesabınızın etkinleştirin.<br/>'.
	'Sen güncellenmiştir '.GWF_SITENAME.' kayıt etmediyseniz, Bu mail görmezden ya da güncellenmiştir '.GWF_SUPPORT_EMAIL.' lütfen bizi arayınız.<br/>'.
	'<br/>'.
	'%s<br/>'.
	'<br/>'.
	'%s'.
	'Saygılarımızla<br/>'.
	GWF_SITENAME.' Takım.',

'err_tos' => 'Bu EULA kabul etmek var.',

'regmail_ptbody' =>
	'Your Giriş Credentials şunlardır: <br/>'.
	'Kullanıcı adı: %s<br/>.',
	'Parola: %s<br/>.',
	'<br/>'.
	'Bu iyi bir fikir bu e-postayı silmek ve şifrenizi başka yerde mağazası.<br/>'.
	'Biz düz yazı şifrenizi saklamiyoruz, yapmanız gerektiğine ya.<br/>'.
	'<br/>',

# # # Admin Config # # #
'cfg_auto_login' => 'Otomatik girişi Aktivasyonu den sonra',
'cfg_captcha' => 'kaptan ol için',
'cfg_country_select' => 'göster ülke seçin',
'cfg_email_activation' => 'E-kayıt',
'cfg_email_twice' => 'Kayıt aynı e-posta iki kez?',
'cfg_force_tos' => 'göster zorla TOS',
'cfg_ip_usetime' => 'multi-kayıt için IP zaman aşımı',
'cfg_min_age' => 'En küçük yaş / Birthday seçici',
'cfg_plaintextpass' => 'Şifre Gönder Şifresiz metin in e-posta',
'cfg_activation_pp' => 'aktivasyonlar başına Yönetici Sayfa',
'cfg_ua_threshold' => 'tam kayıt zaman aşımı',

'err_birthdate' => 'Kişisel doğum geçersizdir.',
'err_minage' => 'Üzgünüz, ama yeterince kayıt eski değildir. En az %s yaşında gerekir.',
'err_ip_timeout' => 'Biri son zamanlarda bu IP hesap kayıtlı.',
'th_token' => 'Simgesi',
'th_timestamp' => 'Kayıt Time',
'th_ip' => 'Reg IP',
'tt_username' => 'kullanıcı adı bir harf ile başlamalı.'.PHP_EOL.'Sadece harfler, rakamlar ve altçizgi içerebilir.'.PHP_EOL.'Süre 3 olmalı - %s Karakter.',
'tt_email' => 'Geçerli bir EMail kayıt için gereklidir.',

'info_no_cookie' => 'Tarayıcınız veya çerezleri desteklemiyor için '. GWF_SITENAME.' onlara izin vermez, Ama aşçı giriş için gereklidir.',

# V2.01 (sabit)
'msg_mail_sent' => 'talimatlarla bir e-posta gönderildi hesabınızı aktif hale getirmek için.',

# V2.02 (Algılama Ülke)
'cfg_reg_detect_country' => 'Her zaman otomatik olarak ülke bulmak',

# V2.03 (Linkler)
'btn_login' => 'Giriş',
'btn_recovery' => 'Şifre kurtarma',
# v2.04 (Fixes)
'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
# v2.05 (Blacklist)
'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>