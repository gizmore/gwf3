<?php
final class Shadowfunc
{
	/** Move that to a file! **/
	const BUY_PERCENT_CHARISMA = 0.5;
	const BUY_PERCENT_NEGOTIATION = 1.0;
	const SELL_PERCENT_CHARISMA = 0.6;
	const SELL_PERCENT_NEGOTIATION = 1.0;
	
	/**
	 * Convert a long human{} username to short human name. (strip {server})
	 * @param string $name
	 * @return string
	 */
	public static function toShortname($name)
	{
		return (false !== ($pos = strrpos($name, '{'))) ? substr($name, 0, $pos) : $name;
	}
	
	private static function sharesLocation(SR_Player $a, SR_Player $b)
	{
		$pa = $a->getParty();
		$pb = $b->getParty();
		# Same party
		if ($pa->getID() === $pb->getID()) {
			return true;
		}
		
		# Need same action
		$a = $pa->getAction();
		if ($a !== $pb->getAction()) {
			return false;
		}
		switch ($a)
		{
			case SR_Party::ACTION_INSIDE:
			case SR_Party::ACTION_OUTSIDE:
				if ($pa->getLocation($a) === $pb->getLocation($a)) {
					return true;
				} 
				break;
				
			case SR_Party::ACTION_TALK:
				if (intval($pb->getTarget()) === $pa->getID()) {
					return true;
				}
				break;
		}
		return false;
	}
	
	/**
	 * @param SR_Player $player
	 * @param string $name
	 * @return SR_Player
	 */
	public static function getPlayerInLocation(SR_Player $player, $name)
	{
		if (false === ($back = Shadowrun4::getPlayerByName($name))) {
			return false;
		}
	
		# Same party
		if ($back->getPartyID() === $player->getPartyID()) {
			return $back;
		}
		
		if (self::sharesLocation($player, $back)) {
			return $back;
		}
		return false;
	}
	
	##############
	### Combat ###
	##############
	/**
	 * Get a firendly target in the same location.
	 * @param SR_Player $player
	 * @param string $arg
	 * @return SR_Player
	 */
	public static function getFriendlyTarget(SR_Player $player, $arg, $own_members=true)
	{
		if ($arg === '')
		{
			return $player;
		}
		
		# Gather all targets.
		$targets = self::getPlayersInLocation($player, false);
		if ($own_members)
		{
			$targets = array_merge($targets, $player->getParty()->getMembers());
		}
		
		# Do first run with all possible targets.
		if (false !== ($target = self::getTarget($targets, $arg, false)))
		{
			return $target;
		}
		
		# Do second run with own members and enum.
		if ($own_members)
		{
			if (false !== ($target = self::getTarget($player->getParty()->getMembers(), $arg, true)))
			{
				return $target;
			}
		}
		
		return false;
	}
	
	public static function getPlayersInLocation(SR_Player $player, $own_members=true)
	{
		$p = $player->getParty();
		$a = $p->getAction();
		
		$back = $own_members ? $p->getMembers() : array();
		
		switch ($a)
		{
			case SR_Party::ACTION_TALK:
			case SR_Party::ACTION_FIGHT:
				// we can see enemy party
				$back = array_merge($back, $p->getEnemyParty()->getMembers());
				break;
				
				
			case SR_Party::ACTION_INSIDE:
			case SR_Party::ACTION_OUTSIDE:
				// we can see other parties
				$pid = $p->getID();
				$loc = $p->getLocation($a);
				foreach (Shadowrun4::getParties() as $party)
				{
					$party instanceof SR_Party;
					if ($party->getID() !== $pid)
					{
						if ($party->getLocation($a) === $loc)
						{
							$back = array_merge($back, $party->getMembers());
						}
					}
				}
				break;
				
				// we see no other parties
			case SR_Party::ACTION_DELETE:
			case SR_Party::ACTION_SLEEP:
			case SR_Party::ACTION_TRAVEL:
			case SR_Party::ACTION_EXPLORE:
			case SR_Party::ACTION_GOTO:
			case SR_Party::ACTION_HUNT:
			default:
				break;
		}
		
		return $back;
	}
	
	/**
	 * @param SR_Player $player
	 * @param string $arg
	 * @return SR_Player
	 */
	public static function getOffensiveTarget(SR_Player $player, $arg)
	{
		return self::getTarget($player->getEnemyParty()->getMembers(), $arg);
	}
	
	public static function getTarget(array $players, $arg, $enum=true, $shortcuts=true)
	{
		if ($arg === '')
		{
			return Shadowfunc::randomListItem($players);
		}

		# enum
		if ($enum && is_numeric($arg))
		{
			foreach ($players as $player)
			{
				$player instanceof SR_Player;
				if ($player->getEnum() == $arg)
				{
					return $player;
				}
			}
		}
		
		if (strlen($arg) < 3)
		{
			$shortcuts = false;
		}

		$arg = strtolower($arg);
		$n = self::toShortname($arg);
		$candidates = array();
		foreach ($players as $target)
		{
			$name = strtolower($target->getName());
			
			# Exact match
			if ($name === $arg)
			{
				return $target;
			}
			
			# Partial match
			if (
				(strtolower($target->getShortName()) === $n) # Exact Shortname (Moe)
				||
				(($shortcuts) && (strpos($name, $arg)!==false)) # Pattern match (izmo)
			)
			if (strpos($name, $n) !== false)
			{
				$candidates[] = $target;
			}
		}
		
		switch (count($candidates))
		{
			case 0:
				return false;
			case 1:
				return $candidates[0];
			default:
				return false;
		}
	}
	
	##############
	### Quests ###
	##############
	public static function getQuestsBySection(SR_Player $player, $section)
	{
		if (false === ($quests = SR_Quest::getQuestsBySection($player, $section))) {
			return false;
		}
		$i = 1;
		$back = '';
		$b = chr(2);
		foreach ($quests as $quest)
		{
			$back .= sprintf(', %s-%s', $b.$i.$b, $quest->getQuestName());
			$i++;
		}
		# You have no %s quests.
		return $back === '' ? $player->lang('1004', array($section)) : substr($back, 2);
	}
	
	############
	### Rand ###
	############
	/**
	 * Dice a W10000
	 * @param $percent
	 */
	public static function dicePercent($percent)
	{
		return self::dice(1000000, round($percent*10000));
	}
	
	/**
	 * Dice a float value.
	 * @param int $min
	 * @param int $max
	 * @param int $precision
	 * @return float
	 */
	public static function diceFloat($min, $max, $precision=1)
	{
		$p = pow(10, $precision);
		$min *= $p;
		$max *= $p;
		$back = round(rand($min, $max) / $p, $precision);
// 		echo "diceFloat($min, $max) = $back\n";
		return $back;
	}
	
	public static function dice($n, $min)
	{
		return rand(1, $n) <= $min;
	}
	
	public static function dicePool($dices, $n, $min)
	{
		$hits = 0;
		$dices = round($dices);
		$m = Common::clamp($min, 1, $n);
		for ($i = 0; $i < $dices; $i++)
		{
			if (Shadowfunc::dice($n, $m))
			{
				$hits++;
			}
		}
		printf('Shadowfunc::dicePool(dices=%s, sides=%s, min=%s) === %s hits', $dices, $n, $min, $hits).PHP_EOL;
		return $hits;
	}

	public static function dicePoolB($dices, $defense)
	{
		$defense = Common::clamp($defense, 1);
		$dicesB = $dices / $defense;
		$hits = rand(0, $dicesB);
		printf("Shadowfunc::dicePoolB(dices=%s, defense=%s) === %s hits\n", $dices, $defense, $hits);
		return $hits;
	}
	
	public static function diceHits($mindmg, $arm, $atk, $def, SR_Player $player, SR_Player $target)
	{
		$ep = $target->getParty();
		if ($player->isHuman()) # Human attacks ... 
		{
			if ($target->isHuman()) # Human attacks Human
			{
// 				$oops = rand(80, 250) / 10;
				$oops = self::diceFloat(6.0, 9.0, 1);
			}
			else # Human Attacks NPC
			{
// 				$oops = rand(80, 190) / 10;
				$oops = $player->getBase('level') * 0.1;
				$oops = self::diceFloat(6.0+$oops, 9.0+$oops, 1);
			}
		}
		else # NPC attacks ...
		{
			if ($target->isHuman()) # NPC attacks Human
			{
// 				$rand = rand(12, 20) / 10;
// 				$oops = $rand + $ep->getMemberCount()*0.3; # + $ep->getMax('level', true)*0.01;
				$oops = 0.2 + $target->getBase('level') * 0.05;
				$oops *= Common::pow(1.28, $ep->getMemberCount());
			}
			else # NPC attacks NPC
			{
// 				$oops = rand(80, 250) / 10;
				$oops = self::diceFloat(0.8, 2.5, 1);
			}
		}
// 		$chances = (($atk*10 + $mindmg*5) / ($def*5 + $arm*2)) * $oops * 0.65;
		$chances = (($atk*20 + $mindmg*50) / ($def*5 + $arm*2)) * $oops * 0.70;
		
// 		echo "OOOOOOOPS: $oops\n";
		
// 		return Shadowfunc::dicePool(round($chances), round($def)+1, round(sqrt($def)));
		return Shadowfunc::dicePoolB($chances, $def);
	}	
	
	#################
	### Shortcuts ###
	#################
	public static function unshortcut($string, $array)
	{
// 		$string = strtolower($string);
		if ($array === false)
		{
			return $string;
		}
		return true === isset($array[$string]) ? $array[$string] : $string;
	}
	
	public static function shortcut($string, array $array)
	{
// 		$string = strtolower($string);
		if ($array === false)
		{
			return false;
		}
		if (false === ($key = array_search($string, $array, true)))
		{
			return $string;
		}
		return $key;
// 		return strtolower($key);
	}
	
	##############
	### Status ###
	##############
	/**
	 * Return status string for a player.
	 * @param SR_Player $player
	 */
	public static function getStatus(SR_Player $player, $key='5014')
	{
		$args = array();
		
		# Scanner in Use?
		if ($key > 5015)
		{
			$args[] = $player->getName();
		}

		# Pre magic
		$args = array_merge($args, array(
			$player->getGender(), $player->getRace(),
			$player->getBase('level'), $player->get('level'),
			$player->getHP(), $player->getMaxHP()
		));

		# Magic?
		if ($player->getBase('magic') >= 0)
		{
			$key++; # different event
			$args = array_merge($args, array(
				$player->getMP(), $player->getMaxMP()
			));
		}

		# After magic
		$args = array_merge($args, array(
			$player->get('attack'), $player->get('defense'),
			$player->get('min_dmg'), $player->get('max_dmg'),
			$player->get('marm'), $player->get('farm'),
			round($player->getBase('xp'), 2), $player->getBase('karma'),
			round($player->getNuyen(), 2),
			$player->displayWeight(), $player->displayMaxWeight())
		);
		
		return Shadowrun4::lang($key, $args);
		
		
		
		# Status message
// 		if ($player->getBase('magic') >= 0)
// 		{
// 			return Shadowrun4::lang('5014', array(
// 				$player->getGender(), $player->getRace(), $player->getBase('level'), $player->get('level'),
// 				$player->getHP(), $player->getMaxHP(),
// 				$player->getMP(), $player->getMaxMP(),
// 				$player->get('attack'), $player->get('defense'),
// 				$player->get('min_dmg'), $player->get('max_dmg'),
// 				$player->get('marm'), $player->get('farm'),
// 				round($player->getBase('xp'), 2), $player->getBase('karma'),
// 				round($player->getNuyen(), 2),
// 				$player->displayWeight(), $player->displayMaxWeight(),
// 			));
// 		}	
// 		else
// 		{
// 			return Shadowrun4::lang('5015', array(
// 				$player->getGender(), $player->getRace(), $player->getBase('level'), $player->get('level'),
// 				$player->getHP(), $player->getMaxHP(),
// 				$player->get('attack'), $player->get('defense'),
// 				$player->get('min_dmg'), $player->get('max_dmg'),
// 				$player->get('marm'), $player->get('farm'),
// 				round($player->getBase('xp'), 2), $player->getBase('karma'),
// 				round($player->getNuyen(), 2),
// 				$player->displayWeight(), $player->displayMaxWeight(),
// 			));
// 		}
	}
	
	public static function getKnownPlaces(SR_Player $player, $cityname)
	{
		$b = chr(2);
		$back = '';
		$kp = $player->getVar('sr4pl_known_places');
		
		if (!strcasecmp($cityname, $player->getParty()->getCity()))
		{
			$i = 1;
		}
		else
		{
			$i = 0;
		}
		
		$cn = $cityname.'_';
		$len = strlen($cn);
		foreach (explode(',', $kp) as $p)
		{
			if ($p === '')
			{
				continue;
			}
			
			if (strpos($p, $cn) === 0)
			{
				$id = $i === 0 ? '' : "\X02{$i}\X02-";
				$back .= sprintf(', %s%s', $id, substr($p, $len));
				if ($i > 0)
				{
					$i++;
				}
			}
		}
		return substr($back, 2);
	}
	
	public static function getKnownWords(SR_Player $player)
	{
		$i = 1;
		$back = '';
		$format = $player->lang('fmt_rawitems');
		foreach (explode(',', trim($player->getVar('sr4pl_known_words'), ',')) as $w)
		{
			$back .= sprintf($format, $i++, $w);
// 			$back .= sprintf(", \x02%s\x02-%s", $i++, $w);
		}
		return $back === '' ? $player->lang('none') : substr($back, 2);
	}
	
	
	public static function getPartyStatus(SR_Player $player)
	{
		$party = $player->getParty();
		$mc = $party->getMemberCount();
		
		$action = $party->displayAction($player);
		
		$with_distance = $party->isFighting();
		
		if ($mc === 1)
		{
			return $player->lang('5016', array($action));
// 			return sprintf('You are %s', $action);
		}
		elseif ($player->isLeader())
		{
			return $player->lang('5017', array($mc, $party->displayMembers($with_distance), $action));
// 			return sprintf('You are leading %d members (%s) and you are %s', $mc, $party->displayMembers($with_distance), $action);
		}
		else {
			return $player->lang('5018', array($mc, $party->displayMembers($with_distance), $action));
// 			return sprintf('Your party (%s) is %s', $party->displayMembers($with_distance), $action);
		}
	}
	
	public static function getSkills(SR_Player $player, $key='5006')
	{
		$args = array();
		if ($key > 5006)
		{
			$args[] = $player->getName();
		}
		$args[] = self::getStatsArray($player, SR_Player::$SKILL);
		return Shadowrun4::lang($key, $args);
	}
	
	public static function getAttributes(SR_Player $player, $key='5004')
	{
		$args = array();
		if ($key > 5004)
		{
			$args[] = $player->getName();
		}
		$args[] = self::getStatsArray($player, SR_Player::$ATTRIBUTE);
		return Shadowrun4::lang($key, $args);
	}
	
	public static function getKnowledge(SR_Player $player)
	{
		return self::getStatsArray($player, SR_Player::$KNOWLEDGE);
	}
	
	public static function getEquipment(SR_Player $player, $langkey='5048')
	{
// 		$b = chr(2);
		$back = '';
		$format = $player->lang('fmt_equip');
		foreach ($player->getAllEquipment(true) as $key => $item)
		{
			$item instanceof SR_Equipment;
			$back .= sprintf($format, self::translateVariable($player, $key), $item->displayFullName($player), self::shortcutEquipment($key));
// 			$back .= sprintf($format, $key, $item->getItemName(), self::shortcutEquipment($key));
// 			$back .= sprintf(', %s:%s', "{$b}$key{$b}", $item->getItemName());
		}
		$back = ltrim($back, ',; ');
		
		$args = array();
		if ($langkey > 5048)
		{
			$args[] = $player->getName();
		}
		$args[] = $back;
		
		return Shadowrun4::lang($langkey, $args);
	}
	
	/**
	 * Returns comma list of base(adjusted)
	 * @param SR_Player $player
	 * @param array $fields
	 */
	private static function getStatsArray(SR_Player $player, array $fields)
	{
		$back = '';
		foreach ($fields as $fiel => $field)
		{
			$now = round($player->get($field), 1);
			$base = round($player->getBase($field), 1);
			if ($now >= 0)
			{
				$dnow = $base == $now ? '' : "($now)";
				$field = self::translateVariable($player, $field);
				$back .= Shadowrun4::lang('fmt_stats', array($field, $base, $dnow, $fiel, $now));
			}
		}
		return $back === '' ? Shadowrun4::lang('none') : ltrim($back, ',; ');
	}
	
	public static function getStatsLvlUpArray(SR_Player $player, array $fields, $cost, $max)
	{
// 		$b = chr(2);
		$back = '';
		$karma = $player->getBase('karma');
		$nl = array();
		
		foreach($fields as $aa => $bb) { $nl[$aa] = $player->getBase($bb); }

		asort($nl);
		
		$format = $player->lang('fmt_lvlup');
		foreach (array_reverse($nl) as $field => $base)
		{
			$k = 'K';
			$bold = '';
			$could = 0;
			if ($base >= 0)
			{
				if($base >= $max)
				{
					$n = '*';
					$k = '';
				}
				else
				{
					$n = ($base + 1) * $cost;
					if($n <= $karma)
					{
// 						$n = $b.$n.'K'.$b;
// 						$field = $b.$field.$b;
						$bold = chr(2);
						$could = 1;
					}
					else
					{
// 						$n = $n.'K';
					}
				}
				$back .= sprintf($format, $field, ($base+1), $n, $bold, $k, $could);
// 				$back .= sprintf(', %s:%s(%s)', $field, ($base+1), $n);
			}
			
		}
		return $back === '' ? Shadowrun4::lang('none') : ltrim($back, ',; ');
	}
	
	public static function getEffects(SR_Player $player)
	{
// 		$b = chr(2);
		$e = $player->getEffects();
		if (count($e) === 0)
		{
			return Shadowrun4::lang('none');
		}
		
		$sorted = array();
		foreach ($e as $effect)
		{
			$effect instanceof SR_Effect;
			$t = $effect->getTimeEnd();
			$raw = $effect->getModifiersRaw();
			foreach ($raw as $k => $v)
			{
				if (isset($sorted[$k])) {
					$sorted[$k][0] += $v;
					if ($t < $sorted[$k][1]) {
						$sorted[$k][1] = $t;
					}
				} else {
					$sorted[$k] = array($v, $t);
				}
			}
		}
		
		$t2 = Shadowrun4::getTime();
		$format = Shadowrun4::lang('fmt_effect');
		$back = '';
		foreach ($sorted as $k => $data)
		{
			list($v, $t) = $data;
			$back .= sprintf($format, $k, $v, GWF_Time::humanDuration($t-$t2));
// 			$back .= sprintf(', %s:%s(%s)', $b.$k.$b, $v, GWF_Time::humanDuration($t-$t2));
		}
		
		return ltrim($back, ',; ');
	}
	
	public static function getSpells(SR_Player $player, $key='5054')
	{
		$format = $player->lang('fmt_spells');
		$back = '';
// 		$b = chr(2);
		$i = 1;
		foreach ($player->getSpellData() as $name => $base)
		{
			$mod = $player->get($name);
			$dmod = $mod > $base ? "($mod)" : '';
			$back .= sprintf($format, $i++, $name, $base, $dmod, $mod);
// 			$back .= sprintf(', %s-%s:%s%s', $b.$i.$b, $name, $base, $mod);
// 			$i++;
		}
		$back = $back === '' ? Shadowrun4::lang('none') : ltrim($back, ',; ');
		
		$args = $key === '5054' ? array() : array($player->getName());
		$args[] = $back;
		
		return Shadowrun4::lang($key, $args);
	}
	
	public static function getItemsSorted(SR_Player $player, array $items, $i=1)
	{
// 		$b = chr(2);
		$back = '';
		$format = $player->lang('fmt_items');
		foreach ($items as $itemname => $data)
		{
			$count = $data[0];
			$dcount = $count > 1 ? "($count)" : '';
			$back .= sprintf($format, ($i++), $itemname, $dcount, $count);
// 			$back .= sprintf(', %s-%s%s', $b.($i++).$b, $itemname, $dcount);
		}
		return $back === '' ? Shadowrun4::lang('none') : substr($back, 2);
	}
	
	public static function getCyberware(SR_Player $player, $key='5045', SR_Player $spectator=null)
	{
		$i = 1;
		$back = '';
		$format = $player->lang('fmt_rawitems');
		foreach ($player->getCyberware() as $item)
		{
			$item instanceof SR_Item;
			$back .= sprintf($format, $i++, $item->displayName($spectator));
// 			$back .= sprintf(', %d-:%s', $i++, $item->getItemName());
		}
		
		$back = $back === '' ? Shadowrun4::lang('none') : substr($back, 2);
		
		$args = $key === '5045' ? array() : array($player->getName());
		$args[] = $back;
		return Shadowrun4::lang($key, $args);
	}
	
	###################
	### Random Name ###
	###################
	public static function getRandomName(SR_Player $player)
	{
		static $rand = array(
			'fairy_male' => array('Schwunkol'),
			'fairy_female' => array('Ambra','Elina'),
			'vampire_male' => array('Dracool','Vincent'),
			'vampire_female' => array('Daria'),
			'elve_male' => array('Filöen','Vincent'),
			'elve_female' => array('Anja','Joanna'),
			'darkelve_male' => array('Noplan'),
			'darkelve_female' => array('Noplan'),
			'woodelve_male' => array('Noplan'),
			'woodelve_female' => array('Noplan'),
			'halfelve_male' => array('Filöen','Alaster'),
			'halfelve_female' => array('Anja'),
			'human_male' => array('Lesley','Norman','Simon','Jessey','Tobias','Marcus','Oliver','Richard','Gandalf','Carsten','Mike','Paul','Wesley','Mathew','Jersey','Stephen'),
			'human_female' => array('Mary','Tanny'),
			'gnome_male' => array('Garry'),
			'gnome_female' => array('Sabine'),
			'dwarf_male' => array('Roon','Reiner','Oscar'),
			'dwarf_female' => array('Alisa'),
			'ork_male' => array('Grunt','Bruno'),
			'ork_female' => array('Broga'),
			'halfork_male' => array('Bren','Diego'),
			'halfork_female' => array('Yuly'),
			'halftroll_male' => array('Roon','Rodrigo'),
			'halftroll_female' => array('Björk'),
			'troll_male' => array('Roog'),
			'troll_female' => array('Gunda'),
			'gremlin_male' => array('gizmo'),
			'gremlin_female' => array('gizma'),
		);
		$r = $rand[$player->getVar('sr4pl_race').'_'.$player->getVar('sr4pl_gender')];
		return GWF_Random::arrayItem($r);
	}
	
	##############
	### Prices ###
	##############
	public static function calcBuyPrice($price, SR_Player $player)
	{
//		$neg = Common::clamp((int)$player->get('negotiation'), 0, 100);
//		$f = (200 - $neg) / 200;
//		return round($price*$f, 2);
		$ch = $player->get('charisma') - 2;
		$neg = $player->get('negotiation');
		
		$perc = ($ch * self::BUY_PERCENT_CHARISMA) + ($neg * self::BUY_PERCENT_NEGOTIATION);
		$perc = Common::clamp($perc, 0, 50);
		$perc = 100 - $perc;
		$perc /= 100;
		
		return round($price*$perc, 2);
	}
	
	public static function calcSellPrice($price, SR_Player $player)
	{
//		$neg = Common::clamp((int)$player->get('negotiation'), 0, 100);
//		$f = (100 + ($neg/2)) / 100;
//		return round($price*$f, 2);
		$ch = $player->get('charisma');
		$neg = $player->get('negotiation');
		$perc = 100 + ($ch * self::SELL_PERCENT_CHARISMA) + ($neg * self::SELL_PERCENT_NEGOTIATION);
		$perc = Common::clamp($perc, 100, 200);
		$perc /= 100;
		return round($price*$perc, 2);
	}
	
	###############
	### Display ###
	###############
	public static function displayHPGain($oldhp, $gain, $maxhp)
	{
		return self::displayGain($oldhp, $gain, $maxhp, 'HP');
	}
	public static function displayMPGain($oldmp, $gain, $maxmp)
	{
		return self::displayGain($oldmp, $gain, $maxmp, 'MP');
	}
	
	public static function displayGain($old, $gain, $max, $unit)
	{
		$now = $old + $gain;
		$sign = $gain > 0 ? '+' : '';
		$format = Shadowrun4::lang('fmt_gain');
		return sprintf($format, $sign, round($gain,2), round($now,2), round($max,2), $unit);
	}
	
	public static function displayNuyen($price, $precision=2)
	{
		return Shadowrun4::lang('ny', array(sprintf('%.02f', $price)));
	}
	
	public static function displayWeight($weight)
	{
		return $weight > 1000 ? 
			Shadowrun4::lang('kg', array(round($weight/1000, 2))) :
			Shadowrun4::lang('g', array(round($weight)));
	}
	
	public static function displayDistance($distance, $precision=1)
	{
		$unit = Shadowrun4::lang('m');
		return sprintf("%.0{$precision}f{$unit}", $distance);
	}
	
	public static function displayBusy($seconds)
	{
		return Shadowrun4::lang('busy', array(GWF_Time::humanDuration($seconds)));
	}
	
	public static function displayETA($seconds)
	{
		return Shadowrun4::lang('eta', array(GWF_Time::humanDuration($seconds)));
	}
	
	public static function displayASL(SR_Player $player)
	{
		$b = chr(2);
		if (0 >= ($age = $player->getBase('age')))
		{
			return Shadowrun4::lang('none');
		}
		return Shadowrun4::langPlayer($player, 'fmt_asl', array($age, $player->getBase('height'), Shadowfunc::displayWeight($player->getBase('bmi'))));
// 		return sprintf("{$b}Age{$b}:%d, %dcm %s", $age, $player->getBase('height'), Shadowfunc::displayWeight($player->getBase('bmi')));
	}
	
	####################
	### Requirements ###
	####################
	/**
	 * Check if player mets the requirements. Return error message or false.
	 * @param SR_Player $player
	 * @param array $requirements
	 * @return error message or false on success
	 */
	public static function checkRequirements(SR_Player $player, array $requirements)
	{
		if (count($requirements) === 0)
		{
			return false;
		}
		
		$back = '';
		foreach ($requirements as $k => $v)
		{
			$base = $player->getBase($k);
			if ($k === 'race' || $k === 'gender')
			{
				if ($base !== $v)
				{
					$back .= sprintf(', %s:%s', $k, $v);
				}
			}
			else
			{
				if ($base < $v)
				{
					$back .= sprintf(', %s:%s', $k, $v);
				}
			}
		}
		
		return $back === '' ? false : Shadowrun4::lang('1006', array(substr($back, 2)));
// 		return sprintf('You do not meet the requirements: %s.', substr($back, 2));
	}
	
	public static function getRequirements(SR_Player $player, array $requirements)
	{
		if (count($requirements) === 0)
		{
			return '';
		}
		
		$back = '';
		foreach ($requirements as $k => $v)
		{
			$b = $player->getBase($k) < $v;
			$b = $b === true ? chr(2) : '';
			$back .= sprintf(', %s%s:%s%s', $b, $k, $v, $b);
		}
		return Shadowrun4::lang('fmt_requires', array(substr($back, 2)));
// 		return sprintf(" {$b}Requires{$b}: %s.", substr($back, 2));
	}
	
	public static function getModifiers(array $modifiers)
	{
		if (count($modifiers) === 0)
		{
			return '';
		}
		$back = '';
		$format = Shadowrun4::lang('fmt_mods');
		foreach ($modifiers as $k => $v)
		{
			$back .= sprintf($format, $k, $v);
		}
		return ltrim($back, ',; ');
	}
	
	public static function displayModifiers(SR_Player $player, array $modifiers)
	{
		$back = '';
		$format = Shadowrun4::lang('fmt_mods');
		foreach ($modifiers as $k => $v)
		{
			$mod = Shadowfunc::shortcutVariable($player, $k);
			$back .= sprintf($format, $mod, $v);
		}
		return ltrim($back, ',; ');
	}
	
	public static function displayModifiersPacked(SR_Player $player, $modifiers)
	{
		$back = '';
		if (!is_array($modifiers))
		{
			return $back;
		}
		$format = Shadowrun4::lang('fmt_mods');
		foreach ($modifiers as $k => $v)
		{
			$back .= sprintf($format, self::packField($k), $v);
		}
		return ltrim($back, ',; ');
	}
	
	private static function packField($field)
	{
		return self::shortcut($field, Shadowlang::getStatUUIDFile()->getTrans('en'));
	}
	
	#############
	### Drops ###
	#############
	/**
	 * Loot at least N items.
	 * @param SR_Player $player
	 * @param int $level
	 * @param int $n
	 */
	public static function randLootNItems(SR_Player $player, $level, $n)
	{
		$loot = array();
		while (count($loot) < $n)
		{
			$loot = array_merge($loot, self::randLoot($player, $level));
		}
		return $loot;
	}
	
	/**
	 * Get random loot for a player.
	 * @param SR_Player $player
	 * @param int $level of killed mob
	 * @return array
	 */
	public static function randLoot(SR_Player $player, $level, $high_chance=array(), $chance_none=1.85)
	{
		$items = SR_Item::getAllItems();
		$total = 0;
		$possible = array();
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			$il = $item->getItemLevel();
			if ( ($il > $level) || ($il < 0) || (!$item->isItemLootable()) )
			{
				continue;
			}
			
			# Normalize chance
			$chance = 100;
			
			# High chance
			if (in_array($item->getItemName(), $high_chance))
			{
				$chance *= 3; # 3/1
			}

			# Lucky :)
			$chance = self::randLootLuckChance($player, $item, $level, $chance);
			
			# Crunch bit
			$chance /= 10;
			
			# dropchance = base chance * funky stuff
			$dc = round($item->getItemDropChance()*$chance);
			
			# printf("You can loot a %s with %d chance.", $item->getItemName(), $dc);
			
			$possible[] = array($item->getName(), $dc);
			$total += $dc;
		}

		# Party level betters chance none.
// 		$chance_none -= ($player->get('luck') / 200);
		$chance_none -= ($player->getParty()->getPartyLevel() / 200);
		$chance_none = Common::clamp($chance_none, 1.2);
		
		
		# Produce loot. Raise chance_none a lot.
		$back = array();
		while (false !== ($loot = self::randLootItem($player, $level, $possible, $total, $total*$chance_none)))
		{
			$back[] = $loot;
			
			$chance_none *= $chance_none;
		}
		return $back;
	}
	
	private static function randLootLuckChance(SR_Player $player, SR_Item $item, $level, $chance)
	{
		$level++;
		$il = $item->getItemLevel() + 1;
		$luck = $player->get('luck');
		$luck_bonus_wanted = $il / $level;
		return $chance + /*$luck **/ 2 * Common::pow($chance, $luck_bonus_wanted);  
	}
	

	/**
	 * Get a random item with percentages and with a chance of no item. 
	 * $data is an array of array(mixed $back, int $chance).
	 * @param array $data
	 * @param int $total
	 * @param int $chance_none 
	 * @return mixed
	 */
	public static function randomData(array $data, $total, $chance_none=0)
	{
		if ( (0 >= ($total = (int)$total)) )
		{
			return false;
		}
		$chance_none = (int)$chance_none;
		$chance = $total + $chance_none;
		$rand = rand(1, $chance);
// 		Dog_Log::debug(sprintf('Shadowfunc::randomData(): Total(%s)+None(%s)=MAX(%s). Dice: %s', $total, $chance_none, $chance, $rand));
		if ($rand <= $chance_none)
		{
			return false;
		}
		$rand -= $chance_none;
		foreach ($data as $d)
		{
			if ($rand <= $d[1])
			{
				return $d[0];
			}
			$rand -= $d[1];
		}
		return false;
	}
	
	private static function randLootItem(SR_Player $player, $level, array $possible, $total, $chance_none)
	{
		if (false === ($data = self::randomData($possible, $total, $chance_none)))
		{
			return false;
		}
		return self::randLootItemB($player, $level, $data);
	}
	
	
	private static function randLootItemB(SR_Player $player, $level, $itemname)
	{
		$def = SR_Item::getItem($itemname);
		
		$item = SR_Item::createByName($itemname, $def->getItemDefaultAmount(), false);
		
		$item->setRandomDuration();
		
		if (false === $item->insert())
		{
			return false;
		}
		
		if ($item instanceof SR_Rune)
		{
			self::randLootStatItem($player, $level, $item, array(100.00, 35.00, 15.00));
		}
		elseif ($item instanceof SR_StattedEquipment)
		{
			self::randLootStatItem($player, $level, $item, array(100.00, 35.00, 15.00));
		}
		elseif ($item instanceof SR_Mount)
		{
			# nuts
		}
		elseif ($item instanceof SR_Equipment)
		{
			self::randLootStatItem($player, $level, $item, array(45.00, 22.00, 12.00));
		}
		
		return $item;
	}

	private static function randLootStatItem(SR_Player $player, $level, SR_Item $item, array $chance)
	{
		for ($i = 0; $i < count($chance); $i++)
		{
			if (!self::dicePercent($chance[$i]))
			{
				break;
			}
			
			if (false === ($modifiers = SR_Rune::randModifier($player, $level)))
			{
				break;
			}
			
			$item->addModifiers($modifiers, false);
		}
		
		if ($i > 0)
		{
			$item->updateModifiers();
		}
	}
	
	public static function randomListItem()
	{
		$items = array();
		
		foreach (func_get_args() as $arg)
		{
			if (is_array($arg))
			{
				$items = array_merge($items, $arg);
			}
			else {
				$items[] = $arg;
			}
		}
		
		return count($items) === 0 ? false : $items[array_rand($items, 1)];
	}
	
	public static function calcDistance(SR_Player $player, SR_Player $target)
	{
		$x1 = $player->getX();
		$y1 = $player->getY();
		$x2 = $target->getX(); 
		$y2 = $target->getY();
		return self::calcDistanceB($x1, $y1, $x2, $y2);
	}

	public static function calcDistanceB($x1, $y1, $x2, $y2)
	{
		$x = $x2 - $x1;
		$y = $y2 - $y1;
		return sqrt($x*$x + $y*$y);
	}

	public static function longModifierToShort($mod)
	{
		if(array_key_exists($mod,SR_Player::$REV_ALL))
		{
			return SR_Player::$REV_ALL[$mod];
		}
		else
		{
			return $mod;
		}
	}
	
	/**
	 * Do damage to multiple targets and announce the kills and damage in a compressed way.
	 * @param SR_Player $player
	 * @param array $damage
	 */
	public static function multiDamage(SR_Player $player, array $damage, $spellname='Spell')
	{
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		$ep = $p->getEnemyParty();
		
		$loot_xp = array();
		$loot_ny = array();
		foreach ($p->getMembers() as $member)
		{
			$loot_xp[$member->getID()] = 0;
			$loot_ny[$member->getID()] = 0;
		}
		
		$out = array();
		
// 		$out = '';
// 		$out_ep = '';
		foreach ($damage as $pid => $dmg)
		{
			if ($dmg <= 0) {
				continue; 
			}
			
			$target = $ep->getMemberByPID($pid);
			$target->dealDamage($dmg);
			
			if (true === $target->isDead())
			{
				$xp = $target->isHuman() ? 0 : $target->getLootXP();
//				$xp = $target->getLootXP();
				$nuyen = $target->getLootNuyen();
				if ($player->isNPC())
				{
					$target->resetXP();
				}
				$target->giveNuyen(-$nuyen);
				
// 				$app = Shadowrun4::lang('kills', array($target->getName(), $dmg));
				$out[$target->getID()] = array($target, $dmg, true);
// 				$out .= $app;
// 				$out_ep .= $app;
// 				$out .= sprintf(', kills %s with %s', $target->getName(), $dmg);
// 				$out_ep .= sprintf(', kills %s with %s', $target->getName(), $dmg);
				$pxp = 0;
				foreach ($p->getMembers() as $member)
				{
					$lxp = $xp/$mc;
					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
					$lxp *= $leveldiff;
					$lxp = round(Common::clamp($lxp, 0.01), 2);
					$pxp += $lxp;

					$loot_xp[$member->getID()] += $lxp;
					$loot_ny[$member->getID()] += $nuyen / $mc;
				}
				$p->givePartyXP($pxp);
				
			}
			else 
			{
				$out[$target->getID()] = array($target, $dmg, false);
// 				$out .= Shadowrun4::lang('hits1', array($target->getName(), $dmg));
// 				$out_ep .= Shadowrun4::lang('hits2', array($target->getName(), $dmg, $target->getHP(), $target->getMaxHP()));
// 				$out .= sprintf(', hits %s with %s damage', $target->getName(), $dmg);
// 				$out_ep .= sprintf(', hits %s with %s(%s/%s)HP left', $target->getName(), $dmg, $target->getHP(), $target->getMaxHP());
			}
		}

		
		### OUTPUT
		
		if (count($out) === 0)
// 		if ($out === '')
		{
			$p->ntice('1057', array($spellname, $player->getName()));
// 			$p->notice($failmsg);
			return;
		}
		
		### FRIEND PARTY
		
// 		$out = substr($out, 2);
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$loot_out = '';
			
			$ny = $loot_ny[$member->getID()];
			$xp = $loot_xp[$member->getID()];
// 			$xp = round($xp, 2);
			
			if ($ny > 0 || $xp > 0)
			{
				$loot_out = $member->lang('loot_nyxp', array(Shadowfunc::displayNuyen($ny), $xp));
// 				$loot_out = sprintf('. You loot %s and %.02f XP', Shadowfunc::displayNuyen($ny), $xp);
				$member->giveNuyen($ny);
				$member->giveXP($xp);
			}
			
			$msg = $player->getName();
			foreach ($out as $pid => $data)
			{
				list($target, $dmg, $is_kill) = $data;
				$target instanceof SR_Player;
				$key = true === $is_kill ? 'kills' : 'hits1';
// 				$app = Shadowrun4::lang('kills', array($target->getName(), $dmg));
				$msg .= $member->lang($key, array($target->getName(), $dmg));
			}
			
			$member->message($msg.$loot_out.'.');
		}
		
		# ENEMY PARTY
		
// 		$out_ep = substr($out_ep, 2);
// 		$ep->message($player, $out_ep.'.');
		
		foreach ($ep->getMembers() as $member)
		{
			
			$msg = '';
			foreach ($out as $pid => $data)
			{
				list($target, $dmg, $is_kill) = $data;
				$target instanceof SR_Player;
				$key = true === $is_kill ? 'kills' : 'hits2';
				$msg .= $member->lang($key, array($target->getName(), $dmg, $target->getHP(), $target->getMaxHP()));
			}
			
			$member->message($msg.$loot_out.'.');
			
			if ($member->isDead())
			{
				$member->gotKilledBy($player);
			}
		}
		
	}
	
	/**
	 * @deprecated
	 * @param SR_Player $player
	 */
	public static function displayLevel(SR_Player $player)
	{
		$base = $player->getBase('level');
		$adj = $player->get('level');
		return $base == $adj ? "(L\X02{$base}\X02)" : "(L\X02{$base}\X02({$adj}))";
	}
	
	public static function displayALevel($level)
	{
		return $level <= 0 ? '' : Shadowrun4::lang('lvl', array($level));
	}

	public static function getGroupedItems(array $items, $start_index, $end_index, $pattern=null, $is_store=false, &$num_items=null)
	{
		$grouped_items = array();
		$seen = array();
		$num_items = 0;
		foreach ($items as $item)
		{
			$iname = $item->getItemName();
			$group_idx = $is_store ? $num_items : $iname;
			
			if (isset($seen[$group_idx]))
			{
				if (isset($grouped_items[$group_idx]))
				{
					$grouped_items[$group_idx][0] += $item->getAmount();
					$grouped_items[$group_idx][1][] = $item;
				}
			}
			else
			{
				if (   ($pattern === null)
					|| (false !== stripos($iname, $pattern))
					|| (false !== stripos($item->displayFullName(Shadowrun4::getCurrentPlayer(), false, false), $pattern)) )
				{
					$seen[$group_idx] = true;

					if ($start_index <= $num_items && $num_items < $end_index)
					{
						$grouped_items[$group_idx] = array($item->getAmount(), array($item), $num_items);
					}

					$num_items++;
				}
			}
		}

		return $grouped_items;
	}

	public static function getItemPage($player, $items, $start_index, $page, $num_pages, $is_store)
	{
		$b = chr(2);
		$back = '';
		$price = '0';
		$dprice = '';
		
		$format = $player->lang('fmt_itemindex');

		$index = $start_index;
		foreach ($items as $item_name => $data)
		{
			$count = $data[0];
			$dcount = $count > 1 ? "($count)" : '';

			$item = reset($data[1]);
			$dname = $item->displayFullName($player);
			
			if ($is_store)
			{
				$price = $item->getStorePrice();
				$dprice = sprintf("(%s)", Shadowfunc::displayNuyen($price));
			}

			$rindex = count($data) === 2 ? $index : $data[2];

			$back .= sprintf($format, $rindex+1, $dname, $dcount, $dprice, $count, $price);

			$index++;
		}
		
		return Shadowrun4::lang('page', array($page, $num_pages, ltrim($back, ',; ')));
	}
	
	public static function arrayGet($a, $key, $default)
	{
		return array_key_exists($key, $a) ? $a[$key] : $default;
	}
	
	public static function genericViewI(SR_Player $player, $items, array $args, $text=array())
	{
		return Shadowrap::instance($player)->reply(self::getGenericViewI($player, $items, $args, $text));
	}
	
	public static function genericViewS(SR_Player $player, $items, array $args, $text=array())
	{
		return Shadowrap::instance($player)->reply(self::getGenericViewS($player, $items, $args, $text));
	}
	
	/**
	 * Generic item view helper function. Populate text-array with response text snippets,
	 * @param SR_Player $player
	 * @param array $items
	 * @param array $args
	 * @param array $text
	 * @author dloser
	 */
	public static function getGenericViewI(SR_Player $player, $items, array $args, $text=array())
	{
		return self::getGenericView($player, $items, $args, false, $text);
	}
	public static function getGenericViewS(SR_Player $player, $items, array $args, $text=array())
	{
		return self::getGenericView($player, $items, $args, true, $text);
	}
	private static function getGenericView(SR_Player $player, $items, array $args, $is_store, $text, $ipp=10)
	{
		$bot = Shadowrap::instance($player);
		
		if ( (count($args) > 2) /*|| (count($args) < 1)*/ )
		{
			return self::arrayGet($text, 'usage', Shadowhelp::getHelp($player, 'view'));
// 			$bot->reply(self::arrayGet($text, 'usage', Shadowhelp::getHelp($player, 'viewi')));
// 			return false;
		}
		
		# Setup pattern and page
		if (count($args) === 2)
		{
			$pattern = $args[0];
			$page = (int) $args[1];
		}
		elseif (count($args) === 1)
		{
			if (Common::isNumeric($args[0]))
			{
				$pattern = NULL;
				$page = (int) $args[0];
			}
			else
			{
				$pattern = $args[0];
				$page = 1;
			}
		}
		else
		{
			$pattern = NULL;
			$page = 1;
		}

		$start_index = ($page-1) * $ipp;
		$end_index = $start_index + $ipp;

		if (!($items instanceof SR_Inventory))
		{

			$items = Shadowfunc::getGroupedItems($items, $start_index, $end_index, $pattern, $is_store, $num_items);
		
		} else {

			$inventory = $items;
			
			$items = $inventory->getItemsByGroupedIndex($start_index, $end_index, $pattern, $player, $num_items);

			if ($items === false)
			{
				return false;
			}

		}
		
		$num_pages = (int) (($num_items+$ipp-1)/$ipp);
		
		# Display page
		if (count($items) === 0)
		{
			if ( $pattern !== NULL )
			{
				return self::arrayGet($text, 'empty_search', Shadowrun4::lang('1007'));
// 				$bot->reply(self::arrayGet($text, 'empty_search', Shadowrun4::lang('1007')));
			}
			else
			{
				return self::arrayGet($text, 'empty', Shadowrun4::lang('1008'));
// 				$bot->reply(self::arrayGet($text, 'empty', Shadowrun4::lang('1008')));
			}
// 			return true;
		}

		if (false === ($pageStr = Shadowfunc::getItemPage($player, $items, $start_index, $page, $num_pages, $is_store)))
		{
			return self::arrayGet($text, 'no_page', Shadowrun4::lang('1009'));
		}
		
		$code = self::arrayGet($text, 'code', '5276');
		return $player->lang($code, array(sprintf('%s%s', self::arrayGet($text, 'prefix', Shadowrun4::lang('items')), $pageStr)));
// 		return sprintf('%s, %s', self::arrayGet($text, 'prefix', Shadowrun4::lang('items')), $pageStr);
	}
	
	public static function shortcutModifier($modifier)
	{
		return Shadowfunc::shortcut($modifier, SR_Player::$ALL);
// 		return true === isset(SR_Player::$REV_ALL[$modifier]) ? SR_Player::$REV_ALL[$modifier] : $modifier;
	}

	public static function shortcutEquipment($type)
	{
		return (false === ($index = array_search($type, SR_Player::$EQUIPMENT))) ? $type : $index;
	}
	
	public static function isSpell($spellname)
	{
		foreach (SR_Spell::getSpells() as $spell)
		{
			$spell instanceof SR_Spell;
			if ($spell->getName() === $spellname)
			{
				return true;
			}
		}
		return false;
	}
	
	public static function unshortcutVariable(SR_Player $player, $var)
	{
		$lang = Shadowlang::getVarFile();
		return self::unshortcut($var, $lang->getTrans($player->getLangISO()));
	}

	public static function shortcutVariable(SR_Player $player, $var)
	{
		$lang = Shadowlang::getVarFile();
		return self::shortcut($var, $lang->getTrans($player->getLangISO()));
	}

	public static function untranslateVariable(SR_Player $player, $var)
	{
		$lang = Shadowlang::getVariableFile();
		return self::unshortcut($var, $lang->getTrans($player->getLangISO()));
	}
	
	public static function translateVariable(SR_Player $player, $var)
	{
		return Shadowlang::langVariable($player, $var);
	}

	/**
	 * Turn a var into translated shortcut.
	 * @param SR_Player $player
	 * @param string $var
	 * @return string
	 */
	public static function translateVar(SR_Player $player, $var)
	{
		return self::shortcut($var, Shadowlang::getVarFile()->getTrans($player->getLangISO()));
	}
}
?>
