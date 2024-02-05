<?php
$msg = Dog::getIRCMsg();
$rawmsg = $msg->getRaw();
$argv = $msg->getArgs();
$argc = count($argv);

if (false === strpos('&#+!', $argv[0][0]))
{
	# MODE <nickname> *( ( "+" / "-" ) *( "i" / "w" / "o" / "O" / "r" ) )

} else {
	# MODE <channel> *( ( "-" / "+" ) *<modes> *<modeparams> )
	$channel = Dog::setupChannel();
	$arg = 1;
	while ($arg < $argc)
	{
		$sign = $argv[$arg][0];
		if ($sign !== '-' && $sign !== '+')
		{
			Dog_Log::error("No valid sign for argument $arg of $rawmsg");
			break;
		}

		$modes = substr($argv[$arg++], 1);
		for ($i=0; $i<strlen($modes); $i++)
		{
			$mode = $modes[$i];

			if (false !== strpos('aqOohv', $mode)) # member status
                        {
				if ($arg < $argc)
				{
					$nick = $argv[$arg++];
					if (false !== ($user = $channel->getUserByName($nick)))
					{
						$channel->setUser($user, $mode, $sign==='+');
					} else {
						Dog_Log::warn("Unknown user $nick in $rawmsg");
					}
				} else {
					Dog_Log::error("Ran out of arguments while handling mode $mode in $rawmsg");
				}

			} elseif (false !== strpos('aimnqpsrt', $mode))
			{

			} elseif ($mode === 'k')
			{
				$arg++;

			} elseif ($mode === 'l')
			{
				if ($sign === '+')
				{
					$arg++;
				}

			} elseif (false !== strpos('beI', $mode))
			{
				$arg++;

			} else {
				Dog_Log::error("Unknown channel mode $mode in $rawmsg");
				$arg = $argc; # not safe to continue
				break;
			}
		}
	}
}

?>
