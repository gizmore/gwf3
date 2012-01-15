<?php
/**
 * A hipster
 * @author gizmore
 */
final class Delaware_MCGuest3 extends SR_TalkingNPC
{
	public function getName() { return 'Lisa'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_MCGuest31','Delaware_MCGuest32'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'emo': case 'emos':
				return $this->reply('Yeah I hate emos.');
			case 'goth': case 'goths':
				return $this->reply('Yeah I hate goths.');
			default:
				return $this->reply("Damn \X02Emos\X02 and \X02Goths\X02. ლ(╹◡╹)ლ");
		}
	}
}
?>
