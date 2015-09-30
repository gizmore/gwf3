<?php
require_once 'Shadowrun4.php';

final class DOGMOD_Shadowlamb extends Dog_Module
{
	public function getOptions()
	{
		return array(
			'triggers' => 'c,f,s,"#,"', # channel founder string
			'servtrig' => 's,x,s,"#,"', # server owner string
		);
	}
	
	private static $INSTANCE;
	public static function instance() { return self::$INSTANCE; }
	public function __construct()
	{
		self::$INSTANCE = $this;
	}
	
	################
	### Triggers ###
	################
	public function onInstall($flush_tables)
	{
		require_once 'SR_Install.php';
		SR_Install::onInstall($flush_tables);
		Shadowrun4::init();
		SR_Install::onCreateLangFiles();
		
// 		self::convert5();
	}
	private static function convert5()
	{
		$players = GDO::table('SR_Player');
		$items = GDO::table('SR_Item');
		$result = $players->select('*');
		while (false !== ($player = $players->fetch($result, GDO::ARRAY_O)))
		{
// 			foreach (explode(',', $player->getVar('sr4pl_inventory')) as $itemid)
// 			{
// 				if ($itemid < 1) continue;
// 				$now = microtime(true);
// 				if (!$items->update("sr4it_position='inventory', sr4it_microtime=$now", "sr4it_id=$itemid"))
// 				{
// 					die('oops1');
// 				}
// 			}
// 			foreach (explode(',', $player->getVar('sr4pl_bank')) as $itemid)
// 			{
// 				if ($itemid < 1) continue;
// 				$now = microtime(true);
// 				if (!$items->update("sr4it_position='bank', sr4it_microtime=$now, sr4it_uid={$player->getID()}", "sr4it_id=$itemid AND sr4it_uid=0"))
// 				{
// 					die('oops2');
// 				}
// 			}
// 			foreach (explode(',', $player->getVar('sr4pl_mount_inv')) as $itemid)
// 			{
// 				if ($itemid < 1) continue;
// 				$now = microtime(true);
// 				if (!$items->update("sr4it_position='mount_inv', sr4it_microtime=$now", "sr4it_id=$itemid"))
// 				{
// 					die('oops3');
// 				}
// 			}
// 			foreach (explode(',', $player->getVar('sr4pl_cyberware')) as $itemid)
// 			{
// 				if ($itemid < 1) continue;
// 				$now = microtime(true);
// 				if (!$items->update("sr4it_position='cyberware', sr4it_microtime=$now", "sr4it_id=$itemid"))
// 				{
// 					die('oops4');
// 				}
// 			}
			
// 			foreach (SR_Player::$EQUIPMENT as $position)
// 			{
// 				$itemid = $player->getVar('sr4pl_'.$position);
// 				if ($itemid < 1) continue;
// 				$now = microtime(true);
// 				$items->update("sr4it_position='$position', sr4it_microtime=$now", "sr4it_id=$itemid");
// 			}
		}
		die('HA!');
	}
	
	public function onInitTimers()
	{
		Shadowrun4::initTimers();
	}
	
	public function onLoadLanguage()
	{
		parent::onLoadLanguage();
// 		Shadowcmd::onLoadLanguage();
// 		Shadowlang::onLoadLanguage();
	}
	
	public function event_QUIT()
	{
		if (false !== ($user = Dog::getUser()))
		{
			Shadowrun4::onQuit(Dog::getServer(), Dog::getUser(), Dog::argv(0));
		}
	}
	
	public function event_privmsg()
	{
		$message = $this->msg();
		if (strlen($message) === 0)
		{
			return;
		}
		
		# Triggered in channel?
		if (false !== ($channel = Dog::getChannel()))
		{
			if (strpos($this->getConfig('triggers', 'c'), $message[0]) !== false)
			{
				Shadowrun4::onTrigger(Dog::getUser(), substr($message, 1));
			}
		}

		# Triggered in private?
		elseif (strpos($this->getConfig('servtrig', 's'), $message[0]) !== false)
		{
			Shadowrun4::onTrigger(Dog::getUser(), substr($message, 1));
		}
	}
	
	################
	### Commands ###
	################
	public function on_sr_Pb()
	{
		Shadowrun4::onTrigger(Dog::getUser(), $this->msgarg());
	}
}
?>
