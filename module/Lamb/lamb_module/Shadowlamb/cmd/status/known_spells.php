<?php
final class Shadowcmd_known_spells extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) === 1)
		{
			if (false === ($spell = SR_Spell::getSpell($args[0]))) {
				$bot->reply(sprintf('The spell %s is unknown.', $args[0]));
				return false;
			}
			else {
				$bot->reply(sprintf('%s level %s: %s', $spell->getName(), $spell->getLevel($player), $spell->getHelp($player)));
			}
		}
		else
		{
			$bot->reply(sprintf('Known spells: %s.', Shadowfunc::getSpells($player)));
		}
		return true;
	}
}
?>
