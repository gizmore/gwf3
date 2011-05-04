<?php
final class Lamb_Log
{
	private static function getFilename()
	{
		return 'logs/'.date('Ymd').'_lamb.log';
	}
	
	public static function log($message)
	{
//		if (Common::isCLI())
//		{
			echo $message.PHP_EOL;
//		}
		GWF_Log::log('lamb', $message, true);
//		$filename = self::getFilename();
//		if (false === ($fh = fopen($filename, 'a'))) {
//			return false;
//		}
//		
//		echo "$message\n";
//		
//		fprintf($fh, "%s: %s\n", date('H:i:s'), $message);
//		
//		fclose($fh);
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