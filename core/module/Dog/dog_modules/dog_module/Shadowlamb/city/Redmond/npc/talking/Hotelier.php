<?php
final class Redmond_Hotelier extends SR_RealNPC
{
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
		));
	}
	
	public function getName() { return 'The hotelier'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		$quest = SR_Quest::getQuest($player, 'Renraku_I');

		if (!$quest->isAccepted($player))
		{
			$this->rply('intro1');
			$this->rply('intro2');
// 			$this->reply('Hello chummer, are you alright? You have been asleep for 32 hours!' );
// 			$this->reply('You are another victim of Renraku?');
			$player->giveKnowledge('words', 'Hello', 'Renraku');
// 			$this->reply('You were saying something about Renraku... Don`t ask me why ... But ... Take this... And maybe wear some clothes... :S');
			$this->rply('intro3');
			$items = array(SR_Item::createByName('FirstAid'), SR_Item::createByName('Clothes'), SR_Item::createByName('Trousers'), SR_Item::createByName('Shoes'));
			$player->giveItems($items, $this->getName());
			$quest->accept($player);
			$player->help($this->langNPC('intro4'));
			$player->help($this->langNPC('intro5'));
			$player->help($this->langNPC('intro6'));
// 			$player->help('Equip your items now with the #equip command. Try #(eq)uip 3, #(eq)uip Trousers and #eq Shoes.');
// 			$player->help('Check your character with: #(s)tatus, #(i)nventory, #e(q)uipment. Examine items with #(ex)amine.');
// 			$player->help('The first thing you should do after checking your equipment is to find new "#kp" in your current city with #(exp)lore.');
		}

		elseif ($word === 'renraku')
		{
			$this->rply('renraku1');
			$this->rply('renraku2');
// 			$this->reply('Geez, you don`t even remember what Renraku is?');
// 			$this->reply('Check out these links: http://www.intercom.net/user/logan1/raku.htm and http://shadowrun.wikia.com/index.php/Renraku_Computer_Systems, chiphead.');
		}
		elseif ($word === 'chiphead')
		{
			$this->rply('chiphead');
// 			$this->reply('Yeah, chiphead... Oh you don`t have a headcomputer yet? Your hairstyle suggested it.');
		}
		elseif ($word === 'headcomputer')
		{
			$this->rply('headcomputer');
// 			$this->reply('Chummer, you must be really confused... A headcomputer is an interface to connect you to computer terminals... Maybe get some '.$c.'sleep.');
		}
		elseif ($word === 'hello')
		{
			$this->rply('hello');
// 			$this->reply('Yeah, hello. Do you need a Hotel room? Somehow I like you chummer, so you don`t need to pay.');
			$player->giveKnowledge('words', 'Yes');
			$player->giveKnowledge('words', 'No');
		}
		elseif ($word === 'yes')
		{
			$this->rply('yes');
			$player->giveKnowledge('words', 'Yes');
// 			$this->reply('Oh yes, you need a room to rest. Just do '.$c.'sleep here. You don`t need to pay.');
		}
		elseif ($word === 'no')
		{
			$this->rply('no');
			$player->giveKnowledge('words', 'No');
// 			$this->reply('Oh, alright, if you don`t need a room now. You can come back anytime.');
		}
		else
		{
			$this->rply('default');
// 			$this->reply('Hello, chummer, I hope you are alright now?');
		}
	}
}
?>
