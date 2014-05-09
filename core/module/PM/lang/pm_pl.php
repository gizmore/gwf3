<?php # PHmaster + drummachina

$lang = array(
	'hello' => 'Cześć %s',
	'sel_username' => 'Wybierz użytkownika',
	'sel_folder' => 'Wybierz folder',

	# Info
	'pt_guest' => GWF_SITENAME.' PW Gościa',
	'pi_guest' => 'Na '.GWF_SITENAME.' istnieje możliwość wysłania prywatnej wiadomości będąc niezalogowanym, jednak nie otrzymasz wiadomości zwrotnej. Taki wariant wysyłania wiadomości pozwala na szybkie zgłaszanie błędów..',
	'pi_trashcan' => 'To jest Twój PW-Kosz, nie musisz trwale usuwać wiadomości, ale możesz przechowywać je tutaj.',
	
	# Buttons
	'btn_ignore' => 'Umieść %s na liście do zignorowania',
	'btn_ignore2' => 'Ignoruj',
	'btn_save' => 'Zapisz opcje',
	'btn_create' => 'Nowe PW',
	'btn_preview' => 'Podgląd',
	'btn_send' => 'Wyślij PW',
	'btn_delete' => 'Usuń',
	'btn_restore' => 'Przywróć',
	'btn_edit' => 'Edytuj',
	'btn_autofolder' => 'Umieść w Auto Folderze',
	'btn_reply' => 'Odpowiedz',
	'btn_quote' => 'Cytuj',
	'btn_options' => 'Opcje PW',
	'btn_search' => 'Szukaj',
	'btn_trashcan' => 'Twój PW-Kosz',
	'btn_auto_folder' => 'Auto PW',

	# Errors
	'err_pm' => 'Takie PW nie istnieje.',
	'err_perm_read' => 'Nie posiadasz odpowiednich uprawnień, aby odczytać to PW.',
	'err_perm_write' => 'Nie posiadasz odpowiednich uprawnień do edytowania tego PW.',
	'err_no_title' => 'Zapomniałeś podać tytuł PW.',
	'err_title_len' => 'Twój tytuł jest za długi. Wpisz maksymalnie %s znaków.',
	'err_no_msg' => 'Nie wpisałeś treści wiadomości.',
	'err_sig_len' => 'Twój podpis jest zbyt długi. Wpisz maksymalnie %s znaków.',
	'err_msg_len' => 'Twoje PW jest zbyt długie. Wpisz maksymalnie %s znaków.',
	'err_user_no_ppm' => 'Użytkownik nie zgodził się na otrzymywanie prywatnych wiadomości.',
	'err_no_mail' => 'Nie posiadasz potwierdzonego e-maila, powiązanego z Twoim kontem.',
	'err_pmoaf' => 'Wartość dla auto-folderów jest błędna.',
	'err_limit' => 'Osiagnąłeś limit wysyłania prywatnych wiadomości. Możesz wysłać maksymalnie %s PW w czasie %s.',
	'err_ignored' => '%s umieścił Cię na liście osób ignorowanych.<br/>%s',
	'err_delete' => 'Wystąpił błąd podczas usuwania wiadomości.',
	'err_folder_exists' => 'Taki folder już istnieje.',
	'err_folder_len' => 'Nazwa folderu powinna posiadać od 1 do %s znaków.',
	'err_del_twice' => 'Usunąłeś już to PW.',
	'err_folder' => 'Folder jest nieznany.',
	'err_pm_read' => 'Twoje PW zostało już przeczytane, więc nie możesz go już edytować.',

	# Messages
	'msg_sent' => 'Twoje PW zostało pomyślnie wysłane. Wciąż możesz je edytować, dopóki nie zostanie przeczytane przez odbiorcę.',
	'msg_ignored' => 'Umieściłeś %s na liście do ignorowania.',
	'msg_unignored' => 'Usunąłeś %s z listy do ignorowania.',
	'msg_changed' => 'Twoje opcje uległy zmianie.',
	'msg_deleted' => 'Pomyślnie usunięto %s prywatnych wiadomości.',
	'msg_moved' => 'Pomyślnie przeniesiono %s prywatnych wiadomości.',
	'msg_edited' => 'Twoje PW zostało zedytowane.',
	'msg_restored' => 'Pomyślnie odzyskano %s prywatnych wiadomości.',
	'msg_auto_folder_off' => 'Nie posiadasz włączonych opcji Auto-Folderu. PW zostało zaznaczone jako przeczytane.',
	'msg_auto_folder_none' => 'Jest tylko %s wiadomości od/do tego użytkownika. Nic nie zostało przeniesione. PW zostały znaznaczone jako przeczytane.',
	'msg_auto_folder_created' => 'Utwórz folder %s.',
	'msg_auto_folder_moved' => 'Przenieś %s wiadomości do folderu %s. Wszystkie PW zostały oznaczone jako przeczytane.',
	'msg_auto_folder_done' => 'Auto-Foldery stworzone.',


	# Titles
	'ft_create' => 'Napisz do %s nowe PW',
	'ft_preview' => 'Podgląd',
	'ft_options' => 'Twoje ustawienia PW',
	'ft_ignore' => 'Umieść kogoś na liście do ignorowania',
	'ft_new_pm' => 'Napisz nowe PW',
	'ft_reply' => 'Odpowiedz do %s',
	'ft_edit' => 'Edytuj PW',
	'ft_quicksearch' => 'Szybkie wyszukiwanie',
	'ft_advsearch' => 'Zaawansowane wyszukiwanie',

	# Tooltips
	'tt_pmo_auto_folder' => 'Jeśli pojedynczy użytkownik wyśle do Ciebie taką ilość prywatnych wiadomości, zostaną one automatycznie umieszczone w folderze.',
	
	# Table Headers
	'th_pmo_options&1' => 'Wyślij do mnie e-maila, gdy pojawią się nowe PW',
	'th_pmo_options&2' => 'Pozwól wysyłać gościom PW do mnie',
	'th_pmo_auto_folder' => 'Utwórz Folder Użytkownika na n prywatnych wiadomości',
	'th_pmo_signature' => 'Twój podpis w PW',

	'th_pm_options&1' => 'Nowy',
	'th_actions' => '',
	'th_user_name' => 'Użytkownik',
	'th_pmf_name' => 'Folder',
	'th_pmf_count' => 'Ilość',
	'th_pm_id' => 'ID',
	'th_pm_to' => 'Do',
	'th_pm_from' => 'Od',
//	'th_pm_to_folder' => 'Do folderu',
//	'th_pm_from_folder' => 'z folderu',
	'th_pm_date' => 'Data',
	'th_pm_title' => 'Tytuł',
	'th_pm_message' => 'Wiadomość',
//	'th_pm_options' => 'Opcje',

	# Welcome PM
	'wpm_title' => 'Witamy na '.GWF_SITENAME,
	'wpm_message' => 
		'Drogi %s'.PHP_EOL.
		PHP_EOL.
		'Witamy na '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Mamy nadzieję, że polubisz tą stronę i znajdziesz tu masę rozrywki.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Nowe PW od %s',
	'mail_body' =>
		'Cześć %s'.PHP_EOL.
		PHP_EOL.
		'Pojawiła się nowa prywatna wiadomość na '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Od: %s'.PHP_EOL.
		'Tytuł: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Możesz szybko:'.PHP_EOL.
		'Skatalogować Wiadomość:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Usuń wiadomość:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Pozdrawiam,'.PHP_EOL.
		'Wiadomość została wysłana automatycznie przez robota '.GWF_SITENAME.PHP_EOL,
		//no sense to translate admin-config - PHmaster
	# Admin Config
	'cfg_pm_captcha' => 'Używać Captcha dla Gości?',
	'cfg_pm_causes_mail' => 'Wysłać email po nadejściu PM?',
	'cfg_pm_for_guests' => 'Pozwolić na PM dla Gości?',
	'cfg_pm_welcome' => 'Wysłać powitalną PM?',
	'cfg_pm_limit' => 'Maksymalna ilość PM w odstępie czasu',
	'cfg_pm_maxfolders' => 'Maksymalna ilość katalogów per użytkownik',
	'cfg_pm_msg_len' => 'Maksymalna długość wiadomości',
	'cfg_pm_per_page' => 'PM-ek na stronę',
	'cfg_pm_sig_len' => 'Maksymalna długość podpisu',
	'cfg_pm_title_len' => 'Maksymalna długość tematu',
	'cfg_pm_bot_uid' => 'ID użytkownika wysyłającego PM',
	'cfg_pm_sent' => 'Ilość wysłanych PM-ek',
	'cfg_pm_mail_sender' => 'Adres EMail nadawcy wiadomości dla PM',
	'cfg_pm_re' => 'Dopisać tytuł',
	'cfg_pm_limit_timeout' => 'Czasowy limit dla PM',
	'cfg_pm_fname_len' => 'Maksymalna długość nazwy dla folderu',
	
	# v2.01
	'err_ignore_admin' => 'Nie możesz umieścić Administratora na liście do ignorowania.',
	'btn_new_folder' => 'Nowy Folder',
		
	# v2.02
	'msg_mail_sent' => 'E-mail, zawierający Twoją oryginalną wiadomość został wysłany do %s .',
		
	# v2.03 SEO
	'pt_pm' => 'PM',
		
	# v2.04 fixes
	'ft_new_folder' => 'Create a new folder',

	# v2.05 (prev+next)
	'btn_prev' => 'Previous message',
	'btn_next' => 'Next message',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'The other user deleted this pm.',
	'gwf_pm_read' => 'The other user has read your pm.',
	'gwf_pm_unread' => 'The other user has not read your pm yet.',
	'gwf_pm_old' => 'This pm is old for you.',
	'gwf_pm_new' => 'New pm for you.',
	'err_bot' => 'Bots are not allowed to send messages.',

	# v2.07 (fixes)
	'err_ignore_self' => 'You can not ignore yourself.',
	'err_folder_perm' => 'This folder is not yours.',
	'msg_folder_deleted' => 'The Folder %s and %s message(s) got moved into the trashcan.',
	'cfg_pm_delete' => 'Allow to delete PM?',
	'ft_empty' => 'Empty your Trashcan',
	'msg_empty' => 'Your trashcan (%s messages) has been cleaned up.<br/>%s messages has/have been deleted from the database.<br/>%s messages are still in use by the other user and have not been deleted.',
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
	# monnino fixes
	'cfg_pm_limit_per_level' => 'PM limit per level',
	'cfg_pm_own_bot' => 'PM own bot',
	'th_reason' => 'Reason',
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);
