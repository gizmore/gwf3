<?php
$lang = array(
	'title' => 'Few Bonaccis',
	'info' => '
Hello %s,<br/>
<br/>
You and a coworker are talking about programming, in particular the fibonacci sequence.<br/>
You tell him fibonacci is solved, and there is a closed form to compute any number in O(1), etc...<br/>
He argues that you could not even create a microservice that computes fibonacci correctly in a reasonable time.<br/>
<br/>
You take the challenge and implement a microservice at the URL below.<br/>
You agree that your coworker will implement a script to test your service, and he may not modify it, once it is implemented.<br/>
The script will query your httpd a few times, and each request shall only take 2.618 seconds max.<br/>
Your service has to return the MD5 of the Nth fibonacci number.<br/>
<br/>
Example: http://your.host.ip/fib.pl?n=100 => d8400bceb05dfe785afcd2da4fdb010e<br/>
<br/>
Good Luck!<br/>
 - gizmore',
    'err_wrong' => 'Your coworker was right!',
);
