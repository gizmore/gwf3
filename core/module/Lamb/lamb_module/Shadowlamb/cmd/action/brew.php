<?php
final class Shadowcmd_brew extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		if (0 > ($alchemy = $player->get('alchemy')))
		{
			return $player->message('You need to learn alchemy first.');
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
			return $player->message('You cannot brew potions when fighting.');
		}
		if (!$party->isIdle())
		{
			return $player->message('Your party needs to be idle for brewing potions.');
		}

		$bot = Shadowrap::instance($player);
		if (false === ($spell = $player->getSpell($spellname)))
		{
			return $bot->reply('You don\'t have this spell.');
		}
		$spell->setMode(SR_Spell::MODE_POTION);
		$level = $player->getSpellLevel($spellname);
		
		if ($wantlevel === true)
		{
			$wantlevel = $level;
		}
		
		if ($wantlevel > $level)
		{
			return $player->message(sprintf('You don\'t have the %s spell on that high level.', $spellname));
		}
		$level = $wantlevel;
		
		if (false === ($bottle = $player->getInvItem('WaterBottle')))
		{
			return $bot->reply('You do not have a WaterBottle.');
		}
		if (false === $bottle->useAmount($player, 1))
		{
			return $bot->reply('Database error.');
		}
		if (false === $spell->onCast($player, array(), $level))
		{
			return $bot->reply('Brewing the potion failed and the bottle is lost.');
			return true;
		}
		
		
		$minlevel = $alchemy * 0.1;
		$maxlevel = max($minlevel, $level);
		$level = Shadowfunc::diceFloat($minlevel, $maxlevel, 1);
		
		$potion = Item_AlchemicPotion::alchemicFactory($spellname, $level);
		$player->giveItems(array($potion), 'brewing magic potions');
		return;
	}
}
?>
