<?php
$lang = array(
	# Page Titles
	'pt_list' => 'Sezione Download',
	'mt_list' => 'Sezione Download, Downloads, Downloads esclusivi, '.GWF_SITENAME,
	'md_list' => 'Downloads esclusivi su '.GWF_SITENAME.'.',

	# Page Info
	'pi_add' => 'Per avere un\'esperienza migliore carica prima il tuo file, che verrà salvato nella sessione. Dopodichè, modifca le opzioni.<br/>I file caricati non devono occupare più di %s.',

	# Form Titles
	'ft_add' => 'Carica un file',
	'ft_edit' => 'Modifica download',
	'ft_token' => 'Inserisci il token del download',

	# Errors
	'err_file' => 'Devi caricare un file.',
	'err_filename' => 'Il nome del file specificato è invalido. La lunghezza massima consentita è %s. Cerca di usare solo caratteri ASCII.',
	'err_level' => 'Per caricare file è necessario un livello utente >= 0.',
	'err_descr' => 'La descrizione deve avere una lunghezza compresa tra 0 e %s caratteri.',
	'err_price' => 'Il prezzo deve essere compreso tra %s e %s.',
	'err_dlid' => 'Il download non è stato trovato.',
	'err_token' => 'Il token per il download è invalido.',

	# Messages
	'prompt_download' => 'Premi Ok per scaricare il file',
	'msg_uploaded' => 'Il file è stato caricato con successo.',
	'msg_edited' => 'Il download è stato modificato con successo.',
	'msg_deleted' => 'Il download è stato cancellato con successo.',

	# Table Headers
	'th_dl_filename' => 'Nome File',
	'th_file' => 'File ',
	'th_dl_id' => 'ID ',
	'th_dl_gid' => 'Gruppo richiesto',
	'th_dl_level' => 'Livello richiesto',
	'th_dl_descr' => 'Descrizione',
	'th_dl_price' => 'Prezzo',
	'th_dl_count' => 'Downloads ',
	'th_dl_size' => 'Dimensione FIle',
	'th_user_name' => 'Caricato da',
	'th_adult' => 'Per adulti?',
	'th_huname' => 'Nascondi nome utente?',
	'th_vs_avg' => 'Vota',
	'th_dl_expires' => 'Scade il',
	'th_dl_expiretime' => 'Download valido per',
	'th_paid_download' => 'E\' necessario un pagamento per scaricare questo file',
	'th_token' => 'Token per il Download',

	# Buttons
	'btn_add' => 'Aggiungi',
	'btn_edit' => 'Modifica',
	'btn_delete' => 'Cancella',
	'btn_upload' => 'Carica',
	'btn_download' => 'Scarica',
	'btn_remove' => 'RImuovi',

	# Admin config
	'cfg_anon_downld' => 'Permetti download agli utenti non registrati',
	'cfg_anon_upload' => 'Permetti upload agli utenti non registrati',
	'cfg_user_upload' => 'Permtti upload agli utenti',
	'cfg_dl_gvotes' => 'Permetti voti agli utenti non registrati',	
	'cfg_dl_gcaptcha' => 'Captcha per upload degli utenti non registrati',	
	'cfg_dl_descr_max' => 'Lunghezza massima descrizione',
	'cfg_dl_descr_min' => 'Lunghezza minima descrizione',
	'cfg_dl_ipp' => 'Elementi per pagina',
	'cfg_dl_maxvote' => 'Voto massimo',
	'cfg_dl_minvote' => 'Voto minimo',

	# Order
	'order_title' => 'Token per il download di %s (Token: %s)',
	'order_descr' => 'Comprato il token per il download di %s. Valido per %s. Token: %s',
	'msg_purchased' => 'Il pagamento è stato ricevuto e il token per il download è stato inserito.<br/>Il suo token è \'%s\' ed è valido per %s.<br/><b>Si ricordi di salvare il token ricevuto se non ha un account su '.GWF_SITENAME.'!</b><br/>Altrimenti, segue semplicemente questo <a href="%s">link</a>.',

	# v2.01 (+col)
	'th_purchases' => 'Acquisti',

	# v2.02 Expire + finsih
	'err_dl_expire' => 'Il tempo per cui il download resterà attivo deve essere compreso tra 0 secondi and 5 anni.',
	'th_dl_expire' => 'Il download scade dopo',
	'tt_dl_expire' => 'La durata deve essere espressa come 5 secondi o 1 mese 3 giorni.',
	'th_dl_guest_view' => 'Visibile agli utenti non registrati ?',
	'tt_dl_guest_view' => 'Gli utenti non registrati potranno vedere questo download?',
	'th_dl_guest_down' => 'Scaricabile dagli utenti non registrati?',
	'tt_dl_guest_down' => 'Gli utenti non registrati potranno scaricare questo file?',
	'ft_reup' => 'Ricarica il file',
	'order_descr2' => 'Acquistato il token per il download di %s. Token: %s.',
	'msg_purchased2' => 'Il pagamento è stato ricevuto e il token per il download è stato inserito.<br/>Il suo token è \'%s\'.<br/><b>Si ricordi di salvare il token ricevuto se non ha un account su '.GWF_SITENAME.'!</b><br/>Altrimenti, segue semplicemente questo <a href="%s">link</a>.',
	'err_group' => 'E\' necessario essere nel gruppo %s per poter scaricare questo file.',
	'err_level' => 'E\' necessario un livello utente di %s per poter scaricare questo file.',
	'err_guest' => 'Gli utenti non registrati non sono autorizzati a scaricare questo file.',
	'err_adult' => 'Questo file contiene contenuti per adulti.',

	'th_dl_date' => 'Data',

	# GWF3v1.1
	'cfg_dl_min_level' => 'Livello utent minimo per caricare un file',
	'cfg_dl_moderated' => 'Richiedi moderatori per autorizzare gli upload?',
	'cfg_dl_moderators' => 'Gruppo utenti per i moderatori degli upload.',
	'th_enabled' => 'Attivato?',
	'err_disabled' => 'Questo download non è stato ancora attivato.',
	'msg_enabled' => 'Il download è stato attivato.',
	'msg_uploaded_mod' => 'Il suo file è stato caricato con successo, ma deve essere controllato prima che possa essere autorizzato.',

	'mod_mail_subj' => GWF_SITENAME.': Moderazione Upload',
	'mod_mail_body' =>
		'Cari %s'.PHP_EOL.
		PHP_EOL.
		'Un nuovo file è stato caricato su '.GWF_SITENAME.', ed esso richiede il vostro controllo.'.PHP_EOL.
		PHP_EOL.
		'Da: %s'.PHP_EOL.
		'File: %s (%s)'.PHP_EOL.
		'Mime: %s'.PHP_EOL.
		'Dimensione: %s'.PHP_EOL.
		'Descrizione: %s'.PHP_EOL.
		PHP_EOL.
		'Potete scaricare il file qui:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Potete autorizzare il download del fil qui:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Potete cancellare il file qui:'.PHP_EOL.
		'%10$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Distinti saluti'.PHP_EOL.
		'Gli script di '.GWF_SITENAME,
);
?>
