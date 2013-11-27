<?php
final class DOGMOD_IRCStats extends Dog_Module
{
// 	public function event_003()
// 	{
// 		$stats = Dog_IRCStats::getOrCreateByServer(Dog::getServer());
// 		$stats->saveVars(array(
// 			'dis_max_chans' => $argv[1],
// 		));
// 	}

	public function event_004()
	{
		$stats = Dog_IRCStats::getOrCreateByServer(Dog::getServer());
		$argv = Dog::argv();
		$stats->saveVars(array(
			'dis_software' => $argv[2],
		));
	}
	
	public function event_254()
	{
		$stats = Dog_IRCStats::getOrCreateByServer(Dog::getServer());
		$argv = Dog::argv();
		$stats->saveVars(array(
			'dis_max_chans' => $argv[1],
		));
	}
}
?>
