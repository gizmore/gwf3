<?php
final class Item_TomsScroll1 extends SR_QuestItem
{
	public function isItemDropable() { return true; }
	public function getItemWeight() { return 100; }
	public function getItemDescription() { return 'A scroll you found at Tom\'s rotten home. You can #use this item to read it.'; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message(sprintf('The scroll seems to contain only garbage: "9fd8301ac24fb88e65d9d7cd1dd1b1ec".'));
		
		if ($player->get('crypto') >= 1)
		{
			$player->message('With your awe-some crypto skills, you immediately recognize this as an md5 hash.');
		}
		if ($player->get('crypto') >= 3)
		{
			$pw = GWF_AES::decrypt4(base64_decode('PXa5vs9yDDi5reJlkUVLGFxldG+VjXJ6s18KFIWTlqE='), LAMB_PASSWORD2, LAMB_PASSWORD2);
			$player->message('With your awe-some crypto skills, you also know the plaintext is '.$pw.'.');
		}
	}
}
?>