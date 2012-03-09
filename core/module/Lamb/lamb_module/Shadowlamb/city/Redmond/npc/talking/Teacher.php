<?php
final class Redmond_Teacher extends SR_TalkingNPC
{
	const TEMP_PISSED = 'Redmond_Teacher_pissed';
	
	public function getName() { return 'Filöen'; }
	public function getNPCModifiers() { return array('race' => 'elve'); }
	public function getNPCQuests(SR_Player $player) { return array('Redmond_Temple'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{ 
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'learn':
			case "magic":
			case "hummingbird":
			case "goliath":
			case "turtle":
			case "hawkeye":
			case 'firebolt':
			case 'fireball':
			case 'gizmore':
			case 'quangntenemy':
			case 'negotiation':
				return $this->rply($word);
			case 'shadowrun':
				$this->rply($word);
				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
				return true;
			case 'blackmarket':
				$this->rply($word);
				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
				return true;
			default:
				$this->rply('hello');
				$player->giveKnowledge('words', 'Magic');
				return true;
		}
		
// 		$c = Shadowrun4::SR_SHORTCUT;
// 		$b = chr(2);
// 		switch ($word)
// 		{
// 			case 'learn': $msg = "In a place like this you can use {$c}learn and {$c}courses."; break;
// 			case "magic": $msg = 'I will teach you the magic powers for some Nuyen.'; break;
// 			case "hummingbird": $msg = 'The hummingbird spell will raise your quickness.'; break;
// 			case "goliath": $msg = 'The goliath spell will raise your strength.'; break;
// 			case "turtle": $msg = 'The turtle spell will raise your armor.'; break;
// 			case "hawkeye": $msg = 'The hawkeye spell will raise your attack for fireweapons.'; break;
// 			case 'firebolt': $msg = 'The firebolt spell will do damage to a single target.'; break;
// 			case 'fireball': $msg = 'The fireball spell will do good damage to multiple targets.'; break;
// 			case 'gizmore': $msg = 'The last time I saw gizmore he fled from the Punks. Rumors say he is with the brothers in Amerindian now.'; break;
// 			case 'quangntenemy': $msg = 'Master quangntenemy is having a sheep bbq.'; break;
// 			case 'negotiation': $msg = 'If you think you can price a skill, you should rather ask the bird or the fish.'; break;
// 			case 'shadowrun':
// 				$msg = 'Please leave us now, you already learned everything you could need.';
// 				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
// 				break;
// 			case 'blackmarket':
// 				$player->setTemp(self::TEMP_PISSED, $player->getTemp(self::TEMP_PISSED, 0)+1);
// 				$msg = 'And now think about this, who needs a weapon when you can crush your enemy with your bare mind?'; 
// 				break;
// 			default:
// 				$this->reply("Hello my friend, do you seek the powers of {$b}magic{$b}?");
// 				$player->giveKnowledge('words', 'Magic');
// 				return;
// 		}
		
// 		$this->reply($msg);
	}
}
?>
