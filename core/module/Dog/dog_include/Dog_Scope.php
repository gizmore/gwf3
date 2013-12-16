<?php
final class Dog_Scope
{
	/**
	 * @var Dog_User
	 */
	private $user;
	
	/**
	 * @var Dog_Channel
	 */
	private $channel;
	
	/**
	 * @var Dog_Server
	 */
	private $server;

	public function __construct($user, $chan, Dog_Server $serv)
	{
		$this->user = $user;
		$this->channel = $chan;
		$this->server = $serv;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function getChannel()
	{
		return $this->channel;
	}
	
	public function getServer()
	{
		return $this->server;
	}
	
	public function __toString()
	{
		$uid = $this->user ? $this->user->getID() : '?';
		$cid = $this->channel ? $this->channel->getID() : '?';
		$sid = $this->server ? $this->server->getID() : '?';
		return sprintf('SCOPE(U:%s,C:%s,S:%s)', $uid, $cid, $sid);
	}
	
}
