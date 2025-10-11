<?php

$lang = array(

	'page_title' => 'Связаться с '.GWF_SITENAME,
	'page_meta' => 'Foo',

	'contact_title' => 'Контакты',
	'contact_info' =>
		'Здесь вы можете связаться с нами по email. Пожалуйста, укажите действительный адрес, чтобы мы могли ответить при необходимости.<br/>'.
		'Вы также можете написать на адрес <a href="mailto:%s">%s</a> из любого почтового клиента.',
	'form_title' => 'Свяжитесь с нами',
	'th_email' => 'Ваш email',
	'th_message' => 'Ваше сообщение',
	'btn_contact' => 'Отправить письмо',

	'mail_subj' => GWF_SITENAME.': Новое письмо через форму контактов',
	'mail_body' =>
		'Через контактную форму было отправлено письмо.<br/>'.PHP_EOL.
		'От: %s<br/>'.PHP_EOL.
		'Сообщение:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',

	'info_skype' => '<br/>Вы также можете связаться с нами в Skype: %s.',

	'err_email' => 'Неверный адрес email. Если хотите, можете оставить поле пустым.',
	'err_message' => 'Ваше сообщение слишком короткое или слишком длинное.',

	# Admin Config
	'cfg_captcha' => 'Использовать капчу',
	'cfg_email' => 'Отправлять сообщения на (email)',
	'cfg_icq' => 'Контактные данные ICQ',
	'cfg_skype' => 'Контактные данные Skype',
	'cfg_maxmsglen' => 'Макс. длина сообщения',

	# Sendmail
	'th_user_email' => 'Ваш адрес email',
	'ft_sendmail' => 'Отправить письмо пользователю %s',
	'btn_sendmail' => 'Отправить письмо',
	'err_no_mail' => 'Этот пользователь не хочет получать письма.',
	'msg_mailed' => 'Письмо отправлено пользователю %s.',
	'mail_subj_mail' => GWF_SITENAME.': Письмо от %s',
	'mail_subj_body' =>
		'Здравствуйте, %s'.PHP_EOL.
		PHP_EOL.
		'Вам пришло письмо от %s через сайт '.GWF_SITENAME.':'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',

	# V2.01 (List Admins)
	'list_admins' => 'Администраторы: %s.',

	'cfg_captcha_member' => 'Показывать капчу для участников?',
);

