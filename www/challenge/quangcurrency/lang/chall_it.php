<?php
$lang = array(
	# Main Page
	'err_login' => 'Devi connetterti per poter provare a risolvere questa sfida.',
	'title' => 'Descrizione',
	'info' =>
		'La tua missione è <a href="%1$s">comprare</a> 10 oggetti, ma non hai abbastanza soldi per fare ciò.<br/>'.
		'Quando clicchi su <a href="%2$s">questo link</a> riceverai un centesimo per aver cliccato, ma puoi cliccare solo 50 volte.<br/>'.
		'Quando clicchi su <a href="%3$s">questo link</a> la sfida verrà resettata.<br/>'.
		'Visita <a href="%4$s">questa pagina per visualizzare le tua statistiche</a>.<br/><br/>'.
		'Buona fortuna.', #<br/><br/>'.
		#'<i>Note: Do not change the userid. The userid is needed because I could not call session_start() for this challenge.<br/>The userid is your wechall userid, so in theory you can check out other user`s stats or play with their accounts.</i> (will get fixed)',

	# Reset
	'reset_info' => 'Le tue statistiche sono state resettate. Prova ancora!',

	# Stats
	'stats_title' => 'Le tue statistiche',
	'stats_info' =>
		'Soldi nell\'account: %1$s<br/>'.
		'Click totali fatti: %2$s<br/>'.
		'Oggetti comprati: %3$s',

	# Buy
	'err_money' => 'Non hai abbastanza soldi nel tuo account.',
	'msg_buy' => 'Grazie per il tuo acquisto. Ora hai %1$s oggetti nel tuo portafoglio.',
	'msg_solved' => 'Come diamine...?! Come hai fatto a comprare 10 oggetti?!<br/>Comunque... hai risolto la sfida e le tue statistiche sono state resettate.',

	# Click
	'err_max_clicks' => 'Hai raggiunto il massimo numero di click possibili (%1$s). Ti preghiamo di resettare le tue statistiche.',
	'msg_click_1' => 'Validazione del click...',
	'msg_click_2' => 'Limite giornaliero ok...',
	'msg_click_3' => 'Controllo timeout...',
	'msg_clicked' => 'Grazie per il tuo click. Ti abbiamo ricompensato con %1$s centesimi!',

);
?>