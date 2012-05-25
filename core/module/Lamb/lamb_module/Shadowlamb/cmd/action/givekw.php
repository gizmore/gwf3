<?php
require_once 'givekp.php';
final class Shadowcmd_givekw extends Shadowcmd_givekp
{
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->msg('1036');
// 			$player->message('This does not work in combat');
			return false;
		}
		$argc = count($args);
		
		if ( ($argc < 1) || ($argc > 2) )
		{
			$player->message(Shadowhelp::getHelp($player, 'givekw'));
			return false;
		}

		if ($argc === 2)
		{
			if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
			{
				$player->msg('1028', array($args[0]));
				#$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
				return false;
			}
			$word = $args[1];
			$targets = array($target);
		}
		else
		{
			$word = $args[0];
			$targets = $player->getParty()->getMembers();
		}
		
		if (false === $player->hasKnowledge('words', $word))
		{
			$player->msg('1023'); # You don`t have this knowledge.
			return false;
		}
		
		return self::giveKnow($player, $targets, 'words', $args[1]);
	}
}
?>
