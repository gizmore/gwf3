<?php
final class Shadowcmd_known_spells extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		
		if (count($args) === 1)
		{
			$arg = $args[0];
			if (false === ($spell = $player->getSpell($arg)))
			{
				self::rply($player, '1023'); # You don't have this knowledge.
// 				$bot->reply(sprintf('The spell "%s" is unknown or you did not learn it yet.', $arg));
				return false;
			}
			else
			{
				return Shadowhelp::getHelp($player, $spell->getName());
			}
		}
		else
		{
			return self::rply($player, '5054', array(Shadowfunc::getSpells($player)));
// 			$bot->reply(sprintf('Known spells: %s.', Shadowfunc::getSpells($player)));
		}
		return true;
	}
}
?>
