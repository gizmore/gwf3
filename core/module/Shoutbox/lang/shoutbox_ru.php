<?php
$lang = array(
	# Box
	'box_title' => 'Мини-чат '.GWF_SITENAME,

	# History
	'pt_history' => 'История мини-чата '.GWF_SITENAME.' (Страница %s из %s)',
	'pi_history' => 'Мини-чат сайта '.GWF_SITENAME,
	'mt_history' => GWF_SITENAME.', Мини-чат, История',
	'md_history' => 'Мини-чат на '.GWF_SITENAME.' предназначен для коротких сообщений, не требующих отдельной темы на форуме.',

	# Errors
	'err_flood_time' => 'Пожалуйста, подождите %s перед тем как отправить новое сообщение.',
	'err_flood_limit' => 'Вы превысили лимит в %s сообщений в день.',
	'err_message' => 'Сообщение должно быть длиной от %s до %s символов.',
	
	# Messages
	'msg_shouted' => 'Ваше сообщение добавлено.<br/>Вернуться к <a href="%s">%s</a>.',
	'msg_deleted' => 'Одно сообщение было удалено.',

	# Table Heads
	'th_shout_date' => 'Дата',
	'th_shout_uname' => 'Имя пользователя',
	'th_shout_message' => 'Сообщение',

	# Buttons
	'btn_delete' => 'Удалить',
	'btn_shout' => 'Отправить!',

	# Admin config
	'cfg_sb_guests' => 'Разрешить гостевые сообщения',	
	'cfg_sb_ipp' => 'Сообщений на странице истории',
	'cfg_sb_ippbox' => 'Сообщений в окне мини-чата',
	'cfg_sb_maxlen' => 'Максимальная длина сообщения',
	'cfg_sb_maxdayg' => 'Макс. сообщений в день для гостей',
	'cfg_sb_maxdayu' => 'Макс. сообщений в день для пользователей',
	'cfg_sb_timeout' => 'Интервал между двумя сообщениями',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'Модерация по email',
	'emod_subj' => GWF_SITENAME.': Новое сообщение в мини-чате',
	'emod_body' =>
		'Здравствуйте, команда,'.PHP_EOL.
		PHP_EOL.
		'В мини-чате появилось новое сообщение.'.PHP_EOL.
		PHP_EOL.
		'От: %s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Удалить сообщение можно по ссылке: %s'.PHP_EOL.
		PHP_EOL.
		'С уважением,'.PHP_EOL.
		'Скрипт GWF3',

	# monnino fixes
	'cfg_sb_guest_captcha' => 'Капча для гостей',
	'cfg_sb_member_captcha' => 'Капча для пользователей',
);

