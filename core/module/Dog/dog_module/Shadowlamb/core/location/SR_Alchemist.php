<?php
abstract class SR_Alchemist extends SR_Store
{
	/**
	 * Get available recipes.
	 * @param SR_Player $player
	 * @return array(array(name, price, product, array(incredients))
	 */
	public abstract function getRecipes(SR_Player $player);
	
	public function getAbstractClassName() { return __CLASS__; }
	
	const NAME = 0;
	const PRICE = 1;
	const PRODUCT = 2;
	const INCREDIENTS = 3;
	
	public function getCommands(SR_Player $player)
	{
		$cmds = parent::getCommands($player);
		$recipes = $this->getRecipes($player);
		if (count($recipes) > 0)
		{
			$cmds[] = 'recipes';
			$cmds[] = 'recipe';
		}
		return $cmds;
	}
	
	public function getRecipe(SR_Player $player, $arg)
	{
		$recipes = $this->getRecipesB($player);
		if (Common::isNumeric($arg))
		{
			if ( ($arg > 0) && ($arg <= count($recipes)) )
			{
				return $recipes[$arg-1];
			}
		}
		else
		{
			$arg = strtolower($arg);
			foreach ($recipes as $recipe)
			{
				if (strcasecmp($recipe[0], $arg) === 0)
				{
					return $recipe;
				}
			}
		}
		return false;
	}
	
	protected function getRecipesB(SR_Player $player)
	{
		$back = $this->getRecipes($player);
		foreach ($back as $i => $recipe)
		{
			$back[$i][self::INCREDIENTS] = $this->getIncredientItems($recipe[self::INCREDIENTS]);
		}
		return $back;
	}
	
	/**
	 * Convert the incredients item array to real items. Optimize for amt.
	 * @param array $incredients
	 * @return array
	 */
	private function getIncredientItems(array $incredients)
	{
		$back = array();
		foreach ($incredients as $incred)
		{
			$back[] = SR_Item::createByName($incred, true, false);
		}
		return $back;
	}
	
	public function on_recipes(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) > 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'recipes'));
			return false;
		}
		elseif (count($args) === 0)
		{
			return $this->showAllRecipes($player);
		}
		else
		{
			return $this->showRecipe($player, $args[0]);
		}
	}
	
	private function showAllRecipes(SR_Player $player)
	{
		$bot = Shadowrap::instance($player);
		
		$recipes = $this->getRecipesB($player);
		
		$i = 1;
		$back = '';
		$format = $player->lang('fmt_rawitems');
		foreach ($recipes as $recipe)
		{
			$back .= sprintf($format, $i++, $recipe[self::NAME]);
		}
		
		return $bot->rply('5292', array(ltrim($back, ' ,;')));
	}
	
	private function showRecipe(SR_Player $player, $arg)
	{
		$bot = Shadowrap::instance($player);
		
		if (false === ($recipe = $this->getRecipe($player, $arg)))
		{
			$bot->rply('1185');
			return false;
		}
		
		$product = SR_Item::createByName($recipe[self::PRODUCT], true, false);
		
		return $bot->rply('5293', array($recipe[self::NAME], Shadowfunc::displayNuyen($recipe[self::PRICE]), $product->displayFullName($player), $this->getMissingIncredientsMessage($player, $recipe[self::INCREDIENTS])));
	}
	
	public function on_recipe(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) === 0)
		{
			return $this->on_recipes($player, $args);
		}
		
		if (count($args) > 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'recipe'));
			return false;
		}
		
		if (false === ($recipe = $this->getRecipe($player, $args[0])))
		{
			$bot->rply('1185');
			return false;
		}
		
		# Price
		$dp = Shadowfunc::displayNuyen($recipe[self::PRICE]);
		
		# Check if we have the money.
		if (!$player->hasNuyen($recipe[self::PRICE]))
		{
			$bot->rply('1063', array($dp, $player->displayNuyen()));
			return false;
		}
		
		# Check if we have enough incredients
		$need = array();
		foreach ($recipe[self::INCREDIENTS] as $item)
		{
			$item instanceof SR_Item;
			$iname = $item->getItemName();
			$amt = $item->getAmount();
			$have = $player->getInvItemCount($iname);
			if ($have < $amt)
			{
				$need[] = SR_Item::createByName($iname, $amt - $have, false);
			}
		}
		if (count($need) > 0)
		{
			$bot->rply('1186', array($recipe[self::NAME], $this->getMissingIncredientsMessage($player, $need)));
			return false;
		}
		
		# Take the incredients
		foreach ($recipe[self::INCREDIENTS] as $item)
		{
			$item instanceof SR_Item;
			$amt = $item->getAmount();
			$iname = $item->getItemName();
			
			$taken = 0;
			while ($taken < $amt)
			{
				$item = $player->getInvItem($iname, false, true);
				$need = $amt - $taken;
				$have = Common::clamp($item->getAmount(), 0, $need);
				$item->useAmount($player, $have);
				$taken += $have;
			}
		}
		
		# Take money
		if (false === $player->pay($recipe[self::PRICE]))
		{
			$bot->reply('ERROR 4');
			return false;
		}
		
		# Give product
		if (false === ($product = SR_Item::createByName($recipe[self::PRODUCT])))
		{
			$bot->reply('ERROR 5');
			return false;
		}
		if (false === $player->giveItems(array($product), $player->lang('from_recipe')))
		{
			$bot->reply('ERROR 6');
			return false;
		}
		
		return $bot->rply('5291', array($dp, $product->getAmount().'x'.$product->displayFullName($player), $recipe[self::NAME], $this->getMissingIncredientsMessage($player, $recipe[self::INCREDIENTS])));
	}
	
	private function getMissingIncredientsMessage(SR_Player $player, array $need)
	{
		$back = array();
		foreach ($need as $item)
		{
			$item instanceof SR_Item;
			$back[] = $item->getAmount().'x'.$item->displayFullName($player);
		}
		return GWF_Array::implodeHuman($back);
	}
}
?>
