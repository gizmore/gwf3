<?php
class SR_ClanHQ extends SR_Location
{
	const CONFIRM_PHRASE = 'IAMSURE';

	const COST_SLOGAN = 200;
	
	const LVL_CREATE = 10;
	const COST_CREATE = 10000;
	
	const ADD_WEALTH = 10000;
	const COST_WEALTH = 500;
	
	const ADD_MEMBERS = 1;
	const COST_MEMBERS = 1000;
	
	const ADD_STORAGE = 1000;
	const COST_STORAGE = 500;
	
	const COST_PUSHY = 50;
	const COST_POPY = 100;
	
	const COST_PUSHI = 200;
	const COST_POPI = 300;
	
	public function getFoundText(SR_Player $player)
	{
		return sprintf('You found the clan headquarters.');
	}
	
	public function getEnterText(SR_Player $player)
	{
		return sprintf('You enter the clan headquarters.');
	}
	
	public function getHelpText(SR_Player $player)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		return "You can join clans here with {$c}request, {$c}accept and {$c}manage. You can access clan bank with {$c}push and {$c}pop. You can access clan money with {$c}pushy and {$c}popy.";
	}
	
	public function getCommands(SR_Player $player)
	{
		return array('request', 'accept', 'manage', 'push', 'pop', 'pushy', 'popy');
	}
	
	public function on_request(SR_Player $player, array $args)
	{
		if (false !== ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message(sprintf('You are already in the clan "%s".', $clan->getName()));
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_request'));
			return false;
		}
		
		if (false === ($clan = SR_Clan::getByName($args[0])))
		{
			$player->message('This clan is unknown.');
			return false;
		}
		
		if ($clan->isFullMembers())
		{
			$player->message(sprintf('This clan has reached it\'s member limit of %d.', $clan->getMaxMembercount()));
			return false;
		}
		
		if ($clan->isModerated())
		{
			if (SR_ClanRequests::hasOpenRequests($player))
			{
				$player->message('You are already applying for a clan, your old request has been deleted.');
				SR_ClanRequests::clearRequests($player);
			}
			$clan->sendRequest($player);
		}
		else
		{
			$clan->join($player);
		}
	}

	public function on_accept(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message("You don't have a clan, chummer!");
			return false;
		}
		
		# Show requests
		if (count($args) === 0)
		{
			return $this->showRequests($player, $clan);
		}
		if ( (count($args) === 1) && (Common::isNumeric($args[0])) )
		{
			return $this->showRequests($player, $clan, (int)$args[0]);
		}
		
		$leader = $clan->getLeader();
		if ($leader->getID() !== $player->getID())
		{
			$player->message("You don't lead this clan, chummer!");
			return false;
		}
		
		# Accept
		if (false !== ($joiner = SR_ClanRequests::getRequest($player, $clan, $args[0])))
		{
			$player->message(sprintf('%s did not request to join your clan.', $args[0]));
			return false;
		}
		
		if ($clan->isFullMembers())
		{
			$player->message(sprintf("Your clan has reached it's limit of %s members. You can purchase more slots via the #manage function.", $clan->getMaxMembercount()));
			return false;
		}
		
		if (false === $clan->join($joiner))
		{
			$player->message('DB ERROR 4');
			return false;
		}
		
		$joiner->message(sprintf('%s has accepted your join request for the %s clan.', $leader->displayName(), $clan->getName()));
	}
	
	private function showRequests(SR_Player $player, SR_Clan $clan, $page=1)
	{
		$ipp = 10;
		$table = GDO::table('SR_ClanRequests');
		$nItems = $table->countRows("sr4cr_cid={$cid}");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$page = (int)$page;
		if ( ($page < 1) || ($page > $nPages) )
		{
			$player->message('This page is empty.');
			return false;
		}
		
		if (false === ($result = $table->selectAll('sr4cr_pname', "sr4cr_cid={$cid}", '', NULL, $ipp, $from, GDO::ARRAY_N)))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		
		foreach ($result as $row)
		{
			$message .= ', '.$row[0];
		}
		
		$player->message(sprintf('Clan join requests page %d/%d: %s.', $page, $nPages, substr($message, 2)));
		
		return true;
	}

	public function on_manage(SR_Player $player, array $args)
	{
		if ( (count($args) > 1) && ($args[0] === 'create') )
		{
			return $this->onCreate($player, $args);			
		}
		
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message("You don't have a clan, chummer!");
			return false;
		}
		
		$leader = $clan->getLeader();
		if ($leader->getID() !== $player->getID())
		{
			$player->message("You don't lead this clan, chummer!");
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_manage'));
			return false;
		}
		
		switch ($args[0])
		{
			case 'buywealth': return $this->onBuyWealth($player, $clan, $args);
			case 'buystorage': return $this->onBuyStorage($player, $clan, $args);
			case 'buymembers': return $this->onBuyMembers($player, $clan, $args);
			case 'slogan': return $this->onSetSlogan($player, $clan, $args); 
			default:
				$player->message(Shadowhelp::getHelp($player, 'clan_manage'));
				return false;
		}
	}
	
	private function onSetSlogan(SR_Player $player, SR_Clan $clan, array $args)
	{
		array_shift($args);
		$slogan = implode(' ', $args);
		
		$cost = self::COST_SLOGAN;
		$dcost = Shadowfunc::displayNuyen($cost);
		
		if (false === $player->hasNuyen($cost))
		{
			$player->message(sprintf('It cost %s to set a slogan for your clan, but you only have %s.', $dcost, $player->displayNuyen()));
			return false;
		}
		
		if (strlen($slogan) > 196)
		{
			$player->message(sprintf('Your slogan exceeds the maxlength of %s characters.', 196));
			return false;
		}
		
		if (false === $clan->saveVar('sr4cl_slogan', $slogan))
		{
			$player->message('DB ERROR 6');
			return false;
		}
		
		$player->message(sprintf('You paid the fee of %s and set a new slogan for your clan.', $dcost));
		return true;
	}
	
	private function onCreate(SR_Player $player, array $args)
	{
		if (false !== ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message(sprintf('You are already member of the "%s" clan.', $clan->getName()));
			return false;
		}
		
		array_shift($args);
		$dcost = Shadowfunc::displayNuyen(self::COST_CREATE);
		
		if ($player->getBase('level') < self::LVL_CREATE)
		{
			$player->message(sprintf('You do not have the minimum level of %s to create a clan.', self::LVL_CREATE));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_CREATE))
		{
			$player->message(sprintf('It cost %s to create a clan, but you only got %s.', $dcost, $player->displayNuyen()));
			return false;
		}
		
		$name = implode(' ', $args);
		if (strlen($name) > 63)
		{
			$player->message('The name of your clan is too long.');
			return false;
		}
		
		if (false === ($clan = SR_Clan::create($player, $name)))
		{
			$player->message('DB ERROR 5');
			return false;
		}
		
		$player->message(sprintf('Congratulations. You formed a new clan named "%s".', $clan->getName()));
		return true;
	}
	
	private function onBuyWealth(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = Shadowfunc::displayNuyen(self::ADD_WEALTH);
		$dcost = Shadowfunc::displayNuyen(self::COST_WEALTH);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			$player->message(sprintf(
				'Your clan currently can bank %s. Another %s would cost you %s. Please type #manage buywealth %s to confirm.',
				$clan->getMaxNuyen(), $dadd, $dcost, self::CONFIRM_PHRASE
			));
			return true;
		}
		
		if ($clan->isMaxMoney())
		{
			$player->message(sprintf('Your clan has already reached the maximum of %s/%s wealth.', $clan->displayNuyen(), $clan->displayMaxNuyen()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_WEALTH))
		{
			$player->message(sprintf('It would cost %s to buy another %s of clan wealth, but you only got %s.',
				$dcost, $dadd, $player->displayNuyen()
			));
			return false;
		}
		
		if (false === $player->giveNuyen(-self::ADD_WEALTH))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		if (false === $clan->addWealth(self::ADD_WEALTH))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		$player->message(sprintf(
			'You paid %s and your clan now has a max wealth of %s/%s.',
			$dcost, $clan->displayNuyen(), $clan->displayMaxNuyen()
		));
		return true;
	}

	private function onBuyStorage(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = Shadowfunc::displayWeight(self::ADD_STORAGE);
		$dcost = Shadowfunc::displayNuyen(self::COST_STORAGE);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			$player->message(sprintf(
				'Your clan currently can store %s. Another %s would cost you %s. Please type #manage buystorage %s to confirm.',
				$clan->dispalyMaxStorage(), $dadd, $dcost, self::CONFIRM_PHRASE
			));
			return true;
		}
		
		if ($clan->isMaxStorage())
		{
			$player->message(sprintf('Your clan has already reached the maximum of %s/%s storage.', $clan->displayStorage(), $clan->displayMaxStorage()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_STORAGE))
		{
			$player->message(sprintf('It would cost %s to buy another %s of clan storage, but you only got %s.',
				$dcost, $dadd, $player->displayNuyen()
			));
			return false;
		}
		
		if (false === $player->giveNuyen(-self::COST_STORAGE))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		if (false === $clan->addStorage(self::ADD_STORAGE))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		$player->message(sprintf(
			'You paid %s and your clan has now a max storage of %s/%s.',
			$dcost, $clan->displayStorage(), $clan->displayMaxStorage()
		));
		return true;
	}

	private function onBuyMembers(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = Shadowfunc::displayWeight(self::ADD_MEMBERS);
		$dcost = Shadowfunc::displayNuyen(self::COST_MEMBERS);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			$player->message(sprintf(
				'Your clan currently can have a maximum of %s members. Raising this maximum by %s would cost you %s. Please type #manage buystorage %s to confirm.',
				$clan->getMaxMembercount(), $dadd, $dcost, self::CONFIRM_PHRASE
			));
			return true;
		}
		
		if ($clan->isMaxStorage())
		{
			$player->message(sprintf('Your clan has already reached the maximum of %s/%s storage.', $clan->displayStorage(), $clan->displayMaxStorage()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_MEMBERS))
		{
			$player->message(sprintf('It would cost %s to raise your max members by %s, but you only got %s.',
				$dcost, $dadd, $player->displayNuyen()
			));
			return false;
		}
		
		if (false === $player->giveNuyen(-self::COST_MEMBERS))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		if (false === $clan->addMembercount(self::ADD_MEMBERS))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		$player->message(sprintf(
			'You paid %s and your clan has now of %s/%s members.',
			$dcost, $clan->getMembercount(), $clan->getMaxMembercount()
		));
		return true;
	}

	public function on_pushy(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message('You are not in a clan.');
			return false;
		}
		
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_pushy'));
			return false;
		}
		
		$amt = (int)$args[1];
		if ($amt <= 0)
		{
			$player->message('Please push a postive amount of nuyen.');
			return false;
		}
		
		$damt = Shadowfunc::displayNuyen($amt);
		$dfee = Shadowfunc::displayNuyen(self::COST_PUSHY);
		$totalneed = $amt + self::COST_PUSHY;
		if (false === $player->hasNuyen($totalneed))
		{
			$player->message(sprintf('You want to push %s(+%s)=%s to the clan bank, but you only got %s.',
				$damt, $dfee, Shadowfunc::displayNuyen($totalneed), $player->displayNuyen()
			));
			return false;
		}
		
		$max = $clan->getMaxNuyen();
		$have = $clan->getNuyen();
		$can = $max-$have;
		
		if ($can === 0)
		{
			$player->message(sprintf('Your clan already holds the maximum of %s/%s. Ask your clanleader to purchase a higher wealth.', $clan->displayNuyen(), $clan->displayMaxNuyen()));
			return false;
		}
		
		
		$amt = min($can, $amt);
		$totalneed = $amt + self::COST_PUSHY;
		if (false === $clan->increase('sr4cl_money', $amt))
		{
			$player->message('DB ERROR 7');
			return false;
		}
		
		if (false === $player->giveNuyen(-$totalneed))
		{
			$player->message('DB ERROR 8');
			return false;
		}
		
		$player->message(sprintf('You pay the fee of %s and push %s to the clan bank, which now holds %s/%s.',
			$dfee, Shadowfunc::displayNuyen($amt), $clan->displayNuyen(), $clan->displayMaxNuyen()
		));
		return true;
	}

	public function on_popy(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message('You are not in a clan.');
			return false;
		}
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_popy'));
			return false;
		}
		$amt = (int)$args[1];
		if ($amt <= 0)
		{
			$player->message('Please pop a postive amount of nuyen.');
			return false;
		}
		$damt = Shadowfunc::displayNuyen($amt);
		$dfee = Shadowfunc::displayNuyen(self::COST_POPY);
		$totalneed = $amt + self::COST_POPY;
		
		$have = $clan->getNuyen();
		
		if ($have < $totalneed)
		{
			$player->message(sprintf('You want to pop %s(+%s)=%s out of the clan bank, but it currently holds only %s.',
				$damt, $dfee, Shadowfunc::displayNuyen($totalneed), $clan->displayNuyen()
			));
			return false;
		}
		
		if (false === $clan->increase('sr4cl_money', -$totalneed))
		{
			$player->message('DB ERROR 7');
			return false;
		}
		
		if (false === $player->giveNuyen($amt))
		{
			$player->message('DB ERROR 8');
			return false;
		}
		
		$player->message(sprintf('You pop %s(-%s)=%s out of the clan bank, which now holds %s/%s.',
			Shadowfunc::displayNuyen($totalneed), $dfee, $damt, $clan->displayNuyen(), $clan->displayMaxNuyen()
		));
		return true;
	}
	
	public function on_push(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->message('You are not in a clan.');
			return false;
		}
		if ( (count($args) !== 2) && (count($args) !== 3) )
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_push'));
			return false;
		}
		
		$amt = isset($args[2]) ? ((int)$args[2]) : 1;
		if ($amt <= 0)
		{
			$player->message('Please push a positive amount of items.');
			return false;
		}
		
		if (false === ($item = $player->getInvItem($args[1])))
		{
			$player->message("You don't have that item in your inventory.");
			return false;
		}
		$itemname = $item->getItemName();
		
		if ($item->isItemStackable())
		{
			if ($item->getAmount() < $amt)
			{
				$player->message(sprintf('You try to push %s %s but you only have %s.', $amt, $itemname, $item->getAmount()));
				return false;
			}
			$weight = $item->getItemWeightStacked();
			if (false === $clan->canHoldMore($weight))
			{
				$player->message(sprintf('You try to push another %s into the clan bank, but it already holds %s/%s.',
					Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()
				));
				return false;
			}
			
			if (false === $item->useAmount($player))
			{
				$player->message('DB ERROR 1');
				return false;
			}
			
			if (false === $this->putIntoBank($player, $clan, $itemname, $amt, $weight))
			{
				$player->message('DB ERROR 2');
				return false;
			}
		}
		else
		{
			$items = $player->getInvItems($itemname, $amt);
			if (count($items) !== $amt)
			{
				$player->message(sprintf('You try to push %s %s but you only have %s.', $amt, $itemname, count($items)));
				return false;
			}
			
			$weight = $item->getItemWeight() * $amt;
			if (false === $clan->canHoldMore($weight))
			{
				$player->message(sprintf(
					'You try to push another %s into the clan bank, but it already holds %s/%s.',
					Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()
				));
				return false;
			}
			
			$weight2 = $item->getItemWeight();
			foreach ($items as $item2)
			{
				$item2 instanceof SR_Item;
				if (false === $this->putIntoBank($player, $clan, $itemname, 1, $weight))
				{
					$player->message('DB ERROR 3');
				}
			}
			
		}
		
		$player->message(sprintf('You put %s of your %s into the clan bank, which now holds %s/%s.', $amt, $itemname, $clan->displayStorage(), $clan->displayMaxStorage()));
		return true;
	}
	
	private function putIntoBank(SR_Player $player, SR_Clan $clan, $itemname, $amt, $weight)
	{
	}

	public function on_pop(SR_Player $player, array $args)
	{
		
	}

}
?>