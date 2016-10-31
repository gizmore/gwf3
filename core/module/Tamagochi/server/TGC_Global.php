<?php
final class TGC_Global
{
	private $players;
	
	public function __construct()
	{
		$this->players = array();
	}
	
	public function init()
	{
		GWF_Log::logMessage('TGC_Global::init()');
	}
	
	
	public function getPlayer($playername)
	{
		return isset($this->players[$username]) ? $this->players[$username] : false;
	}
	
	public function getOrLoadUser($username)
	{
		if (false !== ($user = $this->getUser($username))) {
			return $user;
		}
		return $this->loadUser($username);
	}
	

	###############
	### Private ###
	###############
	private function loadUser($username)
	{
		$eusername = GDO::escapeS($username);
		if ($user = GDO::table('TGC_Player')->selectFirstObject('*', "p_name='$eusername'")) {
			$this->users[$username] = $user;
			$user->cacheAvatars();
			return $user;
		}
		return false;
	}
	
}
