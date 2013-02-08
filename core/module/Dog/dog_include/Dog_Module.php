<?php
abstract class Dog_Module
{
	private static $MODULES = array();

	private $triggers = array();

	private $name;
	
	/**
	 * @var GWF_LangTrans
	 */
	private $lang_;
	
	public function getName() { return $this->name; }
	public function displayName() { return $this->getName(); }
	public function setName($name) { $this->name = $name; }
	public function getPath() { return DOG_PATH.'dog_module/'.$this->getName().'/'; }
	public function getLangPath() { return $this->getPath().'lang'.'/'.strtolower($this->getName()); }
	public function getTablePath() { return $this->getPath().'tables'.'/'; }
	public function argc() { return count($this->argv()); }
	public function argv($n=NULL, $def=NULL) { $m = self::msgarg(); $argv = $m === '' ? array() : explode(' ', $m); return $n === NULL ? $argv : (isset($argv[$n]) ? $argv[$n] : NULL) ; }
	public function msg() { return Dog::getIRCMsg()->getArg(1); } # The full .cmd thing
	public function msgarg() { return trim(Common::substrFrom($this->msg(), ' ', '')); } # only the three .cmd arg arg arg
	public function rply($key, $args=NULL) { Dog::reply($this->lang($key, $args)); }
	public function reply($message) { Dog::reply($message); }
	public function lang($key, $args=NULL) { return $this->lang_->langISO(Dog::getLangISO(), $key, $args); }
	public function loadLanguage() { $this->lang_ = new GWF_LangTrans($this->getLangPath()); }
	public function langISO($iso, $key, $args=NULL) { return $this->lang_->langISO($iso, $key, $args); }
	public function getTrans() { return $this->lang_->getTrans(Dog::getLangISO()); }
	public function hasTrans($key) { return $this->lang($key) !== $key; }

	################
	### OVERRIDE ###
	################
	public function getPriority() { return 50; }
	public function onInstall($flush_tables) {}
	public function onInitTimers() {}
	public function onInit() {}
// 	public function defaultEnabled() { return true; }

	/**
	* array(KEY => CONFSTRING, ...)
	* CONFSTRING is gscu:prlvhosafix:bifsvx:defaultvalue
	* gscu = global server channel user
	* prvhosafix = public registered voice halfop op staff admin founder ircop xowner
	* bifsvx = boolean integer float string vector script
	* default value for booleans is currently 1 and 0.
	* @example return array('blub' => 'g,x,i,104, 'foo' => 's,s,s,".,-")
	*/
	public function getOptions() { return array(); }
	#######################
	### END_OF_OVERRIDE ###
	#######################


	/**
	 * @param string $modname
	* @return Dog_Module
	*/
	public static function getModule($modname) { return isset(self::$MODULES[$modname]) ? self::$MODULES[$modname] : false; }
	public static function getModules() { return self::$MODULES; }
	public static function createModule($modname)
	{
		$classname = 'DOGMOD_'.$modname;
		$module = new $classname();
		$module->setName($modname);
		$module->includeTables();
		$module->loadLanguage();
		$module->loadTriggers();
		$module instanceof Dog_Module;
		self::$MODULES[$modname] = $module;
	}

	public function includeTables()
	{
		$path = $this->getTablePath();
		if (Common::isDir($path))
		{
			foreach (scandir($path) as $entry)
			{
				if (Common::endsWith($entry, '.php'))
				{
					require_once $path.$entry;
				}
			}
		}
	}

	public function loadTriggers()
	{
		$this->triggers = array();
		$s = array('UP', 'DOWN', 'ADD', 'REMOVE');
		$r = array('++', '--',   '+',   '-');
		foreach (get_class_methods(get_class($this)) as $method)
		{
			if (substr($method, 0, 3) === 'on_')
			{
				$trigger = str_replace($s, $r, substr($method, 3, -3));
				$this->triggers[$method] = $trigger;
			}
		}
		var_dump($this->triggers);
	}

	public function showHelp($trigger, $args=NULL)
	{
		$this->reply($this->getHelp($trigger, $args));
	}

	// 	public function showHelpForMethod($method, $args=NULL)
	// 	{
	// 		$this->reply($this->getHelpForMethod($method, $args));
	// 	}

	// 	public function getHelpForMethod($method, $args=NULL)
	// 	{
	// 		return $this->getHelp(substr($method, 3, -3));
	// 	}

	public function getHelp($trigger, $args=NULL)
	{
		$key = 'help_'.$trigger;
		if ($key === ($help = $this->lang_->lang($key)))
		{
			return Dog::lang('err_no_help');
		}
		return $this->replaceLang($help, $args, $trigger);
	}

	private function replaceLang($text, $args, $trigger='')
	{
		$t = Dog::getTrigger();
		$text = str_replace(array('%T%', '%CMD%', '%BOT%'), array($t, $t.$trigger, Dog::getNickname()), $text);
		return $args === NULL ? $text : vsprintf($text, $args);
	}

	public static function map($method_name, $args=NULL)
	{
		$server = Dog::getServer();
		$channel = Dog::getChannel();

		foreach (self::$MODULES as $module)
		{
			$module instanceof Dog_Module;
			if ($module->isEnabled($server, $channel))
			{
				if (method_exists($module, $method_name))
				{
					call_user_func(array($module, $method_name), $args);
				}
			}
		}
	}

	private function getTriggers()
	{
		return $this->triggers;
	}

	public function getFilteredTriggers($serv, $chan, $user)
	{
		$back = array();
		foreach ($this->getTriggers() as $func => $trigger)
		{
			$privabc = strtolower(substr($func, -2));
			if  ( (Dog::hasPermission($serv, $chan, $user, $privabc[0], $privabc[1]))
					&&($this->isEnabled($serv, $chan))
					&&($this->isTriggerEnabled($serv, $chan, $trigger)) )
			{
				if (!in_array($trigger, $back))
				{
					$back[] = $trigger;
				}
			}
		}
		return $back;
	}

	/**
	 * Get a module by a trigger-name.
	 * @return Dog_Module
	 */
	public static function getByTrigger($trigger)
	{
		$trigger = strtolower($trigger);
		foreach (self::$MODULES as $module)
		{
			$module instanceof Dog_Module;
			foreach ($module->getTriggers() as $func => $trig)
			{
				if ($trig === $trigger)
				{
					return $module;
				}
			}
		}
		return false;
	}

	/**
	 * Get a module by a name.
	 * @return Dog_Module
	 */
	public static function getByName($mod_name)
	{
		foreach (self::$MODULES as $module)
		{
			$module instanceof Dog_Module;
			if (  (!strcasecmp($module->getName(), $mod_name))
				||(!strcasecmp($module->displayName(), $mod_name)) )
			{
				return $module;
			}
		}
		return false;
	}

	/**
	 * @return Dog_Module
	 */
	public static function getModuleWithPermsByTrigger($serv, $chan, $user, $trigger, $with_perms=true)
	{
		foreach (self::$MODULES as $module)
		{
			$module instanceof Dog_Module;
			if (in_array($trigger, $module->getFilteredTriggers($serv, $chan, $user), true))
			{
				return $module;
			}
		}
		return false;
	}

	public function isEnabled(Dog_Server $server, $channel)
	{
		$mod = $this->getName();
		if  (  Dog_Conf_Mod::isDisabled($mod)
				|| Dog_Conf_Mod_Serv::isModuleDisabled($mod, $server->getID())
				|| (($channel !== false) && Dog_Conf_Mod_Chan::isModuleDisabled($mod, $channel->getID())) )
		{
			return false;
		}
		return true;
	}

	public function isTriggerEnabled(Dog_Server $server, $channel, $trigger)
	{
		$mod = $this->getName();
		$sid = $server->getID();

		if  (  (!$this->isEnabled($server, $channel))
				|| Dog_Conf_Mod_Serv::isTriggerDisabled($mod, $sid, $trigger)
				|| ( ($channel !== false) && Dog_Conf_Mod_Chan::isTriggerDisabled($mod, $channel->getID(), $trigger) ) )
		{
			return false;
		}
		return true;
	}

	public function execute($trigger)
	{
		call_user_func(array($this, array_search($trigger, $this->triggers, true)));
	}

	##############
	### Config ###
	##############
	public function getConfigVars()
	{
		$string = '';
		foreach ($this->getOptions() as $name => $str)
		{
			$string .= ",,,$name,$str";
		}
		return $string === '' ? array() : Dog_Var::parseConfigVars(substr($string, 3), $this->getName());
	}

	public function getConfig($varname, $scope=NULL)
	{
		return Dog_Var::getVar($this->getConfigVars(), $varname, $scope)->getValue();
	}

	public function showConfigVarNames($scope)
	{
		Dog::rply('msg_modvars', array($this->getName(), Dog_Var::showVarNames($this->getConfigVars(), $scope)));
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
?>
