<?php
final class Dog_ForumEntry
{
	private $threadid;
	private $lastdate;
	private $gid;
	private $url;
	private $username;
	private $title;
	private $boardid;
	
	public function __construct(array $data)
	{
		$this->threadid = $data[0];
		$this->lastdate = $data[1];
		$this->gid = $data[2];
		$this->url = $data[3];
		$this->username = $data[4];
		$this->title = $data[5];
		$this->boardid = 0;
		if (strpos($this->url, 'http') !== 0)
		{
			$this->url = 'http://'.$this->url;
		}
	}
	
	public function getThreadID() { return $this->threadid; }
	public function getLastDate() { return $this->lastdate; }
	public function getGroupID() { return $this->gid; }
	public function getURL() { return $this->url; }
	public function getUserName() { return $this->username; }
	public function getTitle() { return $this->title; }
	public function getBoardID() { return $this->boardid; }
	
	public function display()
	{
		return "";
	}
}
?>
