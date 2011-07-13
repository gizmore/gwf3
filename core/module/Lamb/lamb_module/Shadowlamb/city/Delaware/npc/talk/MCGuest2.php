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
			case 'Goth': case 'Goths':
				return $this->reply('Yeah i hate goths.');
			case 'Hipster': case 'Hipsters':
				return $this->reply('Yeah i hate hipsters.');
			default:
				$this->reply("Damn \X02Hipsters\X02 and \X02Goth\X02. -.-");
		}
	}
}
?>