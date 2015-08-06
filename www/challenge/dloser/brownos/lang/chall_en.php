<?php
$lang = array(
	'title' => 'The BrownOS',
	'subtitle' => 'Cheat Sheet',
	'info' =>
		'Reports have come in about a new kind of operating system that Gizmore is developing. Scans have detected an extra open port on wechall.net that might be related to this. Additionally, one of our dumpster divers has found part of what appears to be a cheat sheet for something called "BrownOS".<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Please investigate the service at wc3.wechall.net port 61221.<br/>'.PHP_EOL,
	'cheatsheet' =>
		'<pre>FF: End Of Code marker'.PHP_EOL.
		PHP_EOL.
		'BrownOS[&lt;syscall&gt; &lt;argument&gt; FD &lt;rest&gt; FD] -&gt; BrownOS[&lt;rest&gt; &lt;result&gt; FD]'.PHP_EOL.
		PHP_EOL.
		'Quick debug: 05 00 FD 00 05 00 FD 03 FD FE FD 02 FD FE FD FE'.PHP_EOL.
		'For example: QD ?? FD  or  ?? ?? FD QD FD'.PHP_EOL,
);
