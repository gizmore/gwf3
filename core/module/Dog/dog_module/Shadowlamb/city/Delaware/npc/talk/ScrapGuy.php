<?php
final class Delaware_ScrapGuy extends SR_TalkingNPC
{
	public function getName() { return 'Rudolf'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'fight': case 'challenge':
				return $this->rply('fight');
// 				return $this->reply('Yeah, issue #challenge here and gain money and reputation!');
			case 'hello':
				return $this->rply('hello');
// 				return $this->reply("Ello there! Interested in a \X02fight\X02?");
			default:
				return $this->rply('default', array($word));
// 				return $this->reply("I don't know anything about $word.");
		}
	}
}
?>
