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
			case 'Emo': case 'Emos':
				return $this->reply('Yeah i hate emos.');
			case 'Goth': case 'Goths':
				return $this->reply('Yeah i hate goths.');
			default:
				return $this->reply("Damn \X02Emos\X02 and \X02Goths\X02. ლ(╹◡╹)ლ");
		}
	}
}
?>