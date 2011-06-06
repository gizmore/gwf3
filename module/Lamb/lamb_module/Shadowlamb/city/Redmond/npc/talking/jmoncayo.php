<?php
final class Redmond_jmoncayo extends SR_TalkingNPC
{
	public function getName() { return 'jmoncayo'; }
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'firearms': $msg = 'The firearms skill will improve your attack for all fireweapons. Learning this is essential to use these weapons and cost 250 NY.'; break;
			case 'pistols': $msg = 'The pistols skill will improve your attack for pistols. Learning this skill cost 400 NY.'; break;
			case 'shotguns': $msg = 'The shotguns skill will improve your attack for shotguns. Learning this skill cost 650 NY.'; break;
			case 'smgs': $msg = 'The smgs skill will improve your attack for submachineguns. Learning this skill cost 900 NY.'; break;
			case 'sharpshooter': $msg = 'The sharpshooter skill will improve your chance to cause a critical hit. Learning this skill cost 1200 NY.'; break;
			case 'jmoncayo': $msg = 'jmoncayo is the founder of this school. He is a wise man from the east, when you walk 12 times the length of the east.'; break;
			default: $msg = 'We can teach you how to handle certain weapons, or show you how to hit the enemy where it hurts. Just ask me for a certain skill and i\'ll tell you the price.'; break;
		}
		$this->reply($msg);
	}
}
?>