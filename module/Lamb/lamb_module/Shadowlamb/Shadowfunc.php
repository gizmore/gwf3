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
	
	public static function getPlayerInLocationB(SR_Player $player, $name)
	{
		$name = strtolower($name);
		$n = self::toShortname($name);
		$candidates = array();
		$players = Shadowrun4::getPlayers();
		foreach ($players as $pl)
		{
			$pl instanceof SR_Player;
			
			if ($name === $pl->getName()) {
				return $pl;
			}
			
			if ($n !== strtolower($pl->getShortName())) {
				continue;
			}
			
			if (self::sharesLocation($player, $pl))
			{
				$candidates[] = $pl;
			}
		}
		$count = count($candidates);
		if ($count === 0) {
			return false;
		}
		elseif ($count === 1) {
			return $candidates[0];
		}
		return false;
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
	 * @param SR_Player $player
	 * @param string $arg
	 * @return SR_Player
	 */
	public static function getFriendlyTarget(SR_Player $player, $arg)
	{
		return $arg === '' ? $player : self::getTarget($player->getParty()->getMembers(), $arg);
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
	
	private static function getTarget(array $players, $arg)
	{
		if (is_numeric($arg))
		{
			if ( ($arg < 1)	|| ($arg > count($players)) ) {
				return false;
			}
			$arg = (int)$arg;
			$back = array_slice($players, $arg-1, 1, false);
			return $back[0];
		}

		$arg = strtolower($arg);
		$n = self::toShortname($arg);
		$candidates = array();
		foreach ($players as $target)
		{
			if (strtolower($target->getName()) === $arg) {
				return $target;
			}
			if (strtolower($target->getShortName()) === $n) {
				$candidates[] = $target;
			}
		}
		
		if (count($candidates) === 1) {
			return $candidates[0];
		}
		
		return false;
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
		foreach ($quests as $quest)
		{
			$back .= sprintf(', %d-%s', $i++, $quest->getQuestName());
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
	
	public static function dice($n, $min)
	{
		return rand(1, $n) <= $min;
	}
	
	public static function dicePool($dices, $n, $min)
	{
		$hits = 0;
		$m = Common::clamp($min, 1, $n);
		for ($i = 0; $i < $dices; $i++)
		{
			if (Shadowfunc::dice($n, $m))
			{
				$hits++;
			}
		}
		
		echo sprintf('Shadowfunc::dicePool(dices=%s, sides=%s, min=%s) === %s', $dices, $n, $min, $hits).PHP_EOL;
		
		return $hits;
	}
	
	public static function diceHits($mindmg, $arm, $atk, $def, SR_Player $player, SR_Player $target)
	{
		if ($player->isHuman())
		{
			if ($target->isHuman())
			{
				$oops = 25;
			}
			else # TARGET is NPC
			{
				$oops = 10;
			}
		}
		else # NPC attack
		{
			if ($target->isHuman())
			{
				$mc = $target->getParty()->getMemberCount();
				$oops = 2 + $mc * 3;
			}
			else # NPC attack NPC
			{
				$oops = 15;
			}
		}
		$chances = (($atk*7 + $mindmg*4) / ($def*2 + $arm*2)) * $oops;
		return Shadowfunc::dicePool((int)$chances, 3, 1);
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
			return $string;
		}
		return $key;
	}
	
	##############
	### Status ###
	##############
	public static function getStatus(SR_Player $player)
	{
		return sprintf('%s %s Level:%s, HP:%s/%s%s, Atk:%s, Def:%s, Dmg:%s-%s, Arm(M/F):%s/%s, XP:%.02f, Karma:%s, ¥:%.02f, Weight:%s/%s.',
			$player->getGender(), $player->getRace(), $player->getBase('level'),
			$player->getHP(), $player->get('max_hp'),
			$player->get('magic') > 0 ? sprintf(', MP:%s/%s', $player->getMP(), $player->get('max_mp')) : '', 
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
				$back .= sprintf(', %d-%s', $i, substr($p, $len));
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
			$back .= sprintf(', %d-%s', $i++, $w);
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
		$back = '';
		foreach ($player->getAllEquipment(true) as $key => $item)
		{
			$back .= sprintf(', %s:%s', $key, $item->getItemName());
		}
		return substr($back, 2);
	}
	
	private static function getStatsArray(SR_Player $player, array $fields)
	{
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
			$back .= sprintf(', %s:%s%s', $field, $base, $now);
		}
		return $back === '' ? 'None' : substr($back, 2);
	}
	
	public static function getEffects(SR_Player $player)
	{
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
			$back .= sprintf(', %s:%s(%s)', $k, $v, GWF_Time::humanDurationEN($t-$t2));
		}
		
		return substr($back, 2);
	}
	
	public static function getSpells(SR_Player $player)
	{
		$back = '';
		foreach ($player->getSpellData() as $name => $base)
		{
			$mod = $player->get($name);
			$mod = $mod > $base ? "($mod)" : '';
			$back .= sprintf(', %s:%s%s', $name, $base, $mod);
		}
		return $back === '' ? 'None' : substr($back, 2);
	}
	
	public static function getBank(SR_Player $player)
	{
		return self::getItemsSorted($player, $player->getBankSorted());
	}
	
	public static function getInventory(SR_Player $player)
	{
		return self::getItemsSorted($player, $player->getInventorySorted());
	}
	
	private static function getItemsSorted(SR_Player $player, array $items)
	{
		$back = '';
		$i = 1;
		foreach ($items as $itemname => $data)
		{
			$count = $data[0];
			$itemid = $data[1];
			$count = $count > 1 ? "($count)" : '';
			$back .= sprintf(', %s:%s%s', $i++, $itemname, $count);
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
			'elvemale' => array('Filöen'),
			'elvefemale' => array('Anja'),
			'halfelvemale' => array('Filöen'),
			'halfelvefemale' => array('Anja'),
			'humanmale' => array('Rolf','Peter','Paul'),
			'humanfemale' => array('Mary'),
			'dwarfmale' => array('Roon'),
			'dwarffemale' => array('Alisa'),
			'halftrollmale' => array('Roon'),
			'halftrollfemale' => array('Björk'),
			'trollmale' => array('Roog'),
			'trollfemale' => array('Gunda'),
		);
		$r = $rand[$player->getVar('sr4pl_race').$player->getVar('sr4pl_gender')];
		return $r[rand(0,count($r)-1)];
	}
	
	##############
	### Prices ###
	##############
	public static function calcBuyPrice($price, SR_Player $player)
	{
		$neg = Common::clamp((int)$player->get('negotiation'), 0, 50);
		$f = (100 - $neg) / 100;
		return round($price*$f, 2);
	}
	
	public static function calcSellPrice($price, SR_Player $player)
	{
		$neg = Common::clamp((int)$player->get('negotiation'), 0, 50);
		$f = (100 + $neg) / 100;
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
			if ($player->getBase($k) < $v) {
				$back .= sprintf(', %s:%s', $k, $v);
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
		return sprintf(' Requires: %s.', substr($back, 2));
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
	 * Get random loot for a player.
	 * @param SR_Player $player
	 * @return array
	 */
	public static function randLoot(SR_Player $player, $level)
	{
		$items = SR_Item::getAllItems();
		$possible = array();
//		$level = (int)$player->getBase('level');
		$total = 0;
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			$il = $item->getItemLevel();
			if ($il > $level || $il < 0) {
				continue;
			}
			$dc = round($item->getItemDropChance()*100);
			$possible[] = array($item->getName(), $dc);
			$total += $dc;
		}

		$i = 1.414;
		$back = array();
		while (true)
		{
			if (false === ($drop = self::randLootItem($player, $level, $possible, $total, $total*$i))) {
				break;
			}
			$i *= $i;
			$back[] = $drop;
		}
		return $back;
	}

	public static function randomData(array $data, $total, $chance_none=0)
	{
		$total = (int)$total;
		$chance_none = (int) $chance_none;
		
		shuffle($data);
		
		$chance = $total + $chance_none;
		$rand = rand(1, $chance);
		
		Lamb_Log::log(sprintf('Shadowfunc::randomData(%s, %s) Dice: %s', $total, $chance_none, $rand));
		
		if ($rand <= $chance_none) {
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
		if (false === ($data = self::randomData($possible, $total, $chance_none))) {
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
			if (!self::dicePercent($chance[$i])) {
				break;
			}
			
			if (false === ($modifiers = SR_Rune::randModifier($player, $level))) {
				break;
			}
			$item->addModifiers($modifiers, false);
		}
		if ($i > 0) {
			$item->updateModifiers();
		}
	}
}
?>