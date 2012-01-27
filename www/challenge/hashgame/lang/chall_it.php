<?php
$lang = array(
	'title' => 'Gioco dell\'hashing di WeChall',
	'info' => 
		'Benvenuto al gioco dell\'hashing di WeChall.<br/>'.
		'La tua missione è crackare due list di hash.<br/>'.
		'La <a href="%1$s">prima lista</a> utilizza <a href="%2$s">l\'algoritmo di hashing WC3</a>, che utilizza un algoritmo MD5 con una SALT fissa.<br/>'.
		'La <a href="%3$s">seconda lista</a> utilizza <a href="%4$s">l\'algoritmo di hashing WC4</a>, che utilizza un algoritmo SHA-1 con salt.<br/>'.
		'<br/>'.
		'La soluzione è data dalle due parole più lunghe di ogni lista, concatenate con una virgola.<br/>'.
		'Esempio soluzione: parolada1,parolada1,parolada2,parolada2.<br/>'.
		'<br/>'.
		'Lo scopo di questa sfida è quello di dimostrare il vantaggio del nuovo algoritmo su quello vecchio.<br/>'.
		'Nota: Tutte le password sono in minuscolo e sono vere parole inglesi da un dizionario.<br/>'.
		'Grazie a %5$s, per avermi incoraggiato a cambiare l\'algoritmo di hashing.<br/>'.
		'<br/>'.
		'Buon cracking!',

	'tt_list_wc3' => 'Lista delle hash WC3. (<a href="%1$s">WC3 Algo</a>)',
	'tt_list_wc4' => 'Lista delle hash WC4. (<a href="%1$s">WC4 Algo</a>)',

	'err_answer_count' => 'Dovevi inviare 4 parole, ma ne hai inviate %1$s.',
	'err_some_good' => 'Hai indovinato %1$s di 4 parole correttamente. Prova ancora!',
	'err_answer_count_high' => 'Userò solo le prime 4 parole delle %1$s inviate.',
);
?>