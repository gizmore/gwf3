<?php
/**
 * @author dalfor
 */
final class Prison_Prisoner extends SR_TalkingNPC
{
	public function getName() { return 'The prisoner'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("I turn and turn in my cell like a fly that doesn't know where to die.");
			case 'shadowrun': return $this->reply("Stone walls do not a prison make.");
			case 'cyberware': return $this->reply("Keep talking, someday you'll say something intelligent!");
			case 'magic': return $this->reply("I'd like to help you out. Which way did you come in?");
			case 'hire': return $this->reply("The prison psychiatrist asked me if I thought sex was dirty. I told him only when it's done right.");
			case 'blackmarket': return $this->reply("In prison, those things withheld from and denied to the prisoner become precisely what he wants most of all.");
			case 'bounty': return $this->reply("Your verbosity is exceeded only by your stupidity.");
			case 'alchemy': return $this->reply("Are you brain-dead?");
			case 'invite': return $this->reply("Men are not prisoners of fate, but only prisoners of their own minds.");
			case 'malois': return $this->reply("I can't talk to you right now; tell me, where will you be in ten years?");
			case 'bribe': return $this->reply("Unlike me, many of you have accepted the situation of your imprisonment and will die here like rotten cabbages.");
			case 'yes': return $this->reply("What is your malfunction, you fat barrel of monkey spunk?");
			case 'no': return $this->reply("They're not supposed to show prison films in prison. Especially ones that are about escaping.");
			case 'negotiation': return $this->reply("One of the many lessons that one learns in prison is, that things are what they are and will be what they will be.");
			case 'hello': return $this->reply("Free and civilized societies do not hold prisoners incommunicado.");
			
			# DEFAULT PHRASE PLS! ;)
			default:
				return $this->reply("NOT IMPLEMENTED");
		}
	}
}
?>