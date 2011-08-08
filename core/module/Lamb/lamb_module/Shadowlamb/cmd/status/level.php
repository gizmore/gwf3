<?php
final class Shadowcmd_level extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		$p = $player->getParty();
		$out = '';
		foreach ($p->getMembers() as $member)
		{
			$out .= sprintf(', %s(L%s(%s))', $member->getName(), $member->getBase('level'), $member->get('level'));
		}
		$bot->reply(sprintf('Your party has level %s(%s/%s): %s.', $p->getPartyLevel(), $p->getPartyXP(), SR_Party::XP_PER_LEVEL, substr($out, 2)));
		return true;
	}
}
?>