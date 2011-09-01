<?php
final class Shadowcmd_lvlup extends Shadowcmd
{
	# Karm costs
	const KARMA_COST_SKILL = 3;
	const KARMA_COST_ATTRIBUTE = 2;
	const KARMA_COST_KNOWLEDGE = 2;
	const KARMA_COST_SPELL = 2;
	
	# Max values
	const MAX_VAL_SKILL = 24;
	const MAX_VAL_SKILL_RUNNER = 48;
	const MAX_VAL_SPELL = 12;
	const MAX_VAL_SPELL_RUNNER = 36;
	const MAX_VAL_KNOWLEDGE = 12;
	const MAX_VAL_KNOWLEDGE_RUNNER = 24;
	const MAX_VAL_ATTRIBUTE = 12;
	const MAX_VAL_ATTRIBUTE_RUNNER = 18;
	
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();

		# Can lvlup in combat?
//		if ($p->isFighting())
//		{
//			$player->message('You cannot lvlup when your party is fighting.');
//			return false;
//		}
		
		$bot = Shadowrap::instance($player);
		$runner = $player->isRunner();
		$have = $player->getBase('karma');

		if (count($args) !== 1)
		{
			$cost = self::KARMA_COST_SPELL;
			$b = chr(2);
			$player->message('Skills to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, SR_Player::$SKILL, self::KARMA_COST_SKILL, $runner?self::MAX_VAL_SKILL_RUNNER:self::MAX_VAL_SKILL));
			$arr = SR_Player::$ATTRIBUTE;
			unset($arr['es']);//ignore essence
			$player->message('Attributes to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, $arr, self::KARMA_COST_ATTRIBUTE, $runner?self::MAX_VAL_ATTRIBUTE_RUNNER:self::MAX_VAL_ATTRIBUTE));
			$player->message('Knowledge to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, SR_Player::$KNOWLEDGE, self::KARMA_COST_KNOWLEDGE, $runner?self::MAX_VAL_KNOWLEDGE_RUNNER:self::MAX_VAL_KNOWLEDGE));
			$s = '';

			if($player->getSpellData())
			{
				$max = $runner ? self::MAX_VAL_SPELL_RUNNER : self::MAX_VAL_SPELL;
				$nl = $player->getSpellData();
				asort($nl);
				foreach (array_reverse($nl) as $name => $base)
				{
					if($base == $max){
						$n = $b.'*'.$b;
					}else{
						$n = ($base + 1) * 2;
						if($n <= $have){
							$n = $b.$n.'K'.$b;
							$name = $b.$name.$b;
						}else{
							$n = $n.'K';
						}
					}
					$s .= sprintf(', %s:%s(%s)', $name, ($base+1), $n);
				}
			}
			$s = $s === '' ? 'None' : substr($s,2);
			$player->message('Spells to upgrade: '.$s);
			return false;
		}
		$f = strtolower($args[0]);

		# Shortcuts
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		if (isset(SR_Player::$KNOWLEDGE[$f])) { $f = SR_Player::$KNOWLEDGE[$f]; }
		if ($f === 'essence') { $bot->reply('You can not levelup your essence.'); return false; }
		
		$is_spell = false;
		
		if (in_array($f, SR_Player::$SKILL))
		{
			$level = $player->getBase($f);
			$cost = self::KARMA_COST_SKILL;
			$max = $runner ? self::MAX_VAL_SKILL_RUNNER : self::MAX_VAL_SKILL;
		}
		
		elseif (in_array($f, SR_Player::$ATTRIBUTE))
		{
			$level = $player->getBase($f);
			$cost = self::KARMA_COST_ATTRIBUTE;
			$max = $runner ? self::MAX_VAL_ATTRIBUTE_RUNNER : self::MAX_VAL_ATTRIBUTE;
		}
		
		elseif (in_array($f, SR_Player::$KNOWLEDGE))
		{
			$level = $player->getBase($f);
			$cost = self::KARMA_COST_KNOWLEDGE;
			$max = $runner ? self::MAX_VAL_KNOWLEDGE_RUNNER : self::MAX_VAL_KNOWLEDGE;
		}
		elseif (false !== ($spell = SR_Spell::getSpell($f))) {
			$level = $spell->getBaseLevel($player);
			$cost = self::KARMA_COST_SPELL;
			$is_spell = true;
			$max = $runner ? self::MAX_VAL_SPELL_RUNNER : self::MAX_VAL_SPELL;
		}
		
		else
		{
			$bot->reply('You can only levelup attributes, skills, knowledge and spells.');
			return false;
		}
		
		if ($level < 0)
		{
			$bot->reply(sprintf('You need to learn %s first.', $f));
			return false;
		}
		
		if ($level >= $max)
		{
			$bot->reply(sprintf('You already have reached the max level of %d for %s.', $max, $f));
			return false;
		}
		
		$need = ($level+1) * $cost;
		if ($need > $have)
		{
			$bot->reply(sprintf('You need %d karma to increase your base level for %s from %d to %d, but you only have %d karma.', $need, $f, $level, $level+1, $have));
			return false;
		}
		
		# Reduce Karma
		$player->alterField('karma', -$need);
		
		# Lvlup
		if ($is_spell === true)
		{
			$player->levelupSpell($f, 1);
		}
		else
		{
			$player->alterField($f, 1);
		}
		
		$player->modify();
		return $bot->reply(sprintf('You used %d karma and leveled up your %s from %d to %d.', $need, $f, $level, $level+1));
	}
}
?>
