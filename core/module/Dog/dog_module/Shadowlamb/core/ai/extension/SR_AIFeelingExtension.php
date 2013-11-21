<?php
require_once 'SR_AIExtension.php';

abstract class SR_AIFeelingExtension extends SR_AIExtension
{
	public static function getFeelingUrgency(SR_RealNPC $npc, $field)
	{
		return 10000 - Common::clamp($npc->getInt($field) + 50000, -50000, 50000);
	}
}
