<?php
/**
 * Revert a lvlup for a player.
 * @author gizmore
 */
final class Shadowcmd_gmul extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		# Syntax
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'gmul'));
			return false;
		}
		
		# Args
		if (false === ($target = Shadowrun4::getPlayerByShortName($args[0])))
		{
			$player->msg('1017');
			return false;
		}
		elseif ($target === -1)
		{
			$player->msg('1018');
			return false;
		}
		
		# Valid cost?
		$field = $args[1];
		if (false === ($cost = Shadowcmd_lvlup::getKarmaCostFactor($field)))
		{
			$player->msg('1024');
			return false;
		}
		
		# Gather data
		if (false !== ($spell = $target->getSpell($field)))
		{
			$have_level = $target->getSpellBaseLevel($field);
			$is_spell = true;
		}
		else
		{
			$have_level = $target->getBase($field);
			$is_spell = false;
		}
		$karma_back = $cost * $have_level;
		
		# Limit
		if ($have_level <= 0)
		{
			$player->message('Lowered to 0 already!');
			return false;
		}
		
		# Apply
		if ($is_spell === true)
		{
			$target->levelupSpell($field, -1);
		}
		else
		{
			$target->increaseField($field, -1);
		}
		$target->increaseField('karma', $karma_back);
		
		$target->modify();
		
		# Announce
		return $player->message(sprintf('%s reverted %s back to level %s and got %s karma back.', $target->getName(), $field, $have_level-1, $karma_back));
	}
}
?>