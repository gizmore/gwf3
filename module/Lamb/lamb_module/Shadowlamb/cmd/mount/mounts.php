<?php
final class Shadowcmd_mounts extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$i = 1;
		$out = '';
		$total = 0.0;
		$total_max = 0.0;
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$mount = $member->getMount();
			$we = $mount->calcMountWeight();
			$max = $mount->getMountWeight();
			$total += $we;
			$total_max += $max;
			if ('' !== ($weight = $mount->displayWeight()))
			{
				$weight = "({$weight})";
			}
			$out .= sprintf(", \x02%s\x02-%s%s", $i++, $mount->getName(), $weight);
		}
		
		$message = sprintf('Party Mounts(%s/%s): %s.', Shadowfunc::displayWeight($total), Shadowfunc::displayWeight($total_max), substr($out, 2));
		
		return Shadowrap::instance($player)->reply($message);
	}
}
?>
