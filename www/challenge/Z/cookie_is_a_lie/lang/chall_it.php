<?php
$lang = array(
	'index_info' => 
		'Tu, Chell vuoi distruggere GLaDOS. Per questa missione dovrai rubare il cookie da GLaDOS per ottenere l\'accesso al mainframe nel Centro di Arricchimento. Se puoi accedere al mainframe, puoi spegnere GLaDOS e sarai recuperato.<br/>'.
		'<br/>'.
		'Hai trovato il sorgente di una Web Application, vulnerabile a SQL injection e attacchi XSS. Questa Web Application gira sul <a href="%1$s">mainframe (accessibile solo dalla rete interna).</a> <a href="%2$s"> Qui puoi scaricare il codice sorgente.</a><br/>'.
		'<br/>'.
		'La brutta notiza è che non puoi accedere al mainframe senza il cookie, solo GLaDOS può. Un\'altra brutta notizia è che l\'utente www-user ha solo il permesso di lettura su database del mainframe e non è possibile eseguire più query con la stessa richiesta.<br/>'.
		'<br/>'.
		'Hai letto i protocolli e, secondi questi ultimi, se GLaDOS riceve una nuova E-Mail con un id in essa, GLaDOS visiterà la web application d\'esperienza anzidetta, inserirà l\'id e cliccherà sul primo link per acquisire informazioni relative al nuovo soggetto d\'esperienza.<br/>'.
		'<br/>'.
		'Durente la tua missione hai ottenuto l\'accesso ad un webserver di prova e installato un file php, a cui si può accedere, tramite la rete locale, tramite questo link:<br/>'.
		'<i>http://test.cake/steal_cookie.php</i><br/>'.
		'<a href="%3$s">Questo file php</a> può ricevere il paramtero GET "cookie" e salvare il suo valore in un file, accessibile anche a te.<br/>'.
		'<br/>'.
		'La tua missione è quella di mandare un id speciale a <a href="%4$s">GLaDOS</a>, per rubare il valore del cookie.<br/>'.
		'(*scrivi a Z un PM con il titolo della sfida come oggetto)<br/>'.
		'Dopo aver sfruttato con successo l\'applicazione web e GLaDOS stesso, riceverai la tua torta. Intendevo il tuo cookie. Buona fortuna!<br/>'.
		'<br/>'.
		'<b>Additional information:</b><br/>'.
		'<b>magic_quotes_gpc is off on the mainframe</b><br/>',
);
?>
