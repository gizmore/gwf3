<?php
final class SR_Bounty extends GDO
{
	const FEE = 10.00;
	const TIMEOUT = 604800; # 1 Week
	const NUYEN_PER_LEVEL = 100;
	
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
			'victim' => array(GDO::JOIN,0, array('Lamb_User', 'sr4bo_victim', 'lusr_id')),
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
		$i = 1;
		$b = chr(2);
		$back = '';
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$bounty = $member->getBase('bounty');
			if ($bounty > 0)
			{
				$back .= sprintf(", {$b}%s{$b}-%s(%s)", $i++, $member->getName(), Shadowfunc::displayPrice($bounty));
			}
		}
		return $back === '' ? '' : sprintf(" There is a {$b}bounty{$b} on %s.", substr($back, 2));
	}
	
	public static function displayBountyPlayer(SR_Player $player)
	{
		$bounty = $player->getBase('bounty');
		if ($bounty <= 0)
		{
			return "This player has no bounty.";
		}
		$total = Shadowfunc::displayPrice($bounty);
		$b = chr(2);
		return sprintf("There is a total {$b}bounty of %s{$b} for %s: %s.", $total, $player->getName(), self::displayBountyPlayerDetails($player));
	}
	
	public static function displayBountyPlayerDetails(SR_Player $player)
	{
		return "Unknown Contactors";
	}
	
	public static function displayBounties(SR_Player $player, $page=1, $ipp=10, $orderby='bounty DESC', $server=NULL)
	{
//		$gdo = gdo_db();
		$bounties = self::table(__CLASS__);
		$numItems = $bounties->countRows('', NULL, 'sr4bo_victim');
		$numPages = GWF_PageMenu::getPagecount($ipp, $numItems);
		$page = Common::clamp(intval($page,10), 1, $numPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$bounties = $bounties->selectAll('concat(lusr_name, "{", lusr_sid, "}") name, SUM(sr4bo_bounty) bounty', '', $orderby, array('victim'), 10, $from, GDO::ARRAY_N, 'sr4bo_victim');
		
		if (count($bounties) === 0)
		{
			return 'There are no bounties at the moment.';
		}
		
		$out = '';
		foreach ($bounties as $i => $data)
		{
			$ny = Shadowfunc::displayPrice($data[1]);
			$out .= sprintf(", \x02\%s\x02-%s(%s)", $i+1, $data[0], $ny);
		}
		return sprintf('Bounties page %s/%s: %s.', $page, $numPages, substr($out, 2));
	}
	
	public static function cleanupBounties()
	{
		
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
//			SR_BountyStats::i
			$sum += $b;
		}
		
		$killer->giveNuyen($sum);
		self::table(__CLASS__)->deleteWhere($where);
		
		$killer->message(sprintf("You collected a {$b}bounty{$b}: %s.", Shadowfunc::displayPrice($sum)));
	}
	
}
?>