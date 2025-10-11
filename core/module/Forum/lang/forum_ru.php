<?php
 
$lang = array(

	# Errors
	'err_board' => 'Раздел неизвестен или у вас нет прав доступа.',
	'err_thread' => 'Тема неизвестна или у вас нет прав доступа.',
	'err_post' => 'Сообщение неизвестно.',
	'err_parentid' => 'Родительский раздел неизвестен.',
	'err_groupid' => 'Группа неизвестна.',
	'err_board_perm' => 'У вас нет доступа к этому разделу.',
	'err_thread_perm' => 'У вас нет доступа к этой теме.',
	'err_post_perm' => 'Вам не разрешено читать это сообщение.',
	'err_reply_perm' => 'Вам не разрешено отвечать в этой теме. <a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'err_no_thread_allowed' => 'В этом разделе нельзя создавать темы.',
	'err_no_guest_post' => 'Гостям запрещено писать на этом форуме.',
	'err_msg_long' => 'Ваше сообщение слишком длинное. Разрешено максимум %s символов.',
	'err_msg_short' => 'Вы забыли ввести сообщение.',
	'err_descr_long' => 'Описание слишком длинное. Разрешено максимум %s символов.',
	'err_descr_short' => 'Вы забыли ввести описание.',
	'err_title_long' => 'Заголовок слишком длинный. Разрешено максимум %s символов.',
	'err_title_short' => 'Вы забыли указать заголовок.',
	'err_sig_long' => 'Подпись слишком длинная. Разрешено максимум %s символов.',
	'err_subscr_mode' => 'Неизвестный режим подписки.',
	'err_no_valid_mail' => 'У вас нет подтверждённого email для подписки на форумы.',
	'err_token' => 'Недействительный токен.',
	'err_in_mod' => 'Эта тема сейчас на модерации.',
	'err_board_locked' => 'Раздел временно заблокирован.',
	'err_no_subscr' => 'Нельзя вручную подписаться на эту тему. <a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'err_subscr' => 'Произошла ошибка. <a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'err_no_unsubscr' => 'Нельзя отписаться от этой темы. <a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'err_unsubscr' => 'Произошла ошибка. <a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'err_sub_by_global' => 'Вы подписаны на эту тему не вручную, а через глобальные флаги опций.<br/><a href="/forum/options">Используйте ForumOptions</a>, чтобы изменить флаги.',
	'err_thank_twice' => 'Вы уже благодарили за это сообщение.',
	'err_thanks_off' => 'Сейчас нельзя благодарить за сообщения.',
	'err_votes_off' => 'Голосование за сообщения форума отключено.',
	'err_better_edit' => 'Пожалуйста, отредактируйте своё сообщение и не публикуйте подряд. Вы можете включить флаг &quot;Mark-Unread&quot; при существенных изменениях.<br/><a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',

	# Messages
	'msg_posted' => 'Ваше сообщение опубликовано.<br/><a href="%s">Нажмите здесь, чтобы посмотреть</a>.',
	'msg_posted_mod' => 'Ваше сообщение опубликовано, но будет показано после проверки.<br/><a href="%s">Нажмите здесь, чтобы вернуться в раздел</a>.',
	'msg_post_edited' => 'Ваше сообщение отредактировано.<br/><a href="%s">Нажмите здесь, чтобы вернуться к сообщению</a>.',
	'msg_edited_board' => 'Раздел отредактирован.<br/><a href="%s">Нажмите здесь, чтобы вернуться в раздел</a>.',
	'msg_board_added' => 'Новый раздел успешно добавлен. <a href="%s">Перейти к разделу</a>.',
	'msg_edited_thread' => 'Тема успешно отредактирована.',
	'msg_options_changed' => 'Ваши настройки изменены.',
	'msg_thread_shown' => 'Тема одобрена и теперь отображается.',
	'msg_post_shown' => 'Сообщение одобрено и теперь отображается.',
	'msg_thread_deleted' => 'Тема удалена.',
	'msg_post_deleted' => 'Сообщение удалено.',
	'msg_board_deleted' => 'Весь раздел был удалён!',
	'msg_subscribed' => 'Вы подписались на тему и будете получать письма о новых сообщениях.<br/><a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'msg_unsubscribed' => 'Вы отписались от темы и больше не будете получать письма.<br/><a href="%s">Нажмите здесь, чтобы вернуться к теме</a>.',
	'msg_unsub_all' => 'Вы отписались от всех тем.',
	'msg_thanked_ajax' => 'Ваша благодарность записана.',
	'msg_thanked' => 'Ваша благодарность записана.<br/><a href="%s">Нажмите здесь, чтобы вернуться к сообщению</a>.',
	'msg_thread_moved' => 'Тема %s была перемещена в %s.',
	'msg_voted' => 'Спасибо за ваш голос.',
	'msg_marked_read' => 'Успешно помечено как прочитанные тем: %s.',
	# Titles
	'forum_title' => 'Форумы '.GWF_SITENAME,
	'ft_add_board' => 'Добавить новый раздел',
	'ft_add_thread' => 'Создать новую тему',
	'ft_edit_board' => 'Редактировать раздел',
	'ft_edit_thread' => 'Редактировать тему',
	'ft_options' => 'Настройки форума',
	'pt_thread' => '%2$s ['.GWF_SITENAME.']->%1$s',
	'ft_reply' => 'Ответить в теме',
	'pt_board' => '%s',
//	'pt_board' => '%s ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Быстрый поиск',
	'ft_edit_post' => 'Редактировать сообщение',
	'at_mailto' => 'Отправить EMail пользователю %s',
	'last_edit_by' => 'Последнее редактирование: %s — %s',

	# Page Info
	'pi_unread' => 'Непрочитанные темы для вас',

	# Table Headers
	'th_board' => 'Раздел',
	'th_threadcount' => 'Тем',
	'th_postcount' => 'Сообщений',
	'th_title' => 'Заголовок',
	'th_message' => 'Сообщение',
	'th_descr' => 'Описание',
	'th_thread_allowed' => 'Темы разрешены',
	'th_locked' => 'Закрыто',
	'th_smileys' => 'Отключить смайлы',
	'th_bbcode' => 'Отключить BBCode',
	'th_groupid' => 'Ограничить для группы',
	'th_board_title' => 'Название раздела',
	'th_board_descr' => 'Описание раздела',
	'th_subscr' => 'Подписка по email',
	'th_sig' => 'Ваша подпись на форуме',
	'th_guests' => 'Разрешить гостевые посты',
	'th_google' => 'Не подключать Google/Translate JS',
	'th_firstposter' => 'Создатель',
	'th_lastposter' => 'Ответ от',
	'th_firstdate' => 'Первое сообщение',
	'th_lastdate' => 'Последнее сообщение',
	'th_post_date' => 'Дата сообщения',
	'th_user_name' => 'Имя пользователя',
	'th_user_regdate' => 'Зарегистрирован',
	//'th_unread_again' => '',
	'th_sticky' => 'Прикреплено',
	'th_closed' => 'Закрыто',
	'th_merge' => 'Объединить темы',
	'th_move_board' => 'Переместить раздел',
	'th_thread_thanks' => 'Спасибо',
	'th_thread_votes_up' => 'Лайки',
	'th_thanks' => 'Thx',
	'th_votes_up' => 'Голос «за»',

	# Buttons
	'btn_add_board' => 'Создать раздел',
	'btn_rem_board' => 'Удалить раздел',
	'btn_edit_board' => 'Редактировать раздел',
	'btn_add_thread' => 'Создать тему',
	'btn_preview' => 'Предпросмотр',
	'btn_options' => 'Изменить настройки форума',
	'btn_change' => 'Изменить',
	'btn_quote' => 'Цитировать',
	'btn_reply' => 'Ответить',
	'btn_edit' => 'Редактировать',
	'btn_subscribe' => 'Подписаться',
	'btn_unsubscribe' => 'Отписаться',
	'btn_search' => 'Поиск',
	'btn_vote_up' => 'Хороший пост!',
	'btn_vote_down' => 'Плохой пост!',
	'btn_thanks' => 'Спасибо!',
	'btn_translate' => 'Google/перевод',

	# Selects
	'sel_group' => 'Выберите группу',
	'subscr_none' => 'Ничего',
	'subscr_own' => 'Где я писал',
	'subscr_all' => 'Все темы',
	# Config
	'cfg_guest_posts' => 'Разрешить гостевые посты',
	'cfg_max_descr_len' => 'Макс. длина описания',
	'cfg_max_message_len' => 'Макс. длина сообщения',
	'cfg_max_sig_len' => 'Макс. длина подписи',
	'cfg_max_title_len' => 'Макс. длина заголовка',
	'cfg_mod_guest_time' => 'Время авто-модерации',
	'cfg_num_latest_threads' => 'Кол-во последних тем',
	'cfg_num_latest_threads_pp' => 'Тем на странице истории',
	'cfg_posts_per_thread' => 'Сообщений в теме',
	'cfg_search' => 'Разрешить поиск',
	'cfg_threads_per_page' => 'Тем на раздел',
	'cfg_last_posts_reply' => 'Сколько сообщений показывать при ответе',
	'cfg_mod_sender' => 'Отправитель писем модерации',
	'cfg_mod_receiver' => 'Получатель писем модерации',
	'cfg_unread' => 'Включить непрочитанные темы',
	'cfg_gtranslate' => 'Включить Google Translate',
	'cfg_thanks' => 'Включить «Спасибо»',
	'cfg_uploads' => 'Включить вложения',
	'cfg_votes' => 'Включить голосование',
	'cfg_mail_microsleep' => 'Пауза (микросон) при отправке email',
	'cfg_subscr_sender' => 'Отправитель писем подписки',

	# show_thread.php
	'posts' => 'Сообщения',
	'online' => 'Пользователь в сети',
	'offline' => 'Пользователь не в сети',
	'registered' => 'Зарегистрирован',
	'watchers' => 'Сейчас за темой следят: %s.',
	'views' => 'Эта тема просмотрена %s раз.',

	# forum.php
	'latest_threads' => 'Последние активности',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Модерация сообщения',
	'modmail_body' =>
		'Здравствуйте, команда'.PHP_EOL.
		PHP_EOL.
		'В форумах '.GWF_SITENAME.' появилось новое сообщение или тема, требующие модерации.'.PHP_EOL.
		PHP_EOL.
		'Раздел: %s'.PHP_EOL.
		'Тема: %s'.PHP_EOL.
		'От: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Чтобы удалить сообщение, используйте ссылку:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Чтобы одобрить сообщение, используйте ссылку:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Сообщение будет автоматически показано после %s'.PHP_EOL.
		PHP_EOL.
		'С уважением,'.PHP_EOL.
		'Команда '.GWF_SITENAME.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Новое сообщение: "%s", автор %s, в %s',
	'submail_body' =>
		'Здравствуйте, %s'.PHP_EOL.
		PHP_EOL.
		'В форумах '.GWF_SITENAME.' появилось новых сообщений: %s'.PHP_EOL.
		PHP_EOL.
		'Раздел: %s'.PHP_EOL.
		'Тема: %s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'Чтобы открыть тему, перейдите по ссылке:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Чтобы отписаться от этой темы, используйте ссылку ниже:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Чтобы отписаться от всего раздела, используйте ссылку:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'С уважением,'.PHP_EOL.
		'Команда '.GWF_SITENAME.PHP_EOL,

	'submail_body_part' =>  # that`s the %s above
		'От: %s'.PHP_EOL.
		'Заголовок: %s'.PHP_EOL.
		'Сообщение:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,

	# v2.01 (last seen)
	'last_seen' => 'Последний визит: %s',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Пометить всё прочитанным',
	'msg_mark_aread' => 'Помечено как прочитанные тем: %s.',

	# v2.03 (Merge)
	'msg_merged' => 'Темы были объединены.',
	'th_viewcount' => 'Просмотры',

	# v2.04 (Polls)
	'ft_add_poll' => 'Привязать один из ваших опросов',
	'btn_assign' => 'Привязать',
	'btn_polls' => 'Опросы',
	'btn_add_poll' => 'Добавить опрос',
	'msg_poll_assigned' => 'Опрос успешно привязан.',
	'err_poll' => 'Опрос неизвестен.',
	'th_thread_pollid' => 'Ваш опрос',
	'pi_poll_add' => 'Здесь вы можете привязать опрос к своей теме или создать новый.<br/>После создания нужно снова привязать опрос к теме.',
	'sel_poll' => 'Выберите опрос',

	# v2.05 (refinish)
	'th_hidden' => 'Скрыто?',
	'th_thread_viewcount' => 'Просмотры',
	'th_unread_again' => 'Снова пометить как непрочитанное?',
	'cfg_doublepost' => 'Разрешить бамп/двойные посты?',
	'cfg_watch_timeout' => 'Считать «наблюдение за темой» в течение N секунд',
	'th_guest_view' => 'Доступно гостям?',
	'pt_history' => 'История форума — Стр. %s / %s',
	'btn_unread' => 'Новые темы',

	# v2.06 (Admin Area)
	'th_approve' => 'Одобрить',
	'th_delete' => 'Удалить',

	# v2.07 rerefinish
	'btn_pm' => 'ЛС',
	'permalink' => 'ссылка',

	# v2.08 (attachment)
	'cfg_postcount' => 'Счётчик сообщений',
	'msg_attach_added' => 'Ваше вложение загружено. <a href="%s">Вернуться к сообщению</a>.',
	'msg_attach_deleted' => 'Ваше вложение удалено. <a href="%s">Вернуться к сообщению</a>.',
	'msg_attach_edited' => 'Вложение изменено. <a href="%s">Вернуться к сообщению</a>.',
	'msg_reupload' => 'Вложение заменено.',
	'btn_add_attach' => 'Добавить вложение',
	'btn_del_attach' => 'Удалить вложение',
	'btn_edit_attach' => 'Редактировать вложение',
	'ft_add_attach' => 'Добавить вложение',
	'ft_edit_attach' => 'Редактировать вложение',
	'th_attach_file' => 'Файл',
	'th_guest_down' => 'Доступно гостям для скачивания?',
	'err_attach' => 'Неизвестное вложение.',
	'th_file_name' => 'Файл',
	'th_file_size' => 'Размер',
	'th_downloads' => 'Скачиваний',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Создавать языковые разделы',
	'lang_board_title' => 'Раздел %s',
	'lang_board_descr' => 'Для языка: %s',
	'lang_root_title' => 'Иноязычные разделы',
	'lang_root_descr' => 'Неанглоязычные разделы',
	'md_board' => 'Форумы '.GWF_SITENAME.'. %s',
	'mt_board' => GWF_SITENAME.', Форум, Гостевые посты, Альтернатива, Форум, Софт',

	# v2.10 subscribers
	'subscribers' => '%s подписались на эту тему и получают письма о новых сообщениях.',
	'th_hide_subscr' => 'Скрывать ваши подписки?',

	# v2.11 fixes11
	'txt_lastpost' => 'К последнему сообщению',
	'err_thank_self' => 'Нельзя благодарить себя.',
	'err_vote_self' => 'Нельзя голосовать за свои сообщения.',

	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'Чтобы видеть вложения, необходимо войти.',
	'msg_cleanup' => 'Удалено тем: %s и сообщений: %s, находившихся на модерации.',

	# v1.05 (subscriptions)
	'submode' => 'Ваш глобальный режим подписки: &quot;%s&quot;.',
	'submode_all' => 'Весь раздел',
	'submode_own' => 'Где вы писали',
	'submode_none' => 'Вручную',
	'subscr_boards' => 'Вы вручную подписаны на разделов: %s.',
	'subscr_threads' => 'Вы вручную подписаны на тем: %s.',
	'btn_subscriptions' => 'Управление подписками',
	'msg_subscrboard' => 'Вы вручную подписались на этот раздел и будете получать письма о новых сообщениях.<br/>Нажмите <a href="%s">здесь, чтобы вернуться в раздел</a>.',
	'msg_unsubscrboard' => 'Вы отписались от этого раздела и больше не получаете письма.<br/>Нажмите <a href="%s">здесь, чтобы вернуться к обзору подписок</a>.',

	# v1.06 (Post limits)
	'err_post_timeout' => 'Вы недавно отправляли сообщение. Пожалуйста, подождите %s.',
	'err_post_level' => 'Для отправки сообщений требуется уровень не ниже %s.',
	'cfg_post_timeout' => 'Мин. время между двумя сообщениями',
	'cfg_post_min_level' => 'Мин. уровень для отправки сообщений',

	# monnino fixes
	'btn_cleanup' => 'Очистить',
	'btn_fix_counters' => 'Исправить счётчики',
	'cfg_guest_captcha' => 'Капча для гостей?',
	'cfg_gwf2_rewrites' => 'Использовать старые правила переписывания gwf2 форума',

);

