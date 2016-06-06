<?php
require_once 'SR_Player.php';
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
	public static function getItemCI($name) { return GWF_Array::getCaseI(self::$items, $name); }
	public static function exists($name) { return isset(self::$items[$name]); }
	public static function getAllItems() { return self::$items; }
	public static function getTotalItemCount() { return count(self::$items); }
	public static function includeItem($filename, $fullpath)
	{
// 		Dog_Log::debug("SR_Item::initItem($filename)");
		require_once $fullpath;
		$itemname = substr($filename, 0, -4);
		$classname = 'Item_'.$itemname;
		if (!class_exists($classname))
		{
			Dog_Log::error("SR_Item::initItem($fullpath) failed: no such class: $classname");
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
			'sr4it_position' => array(GDO::ENUM|GDO::INDEX, GDO::NULL, array_merge(array('delete', 'inventory', 'cyberware', 'mount_inv', 'bank'), array_values(SR_Player::$EQUIPMENT))),
			'sr4it_microtime' => array(GDO::DECIMAL|GDO::INDEX, NULL, array(12,6)),
		);
	}
	
	public function __toString() { return $this->getName().'{'.$this->getID().'}'; }
	
	public function getID() { return $this->getInt('sr4it_id'); }
	public function getName() { return $this->getVar('sr4it_name'); }
	public function getOwner() { return Shadowrun4::getPlayerByPID($this->getOwnerID()); }
	public function getOwnerID() { return $this->getVar('sr4it_uid'); }
	public function getAmmo() { return $this->getVar('sr4it_ammo'); }
	public function getDuration() { return $this->getVar('sr4it_duration'); }
	public function getAmount() { return $this->getVar('sr4it_amount'); }
	public function getHealth() { return $this->getVar('sr4it_health'); }
	public function getModifiers() { return $this->getVar('sr4it_modifiers'); }
	
	public function isEquipped(SR_Player $player) { return false; }
	public function setOwnerID($pid) { $this->setVar('sr4it_uid', $pid); }
	public function setAmount($amt) { $this->setVar('sr4it_amount', $amt); }
	public function getMicrotime() { return $this->getVar('sr4it_microtime'); }
	public function saveMicrotime($microtime) { return $this->saveVar('sr4it_microtime', $microtime); }
	
	public function getPosition() { return $this->getVar('sr4it_position'); }

	public function changePosition($position)
	{
		return $this->saveVars(array(
			'sr4it_position' => $position,
			'sr4it_microtime' => microtime(true),
		));
	}

	public function changeOwnerAndPosition($pid, $position)
	{
		return $this->saveVars(array(
			'sr4it_uid' => $pid,
			'sr4it_position' => $position,
			'sr4it_microtime' => microtime(true),
		));
	}
	
	##################
	### StaticLoad ###
	##################
	/**
	 * @param string $itemname
	 * @param array $data
	 * @return SR_Item
	 */
	public static function instance($itemname, $data=NULL)
	{
		if (!array_key_exists($itemname, self::$items))
		{
			Dog_Log::error(sprintf('SR_Item::instance() failed: Unknown itemname: %s.', $itemname));
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
				'sr4it_position' => 'delete',
				'sr4it_microtime' => microtime(true),
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
				Dog_Log::error(sprintf('Invalid modstring: %s. Invalid modifier: %s.', $modstring, $k));
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
	 * @param int $amount
	 * @param boolean $insert
	 * @return SR_Item
	 */
	public static function createByName($itemname, $amount=true, $insert=true)
	{
// 		printf("%s(%s, %s, %s)\n", __METHOD__, $itemname, $amount, $insert);
		
		if ($amount === true)
		{
// 			printf("%s(%s, %s, %s)\n", __METHOD__, $itemname, $amount, $insert);
			if (preg_match('/^(\\d+)x(.*)$/iD', $itemname, $matches))
			{
				$amount = (int) $matches[1];
				$itemname = $matches[2];
			}
		}
		
		$name = Common::substrUntil($itemname, '_of_', $itemname);
		if (!array_key_exists($name, self::$items))
		{
			Dog_Log::error(sprintf('SR_Item::createByName(%s) failed: Unknown itemname: %s.', $itemname, $name));
			return false;
		}
		$classname = "Item_$name";

		if ('' === ($modstring = Common::substrFrom($itemname, '_of_', '')))
		{
			$modifiers = NULL;
		}
		else
		{
			$modifiers = $modstring;
			if (false === self::checkModifiers($modstring))
			{
				return false;
			}
		}
		
		$item = self::instance($name);
		
		if ($amount === true || $amount === false) # not a number
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

	public function createCopy($insert=true)
	{
		$item = self::instance($this->getName());
		$item->setVar('sr4it_amount', $this->getAmount());
		$item->setVar('sr4it_modifiers', $this->getModifiers());
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
// 	public function getItemModifiersW(SR_Player $player) { return array(); }
	public function getItemModifiersB() { return $this->modifiers; }
	public function getItemModifiersBArray() { return $this->modifiers === NULL ? array() : $this->modifiers; }
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
	
	/**
	 * Get raw database full item name including modifiers.
	 * @example Foo_of_bar:1,foobar:2
	 * @return string
	 */
	public function getItemName()
	{
		$back = $this->getName();
		if ($this->modifiers === NULL)
		{
			return $back;
		}
		$mod = '';
		foreach ($this->modifiers as $key => $value)
		{
			$mod .= sprintf(',%s:%s', $key, $value);
		}
		return $back.'_of_'.substr($mod, 1);
	}
	
	public function deleteItem(SR_Player $owner, $modify=true)
	{
		if (false === $owner->removeFromPlayer($this, $modify))
		{
			Dog_Log::error(sprintf('Item %s(%d) can not remove from player!', $this->getItemName(), $this->getID()));
			return false;
		}
		if (false === $this->delete())
		{
			Dog_Log::error(sprintf('Item %s(%d) can not delete me!', $this->getItemName(), $this->getID()));
			return false;
		}
		return true;
	}
	
	public function getItemModifier(SR_Player $player, $field)
	{
		$values = $this->getItemModifiers($player);
		return $values[$field];
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
		return $this->displayItemInfo($player);
// 		return $player->getLangISO() === 'bot'
// 			? $this->displayPacked($player)
// 			: $this->displayItemInfo($player);
	}
	
	public function displayItemInfo($player)
	{
		return $player->lang('fmt_examine', array(
			Shadowlang::displayItemname($player, $this),
			$player->lang($this->displayType()),
			$this->displayLevel($player),
			$this->displayDescription($player),
			$this->displayModifiersA($player),
			$this->displayModifiersB($player),
			$this->displaySetModifiers($player),
			$this->displayRequirements($player),
			$this->displayRange($player),
			$this->displayUseTime($player),
			$this->displayWeightB(),
			$this->displayDuration(),
			$this->displayWorth(),
		));
	}
	
	public function displayPacked(SR_Player $player)
	{
		return $player->lang('fmt_exx', array(
			Shadowlang::getItemUUID($this),
			$this->getAmount(),
			$this->getItemLevel(),
			Shadowfunc::displayModifiersPacked($player, $this->getItemModifiersA($player)),
			Shadowfunc::displayModifiersPacked($player, $this->getItemModifiersB($player)),
			Shadowfunc::displayModifiersPacked($player, $this->getItemRequirements()),
			$this->getItemPrice(),
			$this->getItemWeight(),
			$this->getItemRange(),
			$this->getItemUsetime(),
		));
	}
	
	public function getNamePacked(SR_Player $player)
	{
		$back = '';
		if (1 < ($amt = $this->getAmount()))
		{
			$back .= $amt.'x';
		}
		$back .= $this->getName();
		if ($this->isItemStatted())
		{
			$back .= '_of_'.Shadowfunc::displayModifiersPacked($player, $this->getItemModifiersB($player));
		}
		return $back;
	}
	
	public function displayDescription(SR_Player $player)
	{
		if ($player->getLangISO() === 'bot')
		{
			return '';
		}
		return Shadowlang::displayItemdescr($player, $this);
	}
		
	private function displayRange(SR_Player $player)
	{
		$range = $this->getItemRange();
// 		return $range <= 0 ? '' : sprintf(" \X02Range\X02: %s.", Shadowfunc::displayDistance($range, 1));
		return $range <= 0 ? '' : $player->lang('range', array(Shadowfunc::displayDistance($range, 1)));
	}
	
	private function displayUseTime(SR_Player $player)
	{
		if ($this instanceof SR_Weapon)
		{
			$t = $this->getRealAttackTime();
			return $t > 0 ? $player->lang('atk_time', array($t)) : '';
// 			return $t > 0 ? sprintf(" \X02UseTime\X02: %ss.", $t) : '';
		}
		else
		{
			return '';
		}
	}
	
	public function getRealAttackTime()
	{
		$t = $this->getAttackTime(); # normal seconds
		if (false === ($owner = $this->getOwner()))
		{
			return $t;
		}
		$mod = $owner->get('attack_time'); # get rune power
		$mod = round($mod * SR_Player::ATTACK_TIME_SECONDS, 1); # to seconds
		return $t - $mod;
	}
	
	private function displayWorth()
	{
		$price = $this->getItemPrice();
		if ($price > 0)
		{
			return Shadowrun4::lang('worth', array(Shadowfunc::displayNuyen($price)));
// 			$b = chr(2);
// 			return sprintf(' %sWorth%s: %s.', $b, $b, Shadowfunc::displayNuyen($price));
		}
		return '';
	}
	
	/**
	 * Use the amount of an item. Delete item when empty.
	 * @param SR_Player $player
	 * @param int $amount
	 * @return true|false
	 */
	public function useAmount(SR_Player $player, $amount=1, $modify=true)
	{
		if ($amount > $this->getAmount())
		{
			Dog_Log::error(sprintf('Item %s(%d) has not %d amount to use!', $this->getItemName(), $this->getID(), $amount));
			return false;
		}
		if (false === $this->increase('sr4it_amount', -$amount))
		{
			Dog_Log::error(sprintf('Item %s(%d) can not decrease amount %d!', $this->getItemName(), $this->getID(), $amount));
			return false;
		}

		$player->itemAmountChanged($this, -$amount, false);

		if ($this->getAmount() < 1)
		{
			return $this->deleteItem($player, $modify);
		}
		
		if ($modify)
		{
			$player->modify();
		}
		
		return true;
	}
	
	###############
	### Display ###
	###############
	public function displayName(SR_Player $player, $colors=true) { return Shadowlang::displayItemname($player, $this, $colors); }
	public function displayFullName(SR_Player $player, $short_mods=false, $colors=true) { return Shadowlang::displayItemnameFull($player, $this, $short_mods, $colors); }
	public function displayType() { return 'Item'; }
	public function displayEquipmentType(SR_Player $player) { return Shadowrun4::langPlayer($player, $this->getItemType()); }
	public function displayLevel(SR_Player $player) { return Shadowfunc::displayALevel($this->getItemLevel()); }
	public function displayRequirements(SR_Player $player) { return Shadowfunc::getRequirements($player, $this->getItemRequirements()); }
	
	public function displayModifiersA(SR_Player $player)
	{
		if ('' === ($out = Shadowfunc::displayModifiers($player, $this->getItemModifiersA($player))))
		{
			return '';
		}
		
		return ($player->getLangISO() === 'bot') ? $out : " {$out}.";
	}
	
	/**
	 * Display Rune Modifiers.
	 * @param SR_Player $player
	 */
	public function displayModifiersB(SR_Player $player)
	{
		if ($this->modifiers === NULL)
		{
			return '';
		}
		return Shadowrun4::lang('modifiers', array(Shadowfunc::displayModifiers($player, $this->getItemModifiersB())));
// 		$b = chr(2);
// 		return sprintf(' %sModifiers%s: %s.', $b, $b, Shadowfunc::getModifiers($this->getItemModifiersB()));
	}
	
	public function displaySetModifiers(SR_Player $player)
	{
		if (false === ($set = SR_SetItems::getSetForItem($this->getName())))
		{
			return '';
		}
		
		if (SR_SetItems::hasSet($player, $set))
		{
			$b = $i = "\X02\X036";
			$b2 = $i2 = "\X03\X02";
		}
		else
		{
			$b = $i = "\X02\X0315";
			$b2 = $i2 = "\X03\X02";
// 			$b = $b2 = $i = $i2 = ''; # italic
		}
		return ' '.Shadowrun4::lang('set_modifiers', array($b, $set, $b2, $i, Shadowfunc::displayModifiers($player, SR_SetItems::getModifiersForSet($set)), $i2));
	}
	
	private function displayWeightB()
	{
		return ('' === ($s = $this->displayWeight())) ? '' : Shadowrun4::lang('weight', array($s));
// 		$b = chr(2);
// 		return ('' === ($s = $this->displayWeight())) ? '' : " {$b}Weight{$b}: {$s}.";
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

		$index = $owner->getInventory()->getGroupedIndex($itemname);
		
		return $index === false ? -1 : $index+1;
	}
	
	
	######################
	### Item Overrides ###
	######################
	public final function getItemUUID() { return Shadowlang::getItemUUID($this); }
	public function getItemModifiersA(SR_Player $player) { return array(); }
	public function getItemAvail() { return 100.00; }
	public function getItemDropChance() { return 100.00; }
	public function getItemType() { return 'Item'; }
	public function getItemSubType() { return 'Item'; }
	public function getItemLevel() { return -1; }
	public function getItemRange() { return 0.0; }
	public function getItemPrice() { return -1; }
	public function getItemWeight() { return -1; }
	public final function getItemWeightStacked() { return $this->getItemWeight() * $this->getAmount(); }
	public final function getItemPriceStacked() { return $this->getItemPrice() * $this->getAmount(); }
	public function getItemUsetime() { return 60; }
	public function getItemEquipTime() { return 0; }
	public function getItemUnequipTime() { return 0; }
	public function getItemDuration() { return self::IMMORTAL; }
	public function getItemDescription() { return '__ITEM_DESCRIPTION'; }
	public function getItemTypeDescr(SR_Player $player) { return '__ITEM_TYPE_DESCRIPTION'; }
	public function getItemDefaultAmount() { return 1; }
	public function getItemRequirements() { return array(); }
	public final function isItemStatted() { return $this->modifiers !== NULL; }
	public function isItemSellable() { return $this->getItemPrice() > 0; }
	public function isItemLootable() { return true; }
	public function isItemTradeable() { return true; }
	public function isItemStackable() { return true; }
	public function isItemStattable() { return false; }
	public function isItemDropable() { return true; }
	public function isItemFriendly() { return false; }
	public function isItemOffensive() { return false; }
	public function getBulletsMax() { return 0; }
	public function getBulletsPerShot() { return 1; }
	public function isItemRare() { return false; }

	################
	### Triggers ###
	################
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->msg('1013');
// 		$player->message('You can not use this item.');
		return false;
	}
	
	public function onItemEquip(SR_Player $player)
	{
		$player->msg('1014');
// 		$player->message('You can not equip this item.');
		return false;
	}
	
	public function onItemUnequip(SR_Player $player)
	{
		$player->msg('1014');
// 		$player->message('You can not equip this item.');
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
					if ($k === 'bmi')
					{
						$v *= 1000;
					}
					
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
	
	/**
	 * Multiply a player stat and return as modifiers. Used by cyberware and MON_Rings.
	 * @param SR_Player $player
	 * @param array $matrix
	 * @param boolean $base_values true for base, false for modified
	 * @return array modifiers
	 */
	public static function multiplyStats(SR_Player $player, array $matrix, $base_values=true)
	{
		$back = array();
		foreach ($matrix as $field => $multiplier)
		{
			$value = $base_values ? $player->getBase($field) : $player->get($field);
			if ($value > 0)
			{
				$back[$field] = round($value * $multiplier, 2);
			}
		}
		return $back;
	}
	
	
	################
	### Duration ###
	################
	/**
	 * @deprecated
	 */
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
	
	public static function canMergeModifiersLength(SR_item $item, SR_Rune $rune)
	{
		$string = $item->getItemName();
		$string .= '_ofxxxxxxx_'.$rune->displayModifiersB($item->getOwner());
		return strlen($string) <= 255;
	}
	
	/**
	 * Sort items by type.
	 * @param SR_Item $a
	 * @param SR_Item $b
	 * @return integer
	 */
	public static function sort_type_asc($a, $b)
	{
		if (0 !== ($back = strcmp($a->getItemType(), $b->getItemType())))
		{
			return $back;
		}
		
		if (0 !== ($back = strcmp($a->getItemSubType(), $b->getItemSubType())))
		{
			return $back;
		}
		return strcasecmp($a->getName(), $b->getName());
	}
}
?>
