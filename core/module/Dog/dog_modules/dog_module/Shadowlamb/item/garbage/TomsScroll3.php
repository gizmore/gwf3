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
		$ct = base64_decode('XuuV+k2zXxV0C38j0xP+ey3bRl/BTEl/mtwapOW3MaJ1a/GhkYbCYiCtCikX9ELlDOvZh0lTgONAkKjdEPMYqDqLLD/lOkUdKPh7NLoRiaGoIIczHQhVLzFao2nkpAlMFoLQ2iTbVx2t6ypisdSkvaSfoFUyZ/67E8hujBEXnjlX1PCsoq8XBA6TBhL0mS/7raDATqk5bJJaTpj+sJjMNVAFjkvrD39AiLlnK5cr9ZLsNTr0MWrREhuijdFaw+eg');
		$ct = GWF_AES::decrypt4($ct, LAMB_PASSWORD2, LAMB_PASSWORD2);
		$ct .= $this->getSolution($player);
		$ct = preg_replace('/[^A-Z ]/i', '', $ct);
		$pw = GWF_AES::decrypt4(base64_decode('PVHAh6iIlV/Oam8SU3zoZgX4Ziy9U7eYKjF6ogdwG7o='), LAMB_PASSWORD2, LAMB_PASSWORD2);
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