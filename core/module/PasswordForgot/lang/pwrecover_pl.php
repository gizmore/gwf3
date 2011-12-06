<?php # PHmaster + drummachina

$lang = array(

	'msg_sent_mail' => 'Wysłaliśmy e-maila do %s. Prosimy zastosować się do instrukcji zawartych w wysłanej wiadomości.',
	'err_not_found' => 'Nie znaleziono takiego użytkownika. Wpisz Swój adres e-mail lub nazwę Swojego konta.',
	'err_not_same_user' => 'Nie znaleziono takiego użytkownika. Wpisz Swój adres e-mail lub nazwę Swojego konta.', 
	'err_no_mail' => 'Przykro nam, ale Twój adres e-mail nie jest połączony z Twoim kontem. :(',
	'err_pass_retype' => 'Przepisane hasło nie jest identyczne.',
	'msg_pass_changed' => 'Twoje hasło zostało zmienione.',

	'pt_request' => 'Prośba o zmianę hasła',
	'pt_change' => 'Zmień hasło',
	
	'info_request' => 'Tutaj możesz poprosić o nowe hasło dla Swojego konta.<br/>Wpisz nazwę Swojego użytkownika <b>lub</b> adres e-mail. Na Twojego e-maila przeslemy dalsze instrukcje.',
	'info_change' => 'Możesz już używać nowego hasła, %s.',

	'title_request' => 'Poproś o nowe hasło',
	'title_change' => 'Ustaw nowe hasło',

	'btn_request' => 'Prośba',
	'btn_change' => 'Zmiana',

	'th_username' => 'Użytkownik',
	'th_email' => 'E-mail',
	'th_password' => 'Nowe hasło',
	'th_password2' => 'Przepisz hasło ponownie',

	# The email
	'mail_subj' => GWF_SITENAME.': Zmiana hasła',
	'mail_body' => 
		'Drogi %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Otrzymaliśmy prośbę o zmianę hasła na stronie '.GWF_SITENAME.'.<br/>'.PHP_EOL.
		'Aby zmienić hasło kliknij w poniższy link.<br/>'.PHP_EOL.
		'Jeśli nie prosiłeś o zmianę hasła zignoruj tego e-maila bądź skontaktuj się z nami <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Z poważaniem<br/>'.PHP_EOL.
		'Zespół '.GWF_SITENAME.'.'.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'Your password is too weak. Minimum are %s chars.',
);

?>