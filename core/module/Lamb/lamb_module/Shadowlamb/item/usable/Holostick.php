<?php
require_once 'Credstick.php';

/**
 * Holostick as proposed by sabretooth. (thx sabretooth)
 * Push and pop nuyen are inherited by credstick.
 * Push items is costy and depends on weight + worth sums.
 * Pop items is not possible. (Maybe Beamstick?) ;)
 * @author gizmore
 * @since 24th Dec 2011
 */
class Item_Holostick extends Item_Credstick
{
	public static $CONFIRM_ITEMS = NULL;
	
	public function getItemDescription() { return sprintf("You can access your bank money and items with a Holostick. Try #use Holostick [<pushy|popy|pushi>] [<nuyen|item>] [<item_amount>]. Each money transaction cost %s. The item transaction cost varies per item weight and value. You cannot popi items with a Holostick.", Shadowfunc::displayNuyen($this->getTransactionCost())); }
	public function getItemPrice() { return 179.95; }
	public function getItemUsetime() { return 20; } 
	public function getItemWeight() { return 200; }
	public function isItemFriendly() { return false; }
	public function isItemOffensive() { return false; }
	
	public function getTransactionCost() { return 50; }
//	public function getTransactionPopPercent() { return 0; }
//	public function getTransactionPushPercent() { return 5; }

	const PRICE_PER_KG = 50;
	const PRICE_PER_KNY = 20;
	const PRICE_PER_TRANSACTION = 20;
	
	protected function reply(SR_Player $player, $message)
	{
		if ($player->isFighting())
		{
			$player->message($message);
		}
		else
		{
			Shadowrap::instance($player)->reply($message);
		}
		return true;
	}
	
	public function onItemUse(SR_Player $player, array $args)
	{
		# Have ATM?
		$p = $player->getParty();
		if ( (!$p->isInsideLocation()) || (!$p->getLocationClass()->hasATM()) )
		{
			$this->reply($player, "You are not inside a location with an ATM. Towers and dungeons usually don't have those.");
			return false;
		}
		
		# Fallback for credstick
		$amount = isset($args[1]) ? ((int)$args[1]) : 0;
		if (count($args) === 0)
		{
			$args = array('popy');
		}
		
		# Do it!
		switch (strtolower($args[0]))
		{
			case 'pushy': return $this->onItemUsePush($player, $amount);
			case 'popy': return $this->onItemUsePop($player, $amount);
			case 'pushi': return $this->onItemUsePushi($player, $args);
			case 'popi': return $this->onItemUsePopi($player, $args);
			default:
				$player->message('Try #u Holostick pushy <nuyen>. Try #u Holostick popy <nuyen>. Try #u Holostick pushi <item> [<amt>].');
				return false;
		}
	}
	
	protected function onItemUsePopi(SR_Player $player, array $args)
	{
		return $this->reply($player, sprintf('Your bank: %s.', Shadowfunc::getBank($player)));
	}
	
	protected function onItemUsePushi(SR_Player $player, array $args)
	{
		$want_amt = isset($args[2]) ? ((int)$args[2]) : 1;
		if ($want_amt < 1)
		{
			$player->message('Please push a positive amount larger than zero.');
			return false;
		}
		
		# Have at least 1?
		$items = $player->getInvItems($args[1], $want_amt);
		if (count($items) === 0)
		{
			$player->message('You don\'t have that item. Please note that you have to provide full item name.');
			return false;
		}
		
		# Gather data
		$item = $items[0];
		$item instanceof SR_Item;
		$itemname = $item->getItemName();
		$have_amt = $item->isItemStackable() ? min($item->getAmount(), $want_amt) : count($items);
		$have_worth = $have_amt * $item->getItemPrice();
		$have_weight = $have_amt * $item->getItemWeight();
		
		
		# Check amt
		if ($have_amt < $want_amt)
		{
			$player->message(sprintf('You only have %s %s.', $have_amt, $itemname));
			return false;
		}

		# Check cost
		$price = $this->calcItemPushPrice($player, $have_amt, $have_worth, $have_weight);
		$dp = Shadowfunc::displayNuyen($price);
		if (!$player->hasNuyen($price))
		{
			$this->reply($player, sprintf('You need %s for this transaction, but you only got %s.', $dp, $player->displayNuyen()));
			return false;
		}
		
		
// 		if (false !== ($this->confirm()))
// 		{
// 			$this->reply($player, sprintf('You are about to transfer %s %s to your bank. Cost: %s. Retype to confirm.'));
// 			return true;
// 		}

		# Transfer to bank
		$need_amt = $want_amt;
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			$have_iamt = $item->getAmount();
			$use_amt = min($want_amt, $have_iamt);
			if (false === $item->useAmount($player, $use_amt))
			{
				$this->reply($player, GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
				return false;
			}
			if (false === ($pushitem = SR_Item::createByName($itemname, $use_amt)))
			{
				$this->reply($player, GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
				return false;
			}
			if (false === $player->putInBank($pushitem))
			{
				$this->reply($player, GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
			}
						
			$need_amt -= $use_amt;
			if ($need_amt <= 0)
			{
				break;
			}
		}
		
		# Pay
		$player->giveNuyen(-$price);
		
		# Announce
		$message = sprintf('You pay %s and transfer %s %s to your bank account.', $dp, $want_amt, $itemname);
		return $this->reply($player, $message);
	}
	
	protected function calcItemPushPrice(SR_Player $player, $have_amt, $have_worth, $have_weight)
	{
		$price = self::PRICE_PER_KG * ($have_weight/1000);
		$price += self::PRICE_PER_KNY * ($have_worth/1000);
		$price += self::PRICE_PER_TRANSACTION;
		return round($price, 2);
	}
}
?>