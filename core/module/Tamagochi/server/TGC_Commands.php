<?php
final class TGC_Commands
{
	public static function execute(TGC_Player $player, $message)
	{
		GWF_Log::logCron(sprintf("%s executes %s", $player->displayName(), $message));
	}
}