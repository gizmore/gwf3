<?php
final class Item_TomsScroll2 extends SR_QuestItem
{
	public function isItemDropable() { return true; }
	public function getItemWeight() { return 100; }
	public function getItemDescription() { return 'A scroll you found at Tom\'s rotten home. You can #use this item to read it.'; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message('The scroll contains hand-written notes from Tom, which are almost readable.');
		$player->message('"TODO: Change the password to the safe. Store the encryption key as md5. Encrypt the new passphrase with a polyalphabetic rot cipher. This should stop Renraku from spying on me!"');
	}
}
?>