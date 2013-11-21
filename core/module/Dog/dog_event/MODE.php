<?php
$msg = Dog::getIRCMsg();
$argv = $msg->getArgs();
$argc = count($argv);
$channel = Dog::setupChannel();

# Set mode for channel
if ($argc === 2)
{
	
}

elseif ($channel === false)
{
	# HUH?!
}

# Set mode for user
# :gizmore!gizmore@localhost MODE #sr +o Dog
elseif ($argc === 3)
{
	$chan_name = array_shift($argv);
	$symbols = str_split(array_shift($argv));
	$sign = array_shift($symbols);
	foreach ($symbols as $i => $symbol)
	{
		if (false !== ($user = $channel->getUserByName($argv[$i])))
		{
			$channel->setUser($user, $symbol, $sign==='+');
		}
		else
		{
			echo "DUNNO!!!\n";
		}
// 		else if ($argv[$i] === Dog::getNickname())
// 		{
			
// 		}
	}
}
?>
