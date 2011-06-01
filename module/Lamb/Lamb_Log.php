<?php
final class Lamb_Log
{
	private static function getFilename()
	{
		return 'logs/'.date('Ymd').'_lamb.log';
	}
	
	public static function log($message)
	{
		if (PHP_SAPI === 'cli')
		{
			echo $message.PHP_EOL;
		}
		GWF_Log::log('lamb', $message, true);
	}
	
	public static function debugCommand(Lamb_Server $server, $command, $from, array $args)
	{
		echo 'Lamb_Log::debugCommand'.PHP_EOL;
		echo 'CMD: '.$command.PHP_EOL;
		echo 'FROM: '.$from.PHP_EOL;
		echo 'ARGS: '.implode(',', $args).PHP_EOL;
	}
}
?>