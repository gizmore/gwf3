<?php
/**
 * An Emo
 * @author gizmore
 */
final class Delaware_MCGuest2 extends SR_TalkingNPC
{
	public function getName() { return 'Amanda'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_MCGuest21','Delaware_MCGuest22'); }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		
		switch ($word)
		{
			case 'goth': case 'goths':
				return $this->reply('Yeah I hate goths.');
			case 'hipster': case 'hipsters':
				return $this->reply('Yeah I hate hipsters.');
			default:
				$this->reply("Damn \X02Hipsters\X02 and \X02Goth\X02. -.-");
		}
	}
}
?>
