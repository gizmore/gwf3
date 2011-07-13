<?php
/**
 * A goth.
 * @author gizmore
 */
final class Delaware_MCGuest1 extends SR_TalkingNPC
{
	public function getName() { return 'Miriam'; }
	public function getNPCQuests(SR_Player $player) { return array('Delaware_MCGuest11','Delaware_MCGuest12'); }
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
			case 'Hipster': case 'Hipsters':
				return $this->reply('Yeah i hate hipsters.');
			default:
				return $this->reply("Damn \X02Hipsters\X02 and \X02Emos\X02. Pfff.");
		}
	}
}
?>