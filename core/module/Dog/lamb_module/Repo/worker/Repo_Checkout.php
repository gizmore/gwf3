<?php
final class Repo_Checkout extends Thread
{
	private $reply_to;

	/**
	 * @var Dog_Repo
	 */
	private $repo;
	
	public function Repo_Checkout($reply_to, Dog_Repo $repo)
	{
		$this->reply_to = $reply_to;
		$this->repo = $repo;
	}
	
	public function run()
	{
		sleep(10);
		$this->reply_to->sendPRIVMSG('YEAH!');
	}
	
}
