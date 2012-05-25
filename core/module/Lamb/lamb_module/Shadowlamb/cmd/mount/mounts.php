<?php
final class Shadowcmd_mounts extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		if (false !== ($city = $p->getCityClass()))
		{
			if ($city->isDungeon())
			{
				self::rply($player, '1035');
				return false;
// 				Shadowrap::instance($player)->reply('In dungeons you don\'t have mounts.');
			}
		}
//		$i = 1;
		$format = $player->lang('fmt_sumlist');
		$out = '';
		$total = 0.0;
		$total_max = 0.0;
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$mount = $member->getMount();
			$we = $mount->calcMountWeight();
			$max = $mount->getMountWeightB();
			$total += $we;
			$total_max += $max;
			if ('' !== ($weight = $mount->displayWeight()))
			{
// 				$weight = "({$weight})";
			}
			$out .= sprintf($format, $member->getEnum(), $mount->getName(), $weight);
// 			$out .= sprintf(", \x02%s\x02-%s%s", $member->getEnum(), $mount->getName(), $weight);
		}
		
		return self::rply($player, '5083', array(Shadowfunc::displayWeight($total), Shadowfunc::displayWeight($total_max), ltrim($out, ',; ')));
// 		$message = sprintf('Party Mounts(%s/%s): %s.', Shadowfunc::displayWeight($total), Shadowfunc::displayWeight($total_max), substr($out, 2));
		
		return Shadowrap::instance($player)->reply($message);
	}
}
?>
