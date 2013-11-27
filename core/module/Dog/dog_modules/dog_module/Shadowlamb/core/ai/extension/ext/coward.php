<?php
class SR_AI_coward extends SR_AIExtension
{
	public function aic_idle(SR_RealNPC $npc)
	{
		$fear = SR_Feelings::getFear($npc);
		if ($fear > rand(0.4, 0.6))
		{
			$ncp->ai_add_goal(new SR_AIGoal('flee', $fear));
		}
	}
}