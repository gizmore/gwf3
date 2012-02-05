<?php
final class Shadowcmd_brew extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		if (0 > ($alchemy = $player->get('alchemy')))
		{
			$player->msg('1047');
			return false;
// 			return $player->message('You need to learn alchemy first.');
		}
		
		$wantlevel = true;
		switch (count($args))
		{
			case 2: $wantlevel = $args[1];
			case 1: $spellname = $args[0];
				break;
			default:
				return $player->message(Shadowhelp::getHelp($player, 'brew'));
		}
		
		$party = $player->getParty();
		if ($party->isFighting())
		{
			$player->msg('1036');
			return false;
// 			return $player->message('You cannot brew potions when fighting.');
		}
		if (!$party->isIdle())
		{
			$player->msg('1033');
			return false;
// 			return $player->message('Your party needs to be idle for brewing potions.');
		}

		$bot = Shadowrap::instance($player);
		if (false === ($spell = $player->getSpell($spellname)))
		{
			$player->msg('1048');
			return false;
// 			return $bot->reply('You don\'t have this spell.');
		}
		$spell->setMode(SR_Spell::MODE_POTION);
		$level = $player->getSpellLevel($spellname);
		
		if ($wantlevel === true)
		{
			$wantlevel = $level;
		}
		
		if ($wantlevel > $level)
		{
			$player->msg('1049', array($spellname));
			return false;
// 			return $player->message(sprintf('You don\'t have the %s spell on that high level.', $spellname));
		}
		$level = $wantlevel;
		
		if (false === ($bottle = $player->getInvItem('WaterBottle')))
		{
			$player->msg('1050', array('WaterBottle'));
			return false;
// 			return $bot->reply('You do not have a WaterBottle.');
		}
		if (false === $bottle->useAmount($player, 1))
		{
			return $bot->reply('Database error.');
		}
		if (false === $spell->onCast($player, array(), $level))
		{
			$player->msg('1051', array($spellname));
// 			return $bot->reply('Brewing the potion failed and the bottle is lost.');
			return false;
		}
		
		
		$minlevel = $alchemy * 0.1;
		$maxlevel = max($minlevel, $level);
		$level = Shadowfunc::diceFloat($minlevel, $maxlevel, 1);
		
		$potion = Item_AlchemicPotion::alchemicFactory($player, $spellname, $level);
		$player->giveItems(array($potion), $player->lang('from_brewing'));
		return;
	}
}
?>
