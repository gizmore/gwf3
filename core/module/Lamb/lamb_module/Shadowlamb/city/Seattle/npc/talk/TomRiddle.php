<?php
final class Seattle_TomRiddle extends SR_TalkingNPC
{
	public function getName() { return 'Tom'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
//		if ($this->onNPCQuestTalk($player, $word, $args))
//		{
//			return true;
//		}
		switch ($word)
		{
			case 'malois':
				return $this->reply('He is one of them ... one of them!'); 
			case 'crypto':
				return $this->onSolveCrypto($player, $word, $args);
			case 'hello':
				return $this->reply("I cannot get my head around this \X02crypto\X02.");
			default:
				return $this->reply('Aaaaargh');
		}
	}
	
	public function onSolveCrypto(SR_Player $player, $word, array $args)
	{
		if (count($args) !== 1)
		{
			$this->reply('I wrote down some message and cannot decipher it myself again -.- Please tell me the password with #talk crypto <password>.');
			$this->reply('eht swordsap ot ym fase si ont xenophi tub gimmuhnbrid.');
			$cry = $player->get('crypto');
			if ($cry >= 1)
			{
				$player->message('With your awesome crypto skills you can easily read the message: "the password to my safe is not phoenix but hummingbird."');
			}
			elseif ($cry >= 0)
			{
				$player->message('With your awesome crypto skills you immediately recognize it\'s a simple anagram for each word.');
			}
			return true;
		}
		$answer = $args[0];
		
		switch($answer)
		{
			case 'hummingbird':
				return $this->onQuestSolved($player, $word, $args);
			case 'phoenix':
				return $this->reply('Yeah this rings a bell ... Let me try ... Darn wrong!');
			default:
				return $this->reply('Sweet let me try it on my safe ... Darn wrong.');
		}
	}
	
	public function onQuestSolved(SR_Player $player, $word, array $args)
	{
		$val = SR_PlayerVar::getVal($player, 'TOMRIDDLE', '0');
		if ($val === '1')
		{
			return $this->reply('Thank you. I will never forget the password again.');
		}
		
		$this->reply('Let me try it ... Oh gosh ... It works! Thank you so much ... Take this:');
		
		SR_PlayerVar::setVal($player, 'TOMRIDDLE', '1');
		$nuyen = 300;
		$player->giveNuyen($nuyen);
		$player->message(sprintf('Tom hands you %s.', Shadowfunc::displayNuyen($nuyen)));
		
		if ($player->getBase('crypto') < 0)
		{
			$player->message('You have learned a new knowledge: crypto.');
			$player->saveBase('crypto', 0);
			$player->modify();
		}
		return true;
	}
	
}
?>