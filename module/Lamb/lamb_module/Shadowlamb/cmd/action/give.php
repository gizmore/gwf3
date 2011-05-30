<?php
final class Shadowcmd_give extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 3) || (count($args) > 4) )
		{
			$player->message(Shadowhelp::getHelp($player, 'give'));
			return false;
		}
		
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0]))) {
			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
		}
		
//		if (false === ($target = Shadowfunc::getPlayerInLocationB($player, $args[0]))) {
//			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
//			return false;
//		}
		
//		if ($target->isNPC()) {
//			$player->message(sprintf('You can not give stuff to NPC.'));
//			return false;
//		}

		switch ($args[1])
		{
			case 'i': return self::giveItem($player, $target, $args[2], (isset($args[3])?intval($args[3]):1) );
			case 'ny': return self::giveNyKa($player, $target, 'nuyen', $args[2]);
			case 'ka': return self::giveNyKa($player, $target, 'karma', $args[2]);
			case 'kw': return self::giveKnow($player, $target, 'words', $args[2]);
			case 'kp': return self::giveKnow($player, $target, 'places', $args[2]);
			default: $player->message(Shadowhelp::getHelp($player, 'give')); return false;
		}
	}
	
	private static function giveItem(SR_Player $player, SR_Player $target, $id, $amt=1)
	{
		if (false === ($item = $player->getInvItem($id))) {
			$player->message('You don`t have that item.');
			return false;
		}

		if ($item->isItemStackable())
		{
			if ($amt > $item->getAmount())
			{
				$player->message(sprintf('You only have %d %s.', $item->getAmount(), $item->getName()));
				return false;
			}
			$giveItem = SR_Item::createByName($item->getName(), $amt, true);
			$item->useAmount($player, $amt);
		}
		else
		{
			$player->removeFromInventory($item);
			$giveItem = $item;
		}
		
		$target->giveItems($giveItem);
		
		if ($player->isFighting()) {
			$busy = $player->busy(60);
			$busymsg = sprintf(' %d seconds busy.', $busy);
		} else {
			$busymsg = '';
		}
		
		$player->message(sprintf('You gave %d %s to %s.%s', $amt, $giveItem->getName(), $target->getName(), $busymsg));
		return true;
	}
	
	private static function giveNyKa(SR_Player $player, SR_Player $target, $what, $amt)
	{
		if ($player->isFighting()) {
			$player->message(sprintf('You can not give away %s during combat.', $what));
			return false;
		}
		if ($amt <= 0) {
			$player->message(sprintf('You can only give away a positive amount of %s.', $what));
			return false;
		}
		
		$have = $player->getBase($what);
		if ($amt > $have) {
			$player->message(sprintf('You only have %s %s.', $have, $what));
			return false;
		}
		
		if (false === $target->alterField($what, $amt)) {
			$player->message('Database error in giveNyKa()... :(');
			return false;
		}
		if (false === $player->alterField($what, -$amt)) {
			$player->message('Database error II in giveNyKa()... :(');
			return false;
		}
		
		$target->message(sprintf('Your received %s %s from %s.', $amt, $what, $player->getName()));
		$player->message(sprintf('Your gave %s %s %s.', $target->getName(), $amt, $what));
		return true;
	}
	
	private static function giveKnow(SR_Player $player, SR_Player $target, $what, $which)
	{
		if ($player->isFighting()) {
			$player->message(sprintf('You can not share knowledge during combat.'));
			return false;
		}

		if (is_numeric($which)) {
			if (false === ($which = $player->getKnowledgeByID($what, $which))) {
				$player->message(sprintf('You don`t have this knowledge.'));
				return false;
			}
		}
		elseif (!$player->hasKnowledge($what, $which)) {
			$player->message(sprintf('You don`t have this knowledge.'));
			return false;
		}

		if ($target->hasKnowledge($what, $which)) {
			return true;
		}
		$target->giveKnowledge($what, $which);
		$player->message(sprintf('You told %s about %s.', $target->getName(), $which));
		return true;
	}
}
?>
