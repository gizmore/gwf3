<?php
final class Redmond_TrollsInn extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('ttb' => 'Redmond_Barkeeper', 'ttj' => 'Redmond_Johnson', 'ttg' => 'Redmond_Reginald', 'tts' => 'Redmond_Soldier'); }
	public function getFoundPercentage() { return 20.00; }
	public function getFoundText(SR_Player $player) { return sprintf('In a small sidestreet you found a pub called Trolls_Inn. You have a bad feeling in this area.'); }
	public function getEnterText(SR_Player $player) { return 'You are about to enter the TrollsInn ...'; }
	public function isPVP() { return true; }
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		
		if ($p->getMin('level', true) < 1) {
			$p->notice('You are too afraid to go in there. (Each party member needs a minimum level of 1)');
			return true;
		}
		
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->isHuman())
			{
				$quest = SR_Quest::getQuest($member, 'Renraku_I');
				$quest instanceof Quest_Renraku_I;
				if (false === $quest->checkOrk($player))
				{
					$p->notice('A big angry Ork shouts to you: "You not welcome here!" - The Ork attacks you with a tbs-pocket-knife.');
					SR_NPC::createEnemyParty('Redmond_Ork')->fight($p, true);
					return true;
				}
			}
		}

		$p->pushAction(SR_Party::ACTION_INSIDE);
		
		$b = chr(2);
		$c = Shadowrun4::SR_SHORTCUT;
		$p->notice('The guys in there stare quiet at their drinks when you enter the Trolls Inn.');
		$p->notice('You see a barkeeper, a suspicious person in a dark corner, a soldier and some guests, mostly orks and trolls. One of the guests greets and beckons you.');
		$p->help("Use {$b}{$c}ttb{$b}(arkeeper), {$b}{$c}ttg{$b}(uest), {$b}{$c}ttj{$b}(ohnson) and {$b}{$c}tts{$b}(oldier) to talk to the persons.");
		return true;
	}
	
}
?>