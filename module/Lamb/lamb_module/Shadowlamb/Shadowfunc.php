<?php
final class Shadowfunc
{
	public static function toShortname($name)
	{
		if (false !== ($pos = strrpos($name, '{'))) {
			return substr($name, 0, $pos);
		} else {
			return $name;
		}
	}
	
//	public static function getPlayerInLocationB(SR_Player $player, $name)
//	{
//		$name = strtolower($name);
//		$n = self::toShortname($name);
//		$candidates = array();
//		$players = Shadowrun4::getPlayers();
//		foreach ($players as $pl)
//		{
//			$pl instanceof SR_Player;
//			
//			if ($name === $pl->getName()) {
//				return $pl;
//			}
//			
//			if ($n !== strtolower($pl->getShortName())) {
//				continue;
//			}
//			
//			if (self::sharesLocation($player, $pl))
//			{
//				$candidates[] = $pl;
//			}
//		}
//		$count = count($candidates);
//		if ($count === 0) {
//			return false;
//		}
//		elseif ($count === 1) {
//			return $candidates[0];
//		}
//		return false;
//	}
	
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
		
		if ($own_members)
		{
			if (false !== ($target = self::getTarget($player->getParty()->getMembers(), $arg, true)))
			{
				return $target;
			}
		}
		
		if (false !== ($target = self::getTarget(self::getPlayersInLocation($player, false), $arg, false)))
		{
			return $target;
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
	
	public static function getTarget(array $players, $arg, $enum=true)
	{
		if ($arg === '')
		{
			return Shadowfunc::randomListItem($players);
		}

		# enum
		if ($enum && is_numeric($arg))
		{
			if ( ($arg > 0)	&& ($arg <= count($players)) )
			{
				$arg = (int)$arg;
				$back = array_slice($players, $arg-1, 1, false);
				return $back[0];
			}
		}

		$arg = strtolower($arg);
		$n = self::toShortname($arg);
		$candidates = array();
		foreach ($players as $target)
		{
//			echo sprintf('Checking %s against %s', $target->getName(), $arg).PHP_EOL;
			if (strtolower($target->getName()) === $arg)
			{
				return $target;
			}
			
//			echo sprintf('Checking %s against %s', $target->getShortName(), $n).PHP_EOL;
			if (strtolower($target->getShortName()) === $n)
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
	public static function getQuests(SR_Player $player, $section)
	{
		if (false === ($quests = SR_Quest::getQuests($player, $section))) {
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
		return $back === '' ? ('You have no '.$section.' quests.') : substr($back, 2);
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
		echo "diceFloat($min, $max) = $back\n";
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
		echo sprintf('Shadowfunc::dicePool(dices=%s, sides=%s, min=%s) === %s hits', $dices, $n, $min, $hits).PHP_EOL;
		return $hits;
	}
	
	public static function diceHits($mindmg, $arm, $atk, $def, SR_Player $player, SR_Player $target)
	{
		$ep = $target->getParty();
		if ($player->isHuman()) # Human attacks ... 
		{
			if ($target->isHuman()) # Human attacks Human
			{
				$oops = rand(80, 250) / 10;
			}
			else # Human Attacks NPC
			{
				$oops = rand(80, 150) / 10;
			}
		}
		else # NPC attacks ...
		{
			if ($target->isHuman()) # NPC attacks Human
			{
				$rand = rand(11, 15) / 10;
				$oops = $rand + $ep->getMemberCount()*0.4 + $ep->getMax('level')*0.01;
			}
			else # NPC attacks NPC
			{
				$oops = rand(80, 250) / 10;
			}
		}
		$chances = (($atk*10 + $mindmg*5) / ($def*5 + $arm*2)) * $oops;
		return Shadowfunc::dicePool(round($chances), round($def)+1, round(sqrt($def)));
	}	
	
	#################
	### Shortcuts ###
	#################
	public static function unshortcut($string, array $array)
	{
		$string = strtolower($string);
		return isset($array[$string]) ? $array[$string] : $string;
	}
	
	public static function shortcut($string, array $array)
	{
		if (false === ($key = array_search(strtolower($string), $array, true))) {
			return strtolower($string);
		}
		return strtolower($key);
	}
	
	##############
	### Status ###
	##############
	public static function getStatus(SR_Player $player)
	{
		$b = chr(2);
		return sprintf("%s %s Lvl%s. {$b}HP{$b}:%s/%s%s, {$b}Atk{$b}:%s, {$b}Def{$b}:%s, {$b}Dmg{$b}:%s-%s, {$b}Arm{$b}(M/F):%s/%s, {$b}XP{$b}:%.02f, {$b}Karma{$b}:%s, {$b}¥{$b}:%.02f, {$b}Weight{$b}:%s/%s.",
			$player->getGender(), $player->getRace(), $player->getBase('level'),
			$player->getHP(), $player->get('max_hp'),
			$player->get('magic') > 0 ? sprintf(", {$b}MP{$b}:%s/%s", $player->getMP(), $player->get('max_mp')) : '', 
			$player->get('attack'), $player->get('defense'),
			$player->get('min_dmg'), $player->get('max_dmg'),
			$player->get('marm'), $player->get('farm'),
			$player->getBase('xp'), $player->getBase('karma'),
			$player->getBase('nuyen'),
			self::displayWeight($player->get('weight')), self::displayWeight($player->get('max_weight'))
		);
	}
	
	public static function getKnownPlaces(SR_Player $player, $cityname)
	{
		$cityname = strtolower($cityname);
		$b = chr(2);
		$back = '';
		$kp = $player->getVar('sr4pl_known_places');
		$i = 1;
		$cn = $cityname.'_';
		$len = strlen($cn);
		foreach (explode(',', $kp) as $p)
		{
			if ($p === '') {
				continue;
			}
			if (stripos($p, $cn) === 0)
			{
				$back .= sprintf(', %s-%s', $b.$i.$b, substr($p, $len));
			}
			$i++;
		}
		return substr($back, 2);
	}
	
	public static function getKnownWords(SR_Player $player)
	{
		$i = 1;
		$back = '';
		foreach (explode(',', trim($player->getVar('sr4pl_known_words'), ',')) as $w)
		{
			$back .= sprintf(", \x02%s\x02-%s", $i++, $w);
		}
		return $back === '' ? 'You don`t know any word' : substr($back, 2);
	}
	
	
	public static function getPartyStatus(SR_Player $player)
	{
		$party = $player->getParty();
		$action = $party->displayAction();
		$mc = $party->getMemberCount();
		
		$with_distance = $party->isFighting();
		
		if ($mc === 1)
		{
			return sprintf('You are %s', $action);
		}
		elseif ($player->isLeader())
		{
			return sprintf('You are leading %d members (%s) and you are %s', $mc, $party->displayMembers($with_distance), $action);
		}
		else {
			return sprintf('Your party (%s) is %s', $party->displayMembers($with_distance), $action);
		}
	}
	
	public static function getSkills(SR_Player $player)
	{
		return self::getStatsArray($player, SR_Player::$SKILL);
	}
	
	public static function getAttributes(SR_Player $player)
	{
		return self::getStatsArray($player, SR_Player::$ATTRIBUTE);
	}
	
	public static function getEquipment(SR_Player $player)
	{
		$b = chr(2);
		$back = '';
		foreach ($player->getAllEquipment(true) as $key => $item)
		{
			$back .= sprintf(', %s:%s', "{$b}$key{$b}", $item->getItemName());
		}
		return substr($back, 2);
	}
	
	private static function getStatsArray(SR_Player $player, array $fields)
	{
		$b = chr(2);
		$back = '';
		foreach ($fields as $field)
		{
			if (0 > ($base = $player->getBase($field))) {
				continue;
			}
			$now = $player->get($field);
			
			if ($base < 0 && $now < 0) {
				continue;
			}
			
			$now = $base == $now ? '' : "($now)";
			$back .= sprintf(', %s:%s%s', $b.$field.$b, $base, $now);
		}
		return $back === '' ? 'None' : substr($back, 2);
	}
	
	public static function getEffects(SR_Player $player)
	{
		$b = chr(2);
		$e = $player->getEffects();
		if (count($e) === 0) {
			return 'none';
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
		$back = '';
		foreach ($sorted as $k => $data)
		{
			list($v, $t) = $data;
			$back .= sprintf(', %s:%s(%s)', $b.$k.$b, $v, GWF_Time::humanDuration($t-$t2));
		}
		
		return substr($back, 2);
	}
	
	public static function getSpells(SR_Player $player)
	{
		$back = '';
		$b = chr(2);
		$i = 1;
		foreach ($player->getSpellData() as $name => $base)
		{
			$mod = $player->get($name);
			$mod = $mod > $base ? "($mod)" : '';
			$back .= sprintf(', %s-%s:%s%s', $b.$i.$b, $name, $base, $mod);
			$i++;
		}
		return $back === '' ? 'None' : substr($back, 2);
	}
	
	public static function getBank(SR_Player $player)
	{
		return self::getItemsSorted($player, $player->getBankSorted());
	}
	
	public static function getMountInv(SR_Player $player)
	{
		return self::getItemsSorted($player, $player->getMountInvSorted());
	}
	
	public static function getInventory(SR_Player $player)
	{
		return self::getItemsSorted($player, $player->getInventorySorted());
	}
	
	private static function getItemsSorted(SR_Player $player, array $items)
	{
		$b = chr(2);
		$back = '';
		$i = 1;
		foreach ($items as $itemname => $data)
		{
			$count = $data[0];
			$itemid = $data[1];
			$count = $count > 1 ? "($count)" : '';
			$back .= sprintf(', %s-%s%s', $b.($i++).$b, $itemname, $count);
		}
		
		if ($back === '') {
			return 'Empty';
		}
		
		return substr($back, 2);
		
	}
	
	public static function getCyberware(SR_Player $player)
	{
		$i = 1;
		$back = '';
		foreach ($player->getCyberware() as $item)
		{
			$back .= sprintf(', %d-:%s', $i++, $item->getItemName());
		}
		return $back === '' ? 'None' : substr($back, 2);
	}
	
	###################
	### Random Name ###
	###################
	public static function getRandomName(SR_Player $player)
	{
		static $rand = array(
			'fairy_male' => array('Schwunkol'),
			'fairy_female' => array('Ambra','Elina'),
			'vampire_male' => array('Dracool'),
			'vampire_female' => array('Daria'),
			'elve_male' => array('Filöen'),
			'elve_female' => array('Anja'),
			'darkelve_male' => array('Noplan'),
			'darkelve_female' => array('Noplan'),
			'woodelve_male' => array('Noplan'),
			'woodelve_female' => array('Noplan'),
			'halfelve_male' => array('Filöen'),
			'halfelve_female' => array('Anja'),
			'human_male' => array('Rolf','Peter','Paul','Homer','Carl','Lenny'),
			'human_female' => array('Mary',''),
			'dwarf_male' => array('Roon'),
			'dwarf_female' => array('Alisa'),
			'ork_male' => array('Grunt'),
			'ork_female' => array('Broga'),
			'halfork_male' => array('Bren'),
			'halfork_female' => array('Yuly'),
			'halftroll_male' => array('Roon'),
			'halftroll_female' => array('Björk'),
			'troll_male' => array('Roog'),
			'troll_female' => array('Gunda'),
			'gremlin_male' => array('gizmo'),
			'gremlin_female' => array('gizma'),
		);
		$r = $rand[$player->getVar('sr4pl_race').'_'.$player->getVar('sr4pl_gender')];
		return $r[rand(0,count($r)-1)];
	}
	
	##############
	### Prices ###
	##############
	public static function calcBuyPrice($price, SR_Player $player)
	{
		$neg = Common::clamp((int)$player->get('negotiation'), 0, 100);
		$f = (200 - $neg) / 200;
		return round($price*$f, 2);
	}
	
	public static function calcSellPrice($price, SR_Player $player)
	{
		$neg = Common::clamp((int)$player->get('negotiation'), 0, 100);
		$f = (100 + ($neg/2)) / 100;
		return round($price*$f, 2);
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
		return sprintf('%s%.02f(%.02f/%.02f)%s', $sign, $gain, $now, $max, $unit);
	}
	
	public static function displayPrice($price)
	{
		return sprintf('%.02f¥', $price);
	}
	
	public static function displayWeight($weight)
	{
		return $weight > 1000 ? sprintf('%.02fkg', $weight/1000) : $weight.'g';
	}
	
	public static function displayDistance($distance, $precision=1)
	{
		return sprintf("%.0{$precision}fm", $distance);
	}
	
	public static function displayBusy($seconds)
	{
		return sprintf('%s busy.', GWF_Time::humanDuration($seconds));
	}
	
	public static function displayETA($seconds)
	{
		return sprintf('ETA: %s.', GWF_Time::humanDuration($seconds));
	}
	
	public static function displayASL(SR_Player $player)
	{
		$b = chr(2);
		if (0 >= ($age = $player->getBase('age')))
		{
			return 'No asl info';
		}
		return sprintf("{$b}Age{$b}:%d, %dcm %s", $age, $player->getBase('height'), Shadowfunc::displayWeight($player->getBase('bmi')));
	}
	
	####################
	### Requirements ###
	####################
	/**
	 * Check if player mets the requirements. return error message or false.
	 * @param SR_Player $player
	 * @param array $requirements
	 * @return error message or false on success
	 */
	public static function checkRequirements(SR_Player $player, array $requirements)
	{
		if (count($requirements) === 0) {
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
		
		if ($back === '') {
			return false;
		}
		
		return sprintf('You do not meet the requirements: %s.', substr($back, 2));
		
	}
	
	public static function getRequirements(SR_Player $player, array $requirements)
	{
		if (count($requirements) === 0) {
			return '';
		}
		$back = '';
		foreach ($requirements as $k => $v)
		{
			$b = $player->getBase($k) < $v;
			$b = $b === true ? chr(2) : '';
			$back .= sprintf(', %s%s:%s%s', $b, $k, $v, $b);
		}
		$b = chr(2);
		return sprintf(' %sRequires%s: %s.', $b, $b, substr($back, 2));
	}
	
	public static function getModifiers(array $modifiers)
	{
		if (count($modifiers) === 0) {
			return '';
		}
		$back = '';
		foreach ($modifiers as $k => $v)
		{
			$back .= sprintf(', %s:%s', $k, $v);
		}
		return substr($back, 2);
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
	 * @return array
	 */
	public static function randLoot(SR_Player $player, $level, $high_chance=array())
	{
		$back = array();
		
		$items = SR_Item::getAllItems();
		$total = 0;
		$possible = array();
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			$il = $item->getItemLevel();
			if ($il > $level || $il < 0)
			{
				continue;
			}
			$chance = 100;
//			$chance += round($player->get('luck')/2);
			if (in_array($item->getItemName(), $high_chance))
			{
				$chance *= 2;
			}
			$chance = round($chance);
			
			$dc = round($item->getItemDropChance()*$chance);
			$possible[] = array($item->getName(), $dc);
			$total += $dc;
		}

		$chance_none = 1.80;
		$chance_none -= ($player->get('luck') / 200) - ($player->getParty()->getPartyLevel() / 200);
		$i = $chance_none;
		while (true)
		{
			if (false === ($drop = self::randLootItem($player, $level, $possible, $total, $total*$i)))
			{
				break;
			}
			
			$back[] = $drop;
			
			$i *= $i;
		}
		
		return $back;
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
		Lamb_Log::logDebug(sprintf('Shadowfunc::randomData(): Total(%s)+None(%s)=MAX(%s). Dice: %s', $total, $chance_none, $chance, $rand));
		if ($rand <= $chance_none)
		{
			return false;
		}
		shuffle($data);
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
		
		$item = SR_Item::createByName($itemname, $def->getItemDefaultAmount(), true);
		
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
		
		return $items[array_rand($items, 1)];
	}
	
	public static function calcDistance(SR_Player $player, SR_Player $target)
	{
		$x1 = $player->getEnum() * SR_Party::X_COORD_INC;
		$y1 = $player->getDistance();
		$x2 = $target->getEnum() * SR_Party::X_COORD_INC;
		$y2 = $target->getDistance();
		return self::calcDistanceB($x1, $y1, $x2, $y2);
	}

	public static function calcDistanceB($x1, $y1, $x2, $y2)
	{
		$x = $x2 - $x1;
		$y = $y2 - $y1;
		return sqrt($x*$x + $y*$y);
	}
}
?>