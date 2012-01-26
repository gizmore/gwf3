<?php

$lang = array(

	# Titles
	'ft_search' => 'Cerca nel database degli ordini',

	# Admin Config
	'cfg_donations' => 'Accetta donazioni?',
	'cfg_global_fee_buy' => 'Commissione d\'acquisto globale',
	'cfg_global_fee_sell' => 'Commissione di vendita globale',
	'cfg_local_fee_buy' => 'Commissione d\'acquisto locale',
	'cfg_local_fee_sell' => 'Commissione di vendita locale',
	'cfg_orders_per_page' => 'Ordini per pagina',
	'cfg_currency' => 'Moneta del negozio',
	'cfg_currencies' => 'Monete accettate',

	# Tooltips
	'tt_currency' => 'Codice ISO di 3 lettere maiuscole',

	# Errors
	'err_country' => 'La sua nazione non è supportata da %s.',
	'err_currency' => 'Questa moneta non è supportata da %s.',
	'err_can_order' => 'Non è autorizzato ad effettuare questo ordine.',
	'err_paysite' => 'Questo Processore di Pagamento (Payment Processor) è sconosciuto.',
	'err_order' => 'L\'ordine non è stato trovato.',
	'err_token' => 'Il suo toekn per '.GWF_SITENAME.' è invalido.',
	'err_xtoken' => 'Il suo token per %s è invalido.',
	'err_crit' => 'Si è verificato un errore durante l\'esecuzione dell\'ordine.<br/>La preghiamo di contattare l\'amministratore del sito e comunicare il token del suo ordine: %s.',

	# Messages
	'msg_paid' => 'Grazie per il suo acquisto. Il suo ordine è stato eseguito con successo.',
	'msg_executed' => 'L\'ordine è stato eseguito manualmente.',
	
	# Buttons
	'btn_show_cart' => 'Vai al Carrello',
	'btn_add_to_cart' => 'Aggiungi al Carrello',
	'btn_execute' => 'Esegui',

	# Table Headers
	'th_price' => 'Prezzo',
	'th_fee_per' => 'Tasse/Commissioni',
	'th_price_total' => '<b>Totale</b>',
	'th_order_id' => 'ID ',
	'th_user_name' => 'Nome utente',
	'th_order_price' => 'Prezzo',
	'th_order_price_total' => 'Prezzo',
	'th_order_site' => 'Sito per il pagamento',
	'th_order_email' => 'E-Mail per il pagamento',
	'th_order_descr_admin' => 'Descrizione',
	'th_order_date_ordered' => 'Ordinato il',
	'th_order_status' => 'Stato',
	'th_order_date_paid' => 'Pagato il',
	'th_order_token' => 'Token ',

	# Status
	'status_created' => 'Creato',
	'status_ordered' => 'Ordinato',
	'status_paid' => 'Pagato',
	'status_processed' => 'Processato',

	# Info
	'payment_info' => 'Ogni processore di pagamento (Payment Processor) può avere le proprie tasse/commissioni.<br/>Se sceglie PayPal, deve confermare il pagamento qui prima che ogni transazione venga effettuata.',

	# Fixes
	'msg_pending' => 'La sua transazione è in sospeso. Riceverà una E-Mail con le istruzioni, quando il pagamento verrà perfezionato.',

	'err_already_done' => 'Il suo ordine è già stato eseguito.',
);

?>