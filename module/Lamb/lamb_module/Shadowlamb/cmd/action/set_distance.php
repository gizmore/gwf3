<?php
final class Shadowcmd_set_distance extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) === 0)
		{
			$p = $player->getParty();
			$out = '';
			foreach ($p->getMembers() as $member)
			{
				$member instanceof SR_Player;
				if ($p->isFighting()) {
					$out .= sprintf(', %s:%s(%s)', $member->getName(), $member->getBase('distance'), $p->getDistance($member));					
				} else {
					$out .= sprintf(', %s:%s', $member->getName(), $member->getBase('distance'));					
				}
			}
			$player->message('Distances: '.substr($out, 2).'.');
			return true;
		}
		
		if ( (count($args) !== 1) || (!is_numeric($args[0])) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		$d = round(floatval($args[0]), 1);
		if ($d < 0 || $d > SR_Player::MAX_RANGE) {
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		$player->updateField('distance', $d);
		$player->message(sprintf("Your default combat distance has been set to %.01f meters.", $d));
		return true;
	}
}
?>
