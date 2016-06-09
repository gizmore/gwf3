<?php
class SR_Inventory
{

	######################
	### Private fields ###
	######################

	private $owner;
	private $type;
	private $inventory;
	private $cached_grouped = null;
	private $change_handlers = array();
	


	######################
	### Initialisation ###
	######################

	public function __construct($type, $owner)
	{
		$this->type = $type;
		$this->owner = $owner;
		$this->load();
	}

	private function load()
	{
		$inv = array();
		$pid = $this->owner->getID(); // XXX What if owner is not SR_Player?

		$items_table = GDO::table('SR_Item');
		if (false === ($select_result = $items_table->select('*', "sr4it_uid={$pid} AND sr4it_position='{$this->type}'", 'sr4it_microtime ASC')))
		{
			Dog_Log::error("Failed to load inventory '{$this->type}' for player id {$pid}!");
			$this->inventory = false; // XXX compatible with old code, but ugh
			return;
		}

		while (false !== ($data = $items_table->fetch($select_result, GDO::ARRAY_A)))
		{
			$item = SR_Item::instance($data['sr4it_name'], $data);
			$item->initModifiersB();
			$inv[$data['sr4it_id']] = $item;
		}

		$items_table->free($select_result);

		$this->inventory = &$inv;
	}



	##############
	### Events ###
	##############

	private function onChanged($same_items=false)
	{
		foreach ($this->change_handlers as $handler)
		{
			call_user_func($handler, $same_items);
		}
	}

	public function addChangeHandler($handler)
	{
		$this->change_handlers[] = $handler;
	}



	######################
	### Cached Grouped ###
	######################

	private function clearCache()
	{
		$this->cached_grouped = null;
	}

	private function cacheGroupedItems()
	{
		if ($this->cached_grouped !== null)
		{
			return;
		}

		$grouped = array();
		foreach ($this->inventory as $itemid => $item)
		{
			$name = $item->getItemName();
			if (isset($grouped[$name]))
			{
				$grouped[$name][0] += $item->getAmount();
				$grouped[$name][1][$item->getID()] = $item;
			}
			else
			{
				$grouped[$name] = array($item->getAmount(), array($item->getID() => $item));
			}
		}

		$this->cached_grouped = &$grouped;
	}

	private function addToGroup($item)
	{
		if ($this->cached_grouped === null)
		{
			return;
		}

		// XXX share code with cacheGroupedItems
		$name = $item->getItemName();
		$id = $item->getID();
		if (isset($this->cached_grouped[$name]))
		{
			$this->cached_grouped[$name][0] += $item->getAmount();
			$this->cached_grouped[$name][1][$id] = $item;
		}
		else
		{
			$this->cached_grouped[$name] = array($item->getAmount(), array($id => $item));
		}
	}
	
	private function increaseGroupAmount($item_name, $amount)
	{
		if ($this->cached_grouped === null)
		{
			return;
		}
		
		$this->cached_grouped[$item_name][0] += $amount;
	}

	private function removeFromGroup($item)
	{
		if ($this->cached_grouped === null)
		{
			return;
		}

		$name = $item->getItemName();
		$id = $item->getID();

		$this->cached_grouped[$name][0] -= $item->getAmount();
		unset($this->cached_grouped[$name][1][$id]);

		if (count($this->cached_grouped[$name][1]) === 0)
		{
			unset($this->cached_grouped[$name]);
		}
	}

	private function swapGroups($item_name1, $item_name2)
	{
		if ($this->cached_grouped === null)
		{
			return;
		}
		
		$new_grouped = array();
		$group1 = &$this->cached_grouped[$item_name1];
		$group2 = &$this->cached_grouped[$item_name2];
		foreach ($this->cached_grouped as $item_name => &$group)
		{
			if ($item_name === $item_name1)
			{
				$new_grouped[$item_name2] = &$group2;
			} else if ($item_name === $item_name2)
			{
				$new_grouped[$item_name1] = &$group1;
			} else {
				$new_grouped[$item_name] = &$group;
			}
		}

		$this->cached_grouped = &$new_grouped;
	}



	##########################
	### Access to interals ###
	##########################

	public function &getArrayRef()
	{
		return $this->inventory;
	}

	public function &getGroupedRef()
	{
		$this->cacheGroupedItems(); // make sure it's available
		return $this->cached_grouped;
	}



	########################
	### Inventory access ###
	########################

	public function getNumItems()
	{
		return count($this->inventory);
	}

	public function getNumGrouped()
	{
		$this->cacheGroupedItems(); // make sure it's available
		return count($this->cached_grouped);
	}

	private function getInventoryIndex($item)
	{
		$index = 0;
		foreach ($this->inventory as $inv_item)
		{
			if ($item === $inv_item)
			{
				return $index;
			}
			$index++;
		}

		return false;
	}

	public function getGroupedIndex($item_name)
	{
		$this->cacheGroupedItems(); // make sure it's available

		$index = 0;
		foreach ($this->cached_grouped as $current_name => &$data)
		{
			if ($item_name === $current_name)
			{
				return $index;
			}
			$index++;
		}

		return false;
	}

	public function getItemByInventoryIndex($index)
	{
		$index = (int)$index; // XXX should be called with int
		if ( $index < 0 || count($this->inventory) <= $index )
		{
			return false;
		}

		$item_array = array_slice($this->inventory, $index, 1); // awkward way of getting element because array is indexed by id
		$item = array_shift($item_array); // get only (keyed) element
		return $item;
	}

	public function getItemByGroupedIndex($index)
	{
		$this->cacheGroupedItems(); // make sure it's available

		$index = (int)$index; // XXX should be called with int
		if ( $index < 0 || count($this->cached_grouped) <= $index )
		{
			return false;
		}

		$group_array = array_slice($this->cached_grouped, $index, 1); // awkward way of getting element because array is indexed by name
		$group = array_shift($group_array); // get only (keyed) element
		return end($group[1]); // XXX old code took first; is this ok?
	}

	public function getItemsByGroupedIndex($start, $end=false, $pattern=null, $requesting_player=null, &$num_items=null)
	{
		$this->cacheGroupedItems(); // make sure it's available

		$num_items = count($this->cached_grouped);

		if ($start < 0)
		{
			$start = 0;
		}

		if ($end === false)
		{
			$end = $start+1;
		} else if ($end > $num_items)
		{
			$end = $num_items;
		}

		if ($pattern === null)
		{
			return array_slice($this->cached_grouped, $start, $end-$start); // deep copy
		} else {

			$result = array();
			$num_items = 0;
			$index = 0;
			$iso = $requesting_player->getLangISO();
			foreach ($this->cached_grouped as $item_name => &$group)
			{
				$item = reset($group[1]);
				if (   (false !== stripos($item_name, $pattern))
					|| (false !== stripos(Shadowlang::itemNameForSearch($item, $iso), $pattern)) )
				{
					if ($start <= $num_items && $num_items < $end)
					{
						$result[$item_name] = $group;
						$result[$item_name][] = $index;
					}
					$num_items++;
				}
				$index++;
			}

			return $result;

		}
	}

	public function getItemByItemName($item_name, $first=false)
	{
		if ($this->cached_grouped !== null)
		{
			if (!isset($this->cached_grouped[$item_name]))
			{
				return false;
			}

			$items = &$this->cached_grouped[$item_name][1];
			if ($first)
			{
				reset($items);
			} else { # last
				end($items);
			}
			return current($items);
		}

		if ($first)
		{
			foreach ( $this->inventory as $item )
			{
				if ($item->getItemName() === $item_name)
				{
					return $item;
				}
			}
		} else { # last
			for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
			{
				if ($item->getItemName() === $item_name)
				{
					return $item;
				}
			}
		}

		return false; // not found
	}

	public function getItemsByItemName($item_name, $max=false) // XXX should items be in some order?
	{
		if ($max !== false && $max < 1)
		{
			return array();
		}

		if ($this->cached_grouped !== null)
		{
			if (!isset($this->cached_grouped[$item_name]))
			{
				return false;
			}

			$items = &$this->cached_grouped[$item_name][1];

			if ($max !== false && $max < count($items))
			{
				return array_slice($items,-$max);
			} else {
				return $items;
			}
		}

		$items = array();
		for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
		{
			if ($item->getItemName() === $item_name)
			{
				$items[] = $item;
				if ($max !== false && $max === count($items))
				{
					break;
				}
			}
		}

		return $items;
	}


	public function getItemByName($name, $requesting_player, $check_base_name=true)
	{
		# Reverse search on full name
		$iso = $requesting_player->getLangISO();
		for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
		{
			if (   (!strcasecmp($item->getItemName(), $name))
				|| (!strcasecmp(Shadowlang::itemNameForSearch($item, $iso), $name)) )
			{
				return $item;
			}
		}

		if (!$check_base_name)
		{
			return false;
		}

		# Reverse search on full base name
		for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
		{
			if (!strcasecmp($item->getName(), $name))
			{
				return $item;
			}
		}

		return false;
	}
	
	public function getItemBySubstring($substr, $requesting_player, $prefer_fullname=true, $verbose=true)
	{
		if ($prefer_fullname)
		{
			$item = $this->getItemByName($substr, $requesting_player, false);
			if ($item !== false)
			{
				return $item;
			}
		}

		$found_item = false;
		
		# Reverse search on full name
		$iso = $requesting_player->getLangISO();
		for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
		{
			if (   (false !== stripos($item->getItemName(), $substr))
				|| (false !== stripos(Shadowlang::itemNameForSearch($item, $iso), $substr)) )
			{
				if ($found_item !== false)
				{
					if ($verbose)
					{
						$requesting_player->msg('1179'); # Ambigious
					}
					return false;
				}
				$found_item = $item;
			}
		}
		
		return $found_item;
	}
	
	public function getItem($str, $requesting_player)
	{
		if (Common::isNumeric($str))
		{
			return $this->getItemByGroupedIndex(((int)$str)-1);
		} else {
			return $this->getItemBySubstring($str, $requesting_player);
		}
	}

	public function getItemByClass($class)
	{
		$items = $this->getItemsByClass($class, 1);

		if (count($items) !== 1)
		{
			return false;
		}

		return $items[0];
	}

	public function getItemsByClass($class, $max=false)
	{
		if ($max !== false && $max < 1)
		{
			return array();
		}

		# Reverse search for items
		$items = array();
		for ($item = end($this->inventory); false !== $item; $item = prev($this->inventory))
		{
			if ($item instanceof $class)
			{
				$items[] = $item;

				if ($max !== false && count($items) === $max)
				{
					break;
				}
			}
		}

		return $items;
	}

	public function countByItemName($item_name)
	{
		if ($this->cached_grouped !== null)
		{
			if (isset($this->cached_grouped[$item_name]))
			{
				return $this->cached_grouped[$item_name][0];
			} else {
				return 0;
			}
		}

		// XXX cache groups instead?
		$cnt = 0;
		foreach ($this->inventory as $item)
		{
			if ($item->getItemName() === $item_name)
			{
				$cnt += $item->getAmount();
			}
		}

		return $cnt;
	}



	##############################
	### Inventory modification ###
	##############################

	public function addItem($item)
	{
		if ($item->isItemStackable())
		{
			$item_name = $item->getItemName();
			$existing_item = $this->getItemByItemName($item_name);

			if ($existing_item !== false)
			{
				$add_amount = $item->getAmount();
				if (false === $existing_item->increase('sr4it_amount', $add_amount)) # bit ugly
				{
					return false;
				}

				$this->increaseGroupAmount($item_name, $add_amount);

				$this->onChanged();

				return $item->delete();
			}
		}

		if (!$item->changeOwnerAndPosition($this->owner->getID(),$this->type)) // also changes item microtime
		{
			return false;
		}
		$this->inventory[$item->getID()] = $item;
		$this->addToGroup($item);

		$this->onChanged();

		return true;
	}
	
	public function itemAmountChanged(SR_Item $item, $amount_change, $modify=true)
	{
		if ($item->getPosition() !== $this->type) // make sure it's in here
		{
			return false;
		}

		if ($this->cached_grouped !== null)
		{
			$name = $item->getItemName();
			$this->cached_grouped[$name][0] += $amount_change;
		}
		
		$this->onChanged();

		return true;
	}

	public function removeItem($item)
	{
		if (!isset($this->inventory[$item->getID()]))
		{
			return false;
		}

		unset($this->inventory[$item->getID()]);
		$this->removeFromGroup($item);

		$this->onChanged();

		return true;
	}

	public function swapItems($name1, $name2, $requesting_player)
	{
		# returns  0 if swapped
		#         -1 if no items for name1,
		#         -2 if no items for name2,
		#         -3 if name1 and name2 result in same item

		# find actual items
		$item1 = $this->getItem($name1, $requesting_player);
		if ($item1 === false)
		{
			return -1;
		}

		$item2 = $this->getItem($name2, $requesting_player);
		if ($item2 === false)
		{
			return -2;
		}

		# make sure we are going to do something
		$item_name1 = $item1->getItemName();
		$item_name2 = $item2->getItemName();
		if ($item_name1 === $item_name2)
		{
			return -3;
		}

		# get first entries instead of last
		$item1 = $this->getItemByItemName($item_name1, true);
		$item2 = $this->getItemByItemName($item_name2, true);

		# get index in inventory
		$index1 = $this->getInventoryIndex($item1);
		$index2 = $this->getInventoryIndex($item2);

		# make sure item1 is before item2 in inventory
		if ($index1 > $index2)
		{
			$tmp = $index1;
			$index1 = $index2;
			$index2 = $tmp;
			$tmp = $item1;
			$item1 = $item2;
			$item2 = $tmp;
			$tmp = $item_name1;
			$item_name1 = $item_name2;
			$item_name2 = $tmp;
		}


		# Do the swap
		#
		# Note that initial situtation could be (with item:microtime):
		# ... A:1 ... A:2 ... B:3 ... C:4 D:4.0001...
		# Then result of swapping A and C should be:
		# ... C:1 ...     ... B:3 ... A:4 A:4.001 D:4.002 ...
		# That is, first C can simply be put in place of first A
		# All As before first C most be moved to keep index of B
		# Microtimes of elements after first C might need to be
		# adjusted to compensated for moved items.
		$new_inv = array(); // new inventory
		$current_index = 0; // index of current item in old array
		$last_microtime = 0; // microtime of previous item
		$update_microtime = false; // need to update item microtimes due to moved items?
		$items_to_move = array($item1); // items like $item1 that need to be moved to keep indexing in order
		$old_item2_microtime = $item2->getMicrotime();
		foreach ($this->inventory as $id => $item)
		{
			if ($current_index == $index1)
			{

				# simply put $item2 in place of $item1
				$new_inv[$item2->getID()] = $item2;
				$last_microtime = $item1->getMicrotime();
				$item2->saveMicrotime($last_microtime);
			
			}
			else if ($current_index == $index2)
			{

				# make sure microtimes of $items_to_move are after $item2 in $new_inv
				$old_microtime = $item1->getMicrotime();
				$new_microtime = $old_item2_microtime;
				if ($old_microtime >= $new_microtime) # should not be greater, but could be equal
				{
					$new_microtime = $old_microtime + 0.001;
				}

				# put all $item1 like items in place
				foreach ($items_to_move as $item)
				{
					$new_inv[$item->getID()] = $item;
					$item->saveMicrotime($new_microtime);
					$last_microtime = $new_microtime;
					$new_microtime += 0.001;
				}

				# make sure items after these have proper microtimes
				$update_microtime = true;

			}
			else
			{

				if ($index1 < $current_index && $current_index < $index2 && $item->getItemName() === $item_name1) # item like $item1 that needs to be moved
				{
					$items_to_move[] = $item;

				} else { # normal item; add and possibly update microtime
					$new_inv[$id] = $item;
					if ($update_microtime)
					{
						$this_microtime = $item->getMicrotime();
						if ( $this_microtime <= $last_microtime ) # need to update microtime?
						{
							$item->saveMicrotime($last_microtime + 0.001);
						} else { # done fixing microtimes
							$update_microtime = false;
						}
					}
					$last_microtime = $item->getMicrotime();
				}
				
			} // if

			$current_index++;
		} // foreach

		$this->inventory = &$new_inv;

		$this->swapGroups($item_name1, $item_name2);

		$this->onChanged(true);
	}

}
