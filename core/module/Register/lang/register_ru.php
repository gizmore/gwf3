<?php
$lang = array(
	'pt_register' => 'Регистрация на '.GWF_SITENAME,

	'title_register' => 'Регистрация',

	'th_username' => 'Имя',
	'th_password' => 'Пароль',
	'th_email' => 'Email',
	'th_birthdate' => 'Дата рождения',
	'th_countryid' => 'Страна',
	'th_tos' => 'Я согласен с<br/>Условиями Сайта',
	'th_tos2' => 'Я согласен с<br/><a href="%s">Условиями Сайта</a>',
	'th_register' => 'Регистрация',

	'btn_register' => 'Регистрация',
	

	'err_register' => 'Произошла ошибка во время регистрации.',
	'err_name_invalid' => 'Неверное имя пользователя.',
	'err_name_taken' => 'Это имя пользователя уже используется.',
	'err_country' => 'Неверное имя пользователя.',
	'err_pass_weak' => 'Ваш пароль слишком лёгкий. Также, <b>Не используйте важные для Вас пароли от других сервисов/сайтов</b>.',
	'err_token' => 'Код активации неверен. Может быть, Ваша учетная запись уже активирована.',
	'err_email_invalid' => 'Неверный email.',
	'err_email_taken' => 'Указанный email уже используется.',
	'err_activate' => 'Произошла ошибка во время активации. Did you click the activation link twice?',
		
	'msg_activated' => 'Ваша учетная запись теперь активирована. Вы можете войти.',
	'msg_registered' => 'Спасибо за регистрацию.',

	'regmail_subject' => 'Регистрация на '.GWF_SITENAME,
	'regmail_body' => 
		'Здравствуй %s<br/>'.
		'<br/>'.
		'Спасибо за регистрацию на '.GWF_SITENAME.'.<br/>'.
		'Для завершения регистрации, Вам необходимо активировать учетную запись, пройдя по ссылке снизу.<br/>'.
		'Если Вы не регистрировались на '.GWF_SITENAME.', пожалуйста проигнорируйте это письмо, или свяжитесь с нами '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'С наилучшими пожеланиями,<br/>'.
		'Команда '.GWF_SITENAME.'.',
	'err_tos' => 'Вы должны принять лицензионное соглашение.',

	'regmail_ptbody' => 
		'Ваши полномочия:<br/><b>'.
		'Имя: %s<br/>'.
		'Пароль: %s<br/>'.
		'</b><br/>'.
		'Рекомендуется удалить это письмо, и хранить пароль в другом месте.<br/>'.
		'Мы не храним пароль в открытом виде, и Вам не советуем.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'АвтоВход после Активации',	
	'cfg_captcha' => 'Captcha для Регистрации',
	'cfg_country_select' => 'Показывать выбор страны',
	'cfg_email_activation' => 'Email Регистрация',
	'cfg_email_twice' => 'Регистрация на тот же email дважды?',
	'cfg_force_tos' => 'Принудительно показывать TOS',
	'cfg_ip_usetime' => 'IP тайм-аут для мульти-регистрации',
	'cfg_min_age' => 'Минимальный возраст / Опция дня рождения',
	'cfg_plaintextpass' => 'Посылать пароль по email в открытом виде',
	'cfg_activation_pp' => 'Активаций на странице администратора',
	'cfg_ua_threshold' => 'Тайм-аут для завершения регистрации',

	'err_birthdate' => 'Дата рождения неверна.',
	'err_minage' => 'Очень жаль, но Вы ещё очень молоды для регистрации. Вам должно быть хотя бы %s лет.',
	'err_ip_timeout' => 'Кто-то недавно уже зарегистрировался с этого IP.',
	'th_token' => 'Токен',
	'th_timestamp' => 'Время регистрации',
	'th_ip' => 'Регистрационный IP',
	'tt_username' => 'Имя должно начинаться с символа.'.PHP_EOL.'Это могут быть только буквы, цифры и знак подчеркивания. Длина должна быть от 3 до %s символов.', 
	'tt_email' => 'Для регистрации необходим действующий EMail.',

	'info_no_cookie' => 'Ваш браузер не поддерживает cookies или не принимает их с '.GWF_SITENAME.', но cookies необходимы для входа.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Письмо с инструкциями по активации учетной записи было отправлено Вам.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Всегда автоопределять страну',

	# v2.03 (Links)
	'btn_login' => 'Имя',
	'btn_recovery' => 'Восстановление пароля',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
	# v2.06 (Spambot)
	'th_spambot' => 'Name of this site in reverse (%s letters)',
	'tt_spambot' => 'For example, if you were registering on Google, you would enter ´elgooG´.',
	'err_spambot' => 'Invalid site name. Make sure you enter it in reverse!',
);
