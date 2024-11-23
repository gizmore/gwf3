<?php
final class Shadowcmd_world extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->msg('5241', array(
			SR_NPC::$NPC_COUNTER, Shadowrun4::getCityCount(),
			SR_Location::$LOCATION_COUNT, SR_Item::getTotalItemCount(),
			SR_Spell::getTotalSpellCount(), SR_Quest::getTotalQuestCount(),
			Shadowcmd::translate('stats')
		));
// 		$bot = Shadowrap::instance($player);
// 		$message = sprintf('In Shadowlamb v3 there are: %s different NPC in %s Areas with %s Locations. %s Items, %s Spells and %s Quests. Try #stats to show how many are playing.', SR_NPC::$NPC_COUNTER, Shadowrun4::getCityCount(), SR_Location::$LOCATION_COUNT, SR_Item::getTotalItemCount(), SR_Spell::getTotalSpellCount(), SR_Quest::getTotalQuestCount());
// 		return $bot->reply($message);
	}
}
?>