<?php
$lang = array(
	# Scoring Faq
	'pt_scorefaq' => '[WeChall] FAQ sul punteggio',
	'mt_scorefaq' => 'FAQ sul calcolo del punteggio di WeChall.',
	'scoring_faqt' => 'Calcolo del punteggio su WeChall',
	'scoring_faq' => 
		'Questa painga descrive le modalità di calcolo del punteggio su WeChall.<br/>'.
		'<br/>'.
		'Al momento, ogni sito ha un certo punteggio che dipende da tre fattori:<br/>'.
		'<br/>'.
		'1. Lo score di base del sito.<br/>'.
		'2. Il numero di sfide del sito.<br/>'.
		'3. Quanto bene si comportano i giocatori sul sito.<br/>'.
		'<br/>'.
		'Esempio:<br/>'.
		'Il punteggio base di Electrica è 10000 (valore di default, correggibile dagli amministratori).<br/>'.
		'Siccome ha 44 sfide un punteggio di 25 * 44 = 1100 è aggiungo a quello base, ottenendo 11100.'.
		'In media, i nostri utenti hanno completato il 42%% del sito.<br/>'.
		'Il punteggio per quel sito diventa quindi: base+base-avg*base, ovvero:<br/>'.
		'11100 + 11100 - 4662 = 17538 points.<br/>'.
		'Per cui, più un sito è difficile, più punti garantisce per la classifica di WeChall.<br/>'.
		'<br/>'.
		'Il punteggio di un sito determina il totale di punti che si ottengono su WeChall.<br/>'.
		'<br/>'.
		'Esempio:<br/>'.
		'Peter ha 30000 punti su HackQuest, da un massimo di 100000 punti.<br/>'.
		'Ciò significa che Peter ha risolta il 30%% di Hackquest.<br/>'.
		'Questa percentuale è aggiustata con questa formula (p*p/100) che fa si che si guadagnino più punti per percentuali di completamento più elevate.<br/>'.
		'Quindi, su WeChall Peter ottiene il 9%% (30*30/100) del punteggio di HackQuest.<br/>'.
		'HackQuest ha, attualmente, un punteggio di 19698, quindi Peter ottiene 1773 punti.<br/>'.
		'<br/>'.
		'Gli amministratori possono aggiornare manualmente il punteggio base dei vari siti.<br/>'.
		'E\' possibile che un sito con poche semplici sfide possa avere un punteggio base inferiore ad un\'altro sito con molte sfide difficili.<br/>'.
		'<br/>'.
		'Non abbiate remore a porci delle domande nel <a href="%s">forum</a> se non comprendete qualcosa di questa spiegazione.',
);
?>
