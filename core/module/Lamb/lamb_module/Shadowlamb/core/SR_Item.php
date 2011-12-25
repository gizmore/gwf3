<?php
require_once 'item/SR_Rune.php';
require_once 'item/SR_Usable.php';
require_once 'item/SR_QuestItem.php';
require_once 'item/SR_Consumable.php';
require_once 'item/SR_Grenade.php';
require_once 'item/SR_Equipment.php';
require_once 'item/SR_Cyberware.php';
require_once 'item/SR_Amulet.php';
require_once 'item/SR_Armor.php';
require_once 'item/SR_Boots.php';
require_once 'item/SR_Earring.php';
require_once 'item/SR_Helmet.php';
require_once 'item/SR_Legs.php';
require_once 'item/SR_Ring.php';
require_once 'item/SR_Shield.php';
require_once 'item/SR_Weapon.php';
require_once 'item/SR_FireWeapon.php';
require_once 'item/SR_MeleeWeapon.php';
require_once 'item/SR_Cyberdeck.php';

/**
 * A shadowrum item.
 * @author gizmore
 */
class SR_Item extends GDO
{
	const BROKEN = -2;
	const IMMORTAL = -1;
	
	####################
	### Static Items ###
	####################
	private static $items = array();
	
	/**
	 * @param string $name
	 * @return SR_Item
	 */
	public static function getItem($name) { return isset(self::$items[$name]) ? self::$items[$name] : false; }
	public static function getAllItems() { return self::$items; }
	public static function includeItem($filename, $fullpath)
	{
		Lamb_Log::logDebug("SR_Item::initItem($filename)");
		require_once $fullpath;
		$itemname = substr($filename, 0, -4);
		$classname = 'Item_'.$itemname;
		if (!class_exists($classname))
		{
			Lamb_Log::logError("SR_Item::initItem($fullpath) failed: no such class: $classname");
			die();
		}
		
		$item = new $classname(array(
			'sr4it_id' => 0,
			'sr4it_uid' => 0,
			'sr4it_name' => $itemname,
			'sr4it_ammo' => 0,
			'sr4it_amount' => 1,
			'sr4it_health' => 10000,
			'sr4it_modifiers' => NULL,
			'sr4it_duration' => -1,
		));
		
		self::$items[$itemname] = $item;
	}
	
	public static function deleteAllItems(SR_Player $player)
	{
		$pid = $player->getID();
		return self::table(__CLASS__)->deleteWhere("sr4it_uid=$pid");
	}
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_item'; }
	public function getColumnDefines()
	{
		return array(
			'sr4it_id' => array(GDO::AUTO_INCREMENT),
			'sr4it_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4it_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 63),
			'sr4it_ammo' => array(GDO::UINT, 0),
			'sr4it_amount' => array(GDO::UINT, 1),
			'sr4it_health' => array(GDO::UINT, 10000),
			'sr4it_modifiers' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4it_duration' => array(GDO::INT, -1), # sr time
		);
	}
	public function getID() { return $this->getInt('sr4it_id'); }
	public function getName() { return $this->getVar('sr4it_name'); }
	public function __toString() { return $this->getName().'{'.$this->getID().'}'; }
	public function getOwner() { return Shadowrun4::getPlayerByPID($this->getOwnerID()); }
	public function getOwnerID() { return $this->getVar('sr4it_uid'); }
	public function getAmmo() { return $this->getVar('sr4it_ammo'); }
	public function getDuration() { return $this->getVar('sr4it_duration'); }
	public function getAmount() { return $this->getVar('sr4it_amount'); }
	public function getHealth() { return $this->getVar('sr4it_health'); }
	public function getModifiers() { return $this->getVar('sr4it_modifiers'); }
	
	public function isEquipped(SR_Player $player) { return false; }
	public function setOwnerID($pid) { $this->setVar('sr4it_uid', $pid); }
	
	##################
	### StaticLoad ###
	##################
	public static function getTotalItemCount()
	{
		return count(self::$items);
	}
	/**
	 * @param string $itemname
	 * @param array $data
	 * @return SR_Item
	 */
	protected static function instance($itemname, $data=NULL)
	{
		if (!array_key_exists($itemname, self::$items)) {
			Lamb_Log::logError(sprintf('SR_Item::instance() failed: Unknown itemname: %s.', $itemname));
			return false;
		}
		
		$classname = 'Item_'.$itemname;

		if ($data === NULL)
		{
			$is_null = true;
			$data = array(
				'sr4it_id' => 0,
				'sr4it_uid' => 0,
				'sr4it_name' => $itemname,
				'sr4it_ammo' => 0,
				'sr4it_amount' => 1,
				'sr4it_health' => 10000,
				'sr4it_modifiers' => NULL,
				'sr4it_duration' => -1,
			);
		}
		else {
			$is_null = false;
		}
		
		$back = new $classname($data);
		
		if ($is_null === true)
		{
			$back->setVar('sr4it_ammo', $back->getBulletsMax());
			$back->setVar('sr4it_duration', $back->getItemDuration());
		}
		
		return $back;
	}
	
	/**
	 * @param unknown_type $itemid
	 * @return SR_Item
	 */
	public static function getByID($itemid)
	{
		if (0 >= ($itemid = (int) $itemid)) {
			return false;
		}
		
		$db = gdo_db();
		$table = GWF_TABLE_PREFIX.'sr4_item';
		if (false === ($result = $db->queryFirst("SELECT * FROM $table WHERE sr4it_id=$itemid"))) {
			return false;
		}

		if (false === ($item = self::instance($result['sr4it_name'], $result))) {
			return false;
		}

		$item->initModifiersB();

		return $item;
	}

	public static function checkModifiers($modstring)
	{
		foreach (explode(',', $modstring) as $modstr)
		{
			list($k, $v) = explode(':', $modstr);
			if (!self::isValidModifier($k))
			{
				Lamb_Log::logError(sprintf('Invalid modstring: %s. Invalid modifier: %s.', $modstring, $k));
				return false;
			}
		}
		return true;
	}
	
	private static function isValidModifier($k)
	{
		return
			( (in_array($k, SR_Player::$ATTRIBUTE))
			||(in_array($k, SR_Player::$SKILL))
			||(in_array($k, SR_Player::$COMBAT_STATS))
			||(in_array($k, SR_Player::$MAGIC_STATS))
			||(in_array($k, SR_Player::$MOUNT_STATS))
			||(SR_Spell::getSpell($k) !== false)
			);
	}
	
	/**
	 * LeatherVest_of_strength:1,quickness:4,marm:4,foo:4
	 * @param string $itemname
	 * @return SR_Item
	 */
	public static function createByName($itemname, $amount=true, $insert=true)
	{
		$name = Common::substrUntil($itemname, '_of_', $itemname);
		if (!array_key_exists($name, self::$items)) {
			Lamb_Log::logError(sprintf('SR_Item::createByName(%s) failed: Unknown itemname: %s.', $itemname, $name));
			return false;
		}
		$classname = "Item_$name";

		
		if ('' === ($modstring = Common::substrFrom($itemname, '_of_', ''))) {
			$modifiers = NULL;
		}
		else {
			$modifiers = $modstring;
			if (false === self::checkModifiers($modstring)) {
				return false;
			}
		}
		
		$item = self::instance($name);
		
		if ($amount === true)
		{
			$amount = self::$items[$name]->getItemDefaultAmount();
		}
		$item->setVar('sr4it_amount', $amount);
		$item->setVar('sr4it_modifiers', $modifiers);
		if ($insert === true)
		{
			if (false === $item->insert()) {
				return false;
			}
		}
		$item->initModifiersB();
		return $item;
	}
	
	############
	### Item ###
	############
	private $store_price = false;
	public function setStorePrice($price) { $this->store_price = $price; }
	public function getStorePrice() { return $this->store_price === false ? $this->getItemPrice() : $this->store_price; }
	
	private $modifiers = NULL;
	public function getItemModifiersB() { return $this->modifiers; }
	public function initModifiersB()
	{
		$modifiers = array();
		foreach (explode(',', $this->getVar('sr4it_modifiers')) as $data)
		{
			if ($data !== '')
			{
				$data = explode(':', $data);
				$modifiers[$data[0]] = (float)$data[1];
			}
		}
		
		if (count($modifiers) === 0)
		{
			$this->modifiers = NULL;
		}
		$this->modifiers = count($modifiers) ? $modifiers : NULL;
	}
	
	public function addModifiers(array $modifers, $update=true)
	{
		foreach ($modifers as $k => $v)
		{
			if (isset($this->modifiers[$k])) {
				$this->modifiers[$k] += $v;
			} else {
				$this->modifiers[$k] = $v;
			}
		}
		return $update === false ? true : $this->updateModifiers();
	}
	
	public function updateModifiers()
	{
		if (count($this->modifiers) === 0) {
			$modstring = NULL;
		}
		else {
			$modstring = '';
			foreach ($this->modifiers as $k => $v)
			{
				$modstring .= sprintf(',%s:%s', $k, $v);
			}
			$modstring = substr($modstring, 1);
		}
		return $this->saveVar('sr4it_modifiers', $modstring);		
	}
	
	
	public function getItemName()
	{
		$back = $this->getName();
		if ($this->modifiers === NULL) {
			return $back;
		}
		$mod = '';
		foreach ($this->modifiers as $key => $value)
		{
			$mod .= sprintf(',%s:%s', $key, $value);
		}
		return $back.'_of_'.substr($mod, 1);
	}
	
	public function deleteItem(SR_Player $owner)
	{
		if (false === $owner->removeFromInventory($this))
		{
			Lamb_Log::logError(sprintf('Item %s(%d) can not remove from inventory!', $this->getItemName(), $this->getID()));
			return false;
		}
		if (false === $this->delete())
		{
			Lamb_Log::logError(sprintf('Item %s(%d) can not delete me!', $this->getItemName(), $this->getID()));
			return false;
		}
		return true;
	}
	
	public function getItemModifiers(SR_Player $player)
	{
		$weight = $this->getItemWeightStacked();
		$back = array_merge(array('weight'=> $weight), $this->getItemModifiersA($player));
		if (NULL !== ($modB = $this->getItemModifiersB()))
		{
			$back = self::mergeModifiers($back, $modB);
		}
		return $back;
	}
	
	public function getItemInfo(SR_Player $player)
	{
		return sprintf('%s is %s%s. %s%s%s%s%s%s%s%s%s',
			$this->getName(),
			$this->displayType(),
			$this->displayLevel(),
			$this->getItemDescription(),
			$this->displayModifiersA($player),
			$this->displayModifiersB($player),
			$this->displayRequirements($player),
			$this->displayRange($player),
			$this->displayUseTime($player),
			$this->displayWeightB(),
			$this->displayDuration(),
			$this->displayWorth()
		);
	}
		
	private function displayRange(SR_Player $player)
	{
		$range = $this->getItemRange();
		return $range <= 0 ? '' : sprintf(" \X02Range\X02: %s.", Shadowfunc::displayDistance($range, 1));
	}
	
	private function displayUseTime(SR_Player $player)
	{
		if ($this instanceof SR_Weapon)
		{
			$t = $this->getAttackTime();
			return $t > 0 ? sprintf(" \X02UseTime\X02: %ss.", $t) : '';
		}
		else
		{
			return '';
		}
	}
	
	private function displayWorth()
	{
		$price = $this->getItemPrice();
		if ($price > 0) {
			$b = chr(2);
			return sprintf(' %sWorth%s: %s.', $b, $b, Shadowfunc::displayNuyen($price));
		}
		return '';
	}
	
	/**
	 * Use the amount of an item. Delete item when empty.
	 * @param SR_Player $player
	 * @param int $amount
	 * @return true|false
	 */
	public function useAmount(SR_Player $player, $amount=1)
	{
		if ($amount > $this->getAmount())
		{
			Lamb_Log::logError(sprintf('Item %s(%d) has not %d amount to use!', $this->getItemName(), $this->getID(), $amount));
			return false;
		}
		if (false === $this->increase('sr4it_amount', -$amount))
		{
			Lamb_Log::logError(sprintf('Item %s(%d) can not decrease amount %d!', $this->getItemName(), $this->getID(), $amount));
			return false;
		}
		
		$player->modify();
		
		return $this->getAmount() < 1 ? $this->deleteItem($player) : true;
	}
	
	###############
	### Display ###
	###############
	public function displayType()
	{
		return 'Item';
	}
	
	public function displayLevel()
	{
		$l = $this->getItemLevel();
		return $l < 0 ? '' : (' Lvl'.$l);
	}
	
	public function displayRequirements(SR_Player $player)
	{
		return Shadowfunc::getRequirements($player, $this->getItemRequirements());
	}
	
	public function displayModifiersA(SR_Player $player)
	{
		if ('' === ($out = Shadowfunc::getModifiers($this->getItemModifiersA($player)))) {
			return '';
		}
		return " {$out}.";
	}
	
	/**
	 * Display Rune Modifiers.
	 * @param SR_Player $player
	 */
	public function displayModifiersB(SR_Player $player)
	{
		if ($this->modifiers === NULL) {
			return '';
		}
		$b = chr(2);
		return sprintf(' %sModifiers%s: %s.', $b, $b, Shadowfunc::getModifiers($this->getItemModifiersB()));
	}
	
	private function displayWeightB()
	{
		$b = chr(2);
		return ('' === ($s = $this->displayWeight())) ? '' : " {$b}Weight{$b}: {$s}.";
	}
	
	public function displayWeight()
	{
//		$weight = $this->getItemWeightStacked();
		$weight = $this->getItemWeight();
		if ($weight <= 0)
		{
			return '';
		}
		$amount = $this->getAmount();
		$w = Shadowfunc::displayWeight($weight);
		if ($amount > 1)
		{
			return $amount.'x'.$w;
		}
		return $w;
	}
	
	public function getItemPriceStatted()
	{
		$price = $this->getItemPrice();
		if (NULL === ($mods = $this->getItemModifiersB())) {
			return $price;
		}
		return $price + SR_Rune::calcPrice($mods);
	}
	
	public function getInventoryID()
	{
		if (false === ($owner = $this->getOwner()))
		{
			return -1;
		}
		
		$name = $this->getItemName();
		$i = 1;
		foreach ($owner->getInventorySorted() as $itemname => $data)
		{
			if ($name === $itemname)
			{
				return $i;
			} 
			$i++;
		}
		
		return -1;
	}
	
	
	######################
	### Item Overrides ###
	######################
	public function getBulletsMax() { return 0; }
	public function getBulletsPerShot() { return 1; }
	public function getItemType() { return 'item'; }
	public function getItemSubType() { return 'item'; }
	public function getItemPrice() { return -1; }
	public function getItemWeight() { return -1; }
	public function getItemWeightStacked() { return $this->getItemWeight() * $this->getAmount(); }
	public function getItemPriceStacked() { return $this->getItemPrice() * $this->getAmount(); }
	public function getItemUsetime() { return 60; }
	public function getItemDuration() { return self::IMMORTAL; }
	public function getItemDescription() { return 'ITEM DESCRIPTION'; }
	public function getItemTypeDescr(SR_Player $player) { return ''; }
	public function getItemDefaultAmount() { return 1; }
	public function getItemRequirements() { return array(); }
	public function getItemDropChance() { return 100.00; }
	public function getItemAvail() { return 100.00; }
	public function isItemSellable() { return $this->getItemPrice() > 0; }
	public function isItemTradeable() { return true; }
	public function isItemStackable() { return true; }
	public function isItemStatted() { return $this->modifiers !== NULL; }
	public function isItemStattable() { return false; }
	public function isItemDropable() { return true; }
	public function isItemFriendly() { return false; }
	public function isItemOffensive() { return false; }
	public function getItemModifiersA(SR_Player $player) { return array(); }
	public function getItemLevel() { return -1; }
	public function getItemRange() { return 0.0; }
	
	################
	### Triggers ###
	################
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message('You can not use this item.');
		return false;
	}
	
	public function onItemEquip(SR_Player $player)
	{
		$player->message('You can not equip this item.');
		return false;
	}
	
	public function onItemUnequip(SR_Player $player)
	{
		$player->message('You can not equip this item.');
		return false;
	}
	
	############
	### Util ###
	############
	public static function mergeModifiers()
	{
		$back = array();
		foreach (func_get_args() as $arg)
		{
			if (is_array($arg))
			{
				foreach ($arg as $k => $v)
				{
					if (isset($back[$k]))
					{
						$back[$k] += $v;
					}
					else
					{
						$back[$k] = $v;
					}
				}
			}
		}
		return $back;
	}
	
	################
	### Duration ###
	################
	public function displayDuration()
	{
		return '';
		if ($this->isItemStackable())
		{
			return '';
		}
		if ($this->isImmortal())
		{
			return " \X02Immortal!\X02";
		}
		elseif ($this->isBroken())
		{
			return " \X02Broken!\X02";
		}
		else
		{
			return sprintf(" \X02Best before\X02: %s.", GWF_Time::humanDuration($this->getDuration()-Shadowrun4::getTime()));
		}
	}
	
	public function setRandomDuration()
	{
		$max = round($this->getItemDuration());
		$min = round($max / 2);
		$this->setVar('sr4it_duration', rand($min, $max));
	}
	
	public function setDuration($dur)
	{
		$dur += Shadowrun4::getTime();
		return $this->saveVars(array('sr4it_duration' => $dur));
	}
	
	public function alterDuration($by)
	{
		if (0 === ($by = ((int)$by)))
		{
			return true;
		}

		if (0 < ($d = $this->getDuration()))
		{
			return $this->saveVars(array('sr4it_duration' => $d+$by));
		}
		
		return true;
	}
	
	public function isBreaking()
	{
		if ($this->isItemStackable())
		{
			return false;
		}
		$d = $this->getDuration();
		if ($d > 0)
		{
			return $d < Shadowrun4::getTime();
		}
		else
		{
			return false;
		}
	}

	public function breakItem()
	{
		if (false === $this->saveVar('sr4it_duration', self::BROKEN))
		{
			return false;
		}
		return $this->onBreak();
	}
	
	public function isBroken()
	{
		return $this->getVar('sr4it_duration') == self::BROKEN;
	}
	
	public function isImmortal()
	{
		return $this->getVar('sr4it_duration') == self::IMMORTAL;
	}
	
	public function onBreak()
	{
		$player = $this->getOwner();
		$player->message(sprintf("Your %s broke.", $this->getItemName()));
		if ($this->isEquipped($player))
		{
			$this->onItemUnequip($player);
		}
		return true;
	}
	
}
?>
