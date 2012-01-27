<?php
$lang = array(
	'page_title' => 'Introduzione a C++',
	'meta_tags' => 'Gizmore Tutorial, Introduzione a C++, Principianti, Tutorial Principiante',

	'box_1_t' => 'Introduzione a C++',
	'box_1_b' =>
		'Questo tutorial è un introduzione al linguaggio di programmazione C++ su un computer Windows, utilizzando strumenti Open Source.<br/>'.
		'Prima di iniziare: io non sono un guru di C++; questo tutorial è per princiapianti, per avere una base da cui partire.<br/>'.
		'<br/>'.
		'C++ è un linguaggio di programmazine compilato, questo significa che il codice sorgente viene compilato in un programma eseguibile.<br/>'.
		'Quindi, per scrivere programmi C++, ti servirà un <i>compilatore</i>, che genera programmi eseguibili a partire da sorgenti C/++.<br/>'.
		'<br/>'.
		'In questo tutorial installeremo il compilatore mingw, e useremo Code::Blocks come IDE (Integrated Developement Environment -> Ambiente di Sviluppo Integrato).<br/>'.
		'<br/>'.
		'Quindi gente, cosa serve per iniziare?<br/>'.
		'<br/>'.
		'<ul style="margin-left: 20px;"><li><a href="%s">MinGW Compiler</a></li><li><a href="%s">Code::Blocks</a></li></ul>',

	'box_2_t' => 'Installazione MinGW',
	'box_2_b' =>
		'Ho scelto di scaricare il programma di installazione automatico MinGW.<br/>'.
		'Questa è una piccola applicazione che scaricherà ed installerà automaticamente MinGW per te.<br/>'.
		'Durante la selezione dei componente, ho attivato anche <b>make for MinGW</b> e <b>g++</b>. Non ne sono assolutamente certo, ma credo che potrebbero servirci.',

	'box_3_t' => 'Installazione di Code::Blocks',
	'box_3_b' =>
		'Installare Code::Blocks è altrettanto semplice.<br/>'.
		'Ho scelto il binario per Windows senza MinGw. Altrimenti, è possibile scaricare il file che include anche MinGW, evitando di installare MinGW da soli.<br/>'.
		'La prima volta che utilizzi Code::Blocks, verrai invitato a scegliere il compilatore di default. Qui devi scegliere: Gnu-GCC-Compiler (dovrebbe essere già selezionato).<br/>'.
		'Se MinGW non viene riconosciuto, devi impostarlo manualmente (cosa altrettanto semplice), quindi non preoccuparti. Via in Menu-><i>Impostazioni->Compilatore e Debugger</i>, seleziona il compilatore gcc e modifica la toolchain executables (cambia il percorso con la directory in cui risiede MinGW).',
		
	'box_4_t' => 'Compilare il primo Hello World!',
	'box_4_b' =>
		'Ok: è ora di compilare il primo programma, per verificare se tutto è stato installato correttamente.<br/>'.
		'Per fare ciò crea un nuovo progetto, una <b>Console Application</b>. Una console application creerà una finestra DOS.<br/>'.
		'Controlla il menu <b>build</b>. Lì potrai ripulire i file compilati e compilarne di nuovi.<br/>'.
		'Ti consiglio di selezionare <i>Build->Clean</i>, e successivamente <i>Build->Build and Run</i>. Il sorgente dovrebbe compilarsi senza errori, e mostrare la stringa &quot;Hello World!&quot; in a black dos box.',
	
	'box_5_t' => 'Imparare C/++',
	'box_5_b' =>
		'Se vuoi imparare C++, è buona cosa iniziare leggendo qualche libro.<br/>'.
		'<br/>'.
		'Ti consiglio questo libri online: <a href="%s">Una lista di libri sul C++ (in inglese, putroppo)</a>.<br/>'.
		'Per i principianti raccomando: <a href="%s">C++ in Action</a> e <a href="%s">Thinking in C++</a>.<br/>'.
		'Un altra lettura consigliata per coloro che sono alle prime armi con la programmazione è "Accelerated C++".<br/>'.
		'<br/>'.
		'Altre risorse C/++ consigliate: <a href="%s">dinkumware.com</a> e <a href="%s">cprogramming.com</a><br/>'.
		'<br/>'.
		'[Un libro in tedesco: <a href="%s">highscore.de</a>]<br/>'.
		'[Introduzione al C++ in tedesco: <a href="%s">Volkards C++ Kurs</a>]',
);
?>