<?php
/**
 * this file is subject to change
 * do not translate!
 */
$lang = array(
	# Join_Us page
	'pt_joinus' => 'Присоединяйтесь к нам',
	'mt_joinus' => 'Присоединиться к WeChall — Рейтинг пользователей сайтов с задачами',

	'join_0_t' => 'Введение',
	'join_0_b' =>
		'Эти страницы предназначены для администраторов сайтов с челленджами. Скрипты для игроков смотрите в разделе <a href="%s">WeChall API</a>.<br/>'.
		'Если вы игрок и хотите, чтобы ваш любимый сайт добавили: <b>не пишите об этом на форумах других сайтов.</b> Свяжитесь с администраторами сайта лично.<br/>',

	'join_1_t' => 'Почему стоит присоединиться к WeChall',
	'join_1_b' =>
		'В первую очередь мы хотим соединить сайты с задачами/головоломками, а также создать для них глобальный рейтинг.<br/>'.
		'Написать два небольших скрипта — несложно, и мы не создаём большого трафика.<br/>'.
		'Если на вашем сайте есть задачки/челленджи и учёт прогресса пользователей — вам сюда.<br/>'.
		'Мы не раскрываем учётные данные пользователей, не «крадём» email и прочее. Мы бесплатный сайт, ориентированный на удовольствие от решения задач и обучение новому.',
		
	'join_2_t' => 'Как подружить другие сайты с WeChall',
	'join_2_b' =>
		'Чтобы сайт работал с нами, нам нужно с ним взаимодействовать.<br/>'.
		'В частности, нам нужен скрипт для проверки аккаунтов на вашем сайте,<br/>'.
		'а также скрипт для получения очков/статистики.<br/>'.
		'Скрипты работают по GET-запросам, значения URL-кодируются.<br/>'.
		'<i><b>Имена скриптов и переменных вы выбираете свободно.</b></i>',
	
	'join_1t' => 'Скрипт для проверки, что пользователь владеет аккаунтом на вашем сайте.',
	'join_1b' =>
		'<i>validatemail.php?username=%%USERNAME%%&amp;email=%%EMAIL%%[&amp;authkey=%%AUTHKEY%%]</i><br/>'.
		'<br/>'.
		'Скрипт должен возвращать просто «1» ИЛИ «0».<br/>'.
		'1: сочетание email/username существует.<br/>'.
		'0: сочетание не существует или неверен authkey.<br/>'.
		'<br/>'.
		'Пожалуйста, убедитесь, что пользователи могут менять email или хотя бы имеют «используемый»/существующий адрес.<br/>'.
		'Чтобы связать аккаунты с wechall, подтверждение приходит на этот email. (если тот же email уже используется у нас — письма не нужны).<br/>'.
		'Также выполняйте проверки с учётом регистра (case-sensitive), чтобы избежать возможной эксплуатации.<br/>'.
		'<br/>'.
		'hackthissite.org подсказал, что старая API была склонна к утечке приватной информации. Можно просто тестировать пользователей по email или наоборот.<br/>'.
		'Мы добавили необязательную переменную AUTHKEY, чтобы сделать API неэксплуатируемой публично.<br/>'.
		'Ключ authkey выбираете сами.<br/>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_1_1\'); return false;">Посмотреть пример реализации на PHP</a><br/>'.
		'<div id="example_1_1" class="gwf_code" style="display: %s;"><pre>'.
		'if (!isset($_GET[\'username\']) || !isset($_GET[\'email\']) || is_array($_GET[\'username\']) || is_array($_GET[\'email\']) ) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		PHP_EOL.
		'$uname = mysql_real_escape_string($_GET[\'username\']);'.PHP_EOL.
		'$email = mysql_real_escape_string($_GET[\'email\']);'.PHP_EOL.
		'$query = "SELECT 1 FROM users WHERE BINARY user_name=\'$uname\' AND BINARY user_email=\'$email\'";'.PHP_EOL.
		'if (false === ($result = mysql_query($query))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'if (false === ($row = mysql_fetch_row($result))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'die(\'1\');'.PHP_EOL.
		'</pre></div>'.
		PHP_EOL,
		
	'join_2t' => 'Скрипт, который возвращает очки пользователя на вашем сайте.',
	'join_2b' =>
		'<i>userscore.php?username=%%USERNAME%%[&amp;authkey=%%AUTHKEY%%]</i><br/>'.
		'<br/>'.
		'authkey здесь опционален. Если профили доступны публично — можете игнорировать.<br/>'.
		'<br/>'.
		'Формат вывода не важен, мы пишем парсер под каждый сайт.<br/>'.
		'Вывод должен содержать минимум userscore и maxscore. Например, «userscore:maxscore».<br/>'.
		'Можно и так: «username has solved solved of total and is rank rank of usercount»<br/>'.
		'(см. пункт 5)<br/>'.
		'<br/>'.
		'WeChall также может обновлять количество пользователей и задач через этот скрипт.'.
		'<br/><b>Идеальный вывод: username:rank:score:maxscore:challssolved:challcount:usercount</b><br/>'.
		'<br/>'.PHP_EOL.
		'<a href="%s" onclick="toggleHidden(\'example_2_1\'); return false;">Посмотреть пример реализации на PHP</a><br/>'.
		'<div id="example_2_1" class="gwf_code" style="display: %s;"><pre>'.
		'# return username:rank:score:maxscore:challssolved:challcount:usercount'.PHP_EOL.
		'# but wechall can handle any output you like.'.PHP_EOL.
		'if (!isset($_GET[\'username\']) || is_array($_GET[\'username\']) ) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'# Let`s see if user exists.'.PHP_EOL.
		'$uname = mysql_real_escape_string($_GET[\'username\']);'.PHP_EOL.
		'$query = "SELECT * FROM users WHERE BINARY user_name="$uname";'.PHP_EOL.
		'if (false === ($result = mysql_query($query))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'if (false === ($userrow = mysql_fetch_row($result))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		PHP_EOL.
		'# Now calculate the userscore and stuff for the user.'.PHP_EOL.
		'# This is pseudocode, as the data you calculate or get very depends on your site.'.PHP_EOL.
		'$rank = mysite_calc_rank($userrow);'.PHP_EOL.
		'$score = mysite_calc_score_for_user($userrow);'.PHP_EOL.
		'$maxscore = mysite_get_maxscore();'.PHP_EOL.
		'$challsolved = mysite_calc_num_challs_solved($userrow);'.PHP_EOL.
		'$challcount = mysite_get_challcount();'.PHP_EOL.
		'$usercount = mysite_get_usercount();'.PHP_EOL.
		PHP_EOL.
		'# Now output the data.'.PHP_EOL.
		'die(sprintf(\'%%s:%%d:%%d:%%d:%%d:%%d:%%d\', $_GET[\'username\'), $rank, $score, $maxscore, $challsolved, $challcount, $usercount));'.PHP_EOL.
		'</pre></div>'.
		PHP_EOL,
		
	'join_3t' => 'Иконка и описания',
	'join_3b' =>
		'<ul>'.PHP_EOL.
		'<li>Иконка 32×32, предпочтительно прозрачный GIF.</li>'.PHP_EOL.
		'<li>Описание вашего сайта, можно на основном языке сайта.</li>'.PHP_EOL.
		'<li>Желаемое отображаемое имя сайта. Его же используйте для remoteupdate.php</li>'.PHP_EOL.
		'</ul>',
	
	'join_4t' => '[ОПЦИОНАЛЬНО] Страница с профилем пользователя на вашем сайте.',
	'join_4b' =>
		'<i>profile.php?username=%%USERNAME%%</i><br/>'.
		'<br/>'.
		'Это опционально и относится скорее к вашему сайту — показывает (полный) профиль пользователя.<br/>'.
		'Если хотите поддержать нас этим скриптом — сделайте его доступным без входа в систему.<br/>'.
		'Снова: имя файла и набор параметров — любые.<br/>'.
		'Скрипты профиля вида <i>profile/%%USERNAME%%.html</i> тоже подходят.',
		
	'join_process_t' => 'Процесс присоединения',
	'join_process_b' =>
		'<p>Здесь описаны обычные шаги, когда ваш сайт (вы — админ) присоединяется.</p>'.
		'<br/><pre>'.PHP_EOL.
		'1. Обычно вы начинаете «тайно» писать скрипты validate и userscore API.'.PHP_EOL.
		'2. Затем просите добавить ваш сайт с челленджами.'.PHP_EOL.
		'   Да, сарказм уместен: этот раздел сокращает время вашего вступления.'.PHP_EOL.
		'   Также хочу отметить, что каждый сайт — отличное пополнение сцены. Респект и спасибо всем создателям!'.PHP_EOL.
		'3. Мы проверяем входные данные и скрипты, тестируем и даём обратную связь.'.PHP_EOL.
		'3a) Для этого нам нужны ваши эндпоинты validate- и userscore-скриптов, т.к. имена вы выбираете сами.'.PHP_EOL.
		'3b) Обычно вы игнорируете нашу просьбу об иконке. 32x32.transparent.gif предпочтительно, но подойдёт любой формат, даже анимированный ico.'.PHP_EOL.
		'3c) Также можно выбрать отображаемое имя сайта, например ´ChillChalls`.'.PHP_EOL.
		'3d) Через пару дней становится ясно, что нужны и основные категории задач вашего сайта. Сообщите 2–4 _основные_ категории.'.PHP_EOL.
		'3e) Мы также забываем про «день рождения» сайта, страну авторов и прочие настройки.'.PHP_EOL.
		'4) Мы протестировали сайт и процесс линковки. Почти готовы объявить официально...'.PHP_EOL.
		'4a) Мы пишем новость каждый раз, когда сайт присоединяется — краткий обзор и фоновые сведения.'.PHP_EOL.
		'4a.1) Лично мне интересно, кто, когда и зачем основал сайт. Есть ли что-то особенное, чем хотите поделиться?'.PHP_EOL.
		'      Вы как админ сможете вычитать новость и внести правки/дополнения.'.PHP_EOL.
		'      Что рассказывать — полностью на ваше усмотрение и в духе вашего проекта.'.PHP_EOL.
		'4b) Хорошо, когда с админом сайта легко связаться через wechall. Было бы здорово, если бы вы...'.PHP_EOL.
		'4b.1) Зарегистрировались на wechall и получили права site-admin для своего сайта. Укажите email, который читаете время от времени.'.PHP_EOL.
		'      Возможны несколько site-admin\'ов.'.PHP_EOL.
		'4b.2) Включили для учётки wechall: EmailOnPM, PublicEmail и ShowEmailAddress.'.PHP_EOL.
		'4b.3) Подписались на тему «Comments on &lt;YourSite&gt;», чтобы получать письма о новых комментариях на форуме.'.PHP_EOL.
		'5) Редактирование карточки сайта'.PHP_EOL.
		'5a) Возможно, у сайта есть IRC-канал — укажите его при редактировании.'.PHP_EOL.
		'5b) Не забудьте описание сайта. Можно сделать переводы на несколько языков.'.PHP_EOL.
		'5c) Станьте первым, кто оставит комментарий о вашем сайте на форуме :)'.PHP_EOL.
		'5d) Если у вас есть собственная страница профиля игроков — укажите её!'.PHP_EOL.
		'6) Больше интеграции'.PHP_EOL.
		'6a) Посмотрите <a href="%s">join_advanced</a> — описание API для более автоматизированного взаимодействия:'.PHP_EOL.
		'6a.1) IRC-анонсы форумных постов о вашем сайте.'.PHP_EOL.
		'6a.2) IRC-анонсы при решении задач на вашем сайте.'.PHP_EOL.
		'6a.3) Автообновления для пользователей, связавших аккаунты.'.PHP_EOL.
		'6a.4) И многое другое?'.PHP_EOL.
		PHP_EOL.
		'Спасибо, что летаете IPv(?:4|6)'.PHP_EOL.
		'</pre>'.PHP_EOL,
		
	'join_5t' => '[ОПЦИОНАЛЬНО] Автообновление WeChall',
	'join_5b' =>
		'Есть два способа автоматически обновлять очки ваших пользователей на WeChall:<br/>'.
		'<br/>'.
		'- Первый: ваше приложение делает запрос на<br/>'.
		'<i>http://www.wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%</i><br/>'.
		'каждый раз, когда пользователь решает задачу.<br/>'.
		'Скрипт вернёт текст с результатом операции.<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_5_1\'); return false;">Пример кода</a><br/>'.
		'<div id="example_5_1" style="display: %s;">'.
		'Example: <br/>'.
		'<br/>'.
		'<div class="gwf_code">'.
			'echo \'&lt;a href=&quot;http://www.wechall.net&quot;&gt;WeChall&lt;/a&gt; reports: \';<br/>'.
			'echo file_get_contents(&quot;http://wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%&quot;);<br/>'.
		'</div>'.
		'<br/>'.
		'or<br/>'.
		'<br/>'.
		'<div class="gwf_code">'.
			'echo \'&lt;a href=&quot;http://www.wechall.net&quot;&gt;WeChall&lt;/a&gt; reports: \';<br/>'.
			'$ch = curl_init();<br/>'.
			'curl_setopt($ch, CURLOPT_URL, &quot;http://www.wechall.net/remoteupdate.php?sitename=<b>%%SITENAME%%</b>&amp;username=<b>%%USERNAME%%</b>&quot;);<br/>'.
			'curl_setopt($ch, CURLOPT_HEADER, 0);<br/>'.
			'curl_exec($ch);<br/>'.
			'curl_close($ch);<br/>'.
		'</div>'.
		'<br/>'.
		'</div>'.
		'<br/>'.
		'- Второй: вставить картинку на страницу, которую видит пользователь после решения задачи.<br/>'.
		'<i>http://www.wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%&amp;img=1</i><br/>'.
		'Этот вариант вернёт картинку с результатом операции.<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_5_2\'); return false;">Пример кода</a><br/>'.
		'<div id="example_5_2" style="display: %s;">'.
		'Example:<br/>'.
		'<div class="gwf_code">'.
			'&lt;a href=&quot;http://www.wechall.net&quot;&gt;&lt;img src=&quot;http://www.wechall.net/remoteupdate.php?sitename=<b>%%SITENAME%%</b>&amp;username=<b>%%USERNAME%%</b>&amp;img=1&quot; alt=&quot;http://www.wechall.net&quot; border=0/&gt;&lt;/a&gt;<br/>'.
		'</div>'.
		'<br/>'.
		'</div>'.
		'<br/>'.
		'Если сделать так, пользователям не придётся периодически ходить на ваш сайт для обновления статистики на wechall. Мгновенные апдейты также помогают лучше ловить читеров.<br/>'.
		'<br/>'.
		'Кстати, вывод можно не показывать пользователю — просто выбрасывайте его. В варианте с картинкой её можно скрыть и сделать размер 1×1.',
	
	'join_6t' => '[ОПЦИОНАЛЬНО] Взаимодействие с Pipsqueek-IRC-ботом',
	'join_6b' => 
		'Скрипт, возвращающий статус пользователя в виде одной текстовой строки. Мы используем этого бота на irc.idlemonkeys.net.<br/>'.
		'Content-Type должен быть text/plain, вывод — одна строка не длиннее 192 символов.<br/>'.
		'Скрипт вызывается как yourscript.foo?username=%%USERNAME%%. Обратите внимание, имя GET-параметра username фиксированное.<br/>'.
		'Бонус: если username — целое число, скрипт может показывать статус для ранга №N.<br/>',
		
	'join_7t' => '[ОПЦИОНАЛЬНО] Скрипт, который пушит последние темы форума.',
	'join_7b' =>
		'<i>forum_news.php?datestamp=%%NOW%%&amp;limit=%%LIMIT%%</i><br/>'.
		'<br/>'.
		'Ваш скрипт должен выводить последние N тем форума, не старше указанного datestamp.<br/>'.
		'Формат datestamp: YYYYmmddhhiiss.<br/>'.
		'Запрос должен сортироваться по thread_lastpostdate DESC.<br/>'.
		'Выводите результат в обратном порядке.<br/>'.
		'Экранируйте : как \\: и \\n как \\\\n.<br/>'.
		'Колонки: threadid::datestamp::boardid::url::nickname::threadname<br/>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_7_1\'); return false;">Пример на стороне сервера</a><br/>'.
		'<pre class="gwf_code" style="display: %s;" id="example_7_1">'.
		'%s'.
		'</pre>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_7_2\'); return false;">Пример на стороне клиента</a><br/>'.
		'<pre class="gwf_code" style="display: %s;" id="example_7_2">'.
		'%s'.
		'</pre>'.
		'<br/>'.
		'Если хотите, я могу реализовать для вас этот скрипт, если вы используете известный движок форума (например phpbb).'.
		'У нас уже есть несколько скриптов для популярных форумных движков.'.
		'Посмотреть можно в <a href="%s">репозитории кода gwf3</a>.',
		
	'api_1t' => 'Опрашивать последнюю активность на форуме',
	'api_1b' =>
		'WeChall реализует <a href="%s">опциональный скрипт 7</a>.<br/>'.
		'Чтобы опросить последнюю форумную активность, используйте:<br/>'.
		'<br/>'.
		'<i><a href="https://www.wechall.net/nimda_forum.php?datestamp=20091231232359&amp;limit=10">https://www.wechall.net/nimda_forum.php?datestamp=20091231232359&amp;limit=10</a></i><br/>'.
		'<br/>'.
		'Формат вывода описан в <a href="%s">документации к опциональному присоединению</a>.',
	
	'api_2t' => 'Опрашивать статистику пользователя',
	'api_2b' =>
		'WeChall реализует расширенную версию <a href="%s">опционального скрипта 6</a>.<br/>'.
		'Вы можете использовать его для своих нужд.<br/>'.
		'<br/>'.
		'Использование:<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Выведет общий рейтинг пользователя на wechall. Параметр: username=&lt;username&gt;<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Даст обзор всех сайтов, с которыми связан пользователь. Параметр: username=!sites &lt;username&gt;<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Даст обзор по одному конкретному сайту. Параметр: username="!&lt;site&gt; &lt;username&gt;"<br/>'.
		'<br/>'.
		'Чтобы посмотреть все возможные сайты, используйте <a href="%s">%s</a>.<br/>',
		
	'api_3t' => 'Опрашивать последнюю активность',
	'api_3b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'Можно получать последнюю активность в машинно-читаемом формате этим скриптом.<br/>'.
		'Использование: %s<br/>'.
		'<br/>'.
		'Параметры:<br/>'.
		'- datestamp [YYYYmmddhhiiss]: только сообщения >= этой метки.<br/>'.
		'- username [WeChall Username]: только для одного пользователя.<br/>'.
		'- sitename [Site-name/classname]: только для одного сайта.<br/>'.
		'- limit [max results]: ограничить количество результатов.<br/>'.
		'- masterkey [NoLimit]: поднять лимит количества строк.<br/>'.
		'- password [No Api Override for user]: приватный API-пароль при запросе одного пользователя.<br/>'.
		'- no_session [Mandatory]: обязательно добавляйте no_session=1.<br/>'.
		'<br/>'.
		'Формат вывода — «почти CSV».<br/>'.
		'Разделитель колонок — ::, строк — \\n.<br/>'.
		'Символ : экранируется как \\:, а \\n — как \\\\n.<br/>'.
		'Колонки вывода:<br/>'.
		'EventDatestamp::EventType::<br/>'.
		'WeChallUsername::Sitename::<br/>'.
		'OnSiteName::OnSiteRank::OnSiteScore::MaxOnSiteScore::OnSitePercent::GainOnsitePercent::<br/>'.
		'Totalscore::GainTotalscore<br/>'.
		'- EventDatestamp [YYYYmmddhhiiss]<br/>'.
		'- EventType [одно из %s]<br/>'.
		'- WeChallUsername [имя пользователя на WeChall]<br/>'.
		'- Sitename [имя или сокращение сайта в WeChall]<br/>'.
		'- OnSiteName [ник на сайте]<br/>'.
		'- OnSiteRank [ранг на сайте после обновления]<br/>'.
		'- OnSiteScore [очки на сайте после обновления]<br/>'.
		'- MaxOnSiteScore [максимально возможные очки на сайте]<br/>'.
		'- OnSitePercent [процент решений на сайте после обновления]<br/>'.
		'- GainOnSitePercent [прирост процента из-за обновления]<br/>'.
		'- Totalscore [итоговый счёт WeChall после обновления]<br/>'.
		'- GainTotalscore [прирост/убыль итогового счёта WeChall за обновление]<br/>'.
		'<br/>'.
		'Примеры:<br/>'.
		'%s<br/>'.
		'<br/>'.
		'Игроки могут исключить себя из API-вызовов.<br/>'.
		'Также игроки могут скрывать свой ник на сайтах и даты событий разными настройками.<br/>'.
		'Учтите: можно запросить только последние 20 активностей одного пользователя, или 50 — общей активности.<br/>'.
		'Если нужно выгрузить всё или старые данные — понадобится masterkey, который выдаётся админам сайтов по запросу.',
	
	# v4.04
	'join_summary' => 'Скрипты для взаимодействия',
	'join_summary_opt' => 'Опциональные скрипты для расширенного взаимодействия',
		
	# v4.05
	'btn_join' => 'Базовое подключение',
	'btn_join_opt' => 'Расширенное подключение',
	'btn_api' => 'WeChall API',
		
	# v4.06
	'api_4t' => 'Пользовательское API',
	'api_4b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'Вы можете опрашивать UserAPI, чтобы получать сведения о пользователе в машинно-читаемом формате.<br/>'.
		'Если укажете свой приватный API-пароль, результат также включит счётчик новых связей, непрочитанных ЛС и тем на форуме.<br/>'.
		'Формат вывода — несколько строк пар «ключ:значение».<br/>'.
		'<br/>'.
		'Примеры:<br/>'.
		'%s<br/>'.
		'%s<br/>',
	
	'api_5t' => 'Site API и шорткаты',
	'api_5b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'Можно опрашивать базу сайтов через это API и получать данные в машинно-читаемом формате.<br/>'.
		'Формат снова CSV-подобный: разделитель колонок ::, строк — \\n. Символ : экранируется как \\:, а \\n — как \\\\n<br/>'.
		'Колонки вывода:<br/>'.
		'Sitename::Classname::Status::URL::ProfileURL::Usercount::Linkcount::Challcount::Basescore::Average::Score<br/>'.
		'<br/>'.
		'Примеры:<br/>'.
		'%s<br/>'.
		'%s<br/>',
		
	# v5.02 (EPOCH WARBOX)
	'btn_join_war' => 'Подключить Warbox',
	'war_1t' => 'Warbox API и инструкция',
	'war_1b' =>
		'Эти страницы для администраторов &quot;Warbox&quot;.<br/>'.
		'Warbox — это компьютер с хакерскими задачами, который не ведёт учёт пользователей и их прогресса.<br/><br/>'.
		'Если вы админ Warbox, добавить его в WeChall ещё никогда не было так просто.<br/><br/>'.
		'Вам нужно, чтобы на коробке работал identd на порту ниже %2$s и был доступен с %1$s.<br/>'.
		'Также коробка должна уметь подключаться к %1$s на порт %2$s.<br/>',
		
	'war_4t' => 'Как это работает?',
	'war_4b' =>
		'Когда пользователь выполняет команду netcat (nc) с вашей коробки, identd безопасно сообщает сервису на порту %2$s, какой уровень на вашей коробке отправил команду.<br/>'.
		'Поскольку пользователь также отправляет уникальный Warbox-токен, сервис на %1$s может учитывать его прогресс.<br/>'.
		'Пользователи затем связывают ваш Warbox как обычный сайт через %1$s, выступающий как прокси данных.<br/>'.
		'<br/>'.
		'Добавление нового сайта также требует выбора корректного отображаемого имени, хоста и других настроек вручную.<br/>'.
		'Пришлите нам email с нужной информацией, чтобы мы добавили вашу коробку в wechall.<br/>'.
		'<br/>'.
		'<i>Поблагодарим <a href="/profile/epoch_qwert">epoch_qwert</a> за эту замечательную идею и реализацию!</i>',
		
	'war_2t' => 'Настройка identd',
	'war_2b' => 'Примеры установки identd можно найти здесь.',
	'war_2b_os' => array(
		'gentoo' =>
			'<pre>'.
			"su\n".
			"emerge -av oidentd\n".
			"/etc/init.d/oidentd start\n".
			"rc-update add oidentd default\n".
			'</pre>'.PHP_EOL,
// 		'windows' =>
// 			'Test',
	),
	
	'war_3t' => 'Настройка iptables',
	'war_3b' =>
		"<pre>".
		"<b>Разрешить входящие 113 от %1\$s</b>\n".
		"<i>iptables -I INPUT -p tcp -m tcp --dport 113 -s %1\$s -j ACCEPT</i>\n".
		"\n".
		"<b>Разрешить исходящие на %1\$s порт %2\$s</b>\n".
		"<i>iptables -I OUTPUT -p tcp -m tcp --dport %2\$s -d %1\$s -j ACCEPT</i>\n",
);

