<?php
/**
 * Show quests and their description.
 * @author gizmore
 */
final class Shadowcmd_quests extends Shadowcmd
{
	/**
	 * Called like
	 * #quests SmithHammer
	 * #quests Lovers
	 * #quests open 1
	 * #quests open
	 * #quests done 1
	 * @param SR_Player $player
	 * @param array $args
	 */
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			$args = array('open');
		}
		
		$quests = SR_Quest::getAllQuests($player);
		
		switch ($args[0])
		{
			case 'miss': case 'missing':
				return self::displayMissing($player, $quests, $args);
			case 'open': 
			case 'deny':
			case 'done':
			case 'fail':
			case 'abort':
				return self::displaySection($player, $quests, $args[0], $args);
			case 'stats': case 's':
				return self::displayStats($player, $quests);
			case 'citystats': case 'cstats': case 'cs':
				return self::displayCityStats($player);
			default:
				if (Common::isNumeric($args[0]))
				{
					return self::onDisplayQuestByNum($player, $quests, $args);
				}
				return self::onSearchQuests($player, $quests, $args);
		}
	}
	
	private static function displayStats(SR_Player $player, array $quests)
	{
		$done = 0;
		$open = 0;
		$total = SR_Quest::getTotalQuestCount();
		$failed = 0;
		$declined = 0;
		$unknown = $total - count($quests);
		
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			if ($quest->isInQuest($player) === true)
			{
				$open++;
			}
			elseif ($quest->isDone($player) === true)
			{
				$done++;
			}
			elseif ($quest->isDeclined($player) === true)
			{
				$declined++;
			}
			elseif ($quest->isFailed($player) === true)
			{
				$failed++;
			}
			else
			{
				$unknown++;
			}
		}
		
		$message = Shadowrun4::lang('5010', array(
			$open, $done, $declined, $failed, $unknown, $total
		));
		
// 		$message = sprintf(
// 			'Quest stats: %d open, %d accomplished, %d rejected, %d failed, %d unknown from a total of %d.',
// 			$open, $done, $declined, $failed, $unknown, $total
// 		);
		
		$player->message($message);
	}
	
	private static function displayCityStats(SR_Player $player)
	{
		$all = SR_Quest::getQuests();
		
		$by_city = array();
		foreach ($all as $quest)
		{
			$quest instanceof SR_Quest;
			$q2 = SR_Quest::getQuest($player, $quest->getVar('sr4qu_name'));
			
			$cityname = $quest->getCityName();
			
			if (false === isset($by_city[$cityname]))
			{
				$by_city[$cityname] = array(0, 0);
			}
			
			if ($q2->isDone($player))
			{
				$by_city[$cityname][0]++;
			}

			$by_city[$cityname][1]++;
		}
		
		$format = Shadowrun4::lang('fmt_cityquests');
		
		$out = '';
		foreach ($by_city as $cityname => $data)
		{
			list($done, $total) = $data;
			$out .= sprintf($format, $cityname, round($done/$total*100,1));
		}
		
		if ($out === '')
		{
			$player->message(Shadowrun4::lang('1010'));
			return false;
		}

		$message = Shadowrun4::lang('5009', array(substr($out, 2)));
// 		$message = sprintf('Quest stats per city: %s.', substr($out, 2));
		$player->message($message);
	}

	private static function getCitySection($arg)
	{
		if (false === ($city = Shadowrun4::getCityByAbbrev($arg)))
		{
			return false;
		}
		return $city->getName();
	}
	
	private static function displaySection(SR_Player $player, array $quests, $section, array $args)
	{
		$city = false;
		$page = isset($args[2]) ? (int)$args[2] : 1;
		if (isset($args[1]))
		{
			if (is_numeric($args[1]))
			{
				$page = (int)$args[1];
			}
			else
			{
				$city = self::getCitySection($args[1]);
			}
		}
// 		$page = isset($args[1]) && Common::isNumeric($args[1]) ? ((int)$args[1]) : 1;
		 
		
// 		$page = isset($args[1]) ? ((int)$args[1]) : 1;
		$filtered = array();
		$i = 0;
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			
			$i++;
			
			if ( ($city !== false) && ($city !== $quest->getCityName()) )
			{
				continue;
			}
			
			$bitin = SR_Quest::$QUEST_FLAGS[$section][0];
			$bitot = SR_Quest::$QUEST_FLAGS[$section][1];
			if (($quest->getOptions() & $bitin) === $bitot)
			{
				$filtered[$i] = $quest;
			}
		}
		return self::displayMultiple($player, $filtered, $page, $section, '1178');
	}
	
	private static function displayMultiple(SR_Player $player, array $quests, $page=1, $section='All', $errcode='1010')
	{
		$nQuests = count($quests);
		$ipp = 10;
		$nPages = GWF_PageMenu::getPagecount($ipp, $nQuests);
		$page = (int)$page;
		
		if (count($quests) === 0)
		{
			return $player->msg($errcode); # There are no quests here.
		}
		if ( (count($quests) === 1) && ($player->getLangISO() !== 'bot') )
		{
			$id = key($quests);
			return self::onDisplayQuest($player, $quests[$id], $id);
		}
		else
		{
			if ( ($page < 1) || ($page > $nPages) )
			{
				return $player->message(Shadowrun4::lang($errcode));
			}
			$quests = array_slice($quests, ($page-1)*10, 10, true);
			$message = '';
			$format = Shadowrun4::lang('fmt_quests');
			foreach ($quests as $id => $quest)
			{
				$quest instanceof SR_Quest;
				$b = ($quest->isAccepted($player) && !$quest->isDone($player)) ? chr(2) : '';
				$message .= sprintf($format, $b, $id, $quest->getQuestName());
			}
			
			if ($message === '')
			{
				return $player->message(Shadowrun4::lang($errcode)); # There are no quests here.
			}
			
			$section = Shadowrun4::lang('qu_'.$section);
			
			return $player->msg('5069', array($section, $page, $nPages, ltrim($message, ',; ')));
// 			self::reply($player, Shadowrun4::lang('5009', array($section, $page, $nPages, substr($message, 2))));
// 			$message = sprintf('%s quests, page %d/%d: %s.', $section, $page, $nPages, substr($message, 2));
// 			self::reply($player, $message);
		}
	}
	
	private static function onDisplayQuestByNum(SR_Player $player, array $quests, array $args)
	{
		$id = (int)$args[0];
		if ( ($id < 1) || ($id > count($quests)) )
		{
			$player->msg('1010');
// 			$player->message(sprintf('Unknown quest ID'));
			return false;
		}
		return self::onDisplayQuest($player, $quests[$id-1], $id);
	}
	
	public static function onSearchQuests(SR_Player $player, array $quests, array $args)
	{
		$page = isset($args[1]) ? ((int)$args[1]) : 1;
		
		$i = 1;
		$filtered = array();
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			
			if ( ($quest->isAccepted($player)) || ($quest->isDone($player)) || ($quest->isDeclined($player)) )
			{
				if (stripos($quest->getQuestName(), $args[0]) !== false)
				{
					$filtered[$i] = $quest;
				}
				elseif (stripos($quest->getQuestDescription(), $args[0]) !== false)
				{
					$filtered[$i] = $quest;
				}
			}
			
			$i++;
		}
	
		return self::displayMultiple($player, $filtered, $page, 'Browse');
	}
	
	private static function onDisplayQuest(SR_Player $player, SR_Quest $quest, $id)
	{
		if ($quest->isUnknown($player))
		{
			return $player->msg('1010');
// 			return self::reply($player, 'This quest is unknown to you.');
		}
		// questid, city, status, questname, description,
		$message = Shadowrun4::lang('5011', array(
			$id, $quest->getCityName(), $quest->getStatusString($player), $quest->getQuestName(), $quest->getQuestDescription()
		));
// 		$message = sprintf('%d: %s - %s (%s)', $id, $quest->getQuestName(), $quest->getQuestDescription(), $quest->getStatusString($player));
		return $player->message($message);
	}

	/**
	 * Display classnames of missing quests in a city.
	 * @param SR_Player $player
	 * @param array $quests
	 * @param array $args
	 * @return true
	 */
	private static function displayMissing(SR_Player $player, array $quests, array $args)
	{
		if (count($args) === 1)
		{
			$args[] = $player->getParty()->getCity();
		}
		
		if (count($args) !== 2)
		{
			return $player->message(Shadowhelp::getHelp($player, 'quests'));
		}
		
		if (false === ($city = Shadowrun4::getCityByAbbrev($args[1])))
		{
			return $player->message(Shadowhelp::getHelp($player, 'quests'));
		}
		
		$cityname = $city->getName();
		
		$names = array();
		$all = SR_Quest::getQuests();
		foreach ($all as $classname => $quest)
		{
			$quest instanceof SR_Quest;

			if ($quest->getCityName() !== $cityname)
			{
				continue;
			}
			
			$q2 = SR_Quest::getQuest($player, $quest->getVar('sr4qu_name'));
			
			if ($q2->isUnknown($player))
			{
				$names[] = Common::substrFrom($classname, '_', $classname);
			}
		}
		
		return $player->msg('5265', array($cityname, GWF_Array::implodeHuman($names)));
	}
}
?>
