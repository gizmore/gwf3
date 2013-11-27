<?php
abstract class SR_RealNPCBase extends SR_TalkingNPC
{
	private $npc_can = null;
	
	public function getUser() { return SR_DummyPlayer::getDogUser(); }

	public function ai_act($message)
	{
		echo "AI_ACT: $message\n";
		return Shadowcmd::onTrigger($this, $message);
	}
	
	public function ai_giveny(SR_Player $player, $ny)
	{
		return $this->ai_act("giveny {$player->getName()} $ny");
	}
	
	public function ai_respond($chatcmd, $key, $args=null)
	{
		if (Shadowlang::hasLangRealNPC($this, $key))
		{
			$message = Shadowlang::langNPC($this, $this->getChatPartner(), $key, $args);
		}
		else
		{
			$message = $key;
		}
		return $this->ai_act($chatcmd.' '.$message);
		
	}
	
	public function ai_say($key, $args=null)
	{
		return $this->ai_respond('say', $key, $args);
		return $this->ai_say_message($message);
	}
	
	public function ai_reply($message)
	{
		$player = $this->getChatPartner();
		return $this->ai_act('w '.$player->getName().' '.$message);
	}

	public function ai_say_message($message)
	{
		return $this->ai_act('say '.$message);
	}
	
	public function ai_use(SR_Item $item)
	{
		$this->ai_act('use '.$item->getItemName());
	}
	
	private function ai_idle($delay=15)
	{
		Dog_Timer::addTimer(array($this, 'on_idled'), array(), $delay);
	}
	
	public function ai_can($command, $flush=false)
	{
		if ($flush || $this->npc_can === null)
		{
			$this->npc_can = Shadowcmd::getCurrentCommands($this, true, false, false, false, false, false);
		}
		return in_array($command, $this->npc_can, true);
	}
}
