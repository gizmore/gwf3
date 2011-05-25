<?php
final class Lamb_GreetMsg extends GDO
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
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_greetmsg'; }
	public function getOptionsName() { return 'lgm_options'; }
	public function getColumnDefines()
	{
		return array(
			'lgm_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lgm_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'lgm_options' => array(GDO::UINT, 0),
		);
	}
	
	############
	### Mode ###
	############
	public function getGreetMode()
	{
		return $this->getInt('lgm_options')&self::MODES;
	}
	
	public function setGreetMode($mode)
	{
		return
			$this->saveOption(self::MODES, false)
			&& $this->saveOption($mode, true);
	}
	
	###############
	### Enabled ###
	###############
	public function setEnabled($bool=true)
	{
		$this->saveOption(self::ENABLED, $bool);
	}
	
	public function isEnabled()
	{
		return $this->isOptionEnabled(self::ENABLED);
	}
	
	###############
	### Message ###
	###############
	public static function setGreetMsg(Lamb_Server $server, Lamb_Channel $channel, $message)
	{
		$msg = new self(array(
			'lgm_cid' => $channel->getID(),
			'lgm_msg' => $message,
			'lgm_options' => self::ENABLED|self::MODE_CHAN,
		));
		if (false === ($msg->replace())) {
			return false;
		}
		return true;
	}
	
	public static function getGreetMsg(Lamb_Server $server, Lamb_Channel $channel)
	{
		return GDO::table(__CLASS__)->getRow($channel->getID());
	}
	
	
}
?>