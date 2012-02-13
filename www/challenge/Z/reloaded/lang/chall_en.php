<?php
$lang = array(
	'your_box' => 'Your box',
	'title' => 'Go to the challenge',
	'info' =>
		'Before starting the challenge I suggest you to save every information and solution,<br/>'.
		'because later in the challenge it is likely that you will need them again.<br/>'.
		'Especially if you see passwords in the narrator box.<br/>'.
		'<br/>'.
		'<a href="%1$s" title="Start the challenge">Start the challenge</a>',

	### Narrator ###
	'narr_1' => 'In this challenge you play the role of Trinity, from the famous movie Matrix: Reloaded. In the beginning of this challenge, your mission is the same as in the movie: Power down the whole city. To begin the hack, you have to do a stealth verbose nmap scan against 10.2.2.2 .<br/><br/>You can reset the challenge anytime by typing \'reset\'.',
	'narr_2' => 'Find the vulnerable service, read more about the famous exploit, and name the source file which contains the security bug.',
	'narr_3' => 'Good job Trinity, now use the famous command (as seen in the movie) to exploit the vulnerable service.',
	'narr_4' => 'Oops, looks like your job becomes harder than seen in the movie, because you can not shut down the power grid from this node. Your next job will be to attack the central ms sql database server. It is not reachable from your net, so you have to port forward your local ms sql port via 10.2.2.2 (gateway) to the ms sql port on 192.168.10.2 (using your new ssh account). You are root on your box, so you don\'t have to provide the username.',
	'narr_5' => 'Enter password:',
	'narr_6' => 'You are root on 10.2.2.2 (gateway server), and have a working ssh tunnel between localhost and the database server (192.168.10.2). You have also added your ssh public key to /root/.ssh/authenticated_keys, so you do not have to type the password in the future. Your next job will be to login to the ms sql server 2000 with the command line client of ms sql (osql). You have to exploit a famous vulnerability in ms sql to do it. It is really easy.',
	'narr_7' => 'Nice job, you are system admin on the central database server. Your next job will be to add a windows user called trinity with password Z1ON0101 to the system - with one ms sql command.',
	'narr_8' => 'Add her to the administrators local group - again with one ms sql command.',
	'narr_9' => 'You have to setup a new port forward from your local remote desktop port to the database servers (192.168.10.2) remote desktop port - through the gateway server (10.2.2.2).',
	'narr_10' => 'It is not that hard, is it? :) Now you can login to the database server remote desktop with "rdesktop 127.0.0.1 -u trinity -p Z1ON0101" (it is done, so this is not the solution to type in). You fire up a new console on your localhost, and do another port forward. Any connection to 10.2.2.2 (gateway) port 222 has to be forwarded to your host 164.109.44.69 port 22.',
	'narr_11' => 'Consider scp client is on the database server (same as on Unix), and scp server is on your local box. Your job is to copy the /home/trinity/nasty_virus file to the database server c:\ directory. Username trinity, password MyL0v315N30',
	'narr_12' => 'Oh, a prompt.',
	'narr_13' => 'Your nasty virus is doing a good job against the power grid, it will take days to recover the whole database - and the power grid. Nice work Trinity, mission accomplished :)',

	### After (prompts?) ###
	'after_1' => ' ', # none
	'after_2' => 
		'Starting nmap V. 2.54BETA25'.PHP_EOL.
		'Insufficient responses for TCP sequencing (3), OS detection may be less accurate'.PHP_EOL.
		'Interesting ports on 10.2.2.2:'.PHP_EOL.
		'(The 1539 ports scanned but not shown below are in state: closed)'.PHP_EOL.
		'Port    State           Service         Version'.PHP_EOL.
		'22/tcp  open            ssh             OpenSSH 2.2.0 (protocol 1.0)'.PHP_EOL.
		'...'.PHP_EOL.
		'No exact OS matches for host'.PHP_EOL.
		'...'.PHP_EOL.
		'Nmap run completed -- 1 IP address (1 host up) scanneds'.PHP_EOL,
	'after_3' => 'Right :)',
	'after_4' =>
		'Connecting to 10.2.2.2:ssh ... successful.'.PHP_EOL.
		'Attempting to exploit SSHv1 CRC32 ... successful.'.PHP_EOL.
		'Reseting root password to "Z1ON0101".'.PHP_EOL.
		'System open: Access Level <9>'.PHP_EOL,
	'after_5' => 'Password:',
	'after_6' => 'Welcome to the gateway server, root.',
	'after_7' => 'Welcome to MSSQL. We put the screws in your database!',
	'after_8' => 'Added user trinity.',
	'after_9' => 'Added user trinity to group administrators',
	'after_10' => 'Port Forward 1 done.',		
	'after_11' => 'Port Forward 2 done.',
	'after_12' => 'Password:',
	'after_13' => 'OWNED',

	'cmd_help' => 'This is no Shell. It is more like a trivia - Question and Answer game. Have fun with your research.',
);
?>