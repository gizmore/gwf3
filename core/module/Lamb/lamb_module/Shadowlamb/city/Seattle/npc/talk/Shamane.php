<?php
final class Seattle_Shamane extends SR_TalkingNPC
{
	const TEMP_PISSED = 'Seattle_Shamane_pissed';
	
	public function getName() { return 'Namir'; }
	public function getNPCModifiers() { return array('race' => 'human'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{ 
		$c = Shadowrun4::SR_SHORTCUT;
		$b = chr(2);
		switch ($word)
		{
			case 'malois': return $this->reply('I don\'t know him, i think.'); 
			case 'blow': $msg = 'The blow spell will increase an enemies target distance.'; break;
			case 'learn': $msg = "In a place like this you can use {$c}learn and {$c}courses. You may ask me about the courses you can learn, too."; break;
			case 'berzerk': $msg = 'The berzerk spell will increase a friendly target\'s min and max damage.'; break;
			case 'freeze': $msg = 'The freeze spell will make an enemy target busy.'; break;
			case 'heal': $msg = 'The heal spell can heal a friendly target.'; break;
			case 'flu': $msg = 'The flu spell will poison an enemy target.'; break;
			case 'poison_dart': $msg = 'The poisan dart spell will poison an enemy target and does some instant damage.'; break;
			case 'fireball': $msg = 'The fireball spell will do good damage to multiple targets.'; break;
			case 'gizmore': $msg = 'The last time I saw gizmore he fled from the Punks. Rumors say he is with the brothers in Amerindian now.'; break;
			case 'quangntenemy': $msg = 'Master quangntenemy is having a sheep bbq.'; break;
			case 'negotiation': $msg = 'If you think you can price a skill, you should rather ask the bird or the fish.'; break;
			case 'magic': $msg = 'The magic attribute will increase your MP and allow you to learn spells. You can learn magic in the Redmond Temple.'; break;
			case 'shadowrun':
				$msg = 'Please leave us now, you already learned everything you could need.';
				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
				break;
			case 'blackmarket':
				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
				$msg = 'And now think about this, who needs a weapon when you can crush your enemy with your bare mind?'; 
				break;
			default:
				$this->reply("Hello my friend, do you seek the powers of {$b}magic{$b}?");
				$player->giveKnowledge('words', 'Magic');
				return;
		}
		$this->reply($msg);
	}
}
?>
 