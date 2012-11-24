<?php
final class Dog_ForumAbbo
{
	private $forumid;
	private $groupids;
	private $exclusive;
	
	public function __construct($string)
	{
		$a = explode(':', $string);
		$this->forumid = $a[0];
		$this->groupids = $a[1];
		$this->exclusive = isset($a[2]) ? $a[2] : '';
	}
	
	public function toString() { return "{$this->forumid}:{$this->groupids}:{$this->exclusive}"; }
	public function getForumID() { return $this->forumid; }
	
	public static function containsAbbo(array $abbos, Dog_ForumAbbo $abbo)
	{
		foreach ($abbos as $abb)
		{
			$abb instanceof Dog_ForumAbbo;
			if ($abb->getForumID() === $abbo->getForumID())
			{
				return true;
			}
		}
		return false;
	}
	
	public static function implodeAbbos(array $abbos)
	{
		$strings = array();
		foreach ($abbos as $abbo)
		{
			$abbo instanceof Dog_ForumAbbo;
			$strings[] = $abbo->toString();
		}
		
		return implode(';', $strings);
	}
	
	public static function explodeAbbos($abbostring)
	{
		$back = array();
		if ($abbostring !== '')
		{
			foreach (explode(';', $abbostring) as $abbostr)
			{
				$back[] = new self($abbostr);
			}
		}
		return $back;
	}
	
	public function matches(Dog_Forum $board, Dog_ForumEntry $entry)
	{
		if ($this->forumid !== $board->getID())
		{
			return false;
		}
		
		$bid = $entry->getGroupID();
		if (strpos(','.$this->exclusive.',', ','.$bid.',') !== false)
		{
			return false;
		}
		elseif ($this->groupids == 0)
		{
			return true;
		}
		else
		{
			return strpos(','.$this->groupids.',', ','.$bid.',') !== false;		
		}
	}
}
?>
