<?php
final class Dog_Nick extends GDO
{
	private $cycle = 0;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_nicks'; }
	public function getOptionsName() { return 'nick_options'; }
	public function getColumnDefines()
	{
		return array(
			'nick_id' => array(GDO::AUTO_INCREMENT),
			'nick_sid' => array(GDO::UMEDIUMINT|GDO::INDEX, GDO::NOT_NULL),
			'nick_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 127),
			'nick_pass' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 127),
			'nick_username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'Dawg', 127),
			'nick_hostname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'dog.gizmore.org', 127),
			'nick_realname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'Doggy', 127),
			'nick_options' => array(GDO::UINT, 0),
		);
	}
	
	public function getID() { return $this->getVar('nick_id'); }
	public function getSID() { return $this->getVar('nick_sid'); }
	public function getNick() { return $this->getVar('nick_name'); }
	public function getPass() { return $this->getVar('nick_pass'); }
	public function getCycle() { return $this->cycle; }
	public function setCycle($cycle) { $this->cycle = $cycle; }
	public function getName() { return $this->getNick().$this->displayCycle(); }
	public function displayCycle() { return $this->cycle > 0 ? "_{$this->cycle}" : ''; }
	public function getUsername() { return $this->getVar('nick_username'); }
	public function getHostname() { return $this->getVar('nick_hostname'); }
	public function getRealname() { return $this->getVar('nick_realname'); }
	public function isSaved() { return $this->getID() > 0; }
	public function isTemp() { return $this->getID() <= 0; }
	
	/**
	 * @return Dog_Server
	 */
	public function getServer() { return Dog::getServerByID($this->getSID()); }
	
	public function identify()
	{
		if (NULL !== ($pass = $this->getPass()))
		{
			$this->getServer()->sendPRIVMSG('NickServ', 'IDENTIFY '.$pass);
		}
	}
	
	/**
	 * Get nickname data for a server and cycle.
	 * @param Dog_Server $server
	 * @param int $cycle
	 * @return Dog_Nick
	 */
	public static function getNickFor(Dog_Server $server, $cycle=0)
	{
		$table = self::table(__CLASS__);
		$where = "nick_sid={$server->getID()}";
		if (0 === ($nicks = $table->countRows($where)))
		{
			return false;
		}
		
		if (false === ($back = $table->selectFirst('*', $where, 'nick_id ASC', NULL, self::ARRAY_O, $cycle%$nicks)))
		{
			return false;
		}
		
		$back instanceof Dog_Nick;
		
		$back->setCycle($cycle/$nicks);
		
// 		$server->setNick($back);
		
		return $back;
	}
	
	public static function getExistingNick(Dog_Server $server, $nickname)
	{
		$nick = self::escape($nickname);
		return self::table(__CLASS__)->selectFirstObject('*', "nick_sid={$server->getID()} AND nick_name='{$nick}'");
	}
}
