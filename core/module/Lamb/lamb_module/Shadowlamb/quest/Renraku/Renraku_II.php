<?php
final class Quest_Renraku_II extends SR_Quest
{
	public function getQuestName() { return 'TheOffice'; }
	public function getQuestDescription() { return 'Find out what happened to you and other players during the Renraku experiments.'; }
	
	public function checkQuestB(SR_Player $player)
	{
		if ($this->isDone($player))
		{
			return;
		}
		
		$data = $this->getQuestData();
		if ( (isset($data['H1'])) && (isset($data['H2'])) && (isset($data['H3'])) )
		{
			$this->onSolve($player);
			$quest3 = SR_Quest::getQuest($player, 'Renraku_III');
			$quest3->accept($player);
		}
	}
	
	private function saveHackData($key)
	{
		$data = $this->getQuestData();
		$data[$key] = 1;
		return $this->saveQuestData($data);
	}
	
	public function onHackedOne(SR_Player $player)
	{
		$player->message('You find an interesting file: "proband.dbm" with some familiar names in it ...');
		$names = GDO::table('SR_Player')->selectColumn('sr4pl_name', "sr4pl_classname='NULL'", 'RAND()', NULL, 20, 0, '');
		$names[] = $player->getShortName();
		$names[] = 'Malois';
		array_unique($names);
		sort($names);
		$player->message('Probands: '.implode(', ', $names).'.');
		$data = $this->getQuestData();
		if (!isset($data['H1']))
		{
			$this->saveHackData('H1');
			$this->checkQuestB($player);
		}
	}
	
	public function onHackedTwo(SR_Player $player)
	{
		$player->message('You find an interesting file: "experiments.dbm" ...');
		$player->message('Experiments: TrollDNA, OrkDNA, ElveDNA, DragonDNA.');
		$player->message('That surely is evidence for Renraku playing with the DNA of the probands!');
		$data = $this->getQuestData();
		if (!isset($data['H2']))
		{
			$this->saveHackData('H2');
			$this->checkQuestB($player);
		}
	}
	
	public function onHackedThree(SR_Player $player)
	{
		$player->message('You find an interesting file: "project_leaders.dbm" ...');
		$player->message('Leaders: G. Lessley[Seattle Headquarters], R. Stolemeyer[NySoft, Delaware], J. Johnson[Amerindian Labs]');
		$player->message('You get angry while you read the file ... ');
		if (!isset($data['H3']))
		{
			$this->saveHackData('H3');
			$this->checkQuestB($player);
		}
	}
}
?>