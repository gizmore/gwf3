<?php
require_once 'Shadowrun4.php';

final class LambModule_Shadowlamb extends Lamb_Module
{
//	const WITH_INTERLINK = 0;
	
	# Hardcoded shadowlamb channels for shortcuts
	public static $INCLUDE_CHANS = array('#sr', '#shadowlamb', '#Nasu_gaming');

	private static $INSTANCE;
	public static function instance() { return self::$INSTANCE; }
	public function __construct()
	{
		parent::__construct();
		self::$INSTANCE = $this;
	}
	
	################
	### Triggers ###
	################
	public function onInstall()
	{
		require_once 'SR_Install.php';
		SR_Install::onInstall(false);
		Shadowrun4::init();
		SR_Install::onCreateLangFiles();
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
	
	public function onEvent(Lamb $bot, Lamb_Server $server, $event, $from, $args)
	{
		
		if ($event === 'QUIT')
		{
			if (false === ($user = $server->getUserFromOrigin($from)))
			{
				echo "CANNOT GET USER in onEvent quit!\n";
				return;
			}
			Shadowrun4::onQuit($server, $user, $args);
		}
	}
	
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ($user->isBot())
		{
			return;
		}
		# NO SPAM with it in other channels
		if ( ($server->getBotsNickname() !== $origin) && (!in_array($origin, self::$INCLUDE_CHANS, true)) )
		{
			return;
		}
		
		# Trigger?
		if (Common::startsWith($message, Shadowrun4::SR_SHORTCUT))
		{
			return Shadowrun4::onTrigger($server, $user, $origin, substr($message, 1));
		}
		
		# Location glob interlink (deprecated by #say)
//		if ($origin[0] === '#' && self::WITH_INTERLINK)
//		{
//			if (false !== ($player = Shadowrun4::getPlayerByUID($user->getID())))
//			{
//				if ($player->isCreated())
//				{
//					if ($player->getParty()->getAction() === 'inside')
//					{
//						if (false === ($channel = $server->getChannel('#shadowlamb'))) {
//							if (false === ($channel = $server->getChannel('#sr'))) {
//								return;
//							}
//						}
//						Shadowshout::onLocationGlobalMessage($server, $player, $channel, $message);
//					}
//				}
//			}
//		}
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge, $showHidden=true)
	{
		switch ($priviledge)
		{
			case 'public': return array('sr');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'sr' => '%CMD% <shadowrun command here>. Try '.Shadowrun4::SR_SHORTCUT.'help.',
		);
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $channel_name, $command, $msg)
	{
		Shadowrun4::onTrigger($server, $user, $channel_name, $msg);
	}
}
?>