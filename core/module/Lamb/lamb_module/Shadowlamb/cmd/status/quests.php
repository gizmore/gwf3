<?php
final class Shadowcmd_quests extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		$quest = false;
		switch (count($args))
		{
			case 2:
				$id = $args[1];
				if (!is_numeric($id)) {
					$bot->reply(Shadowhelp::getHelp($player, 'quests'));
					return false;
				}
				else {
					if (false === ($quest = SR_Quest::getByID($player, $args[0], $id))) {
						$bot->reply('This quest-id is unknown.');
						return false;
					} 
				}
			case 1:
				$section = $args[0];
				if (is_numeric($section)) {
					if (false === ($quest = SR_Quest::getByID($player, 'accepted', $section))) {
						$bot->reply('This quest-id is unknown.');
						return false;
					}
					$section = 'accepted';
				}
				break;
				
			case 0:
				$section = 'accepted';
				break;
				
			default: $bot->reply(Shadowhelp::getHelp($player, 'quests')); return false;
				
		}
		
		# Display info
		if ($quest === false)
		{
			if (false === ($message = Shadowfunc::getQuests($player, $section))) {
				$bot->reply(Shadowhelp::getHelp($player, 'quests'));
				return false;
			}
			$bot->reply(sprintf('Your %s quests: %s.', $section, $message));
			return true;
		}
		else
		{
			$bot->reply($quest->displayQuest());
			return true;
		}
	}
}
?>
