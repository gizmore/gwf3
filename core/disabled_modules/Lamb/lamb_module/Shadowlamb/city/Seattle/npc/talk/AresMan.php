<?php
final class Seattle_AresMan extends SR_TalkingNPC
{
// 	public function getName() { return 'The salesman'; }
	public function getName() { return $this->langNPC('name'); }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	private $price = 500;
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		$bm = 'Seattle_AresMan_BM';
		switch ($word)
		{
			case 'gizmore':
				return $this->rply('gizmore');
				#$msg = 'We have multiple gizmo and gadgets.'; break;
			
			case "blackmarket":
				if ($player->hasTemp($bm))
				{
					return $this->rply('bm1');
// 					$msg = "If someone asks, you did not get the permission from me, chummer. So you want one?";
				}
				else
				{
// 					$msg = "Hmm yes, I know the guys in the blackmarket. If you like I can give you a life-long permission for $this->price Nuyen, {$b}yes{$b}?";
					$player->setTemp($bm, 1);
					return $this->rply('bm2', array($this->price));
				}
			case 'yes':
				if ($player->hasTemp($bm))
				{
					$this->buyPermission($player);
					$player->unsetTemp($bm);
					return;
				} else {
					return $this->rply('yes');
// 					$msg = "Yes, have a good day sir.";
				}
				break;
				
			case 'no':
				if ($player->hasTemp($bm)) {
					$player->unsetTemp($bm);
				}
				return $this->rply('no');
// 				$msg = "If life gives you lemons... You might be interested in a few fireweapons.";
				break;
				
			case 'malois':
				return $this->rply('malois');
// 				$msg = 'Never heard of that.'; break;
				
			default:
				return $this->rply('default');
// 				$msg = "Good day sir. How can I help you?"; break;
		}
		return $this->reply($msg);
	}
	
	private function buyPermission (SR_Player $player)
	{
		if ($player->hasConst("SEATTLE_BM", 1))
		{
			return $player->message($this->langNPC('already'));
// 			$player->message("You already have permission to enter the blackmarket in Seattle.");
// 			return ;
		}
		
		$nuyen = $player->getNuyen();
		if ($nuyen < $this->price)
		{
			return $player->message($this->langNPC('poor', array($this->price, $nuyen)));
// 			$player->message("The salesman is shaking his head...\"No!\", he says, \"I want $this->price, not $nuyen\".");
// 			return;
		}
		
		$player->giveNuyen(-$this->price);
		$player->message($this->langNPC('give', array($this->price)));
// 		$player->message("You give $this->price Nuyen to the salesman...");
		$player->setConst("SEATTLE_BM", 1);
		return $this->rply('purchase');
// 		$this->reply('Ok, here is your permission to enter the blackmarket. And you don\'t know me!');
	}
	
}
?>