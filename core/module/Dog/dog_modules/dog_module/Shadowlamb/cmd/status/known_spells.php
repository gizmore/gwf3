<?php
final class Shadowcmd_known_spells extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 1)
		{
			$arg = $args[0];
			if (false === ($spell = $player->getSpell($arg)))
			{
				$player->msg('1023'); # You don't have this knowledge.
				return false;
			}
			else
			{
				return Shadowhelp::getHelp($player, $spell->getName());
			}
		}
		else
		{
			return $player->message(Shadowfunc::getSpells($player, '5054'));
		}
		return true;
	}
}
?>
