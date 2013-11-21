<?php
class SR_AI_common_sense extends SR_AIExtension
{
	public static function ai_init(SR_RealNPC $npc)
	{
		$npc->ai_say_message('I´m alive! - Shark rule!');
	}
}

