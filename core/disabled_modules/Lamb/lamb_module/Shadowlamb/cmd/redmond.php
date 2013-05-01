<?php
/**
 * Beams a character back to redmond. Useful when stuck.
 * @author gizmore
 */
final class Shadowcmd_redmond extends Shadowcmd
{
	const BEAM_TARGET = 'Redmond_Hotel';
	
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isInParty())
		{
			$player->msg('1099'); # You cannot do this when you are in a party.
			return false;
		}
		
		if (!$player->isIdle())
		{
			$player->msg('1033'); # Your party is moving. Try this command when idle.
			return false;
		}
		
		if ( (count($args)===1) && ($args[0]==='i_am_sure') )
		{
			self::beamToRedmond($player);
		}
		else
		{
			$player->msg('5298', array(self::BEAM_TARGET)); # Use "#redmond i_am_sure" to take some of your XP and beam you back to Redmond_Hotel.
		}
		
		return true;
	}
	
	private static function beamToRedmond(SR_Player $player)
	{
		$p = $player->getParty();
		$xp = $player->getBase('xp');
		$player->resetXP();
		$player->msg('5299', array(self::BEAM_TARGET)); # Your XP stack got reset and you get beamed back to %s.
		$p->pushAction(SR_Party::ACTION_INSIDE, self::BEAM_TARGET);
	}
}
?>