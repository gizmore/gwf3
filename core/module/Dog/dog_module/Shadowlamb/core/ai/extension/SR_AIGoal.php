<?php
class SR_AIGoal
{
	private $args = null; # Goal args
	private $command = 'say i have a stub command in SR_AIGoal!';
	private $urgency = 500; # 0-10000 percent
	
	public static function resetGoals(SR_RealNPC $npc)
	{
		$npc->goals = array();
	}
	
	public static function addGoals(SR_RealNPC $npc, $key, array $goals)
	{
		foreach ($goals as $goal)
		{
			 self::addGoal($npc, $key, $goal);
		}
	}
	
	public static function addGoal(SR_RealNPC $npc, $key, NPC_Goal $goal)
	{
		if (!isset($npc->goals))
		{
			$npc->goals = array();
		}
		if (!isset($npc->goals[$key]))
		{
			$npc->goals[$key] = array();
		}
		$npc->goals[$key][] = $goal;
	}
	
	public static function checkGoals(SR_RealNPC $npc)
	{
		if (isset($npc->goals))
		{
			foreach ($npc->goals as $goal)
			{
				$goal->check($npc);
			}
		}
	}
	
	public static function sort_urgency_asc(SR_AIGoal $a, SR_AIGoal $b)
	{
		return $a->urgency - $b->urgency;
	}
	
	/**
	 * AI populated the goals.
	 * @param SR_RealNPC $npc
	 */
	public static function newGoal(SR_RealNPC $npc)
	{
		uasort($npc->goals, array(__CLASS__, 'sort_urgency_asc'));
		
		while ($goal = array_shift($npc->goals))
		{
			$goal instanceof SR_AIGoal;
			if (!$goal->execute($npc))
			{
			}
			elseif ($goal->isInstant())
			{
			}
			else
			{
				break;
			}
		}
	}
	
	public function __construct($command, $urgency=5000, $args=null)
	{
		$this->command = $command;
		$this->urgency = $urgency;
		$this->args = $args;
	}
	
	public function check(SR_RealNPC $npc)
	{
		return true;
	}
	
	public function execute(SR_RealNPC $npc)
	{
		return Shadowcmd::onTrigger($npc, $this->command);
	}
}
