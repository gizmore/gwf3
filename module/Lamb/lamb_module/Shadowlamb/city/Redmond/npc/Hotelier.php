<?php
final class Redmond_Hotelier extends SR_TalkingNPC
{
	public function getName() { return 'The hotelier'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$quest = SR_Quest::getQuest($player, 'Renraku_I');

		# DEBUG
//		if ($word === 'fuck') {
//			$player->giveItems(Shadowfunc::randLoot($player, 1111));
//			return;
//		}
//		elseif ($word === 'foo') {
//			SR_NPC::createEnemyParty('Redmond_Lamer')->fight($player->getParty());
//			return;
//		}
//		elseif ($word === 'bar') {
//			SR_NPC::createEnemyParty('Redmond_Burglar')->fight($player->getParty());
//			return;
//		}
//		elseif ($word === 'foobar') {
//			SR_NPC::createEnemyParty('Redmond_ToughGuy')->fight($player->getParty());
//			return;
//		}
//		elseif ($word === 'fuckbar') {
//			SR_NPC::createEnemyParty('Redmond_Ueberpunk')->fight($player->getParty());
//			return;
//		}
//		elseif ($word === 'fuckork') {
//			SR_NPC::createEnemyParty('Redmond_Ork')->fight($player->getParty());
//			return;
//		}
		
		
		if (!$quest->isAccepted($player))
		{
			$this->reply('Hello chummer, are you alright? You have been asleep for 32 hours!' );
			$this->reply('You are another victim of Renraku?');
			$this->reply('You were saying something about Renraku... Don`t ask me why ... but ... take this... and maybe wear some clothes... :S');
			$player->giveItems(SR_Item::createByName('FirstAid'), SR_Item::createByName('Clothes'));
			$player->giveKnowledge('words', 'Hello', 'Renraku');
			$quest->accept($player);
		}

		elseif ($word === 'renraku')
		{
			$this->reply('Geez, you don`t even remember what Renraku is?');
			$this->reply('Check out this link: http://wiki.dumpshock.com/index.php/Renraku_Computer_Systems , chiphead.');
		}
		elseif ($word === 'chiphead')
		{
			$this->reply('Yeah, chiphead... Oh you don`t have a headcomputer yet? Your hairstyle suggested it.');
		}
		elseif ($word === 'headcomputer')
		{
			$this->reply('Chummer, you must be really confused... a headcomputer is an interface to connect you to computer terminals... maybe get some '.$c.'sleep.');
		}
		elseif ($word === 'hello')
		{
			$this->reply('Yeah, hello. Do you need a Hotel room? Somehow i like you chummer, so you don`t need to pay.');
			$player->giveKnowledge('words', 'Yes');
			$player->giveKnowledge('words', 'No');
		}
		elseif ($word === 'yes')
		{
			$player->giveKnowledge('words', 'Yes');
			$this->reply('Oh yes, you need a room to rest. Just do '.$c.'sleep here. You don`t need to pay.');
		}
		elseif ($word === 'no')
		{
			$player->giveKnowledge('words', 'No');
			$this->reply('Oh, allright, if you don`t need a room now. You can come back anytime.');
		}
		else
		{
			$this->reply('Hello, chummer, i hope you are allright now?');
		}
	}
	
}
?>