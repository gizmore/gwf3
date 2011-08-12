<?php
final class Shadowcmd_giveny extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->message('This does not work in combat');
			return false;
		}
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'giveny'));
			return false;
		}
		
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}

		return self::giveNuyen($player, $target, 'nuyen', $args[1]);
	}
	
	public static function giveNuyen(SR_Player $player, SR_Player $target, $what, $amt)
	{
		if ($amt <= 0)
		{
			$player->message(sprintf('You can only give away a positive amount of %s.', $what));
			return false;
		}
		
		$have = $player->getBase($what);
		if ($amt > $have)
		{
			$player->message(sprintf('You only have %s %s.', $have, $what));
			return false;
		}

		# Thx jjk
//		if (($have - $amt) <= SR_Player::START_NUYEN)
//		{
//			$player->message(sprintf('You can\'t give all your money away, you need at least %s', Shadowfunc::displayNuyen(SR_Player::START_NUYEN)));
//			$player->message(sprintf('Maximum you can give is %s', Shadowfunc::displayNuyen($have-SR_Player::START_NUYEN)));
//			return false;
//		}
			
		if (false === $target->alterField($what, $amt))
		{
			$player->message('Database error in giveNyKa()... 1');
			return false;
		}
		
		if (false === $player->alterField($what, -$amt))
		{
			$player->message('Database error II in giveNyKa()... 2');
			return false;
		}
		
		$target->message(sprintf('Your received %s %s from %s.', $amt, $what, $player->getName()));
		$player->message(sprintf('Your gave %s %s %s.', $target->getName(), $amt, $what));
		
		return true;
	}
}
?>
