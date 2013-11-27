<?php
final class Seattle_GBarkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'hello':
				return $this->rply('hello');
// 				return $this->reply('Welcome chummer. How are things?');
			default:
				return $this->rply('default');
// 				return $this->reply('I am very busy this evening!');
		}
	}
}
?>