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
		
// 		$bot = Shadowrap::instance($player);
		$runner = $player->isRunner();
		$have = $player->getBase('karma');

		if (count($args) !== 1)
		{
			$cost = self::KARMA_COST_SPELL;
// 			$b = chr(2);
			$max = $runner?self::MAX_VAL_SKILL_RUNNER:self::MAX_VAL_SKILL;
			$player->msg('5057', array($max, Shadowfunc::getStatsLvlUpArray($player, SR_Player::$SKILL, self::KARMA_COST_SKILL, $max)));
// 			$player->message('Skills to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, SR_Player::$SKILL, self::KARMA_COST_SKILL, $runner?self::MAX_VAL_SKILL_RUNNER:self::MAX_VAL_SKILL));
			$arr = SR_Player::$ATTRIBUTE;
			unset($arr['es']);//ignore essence
			$max = $runner?self::MAX_VAL_ATTRIBUTE_RUNNER:self::MAX_VAL_ATTRIBUTE;
			$player->msg('5058', array($max, Shadowfunc::getStatsLvlUpArray($player, $arr, self::KARMA_COST_ATTRIBUTE, $max)));
// 			$player->message('Attributes to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, $arr, self::KARMA_COST_ATTRIBUTE, $runner?self::MAX_VAL_ATTRIBUTE_RUNNER:self::MAX_VAL_ATTRIBUTE));
			$max = $runner?self::MAX_VAL_KNOWLEDGE_RUNNER:self::MAX_VAL_KNOWLEDGE;
			$player->msg('5059', array($max, Shadowfunc::getStatsLvlUpArray($player, SR_Player::$KNOWLEDGE, self::KARMA_COST_KNOWLEDGE, $max)));
// 			$player->message('Knowledge to upgrade: ' . Shadowfunc::getStatsLvlUpArray($player, SR_Player::$KNOWLEDGE, self::KARMA_COST_KNOWLEDGE, $runner?self::MAX_VAL_KNOWLEDGE_RUNNER:self::MAX_VAL_KNOWLEDGE));
			$s = '';

			if($player->getSpellData())
			{
				$format = $player->lang('fmt_lvlup');
				$max = $runner ? self::MAX_VAL_SPELL_RUNNER : self::MAX_VAL_SPELL;
				$nl = $player->getSpellData();
				asort($nl);
				foreach (array_reverse($nl) as $name => $base)
				{
					$k = 'K';
					$bold = '';
					$could = 0;
					if($base >= $max)
					{
						$n = '*';
						$k = '';
					}
					else
					{
						$n = ($base + 1) * 2;
						if($n <= $have)
						{
							$bold = chr(2);
							$could = 1;
// 							$n = $b.$n.'K'.$b;
// 							$name = $b.$name.$b;
						}
						else
						{
// 							$n = $n.'K';
						}
					}
					$s .= sprintf($format, $name, ($base+1), $n, $bold, $k, $could);
// 					$s .= sprintf(', %s:%s(%s)', $name, ($base+1), $n);
				}
			}
			$s = $s === '' ? $player->lang('none') : ltrim($s,',; ');
			return $player->msg('5060', array($max, $s));
// 			$player->message('Spells to upgrade: '.$s);
// 			return true;
		}
		$f = strtolower($args[0]);

		# Shortcuts
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		if (isset(SR_Player::$KNOWLEDGE[$f])) { $f = SR_Player::$KNOWLEDGE[$f]; }
// 		if ($f === 'essence') { $bot->reply('You can not levelup your essence.'); return false; }
		if ($f === 'essence')
		{
			$player->msg('1024');
// 			$bot->reply('You can not levelup your essence.');
			return false;
		}
			
		$is_spell = false;
		$cost = self::getKarmaCostFactor($f);
		
		if (in_array($f, SR_Player::$SKILL))
		{
			$level = $player->getBase($f);
// 			$cost = self::KARMA_COST_SKILL;
			$max = $runner ? self::MAX_VAL_SKILL_RUNNER : self::MAX_VAL_SKILL;
		}
		
		elseif (in_array($f, SR_Player::$ATTRIBUTE))
		{
			$level = $player->getBase($f);
// 			$cost = self::KARMA_COST_ATTRIBUTE;
			$max = $runner ? self::MAX_VAL_ATTRIBUTE_RUNNER : self::MAX_VAL_ATTRIBUTE;
		}
		
		elseif (in_array($f, SR_Player::$KNOWLEDGE))
		{
			$level = $player->getBase($f);
// 			$cost = self::KARMA_COST_KNOWLEDGE;
			$max = $runner ? self::MAX_VAL_KNOWLEDGE_RUNNER : self::MAX_VAL_KNOWLEDGE;
		}
		elseif (false !== ($spell = SR_Spell::getSpell($f))) {
			$level = $spell->getBaseLevel($player);
// 			$cost = self::KARMA_COST_SPELL;
			$is_spell = true;
			$max = $runner ? self::MAX_VAL_SPELL_RUNNER : self::MAX_VAL_SPELL;
		}
		
		else
		{
			$player->msg('1024');
// 			$bot->reply('You can only levelup attributes, skills, knowledge and spells.');
			return false;
		}
		
		if ($level < 0)
		{
			$player->msg('1025', array($f));
// 			$bot->reply(sprintf('You need to learn %s first.', $f));
			return false;
		}
		
		if ($level >= $max)
		{
			$player->msg('1026', array($max, $f));
// 			$bot->reply(sprintf('You already have reached the max level of %d for %s.', $max, $f));
			return false;
		}
		
		$need = ($level+1) * $cost;
		
		if ($need > $have)
		{
			$player->msg('1027', array($need, $f, $level, $level+1, $have));
// 			$bot->reply(sprintf('You need %d karma to increase your base level for %s from %d to %d, but you only have %d karma.', $need, $f, $level, $level+1, $have));
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
			$player->levelupField($f, 1);
// 			$player->alterField($f, 1);
		}
		
// 		$player->modify();
		return self::rply($player, '5061', array($need, $f, $level, $level+1));
// 		return $bot->reply(sprintf('You used %d karma and leveled up your %s from %d to %d.', $need, $f, $level, $level+1));
	}
	
	public static function getKarmaCostFactor($field)
	{
		if ($field === 'essence')
		{
			return false;
		}
		if (true === in_array($field, SR_Player::$SKILL, true))
		{
			return self::KARMA_COST_SKILL;
		}
		if (true === in_array($field, SR_Player::$ATTRIBUTE, true))
		{
			return self::KARMA_COST_ATTRIBUTE;
		}
		if (true === in_array($field, SR_Player::$KNOWLEDGE, true))
		{
			return self::KARMA_COST_KNOWLEDGE;
		}
		if (false !== ($spell = SR_Spell::getSpell($field)))
		{
			return self::KARMA_COST_SPELL;
		}
		return false;
	}
	
	public static function getMaxLevel(SR_Player $player, $field)
	{
		$runner = $player->isRunner();
		
		if ($field === 'essence')
		{
			return 6;
		}
		
		if (in_array($field, SR_Player::$SKILL))
		{
			return $runner ? self::MAX_VAL_SKILL_RUNNER : self::MAX_VAL_SKILL;
		}
		
		elseif (in_array($field, SR_Player::$ATTRIBUTE))
		{
			return $runner ? self::MAX_VAL_ATTRIBUTE_RUNNER : self::MAX_VAL_ATTRIBUTE;
		}
		
		elseif (in_array($field, SR_Player::$KNOWLEDGE))
		{
			return $runner ? self::MAX_VAL_KNOWLEDGE_RUNNER : self::MAX_VAL_KNOWLEDGE;
		}
		
		elseif (false !== ($spell = SR_Spell::getSpell($field))) {
			return $runner ? self::MAX_VAL_SPELL_RUNNER : self::MAX_VAL_SPELL;
		}
		
		else
		{
			return false;
		}
	}
	
	public static function getKarmaCost($field, $level)
	{
		$cost = self::getKarmaCostFactor($field);
		return ($level+1) * $cost;
	}
}
?>
