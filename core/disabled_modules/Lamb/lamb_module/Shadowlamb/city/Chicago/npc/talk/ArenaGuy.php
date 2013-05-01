<?php
final class Chicago_ArenaGuy extends SR_TalkingNPC
{
	public function getName() { return 'Klaus'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'fight': case 'challenge':
				return $this->reply('Yeah, issue #challenge here and gain money and reputation!');
			case 'hello':
				return $this->reply("Ello there! Interested in a \X02fight\X02?");
			default:
				return $this->reply("I don't know anything about $word.");
		}
	}
}
?>