<?php
/**
 * Generic ClanHQ location.
 * @author gizmore
 */
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
	
	const COST_PUSHY = 40;
	const COST_POPY = 80;
	
	const COST_PUSHI = 10;
	const COST_POPI = 30;
	
	public function getFoundPercentage()
	{
		return 100;
	}
	
	public function getFoundText(SR_Player $player)
	{
		return $player->lang('stub_found_clanhq');
// 		return sprintf('You found the clan headquarters.');
	}
	
	public function getEnterText(SR_Player $player)
	{
		return $player->lang('stub_enter_clanhq');
// 		return sprintf('You enter the clan headquarters.');
	}
	
	public function getHelpText(SR_Player $player)
	{
		return $player->lang('hlp_clan_enter');
// 		$c = Shadowrun4::SR_SHORTCUT;
// 		return "Join clans with {$c}abandon, {$c}request and {$c}accept. Create a clan with {$c}create. Purchase more size and motto with {$c}manage. Set options with {$c}toggle. Access clan bank with {$c}push, {$c}pop and {$c}view, clan money with {$c}pushy and {$c}popy.";
	}
	
	public function getCommands(SR_Player $player)
	{
		return array('abandon', 'request', 'accept', 'create' , 'manage', 'toggle', 'push', 'pop', 'view', 'pushy', 'popy');
	}

	public function on_abandon(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message(sprintf('You are not in a clan.'));
			return false;
		}
		
		if ($clan->getMembercount() === 1)
		{
			if (!$clan->isStorageEmpty())
			{
				$player->msg('1119');
// 				$player->message(sprintf('You cannot destroy a clan when storage is not empty.'));
				return false;
			}
			if ($clan->getNuyen() > 0)
			{
				$player->msg('1119');
// 				$player->message(sprintf('You cannot destroy a clan when the bank is not empty.'));
				return false;
			}
		}
		
		if (false === $clan->kick($player))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		
		$player->msg('5165', array($clan->getName()));
// 		$player->message(sprintf('You have left the "%s" clan.', $clan->getName()));
		return true;
	}
	
	public function on_request(SR_Player $player, array $args)
	{
		if (false !== ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1120', array($clan->getName()));
// 			$player->message(sprintf('You are already in the clan "%s".', $clan->getName()));
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_request'));
			return false;
		}
		
		if (
			(false === ($clan = SR_Clan::getByName($args[0])))
			&& (false === ($clan = SR_Clan::getByPName($args[0])))
		)
		{
			$player->msg('1121');
// 			$player->message('This clan or player is unknown.');
			return false;
		}
		
		if ($clan->isFullMembers())
		{
			$player->msg('1122', array($clan->getMaxMembercount()));
// 			$player->message(sprintf('This clan has reached it\'s member limit of %d.', $clan->getMaxMembercount()));
			return false;
		}
		
		if ($clan->isModerated())
		{
			if (SR_ClanRequests::hasOpenRequests($player))
			{
				$player->msg('1123');
// 				$player->message('You were already applying for a clan, your old request has been deleted.');
				SR_ClanRequests::clearRequests($player);
			}
			return $clan->sendRequest($player);
		}
		else
		{
			return $clan->join($player);
		}
	}

	public function on_accept(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message("You don't have a clan, chummer!");
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
			$player->msg('1124');
// 			$player->message("You don't lead this clan, chummer!");
			return false;
		}
		
		# Accept
		if (false === ($joiner = SR_ClanRequests::getRequest($player, $clan, $args[0])))
		{
			$player->msg('1125', array($args[0]));
// 			$player->message(sprintf('%s did not request to join your clan.', $args[0]));
			return false;
		}
		
		if ($clan->isFullMembers())
		{
			$player->msg('1126', array($clan->getMaxMembercount()));
// 			$player->message(sprintf("Your clan has reached it's limit of %s members. You can purchase more slots via the #manage function.", $clan->getMaxMembercount()));
			return false;
		}
		
		if (false === $clan->join($joiner))
		{
			$player->message('DB ERROR 4');
			return false;
		}
		
		SR_ClanRequests::clearRequests($joiner);
		
		$joiner->msg('5166', array($leader->displayName(), $clan->getName()));
// 		$joiner->message(sprintf('%s has accepted your join request for the %s clan.', $leader->displayName(), $clan->getName()));
		
		return true;
	}
	
	private function showRequests(SR_Player $player, SR_Clan $clan, $page=1)
	{
		$ipp = 10;
		$cid = $clan->getID();
		$table = GDO::table('SR_ClanRequests');
		$nItems = $table->countRows("sr4cr_cid={$cid}");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$page = (int)$page;
		if ( ($page < 1) || ($page > $nPages) )
		{
			$player->msg('1009');
// 			$player->message('This page is empty.');
			return false;
		}
		
		if (false === ($result = $table->selectAll('sr4cr_pname', "sr4cr_cid={$cid}", '', NULL, $ipp, $from, GDO::ARRAY_N)))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		
		$message = '';
		
		foreach ($result as $row)
		{
			$message .= ', '.$row[0];
		}
		
		$player->msg('5167', array($page, $nPages, substr($message, 2)));
// 		$player->message(sprintf('Clan join requests page %d/%d: %s.', $page, $nPages, substr($message, 2)));
		
		return true;
	}
	
	public function on_create(SR_Player $player, array $args)
	{
		if (false !== ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1120', array($clan->getName()));
// 			$player->message(sprintf('You are already in the "%s" clan, chummer.', $clan->getName()));
			return false;
		}
		
// 		printf('PID: %s', $player->getID());
		
// 		return true;
		
		$dcost = Shadowfunc::displayNuyen(self::COST_CREATE);
		
		if ($player->getBase('level') < self::LVL_CREATE)
		{
			$player->msg('1127', array(self::LVL_CREATE));
// 			$player->message(sprintf('You do not have the minimum level of %s to create a clan.', self::LVL_CREATE));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_CREATE))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('It cost %s to create a clan, but you only got %s.', $dcost, $player->displayNuyen()));
			return false;
		}
		
		$name = implode(' ', $args);
		if (strlen($name) > SR_Clan::MAX_NAME_LEN)
		{
			$player->msg('1128');
// 			$player->message('The name of your clan is too long or too short.');
			return false;
		}
		if (strlen($name) < SR_Clan::MIN_NAME_LEN)
		{
			$player->msg('1128');
// 			$player->message('The name of your clan is too long or too short.');
			return false;
		}

		if (false !== ($clan2 = SR_Clan::getByName($name)))
		{
			$player->msg('1129');
// 			$player->message('A clan with this name already exists.');
			return false;
		}
		
		if (false === ($clan = SR_Clan::create($player, $name)))
		{
			$player->message('DB ERROR 5');
			return false;
		}
		
		if (false === $player->giveNuyen(-self::COST_CREATE))
		{
			$player->message('DB ERROR 6');
			return false;
		}
		
		$player->msg('5168', array($clan->getName()));
// 		$player->message(sprintf('Congratulations. You formed a new clan named "%s".', $clan->getName()));
		return true;
	}

	public function on_manage(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message("You don't have a clan, chummer!");
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
		if ($clan->getLeaderID() != $player->getID())
		{
			$player->msg('1124');
// 			$player->message("You don't lead this clan, chummer!");
			return false;
		}
		
		array_shift($args);
		$slogan = implode(' ', $args);
		
		$cost = self::COST_SLOGAN;
		$dcost = Shadowfunc::displayNuyen($cost);
		
		if (false === $player->hasNuyen($cost))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('It cost %s to set a slogan for your clan, but you only have %s.', $dcost, $player->displayNuyen()));
			return false;
		}
		
		if (strlen($slogan) > 196)
		{
			$player->msg('1130', array(196));
// 			$player->message(sprintf('Your slogan exceeds the maxlength of %s characters.', 196));
			return false;
		}
		
		if (false === $clan->saveVar('sr4cl_slogan', $slogan))
		{
			$player->message('DB ERROR 6');
			return false;
		}
		
		$player->msg('5169', array($dcost));
// 		$player->message(sprintf('You paid the fee of %s and set a new slogan for your clan.', $dcost));
		return true;
	}
	
	private function onBuyWealth(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = Shadowfunc::displayNuyen(self::ADD_WEALTH);
		$dcost = Shadowfunc::displayNuyen(self::COST_WEALTH);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			return $player->msg('5170', array($clan->displayMaxNuyen(), $dadd, $dcost, self::CONFIRM_PHRASE));
// 			$player->message(sprintf(
// 				'Your clan currently can bank %s. Another %s would cost you %s. Please type #manage buywealth %s to confirm.',
// 				$clan->displayMaxNuyen(), $dadd, $dcost, self::CONFIRM_PHRASE
// 			));
// 			return true;
		}
		
		if ($clan->isMaxMoney())
		{
			$player->msg('5171', array($clan->displayNuyen(), $clan->displayMaxNuyen()));
// 			$player->message(sprintf('Your clan has already reached the maximum of %s/%s.', $clan->displayNuyen(), $clan->displayMaxNuyen()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_WEALTH))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('It would cost %s to buy another %s of clan wealth, but you only got %s.',
// 				$dcost, $dadd, $player->displayNuyen()
// 			));
			return false;
		}
		
		if (false === $player->giveNuyen(-self::COST_WEALTH))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		if (false === $clan->addWealth(self::ADD_WEALTH))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		$player->msg('5172', array($dcost, $clan->displayNuyen(), $clan->displayMaxNuyen()));
		
// 		$player->message(sprintf(
// 			'You paid %s and your clan now has a max wealth of %s/%s.',
// 			$dcost, $clan->displayNuyen(), $clan->displayMaxNuyen()
// 		));
		
		return SR_ClanHistory::onAddWealth($clan, $player);
	}

	private function onBuyStorage(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = Shadowfunc::displayWeight(self::ADD_STORAGE);
		$dcost = Shadowfunc::displayNuyen(self::COST_STORAGE);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			return $player->msg('5170', array($clan->displayMaxStorage(), $dadd, $dcost, self::CONFIRM_PHRASE));
// 			$player->message(sprintf(
// 				'Your clan currently can store %s. Another %s would cost you %s. Please type #manage buystorage %s to confirm.',
// 				$clan->displayMaxStorage(), $dadd, $dcost, self::CONFIRM_PHRASE
// 			));
// 			return true;
		}
		
		if ($clan->isMaxStorage())
		{
			$player->msg('5171', array($clan->displayNuyen(), $clan->displayMaxNuyen()));
// 			$player->message(sprintf('Your clan has already reached the maximum of %s/%s storage.', $clan->displayStorage(), $clan->displayMaxStorage()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_STORAGE))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('It would cost %s to buy another %s of clan storage, but you only got %s.',
// 				$dcost, $dadd, $player->displayNuyen()
// 			));
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
		
		$player->msg('5172', array($dcost, $clan->displayStorage(), $clan->displayMaxStorage()));
		
// 		$player->message(sprintf(
// 			'You paid %s and your clan has now a max storage of %s/%s.',
// 			$dcost, $clan->displayStorage(), $clan->displayMaxStorage()
// 		));
		
		return SR_ClanHistory::onAddStorage($clan, $player);
	}

	private function onBuyMembers(SR_Player $player, SR_Clan $clan, array $args)
	{
		$dadd = self::ADD_MEMBERS;
		$dcost = Shadowfunc::displayNuyen(self::COST_MEMBERS);
		
		if ( (count($args) !== 2) || ($args[1] !== self::CONFIRM_PHRASE) )
		{
			return $player->msg('5170', array($clan->displayMaxMembercount(), $dadd, $dcost, self::CONFIRM_PHRASE));
// 			$player->message(sprintf(
// 				'Your clan currently can have a maximum of %s members. Raising this maximum by %s would cost you %s. Please type #manage buystorage %s to confirm.',
// 				$clan->getMaxMembercount(), $dadd, $dcost, self::CONFIRM_PHRASE
// 			));
			return true;
		}
		
		if ($clan->isMaxStorage())
		{
			$player->msg('5171', array($clan->getMembercount(), $clan->displayMaxMembercount()));
// 			$player->message(sprintf('Your clan has already reached the maximum of %s/%s storage.', $clan->displayStorage(), $clan->displayMaxStorage()));
			return false;
		}
		
		if (false === $player->hasNuyen(self::COST_MEMBERS))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('It would cost %s to raise your max members by %s, but you only got %s.',
// 				$dcost, $dadd, $player->displayNuyen()
// 			));
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
		
		$player->msg('5172', array($dcost, $clan->getMembercount(), $clan->displayMaxMembercount()));
// 		$player->message(sprintf(
// 			'You paid %s and your clan has now of %s/%s members.',
// 			$dcost, $clan->getMembercount(), $clan->getMaxMembercount()
// 		));
		
		return SR_ClanHistory::onAddMembers($clan, $player);
	}

	public function on_pushy(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message('You are not in a clan.');
			return false;
		}
		
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_pushy'));
			return false;
		}
		
		$amt = (int)$args[0];
		if ($amt <= 0)
		{
			$player->msg('1062');
// 			$player->message('Please push a postive amount of nuyen.');
			return false;
		}
		
		$damt = Shadowfunc::displayNuyen($amt);
		$dfee = Shadowfunc::displayNuyen(self::COST_PUSHY);
		$totalneed = $amt + self::COST_PUSHY;
		if (false === $player->hasNuyen($totalneed))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('You want to push %s(+%s)=%s to the clan bank, but you only got %s.',
// 				$damt, $dfee, Shadowfunc::displayNuyen($totalneed), $player->displayNuyen()
// 			));
			return false;
		}
		
		$max = $clan->getMaxNuyen();
		$have = $clan->getNuyen();
		$can = $max-$have;
		
		if ($can === 0)
		{
			$player->msg('5171', array($clan->displayNuyen(), $clan->displayMaxNuyen()));
// 			$player->message(sprintf('Your clan already holds the maximum of %s/%s.', $clan->displayNuyen(), $clan->displayMaxNuyen()));
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
		
		$player->msg('5173', array($dfee, Shadowfunc::displayNuyen($amt), $clan->displayNuyen(), $clan->displayMaxNuyen()));
// 		$player->message(sprintf('You pay the fee of %s and push %s to the clan bank, which now holds %s/%s.',
// 			$dfee, Shadowfunc::displayNuyen($amt), $clan->displayNuyen(), $clan->displayMaxNuyen()
// 		));
		
		return SR_ClanHistory::onPushy($clan, $player, $amt);
	}

	public function on_popy(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message('You are not in a clan.');
			return false;
		}
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_popy'));
			return false;
		}
		$amt = (int)$args[0];
		if ($amt <= 0)
		{
			$player->msg('1062');
// 			$player->message('Please pop a postive amount of nuyen.');
			return false;
		}
		$damt = Shadowfunc::displayNuyen($amt);
		$dfee = Shadowfunc::displayNuyen(self::COST_POPY);
		$totalneed = $amt + self::COST_POPY;
		
		$have = $clan->getNuyen();
		
		if ($have < $totalneed)
		{
			$player->msg('1131', array($damt, $dfee, Shadowfunc::displayNuyen($totalneed), $clan->displayNuyen()));
// 			$player->message(sprintf('You want to pop %s(+%s)=%s out of the clan bank, but it currently holds only %s.',
// 				$damt, $dfee, Shadowfunc::displayNuyen($totalneed), $clan->displayNuyen()
// 			));
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
		
		$player->msg('5174', array(Shadowfunc::displayNuyen($totalneed), $dfee, $damt, $clan->displayNuyen(), $clan->displayMaxNuyen()));
// 		$player->message(sprintf('You pop %s(-%s)=%s out of the clan bank, which now holds %s/%s.',
// 			Shadowfunc::displayNuyen($totalneed), $dfee, $damt, $clan->displayNuyen(), $clan->displayMaxNuyen()
// 		));

		return SR_ClanHistory::onPopy($clan, $player, $totalneed);
	}
	
	public function on_push(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message('You are not in a clan.');
			return false;
		}
		if ( (count($args) !== 1) && (count($args) !== 2) )
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_push'));
			return false;
		}
		
		$fee = self::COST_PUSHI;
		$dfee = Shadowfunc::displayNuyen($fee);
		if (false === $player->hasNuyen($fee))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('The fee to push items in the bank is %s, but you only have %s.', $dfee, $player->displayNuyen()));
			return false;
		}
		
		$amt = isset($args[1]) ? ((int)$args[1]) : 1;
		if ($amt <= 0)
		{
			$player->message('1038');
// 			$player->message('Please push a positive amount of items.');
			return false;
		}
		
		if (false === ($item = $player->getInvItem($args[0])))
		{
			$player->message('1029');
// 			$player->message("You don't have that item in your inventory.");
			return false;
		}
		$itemname = $item->getItemName();
		
		if ($item->isItemStackable())
		{
			if ($item->getAmount() < $amt)
			{
				$player->msg('1040', array($itemname));
// 				$player->message(sprintf('You try to push %s %s but you only have %s.', $amt, $itemname, $item->getAmount()));
				return false;
			}
			$weight = $item->getItemWeightStacked();
			if (false === $clan->canHoldMore($weight))
			{
				$player->msg('1132', array(Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()));
// 				$player->message(sprintf('You try to push another %s into the clan bank, but it already holds %s/%s.',
// 					Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()
// 				));
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
				$player->msg('1040', array($itemname));
// 				$player->message(sprintf('You try to push %s %s but you only have %s.', $amt, $itemname, count($items)));
				return false;
			}
			
			$weight = $item->getItemWeight() * $amt;
			if (false === $clan->canHoldMore($weight))
			{
				$player->msg('1132', array(Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()));
// 				$player->message(sprintf(
// 					'You try to push another %s into the clan bank, but it already holds %s/%s.',
// 					Shadowfunc::displayWeight($weight), $clan->displayStorage(), $clan->displayMaxStorage()
// 				));
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
				
				elseif (false === $item2->deleteItem($player))
				{
					$player->message('DB ERROR 33');
				}
			}
		}
		
		if (false === $player->giveNuyen(-$fee))
		{
			$player->message('DB ERROR 44');
		}
		
		$player->msg('5173',array($dfee, "{$amt}x{$itemname}", $clan->displayStorage(), $clan->displayMaxStorage()));
// 		$message = sprintf(
// 			'You pay the fee of %s and put %s of your %s into the clan bank, which now holds %s/%s.',
// 			$dfee, $amt, $itemname, $clan->displayStorage(), $clan->displayMaxStorage());
// 		$player->message($message);
		
		return SR_ClanHistory::onPushi($clan, $player, $itemname, $amt);
	}
	
	private function putIntoBank(SR_Player $player, SR_Clan $clan, $itemname, $amt, $weight)
	{
		return SR_ClanBank::push($clan, $itemname, $amt, $weight);
	}

	public function on_pop(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message('You are not in a clan.');
			return false;
		}
		if ( (count($args) !== 1) && (count($args) !== 2) )
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_pop'));
			return false;
		}
		$amt = isset($args[1]) ? ((int)$args[1]) : 1;
		if ($amt <= 0)
		{
			$player->message('1038');
// 			$player->message('Please pop a positive amount of items.');
			return false;
		}
		$itemname = $args[0];
		
		if (false === ($row = SR_ClanBank::getByCIDINAME($clan->getID(), $itemname)))
		{
			$player->message('1133');
// 			$player->message('You don\'t have that item in your clanbank.');
			return false;
		}
		$itemname = $row->getIName();
		
		$fee = self::COST_POPI;
		$dfee = Shadowfunc::displayNuyen($fee);
		if (false === $player->hasNuyen($fee))
		{
			$player->msg('1063', array($player->displayNuyen()));
// 			$player->message(sprintf('The fee to pop items from the clanbank is %s, but you only have %s.', $dfee, $player->displayNuyen()));
			return false;
		}
		
		if ($row->getAmt() < $amt)
		{
			$player->msg('1134', array($itemname));
// 			$player->message(sprintf('You try to take %s %s out of the clan bank, but there are only %s.', $amt, $itemname, $row->getAmt()));
			return false;
		}
		
		if (false === ($item = SR_Item::createByName($itemname, 1, false)))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		
		if ($item->isItemStackable())
		{
			if (false === ($item2 = SR_Item::createByName($itemname, $amt)))
			{
				$player->message('DB ERROR 2');
				return false;
			}
			if (false === $player->giveItems(array($item2), 'Clanbank'))
			{
				$player->message('DB ERROR 3');
				return false;
			}
		}
		else
		{
			$items = array();
			for ($i = 0; $i < $amt; $i++)
			{
				if (false === ($items[] = SR_Item::createByName($itemname, 1)))
				{
					$player->message('DB ERROR 4');
					return false;
				}
			}
			if (false === $player->giveItems($items, 'Clanbank'))
			{
				$player->message('DB ERROR 5');
				return false;
			}
		}
		
		if (false === $player->giveNuyen(-$fee))
		{
			$player->message('DB ERROR 44');
		}
		
		$weight = $item->getItemWeight() * $amt;
		
		if (false === $row->pop($clan, $amt, $weight))
		{
			$player->message('DB ERROR 55');
		}
		
		$player->msg('5174', array(
			$dfee, "{$amt}x{$itemname}", $clan->displayStorage(), $clan->displayMaxStorage()
		));
// 		$message = sprintf(
// 			'You pay the fee of %s and pop %s %s out of the clanbank. %s/%s storage left.',
// 			$dfee, $amt, $itemname, $clan->displayStorage(), $clan->displayMaxStorage()
// 		);
		
		return SR_ClanHistory::onPopi($clan, $player, $itemname, $amt);
	}

	public function on_toggle(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message("You don't have a clan, chummer!");
			return false;
		}
		
		if ($clan->getLeaderID() != $player->getID())
		{
			$player->msg('1124');
// 			$player->message("You don't lead this clan, chummer!");
			return false;
		}
		
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_toggle'));
			return false;
		}
		
		switch ($args[0])
		{
			case 'm': case 'moderation':
				return $this->onToggle($player, $clan, SR_Clan::MODERATED, 'moderation');
				
			default:
				$player->message(Shadowhelp::getHelp($player, 'clan_toggle'));
				return false;
		}
	}
	
	private function onToggle(SR_Player $player, SR_Clan $clan, $bit, $text)
	{
		if ($clan->isOptionEnabled($bit))
		{
			if (false === $clan->saveOption($bit, false))
			{
				$player->message('DB ERROR 1');
				return false;
			}
			$switch = 'disabled';
		}
		else
		{
			if (false === $clan->saveOption($bit, true))
			{
				$player->message('DB ERROR 2');
				return false;
			}
			$switch = 'enabled';
		}
		
		$bot = Shadowrap::instance($player);
		return $bot->rply('5175', array($player->lang('ct_'.$text)), $player->lang($switch));
// 		return $bot->reply(sprintf('Your clan\'s %s option has been %s.', $text, $switch));
	}
	
	public function on_view(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message("You don't have a clan, chummer!");
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_view'));
			return false;
		}
		
		if ( (count($args) === 1) && (Common::isNumeric($args[0])) )
		{
			return $this->onViewPage($clan, $player, (int)$args[0]);
		}
		elseif (count($args) <= 2)
		{
			$page = isset($args[1]) ? (int)$args[1] : 1;
			return $this->onViewItems($clan, $player, $args[0], $page);
		}
		else
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_view'));
			return false;
		}
	}
	
	private function onViewPage(SR_Clan $clan, SR_Player $player, $page)
	{
		$ipp = 10;
		$cid = $clan->getID();
		$table = GDO::table('SR_ClanBank');
		$where = "sr4cb_cid={$cid}";
		$nItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ( ($page < 1) || ($page > $nPages) )
		{
			$player->msg('1009');
// 			$player->message('This page is empty.');
			return false;
		}
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$orderby = 'sr4cb_iamt ASC, sr4cb_iname ASC';
		if (false === ($result = $table->selectAll('sr4cb_iname, sr4cb_iamt', $where, $orderby, NULL, $ipp, $from, GDO::ARRAY_N)))
		{
			$player->message('DB ERROR 1.');
			return false;
		}
		$out = '';
		$format = $player->lang('fmt_items');
		foreach ($result as $row)
		{
			$from++;
			list($itemname, $amt) = $row;
			$damt = $amt === '1' ? '' : "({$amt})";
			$out .= sprintf($format, $from, $itemname, $damt, $amt);
// 			$out[] = sprintf('%d-%s%s', $from, $itemname, $amt);
		}
		$bot = Shadowrap::instance($player);
		
		return $bot->rply('5176', array($page, $nPages, substr($out, 2)));
// 		$text = count($out) === 0 ? 'The bank is empty.' : implode(', ', $out);
// 		return $bot->reply(sprintf('ClanBank page %d/%d: %s.', $page, $nPages, $text));
	}
	
	private function onViewItems(SR_Clan $clan, SR_Player $player, $arg, $page)
	{
		$ipp = 10;
		$cid = $clan->getID();
		$arg = GDO::escape($arg);
		$page = (int)$page;
		$table = GDO::table('SR_ClanBank');
		$where = "sr4cb_cid={$cid} AND sr4cb_iname LIKE '%{$arg}%'";
		$nItems = $table->countRows($where);
		if ($nItems === 0)
		{
			$player->msg('1007');
// 			$player->message('No match found.');
			return true;
		}
		
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ( ($page < 1) || ($page > $nPages) )
		{
			$player->msg('1009');
// 			$player->message('This page is empty.');
			return false;
		}
		
		$from = GWF_PageMenu::getFrom($page, $ipp);
		if (false === ($result = $table->selectAll('sr4cb_iname, sr4cb_iamt', $where, 'sr4cb_iamt ASC, sr4cb_iname ASC', NULL, $ipp, $from, GDO::ARRAY_N)))
		{
			$player->message('DB ERROR 1.');
			return false;
		}
		
		if (count($result) === 1)
		{
			return $this->onViewItem($clan, $player, $result[0][0], $result[0][1]);
		}
		
		$out = '';
		$format = $player->lang('fmt_items');
		foreach ($result as $row)
		{
			$from++;
			list($itemname, $amt) = $row;
			$damt = $amt === '1' ? '' : "({$amt})";
			$out .= sprintf($format, $from, $itemname, $damt, $amt);
// 			$out[] = sprintf('%d-%s%s', $from, $itemname, $amt);
		}
		
		$bot = Shadowrap::instance($player);
		return $bot->rply('5176', array($page, $nPages, substr($out, 2)));
// 		return $bot->reply(sprintf('ClanBank page %d/%d: %s.', $page, $nPages, implode(', ', $out)));
	}
	
	private function onViewItem(SR_Clan $clan, SR_Player $player, $itemname, $amt)
	{
		if (false === ($item = SR_Item::createByName($itemname, $amt, false)))
		{
			$player->message('ITEM ERROR');
			return false;
		}
		$bot = Shadowrap::instance($player);
		return $bot->reply($item->getItemInfo($player));
	}
	
	public static function onClanMessage(SR_Player $player, array $args)
	{
		if (false === ($clan = SR_Clan::getByPlayer($player)))
		{
			$player->msg('1019');
// 			$player->message('You are not in a clan, chummer.');
			return false;
		}
		
		if ('' === ($message = implode(' ', $args)))
		{
			$player->message(Shadowhelp::getHelp($player, 'clan_message'));
			return false;
		}
		
		foreach (SR_ClanMembers::getOnlineMembers($clan->getID()) as $member)
		{
			$member instanceof SR_Player;
			$member->message($message);
		}
		
		return SR_ClanHistory::onMessage($clan, $player, $message);
	}
}
?>