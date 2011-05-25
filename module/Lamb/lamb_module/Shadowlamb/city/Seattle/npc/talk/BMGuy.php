<?php
final class Seattle_BMGuy extends SR_TalkingNPC
{
	public function getName() { return 'Mogrid'; }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Johnson3');
		switch ($word)
		{
			case 'shadowrun':
				if ($quest->isInQuest($player))
				{
					$this->reply('What? You want money for Mr.Johnson?! ... ');
					$this->reply('Well ... give him that from me:');
					SR_NPC::createEnemyParty('Seattle_BMGuy')->fight($player->getParty(), true);
				}
				else
				{
					$this->reply('Yeah, i have heard from you. I have nothing todo though.');
				}
				return;				

			case 'magic': $this->reply('There is no magic in a good weapon.'); break;
			case 'renraku': $this->reply('You don\'t have trouble with renraku, do you?'); break;
			case 'blackmarket': $this->reply('I\'d call it graymarket.'); break;
				
			case 'negotiation':
				$this->reply('Yes, all want to negotiate nowadays.');
				return;
			
			case 'yes':
			case 'no':
			default: $this->reply('Come buy hot stuff!');
		}
	}
}
?>