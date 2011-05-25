<?php
#:shaun!shaun@oper.idlemonkeys.net TOPIC #idlemonkeys :Go Canucks!
#=== UNKNOWN EVENT ===
#Lamb_Log::debugCommand
#FROM: shaun!shaun@oper.idlemonkeys.net
#CMD: TOPIC
#ARGS: #idlemonkeys,Go Canucks!
$server instanceof Lamb_Server;
if (false === ($channel = $server->getChannel($args[0])))
{
	echo "Unknown channel in event TOPIC: {$args[0]}\n";
	return;
}

$channel->saveTopic($args[1]);
