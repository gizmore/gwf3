<?php
final class Dog_Plugin
{
	##############
	### STATIC ###
	##############
	/**
	 * Current plugin
	 * @return Dog_Plugin
	 */
	public static function getPlugin() { return self::$PLUGIN[0]; }
	private static $PLUGIN = array();
	public static function getPlugDir() { return DOG_PATH.'dog_plugins/dog_plugin'; }
	public static function getPlugDirDev() { return DOG_PATH.'dog_plugins/dog_plugin_dev'; }
	public static function getPlugDirSecret() { return DOG_PATH.'dog_plugins/dog_plugin_secret'; }
	public static function getPlugDirUser() { return DOG_PATH.'dog_plugins/dog_plugin_user_'.Dog::getUnixUsername(); }
	public static function sort_power_descending(Dog_Plugin $a, Dog_Plugin $b) { return $a->getPower() - $b->getPower(); }
	
	/**
	 * Get a plugin by name.
	 * @param string $name
	 * @return Dog_Plugin
	 */
	public static function getPlug($name)
	{
		self::getPlugins($name);
		return count(self::$PLUGIN) > 0 ? self::$PLUGIN[0] : false;
	}
	
	/**
	 * Get plugin by name and check permissions.
	 * @param Dog_Server $serv
	 * @param Dog_Channel $chan
	 * @param Dog_User $user
	 * @param string $name
	 * @return Dog_Plugin
	 */
	public static function getPlugWithPerms($serv, $chan, $user, $name)
	{
		$back = array();
		self::getPlugins($name);
		foreach (self::$PLUGIN as $plugin)
		{
			$plugin instanceof Dog_Plugin;
			if ($plugin->hasPermission($serv, $chan, $user))
			{
				$back[] = $plugin;
			}
		}
		return count($back) > 0 ? $back[0] : false;
	}
	
	public static function getPlugins($name)
	{
		self::$PLUGIN = array();
		GWF_File::filewalker(self::getPlugDir(), array(__CLASS__, 'getPlugRec'), false, true, $name);
		if (GWF3::getConfig('env') === 'dev')
		{
			GWF_File::filewalker(self::getPlugDirDev(), array(__CLASS__, 'getPlugRec'), false, true, $name);
		}
		GWF_File::filewalker(self::getPlugDirUser(), array(__CLASS__, 'getPlugRec'), false, true, $name);
		GWF_File::filewalker(self::getPlugDirSecret(), array(__CLASS__, 'getPlugRec'), false, true, $name);
		usort(self::$PLUGIN, array(__CLASS__, 'sort_power_descending'));
		return self::$PLUGIN;
	}
	
	/**
	 * Filewalker for getPlugins
	 * @see GWF_File::filewalker
	 */
	public static function getPlugRec($entry, $fullpath, $name)
	{
		if (  ($entry[0] !== '_') # disabled
			&&(Common::substrUntil($entry, '_', NULL, true) === $name) )
		{
			self::$PLUGIN[] = new Dog_Plugin($name, $fullpath, substr(Common::substrFrom($entry, '_', null, true), 0, -4));
		}
	}
	#####################
	### END OF STATIC ###
	#####################
	
	
	#####################
	### Plugin Object ###
	#####################
	private $name;  # trigger name
	private $priv;  # prlvhosafix
	private $scope; # a=private, b=both, c=channel
	private $defdis;# 1=defaultDisabled, 0=normal
	private $path;  # file to include
	private $trans; # lang file
	
	public function __construct($name, $path, $priv='Pb')
	{
		$this->name = strtolower($name);
		$this->priv = strtolower($priv[0]);
		$this->scope = strtolower($priv[1]);
		$this->defdis = strlen($priv) > 2 ? '1' : '0';
		$this->path = $path;
// 		$this->trans = NULL;
	}
	
	public function getName() { return $this->name; }
	public function displayName() { return $this->name; }
	public function msg() { return trim(Common::substrFrom(Dog::getIRCMsg()->getArg(1), ' ', '')); }
	public function argv($n=NULL) { $msg = $this->msg(); $argv = $msg === '' ? array() : explode(' ', $msg); return $n === NULL ? $argv : $argv[$n]; }
	public function argc() { return count($this->argv()); }
	public function argvMsgFrom($from=1) { return implode(' ', array_slice($this->argv(), $from)); }
	public function execute() { include $this->path; }
	public function showHelp() { Dog::processFakeMessage('help '.$this->name); }
	public function getConfGlob($key, $def) { return Dog_Conf_Plug::getConf($this->name, $key, $def); }
	public function getConfServ($key, $def) { return Dog_Conf_Plug_Serv::getConf($this->name, Dog::getServer()->getID(), $key, $def); }
	public function getConfChan($key, $def) { return Dog_Conf_Plug_Chan::getConf($this->name, Dog::getChannel()->getID(), $key, $def); }
	public function getConfUser($key, $def) { return Dog_Conf_Plug_User::getConf($this->name, Dog::getUser()->getID(), $key, $def); }
	public function getConf($key) { return Dog_Var::getVar($this->getConfigVars(), $key)->getValue(); }
	public function getHelp() { return 'help' === ($help = $this->lang('help')) ? Dog::lang('err_no_help') : $help; }
	public function getPower() { return Dog_IRCPriv::charToBit($this->priv); }
	public function getPriv() { return $this->priv; }
	public function getScope() { return $this->scope; }
	public function isInScope($serv, $chan) { return Dog::isInScope($serv, $chan, $this->scope); }
	public function hasPermission($serv, $chan, $user) { return Dog::hasPermission($serv, $chan, $user, $this->priv, $this->scope); }
	
	/**
	 * Check if plugin is enabled for server and optional channel.
	 * @param Dog_Server $server
	 * @param DOG_Channel $channel
	 * @return boolean
	 */
	public function isEnabled(Dog_Server $server, $channel)
	{
		$plg = $this->name;
		if  (  Dog_Conf_Plug::isDisabled($plg)
			|| Dog_Conf_Plug_Serv::isDisabled($plg, $server->getID())
			|| ( ($channel !== false) && Dog_Conf_Plug_Chan::isDisabled($plg, $channel->getID(), $this->defdis)) )
		{
			return false;
		}
		return true;
	}
	
	
	############
	### Lang ###
	############
	/**
	 * Eval the $lang structure from this file.
	 * @return array
	 */
	public function loadLang()
	{
		if ($this->trans === NULL)
		{
			$this->trans = array();
			
			if  ( (false !== ($file = file_get_contents($this->path)))
				&&(preg_match('/\\$lang *= *([^;]+)\);/i', $file, $match)) )
			{
				$this->trans = eval("return {$match[1]});");
			}
		}
		
		return $this->trans;
	}
	public function rplyAction($key, $args=NULL) { return $this->replyAction($this->lang($key, $args)); }
	public function replyAction($message) { return Dog::getServer()->replyAction($message); }
	public function reply($message) { return Dog::reply($message); }
	public function rply($key, $args=NULL) { return $this->reply($this->lang($key, $args)); }
	public function hasKey($key) { return $this->lang($key) !== $key; }
	public function lang($key, $args=NULL)
	{
		return $this->langISO(Dog::getLangISO(), $key, $args);
	}
	
	public function langISO($iso, $key, $args=NULL)
	{
		$lang = $this->loadLang();
		
		if (!isset($lang[$iso]))
		{
			$iso = 'en';
		}
		
		if ( (!isset($lang[$iso])) || (!isset($lang[$iso][$key])) )
		{
			return $this->langNotFound($key, $args);
		}
		
		return $this->replaceArgs($lang[$iso][$key], $args);
	}
	
	private function replaceArgs($back, $args=NULL)
	{
		$t = Dog::getTrigger();
		$back = str_replace(array('%BOT%', '%CMD%', '%T%'), array(Dog::getNickname(), $t.$this->name, $t), $back);
		return $args === NULL ? $back : vsprintf($back, $args);
	}
	
	private function langNotFound($key, $args=NULL)
	{
		return $key.print_r($args, true);
	}

	##############
	### Config ###
	##############
	/**
	 * Get the config vars from ####conf string.
	 * @see Dog_Var
	 * @return array
	 */
	public function getConfigVars()
	{
		static $MAGIC = '####conf ';
		$row = false;
		if (false !== ($fh = fopen($this->path, 'r')))
		{
			while (false !== ($row = fgets($fh)))
			{
				if (Common::startsWith($row, $MAGIC))
				{
					break;
				}
			}
			fclose($fh);
		}
		return $row === false ? array() : Dog_Var::parseConfigVars(trim(substr($row, strlen($MAGIC))), NULL, $this->name);
	}
	
	public function showConfigVarNames($scope)
	{
		Dog::rply('msg_plgvars', array($this->displayName(), Dog_Var::showVarNames($this->getConfigVars(), $scope)));
	}
	
	public function showConfigVar($scope, $varname)
	{
		Dog_Var::showVar($this->getConfigVars(), $scope, $varname, $this, $this->lang("conf_$varname"));
	}
	
	public function setConfigVar($scope, $varname, $value)
	{
		Dog_Var::setVar($this->getConfigVars(), $scope, $varname, $value);
	}
}
