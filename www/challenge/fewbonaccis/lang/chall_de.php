<?php
$lang = array(
	'title' => 'Few Bonaccis',
	'info' => '
    Hallo %s,<br/>
<br/>
Sie und ein Kollege unterhalten sich über das Programmieren, insbesondere über die Fibonacci-Folge.<br/>
Sie sagen ihm, dass Fibonacci gelöst ist und dass es eine geschlossene Form gibt, um jede Zahl in O(1) zu berechnen, usw...<br/>
Er argumentiert, dass Sie nicht einmal einen Microservice erstellen könnten, der Fibonacci in einer vernünftigen Zeit korrekt berechnet.<br/>
<br/>
Sie nehmen die Herausforderung an und implementieren einen Microservice unter der unten angegebenen URL.<br/>
Sie vereinbaren, dass Ihr Kollege ein Skript implementiert, um Ihren Dienst zu testen, und dass er es nicht mehr ändern darf, sobald es implementiert ist.<br/>
Das Skript wird Ihren httpd einige Male abfragen, und jede Anfrage darf nur maximal 2,618 Sekunden dauern.<br/>
Ihr Dienst muss den MD5-Wert der N-ten Fibonacci-Zahl zurückgeben.<br/>
<br/>
Beispiel: http://your.host.ip/fib.pl?n=100 => d8400bceb05dfe785afcd2da4fdb010e<br/>
<br/>
Viel Glück!<br/>
 - gizmore',
    'err_wrong' => 'Ihr Kollege hatte Recht!',
);
