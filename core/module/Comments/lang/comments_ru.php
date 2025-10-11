<?php
$lang = array(
	'info_comments' => '<br/><a href="%s">%s комментариев ...</a>',

	'err_message' => 'Длина сообщения должна быть от %s до %s символов.',
	'err_comment' => 'Этот комментарий не существует.',
	'err_comments' => 'Эти комментарии не существуют.',
	'err_disabled' => 'Комментарии здесь временно отключены.',
	'err_hashcode' => 'Доступ запрещён.',
	'err_email' => 'Ваш email выглядит некорректным.',
	'err_www' => 'Ваш сайт указан неверно.',
	'err_username' => 'Ваш ник некорректен и должен быть длиной от %s до %s символов.',

	'msg_commented' => 'Ваш комментарий добавлен.',
	'msg_commented_mod' => 'Ваш комментарий добавлен, но будет показан после одобрения.',
	'msg_hide' => 'Комментарий скрыт.',
	'msg_visible' => 'Комментарий теперь виден.',
	'msg_deleted' => 'Комментарий удалён.',
	'msg_edited' => 'Комментарий отредактирован.',

	'ft_reply' => 'Оставить комментарий',
	'btn_reply' => 'Отправить',

	'btn_hide' => 'Скрыть',
	'btn_show' => 'Показать',

	'ft_edit_cmt' => 'Редактировать комментарий',
	'ft_edit_cmts' => 'Редактировать ветку комментариев',

	'btn_edit' => 'Редактировать',

	'btn_delete' => 'Удалить',

	'th_message' => 'Ваше сообщение',
	'th_www' => 'Ваш веб-сайт',
	'th_email' => 'Ваш email',
	'th_username' => 'Ваш ник',
	'th_showmail' => 'Показывать email публично',

	# Moderation #
	'subj_mod' => GWF_SITENAME.': Новый комментарий',
	'body_mod' =>
		'Здравствуйте, %s,'.PHP_EOL.
		PHP_EOL.
		'На '.GWF_SITENAME.' был оставлен новый комментарий.'.PHP_EOL.
		'От: %s'.PHP_EOL.
		'Почта: %s'.PHP_EOL.
		'Сайт: %s'.PHP_EOL.
		'Сообщение:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Вы можете быстро одобрить комментарий: <a href="%6$s">%6$s</a>'.PHP_EOL.
		PHP_EOL.
		'Или быстро удалить его: <a href="%7$s">%7$s</a>'.PHP_EOL.
		PHP_EOL.
		'С уважением,'.PHP_EOL.
		'Скрипт '.GWF_SITENAME,

	# Notice #
	'subj_cmt' => GWF_SITENAME.': Новый комментарий',
	'body_cmt' =>
		'Здравствуйте, %s,'.PHP_EOL.
		PHP_EOL.
		'На '.GWF_SITENAME.' был оставлен новый комментарий.'.PHP_EOL.
		'От: %s'.PHP_EOL.
		'Почта: %s'.PHP_EOL.
		'Сайт: %s'.PHP_EOL.
		'Сообщение:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Вы можете удалить его при желании: <a href="%6$s">%6$s</a>'.PHP_EOL.
		PHP_EOL.
		'С уважением,'.PHP_EOL.
		'Скрипт '.GWF_SITENAME,

	# monnino fixes
	'cfg_guest_captcha' => 'Капча для гостей?',
	'cfg_member_captcha' => 'Капча для пользователей?',
	'cfg_moderated' => 'Модерируется?',
	'cfg_max_msg_len' => 'Максимальная длина сообщения',
);

