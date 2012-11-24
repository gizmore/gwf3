<?php
final class SR_Bounty extends GDO
{
	const FEE = 10.00;
	const TIMEOUT = 604800; # 1 Week
	const NUYEN_PER_LEVEL = 50;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_bounty'; }
	public function getColumnDefines()
	{
		return array(
			'sr4bo_id' => array(GDO::AUTO_INCREMENT),
			'sr4bo_boss' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4bo_victim' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4bo_bounty' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4bo_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'victim' => array(GDO::JOIN,0, array('Dog_User', 'sr4bo_victim', 'user_id')),
		);
	}
	
	##############
	### Static ###
	##############
	public static function getMinNuyen(SR_Player $player)
	{
		return self::NUYEN_PER_LEVEL + $player->getBase('level') * self::NUYEN_PER_LEVEL;
	}
	
	public static function displayBountyParty(SR_Party $party)
	{
		$back = '';
		$format = Shadowrun4::lang('fmt_sumlist');
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$bounty = $member->getBase('bounty');
			if ($bounty > 0)
			{
				$back .= sprintf($format, $member->getEnum(), $member->getName(), Shadowfunc::displayNuyen($bounty));
// 				$back .= sprintf(", {$b}%s{$b}-%s(%s)", $i++, $member->getName(), Shadowfunc::displayNuyen($bounty));
			}
		}
		return $back === '' ? '' : Shadowrun4::lang('meet_bounty', array(ltrim($back, ',; ')));
// 		return $back === '' ? '' : sprintf(" There is a {$b}bounty{$b} on %s.", substr($back, 2));
	}
	
	public static function displayBountyPlayer(SR_Player $player)
	{
		$bounty = $player->getBase('bounty');
		if ($bounty <= 0)
		{
			return $player->lang('no_bounty'); # This player has no bounty.
		}
		$total = Shadowfunc::displayNuyen($bounty);
		return $player->lang('total_bounty', array($total, $player->getName(), self::displayBountyPlayerDetails($player)));
// 		return sprintf("There is a total {$b}bounty of %s{$b} for %s: %s.", $total, $player->getName(), self::displayBountyPlayerDetails($player));
	}
	
	public static function displayBountyPlayerDetails(SR_Player $player)
	{
		return $player->lang('unknown_contr'); # Unknown contractor
	}
	
	public static function displayBounties(SR_Player $player, $page=1, $ipp=10, $orderby='bounty DESC', $server=NULL)
	{
//		$gdo = gdo_db();
		$bounties = self::table(__CLASS__);
		$numItems = $bounties->countRows('', NULL, 'sr4bo_victim');
		$numPages = GWF_PageMenu::getPagecount($ipp, $numItems);
		$page = Common::clamp(intval($page,10), 1, $numPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$bounties = $bounties->selectAll('concat(user_name, "{", user_sid, "}") name, SUM(sr4bo_bounty) bounty', '', $orderby, array('victim'), 10, $from, GDO::ARRAY_N, 'sr4bo_victim');
		
		if (count($bounties) === 0)
		{
			return $player->lang('no_bounties');
// 			return 'There are no bounties at the moment.';
		}
		
		$format = $player->lang('fmt_sumlist');
		
		$out = '';
		foreach ($bounties as $i => $data)
		{
			$ny = Shadowfunc::displayNuyen($data[1]);
			$out .= sprintf($format, $i+1, $data[0], $ny);
// 			$out .= sprintf(", \x02%s\X02-%s(%s)", $i+1, $data[0], $ny);
		}
		
		return $player->lang('bounty_page', array($page, $numPages, ltrim(',; ', 2)));
// 		return sprintf('Bounties page %s/%s: %s.', $page, $numPages, substr($out, 2));
	}
	
	public static function cleanupBounties()
	{
		# TODO: Cleanup?
	}
	
	public static function insertBounty(SR_Player $boss, SR_Player $victim, $nuyen)
	{
		$bounty = new self(array(
			'sr4bo_id' => 0,
			'sr4bo_boss' => $boss->getUID(),
			'sr4bo_victim' => $victim->getUID(),
			'sr4bo_bounty' => $nuyen,
			'sr4bo_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		
		if (false === $bounty->insert())
		{
			return false;
		}
		
		return self::updateBounty($victim);
	}

	private static function updateBounty(SR_Player $victim)
	{
		return $victim->updateField('bounty', self::sumBounty($victim));
	}
	
	private static function sumBounty(SR_Player $victim)
	{
		return self::table(__CLASS__)->selectVar('SUM(sr4bo_bounty)', 'sr4bo_victim='.$victim->getUID());
	}
	
	public static function onKilledByHuman(SR_Player $killer, SR_Player $victim)
	{
		$b = chr(2);
		$where = 'sr4bo_victim='.$victim->getUID();
		$bounty = self::table(__CLASS__)->selectAll('sr4bo_id, sr4bo_bounty', $where, '');
		$sum = 0;
		foreach ($bounty as $data)
		{
			$b = $data['sr4bo_bounty'];
			
//			SR_BountyHistory::onKilled($killer, $victim, $data['sr4bo_id']);

			$sum += $b;
		}
		
		$victim->updateField('bounty', 0);
		
		$killer->giveNuyen($sum);
		
		$killer->increase('sr4pl_bounty_done', $sum);
		
		self::table(__CLASS__)->deleteWhere($where);
		
		$killer->msg('5034', array(Shadowfunc::displayNuyen($sum)));
// 		$killer->message(sprintf("You collected a {$b}bounty{$b}: %s.", Shadowfunc::displayNuyen($sum)));
	}
	
}
?>