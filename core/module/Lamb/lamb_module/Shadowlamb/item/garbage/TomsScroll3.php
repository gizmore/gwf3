<?php
final class Item_TomsScroll3 extends SR_QuestItem
{
	public function isItemDropable() { return true; }
	public function getItemWeight() { return 100; }
	public function getItemDescription() { return 'A scroll you found at Tom\'s rotten home. You can #use this item to read it.'; }

	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message(sprintf('The scroll seems to contain mostly garbage'));
		$player->message(sprintf('Chapter II: %s', $this->getCiphertext($player)));
	}
	
	private function getCiphertext(SR_Player $player)
	{
		$ct = base64_decode('C9RJy1K5IXpZkCXs/IpuY5+Yb3QlYjGwdmeLH/uddAXyA/hJSYt3HiubjWMe7NxikFPX9Hs9CaqE4X4C1j8HqSEs6IJz23nV0eRbfjgHbCoFKYr/J04DvZ9VoTmkYYCI');
		$ct = GWF_AES::decrypt4($ct, LAMB_PASSWORD2, LAMB_PASSWORD2);
		$ct .= $this->getSolution($player);
		$ct = preg_replace('/[^A-Z ]/i', '', $ct);
		$pw = GWF_AES::decrypt4(base64_decode('PXa5vs9yDDi5reJlkUVLGFxldG+VjXJ6s18KFIWTlqE='), LAMB_PASSWORD2, LAMB_PASSWORD2);
		return GWF_PolyROT::encrypt($ct, $pw);
	}
	
	private function getSolution(SR_Player $player)
	{
		$pname = strtolower($player->getName());
		$hash = substr(md5(md5(md5($pname).LAMB_PASSWORD2)), 3, 16);
		return str_replace(array('0','1','2','3','4','5','6','7','8','9'),  array('g','h','i','j','k','l','m','n','o','p'), $hash);
	}
}
?>