<?php
/**
 * this file is subject to change
 * do not translate!
 */
$lang = array(
	# Join_Us page
	'pt_joinus' => 'Join us',
	'mt_joinus' => 'Join WeChall - Rank Challenge Site Users',

	'join_0_t' => 'Introduction',
	'join_0_b' =>
		'These pages are for challenge site administrators. See <a href="%s">WeChall API section</a> for player scripts.<br/>'.
		'If you are a player, and want your favorite site to get added: <b>Do not post in other site`s forums.</b> Contact the site admins in private.<br/>',

	'join_1_t' => 'Why should we join WeChall',
	'join_1_b' =>
		'Mainly we want to connect challenge/riddle sites, beside that we want to create a global ranking for these sites.<br/>'.
		'Writing 2 small scripts is not too hard and we do not cause a lot of traffic.<br/>'.
		'If your site has riddles or challenges and keeps track of a users solving progress you are very welcome here.<br/>'.
		'Also we do not expose user credentials, steal email or whatever. We are a free site, only with the fun of solving problems and learning new stuff in mind.',
		
	'join_2_t' => 'How to make other sites work with WeChall',
	'join_2_b' =>
		'To make a site work we need to interact with it.<br/>'.
		'In particular we need a script to validate accounts on your site,<br/>'.
		'as well as a scoring script.<br/>'.
		'The scripts are using GET requests, and the values are urlencoded.<br/>'.
		'<i><b>The script and variable names can all be chosen freely.</b></i>',
	
	'join_1t' => 'A script to validate that a user owns an account at your site.',
	'join_1b' =>
		'<i>validatemail.php?username=%%USERNAME%%&amp;email=%%EMAIL%%[&amp;authkey=%%AUTHKEY%%]</i><br/>'.
		'<br/>'.
		'this script must return simply "1" OR "0",<br/>'.
		'1:email/username combination exists.<br/>'.
		'0:combination does not exist or authkey wrong.<br/>'.
		'<br/>'.
		'Please make sure that your users have the possibilty to change their emails or at least have some "used"/existing email address.<br/>'.
		'To link accounts to wechall you have to confirm linking via this email address. (if they registered here with the same email there is no need to send mails).<br/>'.
		'<br/>'.
		'hackthissite.org pointed out that the old API was prone to private information disclosure. You can simply use the script to test users against emails or vica versa.<br/>'.
		'We introduced the optional AUTHKEY variable to make it not publicy exploitable.<br/>'.
		'You can choose your authkey freely.<br/>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_1_1\'); return false;">Click here to see an example implementation in PHP</a><br/>'.
		'<div id="example_1_1" class="gwf_code" style="display: %s;"><pre>'.
		'if (!isset($_GET[\'username\']) || !isset($_GET[\'email\']) || is_array($_GET[\'username\']) || is_array($_GET[\'email\']) ) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		PHP_EOL.
		'$uname = mysql_real_escape_string($_GET[\'username\']);'.PHP_EOL.
		'$email = mysql_real_escape_string($_GET[\'email\']);'.PHP_EOL.
		'$query = "SELECT 1 FROM users WHERE user_name=\'$uname\' AND user_email=\'$email\'";'.PHP_EOL.
		'if (false === ($result = mysql_query($query))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'if (false === ($row = mysql_fetch_row($result))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'die(\'1\');'.PHP_EOL.
		'</pre></div>'.
		PHP_EOL,
		
	'join_2t' => 'A script that returns the users score on your site.',
	'join_2b' =>
		'<i>userscore.php?username=%%USERNAME%%[&amp;authkey=%%AUTHKEY%%]</i><br/>'.
		'<br/>'.
		'making use of authkey is optional here. If you have public accessible profiles you can just ignore it.<br/>'.
		'<br/>'.
		'The format of the output does not matter, since we write seperate code for each site.<br/>'.
		'Your output must contain at least userscore and maxscore. So the output of this script could be like "userscore:maxscore".<br/>'.
		'You can also output something like "username has solved solved of total and is rank rank of usercount"<br/>'.
		'(see point 5)<br/>'.
		'<br/>'.
		'WeChall is also capable of updating user and challenge count via this script.'.
		'<br/><b>Perfect output for this script is: username:rank:score:maxscore:challssolved:challcount:usercount</b><br/>'.
		'<br/>'.PHP_EOL.
		'<a href="%s" onclick="toggleHidden(\'example_2_1\'); return false;">Click here to see an example implementation in PHP</a><br/>'.
		'<div id="example_2_1" class="gwf_code" style="display: %s;"><pre>'.
		'# return username:rank:score:maxscore:challssolved:challcount:usercount'.PHP_EOL.
		'# but wechall can handle any output you like.'.PHP_EOL.
		'if (!isset($_GET[\'username\']) || is_array($_GET[\'username\']) ) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'# Let`s see if user exists.'.PHP_EOL.
		'$uname = mysql_real_escape_string($_GET[\'username\']);'.PHP_EOL.
		'$query = "SELECT * FROM users WHERE user_name="$uname";'.PHP_EOL.
		'if (false === ($result = mysql_query($query))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		'if (false === ($userrow = mysql_fetch_row($result))) { '.PHP_EOL.
		'	die(\'0\'); '.PHP_EOL.
		'}'.PHP_EOL.
		PHP_EOL.
		'# Now calculate the userscore and stuff for the user.'.PHP_EOL.
		'# This is pseudocode, as the data you calculate or get very depends on your site.'.PHP_EOL.
		'$rank = mysite_calc_rank($userrow);'.PHP_EOL.
		'$score = mysite_calc_score_for_user($userrow);'.PHP_EOL.
		'$maxscore = mysite_get_maxscore();'.PHP_EOL.
		'$challsolved = mysite_calc_num_challs_solved($userrow);'.PHP_EOL.
		'$challcount = mysite_get_challcount();'.PHP_EOL.
		'$usercount = mysite_get_usercount();'.PHP_EOL.
		PHP_EOL.
		'# Now output the data.'.PHP_EOL.
		'die(sprintf(\'%%s:%%d:%%d:%%d:%%d:%%d:%%d\', $_GET[\'username\'), $rank, $score, $maxscore, $challsolved, $challcount, $usercount));'.PHP_EOL.
		'</pre></div>'.
		PHP_EOL,
		
	'join_3t' => 'Icon and Descriptions',
	'join_3b' =>
		'<ul>'.PHP_EOL.
		'<li>An icon, 32*32, transparent gif preferred.</li>'.PHP_EOL.
		'<li>A description of your site, can be in the sites language.</li>'.PHP_EOL.
		'<li>The wanted displayed sitename. You also use this name for remoteupdate.php</li>'.PHP_EOL.
		'</ul>',
		
	'join_4t' => '[OPTIONAL] A page that shows your users profile.',
	'join_4b' =>
		'<i>profile.php?username=%%USERNAME%%</i><br/>'.
		'<br/>'.
		'This is more part of your site, optional, and will show a (complete) profile of the user.<br/>'.
		'If you like to support us with this script, make sure you don\'t need to login for that.<br/>'.
		'Again, you can choose the filename and vars for your script freely.<br/>'.
		'Profile scripts that use an URL like <i>profile/%%USERNAME%%.html</i> will work fine too.',
		
	'join_5t' => '[OPTIONAL] Updating WeChall automatically',
	'join_5b' =>
		'There are two ways to automatically update your users scores on WeChall:<br/>'.
		'<br/>'.
		'- The first is to have your application make a request to<br/>'.
		'<i>http://www.wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%</i><br/>'.
		'whenever a user completes a challenge.<br/>'.
		'This will return a text string with the result of the operation.<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_5_1\'); return false;">Click here to view example code</a><br/>'.
		'<div id="example_5_1" style="display: %s;">'.
		'Example: <br/>'.
		'<br/>'.
		'<div class="gwf_code">'.
			'echo \'&lt;a href=&quot;http://www.wechall.net&quot;&gt;WeChall&lt;/a&gt; reports: \';<br/>'.
			'echo file_get_contents(&quot;http://wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%&quot;);<br/>'.
		'</div>'.
		'<br/>'.
		'or<br/>'.
		'<br/>'.
		'<div class="gwf_code">'.
			'echo \'&lt;a href=&quot;http://www.wechall.net&quot;&gt;WeChall&lt;/a&gt; reports: \';<br/>'.
			'$ch = curl_init();<br/>'.
			'curl_setopt($ch, CURLOPT_URL, &quot;http://www.wechall.net/remoteupdate.php?sitename=<b>%%SITENAME%%</b>&amp;username=<b>%%USERNAME%%</b>&quot;);<br/>'.
			'curl_setopt($ch, CURLOPT_HEADER, 0);<br/>'.
			'curl_exec($ch);<br/>'.
			'curl_close($ch);<br/>'.
		'</div>'.
		'<br/>'.
		'</div>'.
		'<br/>'.
		'- The second is to put an image in the page a user gets when he/she solves a challenge.<br/>'.
		'<i>http://www.wechall.net/remoteupdate.php?sitename=%%SITENAME%%&amp;username=%%USERNAME%%&amp;img=1</i><br/>'.
		'This will return an image with the result of the operation.<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_5_2\'); return false;">Click here to view example code</a><br/>'.
		'<div id="example_5_2" style="display: %s;">'.
		'Example:<br/>'.
		'<div class="gwf_code">'.
			'&lt;a href=&quot;http://www.wechall.net&quot;&gt;&lt;img src=&quot;http://www.wechall.net/remoteupdate.php?sitename=<b>%%SITENAME%%</b>&amp;username=<b>%%USERNAME%%</b>&amp;img=1&quot; alt=&quot;http://www.wechall.net&quot; border=0/&gt;&lt;/a&gt;<br/>'.
		'</div>'.
		'<br/>'.
		'</div>'.
		'<br/>'.
		'If you opt to do this, the users won\'t have to make periodical requests to your site to update their stats on wechall. Instant updates also might help to detect cheaters better.<br/>'.
		'<br/>'.
		'By the way, there is no need to display the results to your users, you may discard the output and simply don\'t show it. For example you can use an image with hidden display and size 1x1 when using the image method.',
	
	'join_6t' => '[OPTIONAL] Pipsqueek-IRC-Bot Interaction',
	'join_6b' => 
		'A script that returns userstatus in form of a single text line. We use this bot on irc.idlemonkeys.net<br/>'.
		'The content type has to be text/plain and the output has to be a single line, not exceeding 192 characters.<br/>'.
		'The script has to be like yourscript.foo?username=%%USERNAME%%. Note that the GET parameter username can not be chosen freely.<br/>'.
		'It is also a nice feature to display the stats for rank #N with this script when an integer is given as username<br/>',
		
	'join_7t' => '[OPTIONAL] A script that can push the latest forum threads.',
	'join_7b' =>
		'<i>forum_news.php?datestamp=%%NOW%%&amp;limit=%%LIMIT%%</i><br/>'.
		'<br/>'.
		'Your script has to output the latest N forum threads newer or equal to a datestamp.<br/>'.
		'The datestamp has to be in the format YYYYmmddhhiiss.<br/>'.
		'Your query has to be ordered by thread_lastpostdate DESC.<br/>'.
		'Your output has to print the result in reverse order.<br/>'.
		'You have to escape : with \\: and \\n with \\\\n.<br/>'.
		'The columns are: threadid::datestamp::groupid::url::nickname::threadname<br/>'.
		'It is optional if you output threads that have a groupid != 0.<br/>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_7_1\'); return false;">Click here for an example on the server side</a><br/>'.
		'<pre class="gwf_code" style="display: %s;" id="example_7_1">'.
		'%s'.
		'</pre>'.
		'<br/>'.
		'<a href="%s" onclick="toggleHidden(\'example_7_2\'); return false;">Click here for an example on the client side</a><br/>'.
		'<pre class="gwf_code" style="display: %s;" id="example_7_2">'.
		'%s'.
		'</pre>'.
		'<br/>'.
		'If you like to, I can implement this script for you, in case you use some known forum software, like phpbb.',
		
	'api_1t' => 'Poll the latest forum activity',
	'api_1b' =>
		'WeChall does implement the <a href="%s">optional script 7</a>.<br/>'.
		'To poll the latest forum activity, you can call the following script to get them:<br/>'.
		'<br/>'.
		'<i><a href="https://www.wechall.net/nimda_forum.php?datestamp=20091231232359&amp;limit=10">https://www.wechall.net/nimda_forum.php?datestamp=20091231232359&amp;limit=10</a></i><br/>'.
		'<br/>'.
		'The output of this script is explained in the <a href="%s">optional join documentation</a>.',
	
	'api_2t' => 'Poll user statistics',
	'api_2b' =>
		'WeChall does implement an enhanced version for <a href="%s">optional script 6</a>.<br/>'.
		'You are allowed to use it for your own means.<br/>'.
		'<br/>'.
		'Usage:<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Will output the general user ranking on wechall. Usage: username=&lt;username&gt;<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Will give an overview of all sites the user is linked to. Usage: username=!sites &lt;username&gt;<br/>'.
		'<br/>'.
		'<i><a href="%s">%s</a></i><br/>'.
		'Will give an overview of one particular site the user is playing. Usage: username="!&lt;site&gt; &lt;username&gt;<br/>'.
		'<br/>'.
		'To list all possible sites, use <a href="%s">%s</a>.<br/>',
		
	'api_3t' => 'Poll latest activity',
	'api_3b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'You can poll the latest activities in a machine readable format by using this script.<br/>'.
		'Usage: %s<br/>'.
		'<br/>'.
		'There are several input parameters for this script<br/>'.
		'- datestamp [YYYYmmddhhiiss]: fetch only messages >= this datestamp.<br/>'.
		'- username [WeChall Username]: fetch only messages for one user.<br/>'.
		'- sitename [Site-name/classname]: fetch only messages for one site.<br/>'.
		'- limit [max results]: Limit the results to a value.<br/>'.
		'- masterkey [NoLimit]: Raise the max limit of output rows.<br/>'.
		'- password [No Api Override for user]: Private API password, when a single user is queried.<br/>'.
		'- no_session [Mandatory]: You have to put no_session=1 in your requests.<br/>'.
		'<br/>'.
		'The output format is some sort of csv.<br/>'.
		'The column separator is :: and the row separator is \\n<br/>'.
		'The char : is escaped with \\: and \\n is escaped with \\\\n.<br/>'.
		'The output columns are:<br/>'.
		'EventDatestamp::EventType::<br/>'.
		'WeChallUsername::Sitename::<br/>'.
		'OnSiteName::OnSiteRank::OnSiteScore::MaxOnSiteScore::OnSitePercent::GainOnsitePercent::<br/>'.
		'Totalscore::GainTotalscore<br/>'.
		'- EventDatestamp [YYYYmmddhhiiss]<br/>'.
		'- EventType [one of %s]<br/>'.
		'- WeChallUsername [The Wechall username]<br/>'.
		'- Sitename [The Sitename or shortcut used on WeChall]<br/>'.
		'- OnSiteName [The nickname used on the site]<br/>'.
		'- OnSiteRank [The rank on the site after update]<br/>'.
		'- OnSiteScore [The score on the site after update]<br/>'.
		'- MaxOnSiteScore [Max score possible on the site]<br/>'.
		'- OnSitePercent [The percent solved on the site after update]<br/>'.
		'- GainOnSitePercent [The percent gained due to this update]<br/>'.
		'- Totalscore [WeChall Totalscore after update]<br/>'.
		'- GainTotalscore [WeChall Totalscore gain/loss for update]<br/>'.
		'<br/>'.
		'Examples:<br/>'.
		'%s<br/>'.
		'<br/>'.
		'Players can exclude themself from the api calls.<br/>'.
		'Also players may obfuscate their onsitename and event dates with various settings.<br/>'.
		'Please note that you will only be able to request the latest 20 activities for a single user, or 50 for all activities.<br/>'.
		'If you like to pull all or older data you will need a masterkey, given to site admins on demand.',
	
	# v4.04
	'join_summary' => 'Scripts for interaction',
	'join_summary_opt' => 'Optional scripts for more interaction',
		
	# v4.05
	'btn_join' => 'Join Basics',
	'btn_join_opt' => 'Join Advanced',
	'btn_api' => 'WeChall API',
		
	# v4.06
	'api_4t' => 'User API',
	'api_4b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'You can query the UserAPI to get information about a user in a machine readable format.<br/>'.
		'If you submit your private API password, the result will also include your newlinks-counter, unreadpm-counter and unreadthreads-counter.<br/>'.
		'The output format is multiple rows in key:value pairs.<br/>'.
		'<br/>'.
		'Examples:<br/>'.
		'%s<br/>'.
		'%s<br/>',
	
	'api_5t' => 'Site API and shortcuts',
	'api_5b' =>
		'<i><a href="%s">%s</a></i><br/>'.
		'<br/>'.
		'You can query the site database with this API to retrieve data in a machine readable format.<br/>'.
		'The output format is again in CSV, with :: as column and \\n as row seperator. : is escaped with \\: and \\n is escaped with \\\\n<br/>'.
		'The output columns are:<br/>'.
		'Sitename::Classname::Status::URL::ProfileURL::Usercount::Linkcount::Challcount::Basescore::Average::Score<br/>'.
		'<br/>'.
		'Examples:<br/>'.
		'%s<br/>'.
		'%s<br/>',
		
	# v5.02 (EPOCH WARBOX)
	'btn_join_war' => 'Join Warbox',
	'war_1t' => 'Warbox API and instructions',
	'war_1b' =>
		'These pages are for &quot;Warbox&quot; administrators.<br/>'.
		'A Warbox is a computer that offers hacking challenges, but does not keep track of it´s users and their progress.<br/><br/>'.
		'If you are the admin of a Warbox, adding it to WeChall has never been easier.<br/><br/>'.
		'All you need todo is make sure that you have an identd running on a port below 1025 and being reachable by hacking.allowed.org.<br/>'.
		'Also your box needs to be able to connect to hacking.allowed.org on port 1235.<br/>',
		
	'war_4t' => 'How does it work?',
	'war_4b' =>
		'When a user does the netcat(nc) command from your box, the identd will securely tell the service at port 1235 which level on your box sent the command.<br/>'.
		'As the user sends a unique Warbox token as well, the service at hacking.allowed can keep track of a users progress.<br/>'.
		'Users can then link your Warbox as any regular site, via hacking.allowed as a data proxy.<br/>'.
		'<br/>'.
		'Of course adding a new site also requires us to choose a proper display name, hostname and other settings manually.<br/>'.
		'Provide us with the required information by email to get your site added to wechall.<br/>'.
		'<br/>'.
		'<i>Let us thank <a href="/profile/epoch_qwert">epoch_qwert</a>, for this fabulous idea and implementation!</i>',
		
	'war_2t' => 'Setting up identd',
	'war_2b' => 'Some examples how to install an identd can be found here.',
	'war_2b_os' => array(
		'gentoo' =>
			'<pre>'.
			"su\n".
			"emerge -av oidentd\n".
			"/etc/init.d/oidentd start\n".
			"rc-update add oidentd default\n".
			'</pre>'.PHP_EOL,
// 		'windows' =>
// 			'Test',
	),
	
	'war_3t' => 'Configuring iptables',
	'war_3b' =>
		"<pre>".
		"<b>Allow incoming 113 from hacking.allowed.org</b>\n".
		"<i>iptables -I INPUT -p tcp -m tcp --dport 113 -s hacking.allowed.org -j ACCEPT</i>\n".
		"\n".
		"<b>Allow outgoing to hacking.allowed.org port 1235</b>\n".
		"<i>iptables -I OUTPUT -p tcp -m tcp --dport 1235 -d hacking.allowed.org -j ACCEPT</i>\n",
);
?>
