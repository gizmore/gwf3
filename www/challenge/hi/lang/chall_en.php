<?php

$lang = array(
	'info' => '
Hi, imagine this situation.<br/>
There is an IRC channel #wechall on irc.idlemonkeys.net.<br/>
<br/>
The server sends the messages to all people in the channel, also back to the sender himself.<br/>
When every minute one person joins and says hi,<br/>
how many &quot;hi&quot; messages were totally sent for this channel after 0xfffbadc0ded minutes ?<br/>
No one ever leaves the channel, so there are 0xfffbadc0ded people at the end ;)<br/>
<br/>
Further explanation for 3 minutes:<br/>
the channel is empty and there have been sent 0 messages
1st person joins, sends hi, the server sends hi back to 1 persons.<br/>
2nd person joins, sends hi, the server sends hi back to 2 persons.<br/>
3rd person joins, sends hi, the server sends hi back to 3 persons.<br/>
<br/>
Minute 1: 2 messages sent<br/>
Minute 2: 3 messages sent<br/>
Minute 3: 4 messages sent<br/>
Adding these up means for 3 minutes are 9 messages sent.<br/>
<br/>
Conversion Notes: 0xfffbadc0ded is hexadecimal which converts to 17.591.026.060.781 (Thats around 20 trillion minutes).'.
'Please submit your solution in the decimal system.',

);

?>