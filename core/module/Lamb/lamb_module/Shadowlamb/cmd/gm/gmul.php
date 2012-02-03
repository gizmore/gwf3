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
			self::reply($player, Shadowhelp::getHelp($player, 'gmul'));
			return false;
		}
		
		# Args
		if (false === ($target = Shadowrun4::getPlayerByShortName($args[0])))
		{
			self::rply($player, '1017');
			return false;
		}
		elseif ($target === -1)
		{
			self::rply($player, '1018');
			return false;
		}
		
		# Valid cost?
		$field = $args[1];
		if (false === ($cost = Shadowcmd_lvlup::getKarmaCostFactor($field)))
		{
			self::rply($player, '1024');
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
			self::reply($player, 'Lowered to 0 already!');
			return false;
		}
		
		# Apply
		if ($is_spell === true)
		{
			$player->levelupSpell($field, -1);
		}
		else
		{
			$player->increaseField($field, -1);
		}
		$player->increaseField('karma', $karma_back);
		
		# Announce
		return self::reply($player, sprintf('%s reverted %s back to level %s and got %s karma back.', $target->getName(), $field, $have_level-1, $karma_back));
	}
}
?>