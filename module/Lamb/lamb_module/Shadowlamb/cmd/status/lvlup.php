<?php
final class Shadowcmd_lvlup extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		if ($p->isFighting()) {
			$player->message('You cannot lvlup when your party is fighting.');
			return false;
		}
		
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'lvlup'));
			return false;
		}
		$f = strtolower($args[0]);

		# Shortcuts
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		if (isset(SR_Player::$KNOWLEDGE[$f])) { $f = SR_Player::$KNOWLEDGE[$f]; }
		if ($f === 'essence') { $bot->reply('You can not levelup your essence.'); return false; }
		
		$is_spell = false;
		$runner = $player->isRunner();
		
		if (in_array($f, SR_Player::$SKILL)) {
			$level = $player->getBase($f);
			$cost = 3;
			$max = $runner ? 48 : 24;
		}
		elseif (in_array($f, SR_Player::$ATTRIBUTE)) {
			$level = $player->getBase($f);
			$cost = 2;
			$max = $runner ? 18 : 12;
		}
		elseif (in_array($f, SR_Player::$KNOWLEDGE)) {
			$level = $player->getBase($f);
			$cost = 2;
			$max = $runner ? 24 : 12;
		}
		elseif (false !== ($spell = SR_Spell::getSpell($f))) {
			$level = $spell->getBaseLevel($player);
			$cost = 2;
			$is_spell = true;
			$max = $runner ? 36 : 12;
		}
		else {
			$bot->reply('You can only levelup attributes, skills, knowledge and spells.');
			return false;
		}
		
		if ($level < 0) {
			$bot->reply(sprintf('You need to learn %s first.', $f));
			return false;
		}
		
		if ($level >= $max) {
			$bot->reply(sprintf('You already have reached the max level of %d for %s.', $max, $f));
			return false;
		}
		
		$need = ($level+1) * $cost;
		$have = $player->getBase('karma');
		if ($need > $have) {
			$bot->reply(sprintf('You need %d karma to increase your base level for %s from %d to %d, but you only have %d karma.', $need, $f, $level, $level+1, $have));
			return false;
		}
		
		$player->alterField('karma', -$need);
		if ($is_spell === true) {
			$player->levelupSpell($f, 1);
		} else {
			$player->alterField($f, 1);
		}
		$player->modify();
		
		$bot->reply(sprintf('You used %d karma and leveled up your %s by 1 to %d.', $need, $f, $level+1));
		return true;
	}
}
?>
