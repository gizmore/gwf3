<?php
final class Redmond_Helldrinker extends SR_TalkingNPC
{
	const TEMP_WORD = 'Redmond_Helldrinker';
	
	public function getName() { return 'The guest'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		$quest = SR_Quest::getQuest($player, 'Redmond_Punks');
		$done = $quest->isDone($player);
		$has = $quest->isInQuest($player);
		$amt = $quest->getNeededAmount();
		
		switch ($word)
		{
			case 'yes':
				switch ($player->getTemp(self::TEMP_WORD, 0))
				{
					case 0: $this->reply('Yes what?'); break;
					case 1: $this->reply('Don`t worry then, we bikers are friendly.'); break;
					case 2: $this->reply('Very well chummer. Come back when you are done.'); $quest->accept($player); break;
				}
				$player->unsetTemp(self::TEMP_WORD);
				break;
				
			case 'no':
				switch ($player->getTemp(self::TEMP_WORD, 0))
				{
					case 0: $this->reply('No what?'); break;
					case 1: $this->reply('Welcome back then, chummer. `Njoy your stay.'); break;
					case 2: $this->reply('Too bad. I would even give you a special reward.'); break;
				}
				$player->unsetTemp(self::TEMP_WORD);
				break;
				
			case 'shadowrun': case 'shadowrunner':
				switch ($player->getTemp(self::TEMP_WORD, 0))
				{
					case 0:
					case 1:
						if ($done === true)
						{
							$this->reply("Thank you again chummer. This had shown them, we don`t joke");
						}
						elseif ($has === true)
						{
							$quest->checkQuest($this, $player);
						}
						else
						{
							$this->reply("So you are a runner? Well... if you could kill {$amt} punks i would give you permission to wear our BikerJacket. What do you say?");
							$player->setTemp(self::TEMP_WORD, 2);
						}
						break;
					case 2:
						$this->reply('So? What do you say? I will also give you 150 nuyen.');
						break;
				}
				break;
				
			case 'punk': case 'punks':
				$this->reply("Screw those punks! I wish we could hire a {$b}shadowrun{$b}ner for revenge.");
				break;
				
			case 'biker': case 'bikers':
				
				switch ($player->getTemp(self::TEMP_WORD, 0))
				{
					case 0:
						$this->reply('Haha, chummer, it`s your first time in this pub?');
						$player->setTemp(self::TEMP_WORD, 1);
						break;
					case 1:
						$this->reply('Well, as you can see i am one.');
						$player->unsetTemp(self::TEMP_WORD);
						break;
					case 2:
						$this->reply('Will you punish the punks for me?');
						break;
				}
				break;
				
			case 'hello':
			default:
				if ($has === true) {
					$quest->checkQuest($this, $player);
				} else {
					$this->reply('Hello chummer, drink a beer');
				}
				break;
		}
	}	
}
?>