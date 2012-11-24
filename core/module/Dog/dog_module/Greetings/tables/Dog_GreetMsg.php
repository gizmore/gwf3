<?php
final class Dog_GreetMsg extends GDO
{
	const ENABLED = 0x01;
	 
	const MODE_CHAN = 0x10;
	const MODE_NOTICE = 0x20;
	const MODE_PRIVMSG = 0x40;
	const MODES = 0x70;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_greetmsg'; }
	public function getOptionsName() { return 'dgm_options'; }
	public function getColumnDefines()
	{
		return array(
			'dgm_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'dgm_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'dgm_options' => array(GDO::UINT, 0),
		);
	}
	
	############
	### Mode ###
	############
	public function getGreetMode()
	{
		return $this->getInt('dgm_options')&self::MODES;
	}
	
	public function setGreetMode($mode)
	{
		return $this->saveOption(self::MODES, false) && $this->saveOption($mode, true);
	}
	
	###############
	### Enabled ###
	###############
	public function setEnabled($bool=true)
	{
		return $this->saveOption(self::ENABLED, $bool);
	}
	
	public function isEnabled()
	{
		return $this->isOptionEnabled(self::ENABLED);
	}
	
	public function isDisabled()
	{
		return !$this->isOptionEnabled(self::ENABLED);
	}
	
	###############
	### Message ###
	###############
	public static function setGreetMsg(Dog_Server $server, Dog_Channel $channel, $message)
	{
		$msg = new self(array(
			'dgm_cid' => $channel->getID(),
			'dgm_msg' => $message,
			'dgm_options' => self::ENABLED|self::MODE_CHAN,
		));
		return $msg->replace();
	}
	
	/**
	 * @param Dog_Server $server
	 * @param Dog_Channel $channel
	 * @return Dog_GreetMsg
	 */
	public static function getGreetMsg(Dog_Server $server, Dog_Channel $channel)
	{
		return GDO::table(__CLASS__)->getRow($channel->getID());
	}
}
?>
