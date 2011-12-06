<?php
$lang = array (
'msg_sent_mail' => 'Biz %s bir e-posta gönderdik. Lütfen orada yönergeleri izleyin.',
'err_not_found' => 'Kullanıcı bulunamadı. Lütfen ya e-posta ya da kullanıcı adınızı gönderin.',
'err_not_same_user' => 'Kullanıcı bulunamadı. Lütfen ya e-posta ya da kullanıcı adınızı gönderin.', # Aynı mesajı! => E-posta uname hiçbir şımarık bağlantı
'err_no_mail' => 'Üzgünüz, ama bir e-posta hesabınıza bağlı gerekmez. :(',
'err_pass_retype' => 'Kişisel retyped şifre eşleşmiyor.',
'msg_pass_changed' => 'Şifreniz değiştirildi.',

'pt_request' => 'iste yeni bir parola',
'pt_change' => 'Şifrenizi değiştirin',

'info_request' => 'Burada hesabınız için yeni bir şifre isteyebilirsiniz. Basitçe e-posta kullanıcı adınızı veya gönderin ve biz e-posta adresinize ayrıntılı talimatlar size göndereceğiz.',
'info_change' => 'Şimdi hesabınızı, %s için yeni bir şifre girebilirsiniz.',

'title_request' => 'iste yeni bir parola',
'title_change' => 'Set yeni bir parola',

'btn_request' => 'İstek',
'btn_change' => 'Değiştir',

'th_username' => 'Kullanıcı Adı',
'th_email' => 'E-posta',
'th_password' => 'Yeni Şifre',
'th_password2' => 'Tekrar It',

# E-posta
'mail_subj' => GWF_SITENAME. ': Parolayı Değiştir',
'mail_body' =>
	'Sevgili %1$s'.PHP_EOL.
	PHP_EOL.
	'Sen '.GWF_SITENAME.' Şifrenizi değiştirmek istedi.'.PHP_EOL.
	'Bunu yapmak için, aşağıdaki linki.'.PHP_EOL.
	'Ziyaret etmelisiniz.'.PHP_EOL.
	'Eğer bir değişiklik talep etmediyseniz bu mail görmezden veya bize <a href="mailto:%2$s">%2$s</a>.'.PHP_EOL.
	PHP_EOL.
	'%3$s'.PHP_EOL.
	PHP_EOL.
	'Saygılarımızla'.PHP_EOL.
	GWF_SITENAME. 'Takım',

	
	# v2.01 (fixes)
	'err_weak_pass' => 'Your password is too weak. Minimum are %s chars.',
);
?>