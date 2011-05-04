<?php
abstract class Lamb_Module
{
	private $name;
	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	public function replaceHelp($text) { return str_replace('%TRIGGER%', LAMB_TRIGGER, $text); }

	# --- Override Below here --- #
	
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server) {}
	public function onInstall() {}
	public function onTimer() {}
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onCTPC(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onJoin(Lamb_Server $server, Lamb_User $user, $from, $origin) {}
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message) {}
	public function onEvent(Lamb $bot, Lamb_Server $server, $event, $from, $args) {}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge) { return array(); }
	public function getHelp($trigger) { return ''; }
}
?>