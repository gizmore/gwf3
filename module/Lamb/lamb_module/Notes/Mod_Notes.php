<?php
require_once 'Lamb_Note.php';

final class LambModule_Notes extends Lamb_Module
{
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server) {}
	public function onInstall() { GDO::table('Lamb_Note')->createTable(false); }
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onTimer() {}
	public function onEvent(Lamb $bot, Lamb_Server $server, $event, $from, $args) {}
	public function onJoin(Lamb_Server $server, Lamb_User $user, Lamb_Channel $channel) { $this->onJoinTell($server, $user); }
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('note');
			default: return array();
		}
	}
	
	public function getHelp($trigger)
	{
		$help = array(
			'note' => 'The Notes Module. Leave messages for users and show them when they join the next time. Try %TRIGGER%note help.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	public function onJoinTell(Lamb_Server $server, Lamb_User $user)
	{
		$userid = $user->getID();
		if (0 == ($count = Lamb_Note::countUnread($userid))) {
			return;
		}
		$username = $user->getName();
		
		if ($count == 1)
		{
			$server->sendPrivmsg($username, "Someone left you a note:");
		}
		else
		{
			$server->sendPrivmsg($username, "You got multiple notes:");
		}
		
		for ($i = 0; $i < $count; $i++)
		{
			$server->sendPrivmsg($username, $this->readNext($server, $user));
		}
	}
	
	public function readNext(Lamb_Server $server, Lamb_User $user)
	{
		$userid = $user->getID();
		if (false === ($note = Lamb_Note::popNote($userid))) {
			return "Error: No unread note to pop.";
		}
		return $note->displayNote($server, $userid);
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		$out = '';
		$command = Common::substrUntil($message, ' ', $message);
		$message = Common::substrFrom($message, ' ', '');
		switch ($command)
		{
			case 'help': $out = $this->onHelp($server, $user, $from, $origin, $message); break;
			case 'send'; $out = $this->onSend($server, $user, $from, $origin, $message); break;
			case 'read'; $out = $this->onRead($server, $user, $from, $origin, $message); break;
			case 'delete'; $out = $this->onDelete($server, $user, $from, $origin, $message); break;
			case 'search'; $out = $this->onSearch($server, $user, $from, $origin, $message); break;
			default: return;
		}
		$server->reply($origin, $out);
	}
	
	public function onHelp(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$c = LAMB_TRIGGER;
		switch ($message)
		{
			case 'help': return "Usage: {$c}note help [<cmd>]. Print help for the note command(s).";
			case 'send': return "Usage: {$c}note send <username> <the message ... >. Store a message for a user on this server.";
			case 'read': return "Usage: {$c}note read [id|next]. Display undeleteted message ids or a single message via id or the next unread.";
			case 'delete': return "Usage: {$c}note delete [id]. Delete one message.";
			case 'search': return "Usage: {$c}note search <term1> [term2] ... Search all your messages.";
			default: return "Usage: {$c}note [help|send|read|delete|search] [<args>]. Try {$c}note help <cmd>.";
		}
	}
	
	public function onSend(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		$c = LAMB_TRIGGER;
		if (false === ($nickname = Common::substrUntil($message, ' ', false))) {
			return "You have to leave a message. Try {$c}note send username message.";
		}
		$message = Common::substrFrom($message, ' ');
		
		if (false === ($user_to = Lamb_User::getUser($server, $nickname))) {
			return "The user $nickname seems unknown on this server.";
		}
		
		if (false === Lamb_Note::isWithinLimits($user->getID())) {
			return sprintf("You have exceeded your limit of %s messages within %s.", Lamb_Note::LIMIT_AMT, GWF_Time::humanDuration(Lamb_Note::LIMIT_TIME));
		}
		
		if (false !== $server->getUserByNickAndChannel($nickname, $origin)) {
			return "$nickname is in this channel ... maybe leave him/her a privmsg.";
		}
		
		if (false === Lamb_Note::insertNote($user, $user_to, $message)) {
			return "Database error in insertNote().";
		}
		
		return "I have left a message for $nickname.";
	}
	
	public function onRead(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		return 'STUB FUNCTION';
	}
	
	public function onDelete(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		return 'STUB FUNCTION';
	}
	
	public function onSearch(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		return 'STUB FUNCTION';
	}
	
}
?>