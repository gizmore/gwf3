<?php
$lang = array(
	'title' => 'Agent Larry',
	'info' =>
		'One of our agents (codename Larry) was able to sniff Oracle network traffic deep in the Russian network.<br/>'.
		'First Larry obtained some traffic when users authenticated to the database, this traffic you can find<br/>'.
		'<a href="%1%">here</a><br/>'.
		'<br/>'.
		'Afterwards, Larry sniffed some traffic when the database made some network backup.<br/>'.
		'When he realized how important this could be, the agent immediatly forwarded the traffic<br/>'.
		'to the headquarter, but unfortunately the transmission was stopped.<br/>'.
		'We could not make any contact to Larry anymore.<br/>'.
		'<br/>'.
		'Our experts already analyzed this traffic, and were able to<br/>'.
		'restore the beginning of a database file, which you can find<br/>'.
		'<a href="%2%">here</a>.<br/>'.
		'<br/>'.
		'Your goal is to obtain a valid username - password - connect identifier in the following form<br/>'.
		'<br/>'.
		'<b>database_username/password@database_ip:port/database_name</b><br/>'.
		'<br/>'.
		'This challenge fits in the Internet/Forensics section, so use google to find the right tool for it.<br/>'.
		'After you have found the tool, you need a lot of oracle dll\'s.<br/>'.
		'You can download it from Oracle official site (Oracle Database Client),<br/>'.
		'but I made a small client for this challenge, you can download it here:<br/>'.
		'<a href="%3%">Oracle DLLs</a><br/>'.
		'<br/>'.
		'On the headquarter you found some analyzed Oracle traffic, maybe it will help you to understand<br/>'.
		'more Oracle TNS traffic. You can download it here:<br/>'.
		'<a href="%4%">example.txt</a>.<br/>'.
		'<br/>'.
		'And the last information for you, is that the clients were connecting to the<br/>'.
		'database via IP tunneling, but the traffic was captured after the tunneling was terminated.<br/>'.
		'<br/>'.
		'You don\'t have too much time to solve this, so you think brute force is not the way...<br/>'.
		'<br/>'.
		'If you cannot find the tool, don\'t worry, you will find it <br/>'.
		'Sooner or Later :)',
);
?>