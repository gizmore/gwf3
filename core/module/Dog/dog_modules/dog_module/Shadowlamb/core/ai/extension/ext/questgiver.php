<?php
require_once 'chatter.php';
class SR_AI_questgiver extends SR_AI_chatter
{
	### COMMON SENSE OVERRIDE ME ###
	public function ai_msg_5274(array $args)
	{
		$player = SR_AIExtension::getPlayer($args[1]);
		$item = SR_AIExtension::getItem($args[0]);
		$this->ai_say_message('No thanks.');
		$this->ai_give($player, $item);
	}
	
}