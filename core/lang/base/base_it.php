<?php
$lang = array(

	'ERR_DATABASE' => 'Errore database nel file %s alla linea %s.',
	'ERR_FILE_NOT_FOUND' => 'File non trovato: %s',
	'ERR_MODULE_DISABLED' => 'Il modulo %s è attualmente disabilitato.',
	'ERR_LOGIN_REQUIRED' => 'Per questa funzione deve essere connesso.',
	'ERR_NO_PERMISSION' => 'Permesso negato.',
	'ERR_WRONG_CAPTCHA' => 'Deve digitare le lettere nell\'immagine correttamente.',
	'ERR_MODULE_MISSING' => 'Il modulo %s non è stato trovato.',
	'ERR_COOKIES_REQUIRED' => 'La sua sessione è scaduta è deve abilitare i Cookies nel suo browser.<br/>Provi ad aggiornare la pagina.',
	'ERR_UNKNOWN_USER' => 'L\'utente è sconosciuto.',
	'ERR_UNKNOWN_GROUP' => 'Il gruppo è sconosciuto.',
	'ERR_UNKNOWN_COUNTRY' => 'La nazione è sconosciuta.',
	'ERR_UNKNOWN_LANGUAGE' => 'La lingua è sconosciuta.',
	'ERR_METHOD_MISSING' => 'Metodo sconosciuto: %s nel modulo %s.',
	'ERR_GENERAL' => 'Errore indefinito in %s Linea %s.',
	'ERR_WRITE_FILE' => 'Non è stato possibile salvare il file: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Classe sconosciuta: %s.',
	'ERR_MISSING_VAR' => 'Variabile HTTP Post mancante: %s.',
	'ERR_MISSING_UPLOAD' => 'Deve caricare un file.',
	'ERR_MAIL_SENT' => 'E\' accaduto un errore durante l\'invio di una E-Mail.',
	'ERR_CSRF' => 'Il token del form è invalido. Forse ha postato due volte con lo stesso token, o la sua sessione è scaduta nel frattempo.',
	'ERR_HOOK' => 'Un Hook ha sollevato un errore: %s.',
	'ERR_PARAMETER' => 'Argomento invalido in %s alla linea %s. L\'argomento della funzione %s è invalido.',
	'ERR_DEPENDENCY' => 'Dipendenza non risolta: core/module/%s/method/%s richiede il Modulo %s v%s.',
	'ERR_SEARCH_TERM' => 'Il termine di ricerca deve essere compreso tra %s e %s caratteri.',
	'ERR_SEARCH_NO_MATCH' => 'La sua ricerca per &quot;%s&quot; non ha trovato riscontri.',
	'ERR_POST_VAR' => 'Variabile POST inaspettata: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Il file caricato contiene &quot;&lt;?&quot; che è considerato insicuro e quindi non è permesso.',

	# GWF_Time
	'unit_sec_s' => 's ',
	'unit_min_s' => 'min',
	'unit_hour_s' => 'ore',
	'unit_day_s' => 'gg',
	'unit_month_s' => 'M ',
	'unit_year_s' => 'a',

	'M1' => 'Gennaio',
	'M2' => 'Febbraio',
	'M3' => 'Marzo',
	'M4' => 'Aprile',
	'M5' => 'Maggio',
	'M6' => 'Giugno',
	'M7' => 'Luglio',
	'M8' => 'Agosto',
	'M9' => 'Settembre',
	'M10' => 'Ottobre',
	'M11' => 'Novembre',
	'M12' => 'Dicembre',

	'm1' => 'Gen',
	'm2' => 'Feb ',
	'm3' => 'Mar ',
	'm4' => 'Apr ',
	'm5' => 'Mag',
	'm6' => 'Giu',
	'm7' => 'Lug',
	'm8' => 'Ago',
	'm9' => 'Set',
	'm10' => 'Ott',
	'm11' => 'Nov ',
	'm12' => 'Dic',

	'D0' => 'Domenica',
	'D1' => 'Lunedì',
	'D2' => 'Martedì',
	'D3' => 'Mercoledì',
	'D4' => 'Giovedì',
	'D5' => 'Venerdì',
	'D6' => 'Sabato',

	'd0' => 'Dom',
	'd1' => 'Lun',
	'd2' => 'Mar',
	'd3' => 'Mer',
	'd4' => 'Gio',
	'd5' => 'Ven',
	'd6' => 'Sab',

	'ago_s' => '%s secondi fa',
	'ago_m' => '%s minuti fa',
	'ago_h' => '%s ore fa',
	'ago_d' => '%s giorni fa',

	###
	### TODO: GWF_DateFormat, is problematic, because en != en [us/gb]
	###
	### Here you have to specify how a default dateformats looks for different languages.
	### You have the following substitutes:
	### Year:   Y=1990, y=90
	### Month:  m=01,   n=1,  M=January, N=Jan
	### Day:    d=01,   j=1,  l=Tuesday, D=Tue
	### Hour:   H:23    h=11
	### Minute: i:59
	### Second: s:59
	'df4' => ' Y', # 2009
	'df6' => ' M Y', # January 2009
	'df8' => 'D, j N, Y', # Tue, Jan 9, 2009
	'df10' => 'd N Y - H:00', # Jan 09, 2009 - 23:00
	'df12' => 'd N Y - H:i',  # Jan 09, 2009 - 23:59
	'df14' => 'd N Y - H:i:s',# Jan 09, 2009 - 23:59:59

	# The data from the 5 sections above, merged for faster access.
	'datecache' => array(
		array('Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'),
		array('Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'),
		array('Dom','Lun','Mar','Mer','Gio','Ven','Sab'),
		array('Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'),
		array(4=>'Y', 6=>'M Y', 8=>'D, j N Y', 10=>'d N Y - H:00', 12=>'d N Y - H:i', 14=>'d N Y - H:i:s'),
	),


	# GWF_Form
	'th_captcha1' => '<a href="http://it.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Scriva le cinque lettere presenti nell\'immagine',
	'tt_password' => 'La password deve essere lunga almeno 8 caratteri.',
	'tt_captcha1' => 'Clicca sull\'immagine per richiederne una nuova.',
	'tt_captcha2' => 'Riscriva le lettere dell\'immagine per provare che è un umano.',

	# GWF_Category
	'no_category' => 'Tutte le categorie',
	'sel_category' => 'Seleziona una categoria',

	# GWF_Language
	'sel_language' => 'Seleziona un linguaggio',
	'unknown_lang' => 'Linguaggio sconosciuto',

	# GWF_Country
	'sel_country' => 'Seleziona una nazione',
	'unknown_country' => 'Nazione sconosciuta',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Maschio',
	'gender_female' => 'Femmina',
	'gender_no_gender' => 'Sesso sconosciuto',

	# GWF_User#avatar
	'alt_avatar' => 'Avatar di %s',

	# GWF_Group
	'sel_group' => 'Seleziona un gruppo utente',

	# Date select
	'sel_year' => 'Seleziona anno',
	'sel_month' => 'Seleziona mese',
	'sel_day' => 'Seleziona giorno',
	'sel_older' => 'Più vecchio di',
	'sel_younger' => 'Più giovane di',

	### General Bits! ###
	'guest' => 'Utente non registrato',
	'unknown' => 'Sconosciuto',
	'never' => 'Mai',
	'search' => 'Ricerca',
	'term' => 'Termine',
	'by' => 'da',
	'and' => 'e',

	'alt_flag' => 'Flag di %s',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. Tutti i diritti riservati.',
	'copygwf' => GWF_SITENAME.' usa <a href="http://gwf.gizmore.org">GWF</a>, il Framework di Siti Web simil-BSD.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s significa obbligatorio.',

	# v2.03 BBCode
	'bbhelp_b' => 'grassetto',
	'bbhelp_i' => 'corsivo',
	'bbhelp_u' => 'sottolineato',
	'bbhelp_code' => 'Il suo codice va qui',
	'bbhelp_quote' => 'Questo testo è una citazione',
	'bbhelp_url' => 'Collega testo',
	'bbhelp_email' => 'Campo per link E-Mail',
	'bbhelp_noparse' => 'Disabilita decodifica BB-code.',
	'bbhelp_level' => 'Il testo richiede un livello utente minimo per essere visualizzato.',
	'bbhelp_spoiler' => 'Testo invisibile che verrà visualizzato con un click.',

	# v2.04 BBCode3
	'quote_from' => 'Citazione da %s',
	'code' => 'codice',
	'for' => 'per',

	# 2.05 Bits
	'yes' => 'Si',
	'no' => 'No ',
	
	# 2.06 spoiler
	'bbspoiler_info' => 'Clicca per visualizzare lo spoiler',
	
	# 3.00 Filesize
	'filesize' => array('B ','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'E\' richiesto un livello utente di %s per visualizzare questi contenuti.',
);
?>