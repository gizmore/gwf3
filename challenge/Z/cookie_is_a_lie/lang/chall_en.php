<?php
$lang = array(
	'index_info' => 
		'You, Chell want to destroy GLaDOS. For this mission you have to steal the cookie from GLaDOS in order to get access to the mainframe in the Enrichment Center. If you can access the mainframe, you can shutdown GLaDOS and you will be rescued.<br/>'.
		'<br/>'.
		'You have found a source code for a web application, which is vulnerable to sql-injection and xss attacks. This web application runs on the <a href="%1%">mainframe (accessible only from the internal network).</a> <a href="%2%"> Here you can download the source code.</a><br/>'.
		'<br/>'.
		'Bad news are that you can\'t access the mainframe without the cookie, only GLaDOS can. Another bad news are that the www-user has only read access on the mainframe database, and stacking the queries is not working.<br/>'.
		'<br/>'.
		'You have read the protocols that if GLaDOS receives a new e-mail with an id in it, GLaDOS will visit the experience web application above, enter the id and click on the first link in order to gather information about the new experience subject.<br/>'.
		'<br/>'.
		'During your mission you have succesfully accessed a test webserver, and setup a php file, which can be accessed from the internal network via this link:<br/>'.
		'<i>http://test.cake/steal_cookie.php</i><br/>'.
		'<a href="%3%">This php file</a> can receive the "cookie" get parameter and record the values in a file, which is accessible for you.<br/>'.
		'<br/>'.
		'Your mission is to send a special id to <a href="%4%">GLaDOS</a>, in order to steal the cookie data.<br/>'.
		'(*write Z a PM with the challenge title as subject)<br/>'.
		'After successfully exploiting the web application and GLaDOS itself, you will receive your cake. I mean your cookie. Good luck!<br/>'.
		'<br/>'.
		'<b>Additional information:</b><br/>'.
		'<b>magic_quotes_gpc is off on the mainframe</b><br/>',
);
?>
