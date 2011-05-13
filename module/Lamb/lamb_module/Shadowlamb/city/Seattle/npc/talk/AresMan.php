<?php
final class Seattle_AresMan extends SR_TalkingNPC
{
	public function getName() { return 'The salesman'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	private $price = 500;
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		$bm = 'Seattle_AresMan_BM';
		switch ($word)
		{
			case "blackmarket":
				if ($player->hasTemp($bm))
				{
					$msg = "If someone asks, you did not get the permission from me, chummer. So you want one?";
				}
				else
				{
					$msg = "Hmm yes, i know the guys in the blackmarket. If you like i can give you a life-long permission for $this->price NY, ".irc_bold( "yes" )." ?";
					$player->setTemp($bm, 1);
				}
			case 'yes':
				if ($player->hasTemp($bm))
				{
					$this->buyPermission($player);
					$player->unsetTemp($bm);
					return;
				} else {
					$msg = "Yes, have a good day sir.";
				}
				break;
				
			case 'no':
				if ($player->hasTemp($bm)) {
					$player->unsetTemp($bm);
				}
				$msg = "If life gives you lemons... you might be interested in a few fireweapons.";
				break;
				
			default: $msg = "Good day sir. How can i help you?"; break;
		}
		$this->reply($msg);
	}
	
	private function buyPermission (SR_Player $player)
	{
		if ($player->hasConst("SEATTLE_BM", 1)) {
			$player->message("You already have permission to enter the blackmarket in Seattle.");
			return ;
		}
		
		$nuyen = $player->getNuyen();
		if ($nuyen < $this->price) {
			$player->message("The salesman is shaking his head...\"No!\", he says, \"I want $this->price, not $nuyen\".");
			return;
		}
		
		$player->giveNuyen(-$nuyen);
		$player->message("You give $this->price Nuyen to the salesman...");
		$player->setConst("SEATTLE_BM", 1);
		$this->reply('Ok, here is your permission to enter the blackmarket. And you don\'t know me!');
	}
	
}
?>