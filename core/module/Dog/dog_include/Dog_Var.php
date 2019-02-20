<?php
/**
 * A Dog_Var is parsed from a string like this:
 * name,scope,privilege,type,default,,,name,scope,privilege,type,default,,,name,scope,privilege,type,default
 * Note the three comma above.
 * 
 * In plugins there is a magic byte sequence ####conf to specify such a string.

 * @author gizmore
 * @version 4.0
 */
final class Dog_Var
{
	const SCOPES = 'gscu';         # global server channel user
	const TYPES  = 'bifsvx';       # boolean integer float string vector script
	
	private $name;
	private $scope; # gscu
	private $priv;  # prvhosafix    # public registered voice halfop op staff founder admin xowner      # @see Dog_IRCPriv
	private $type;  # bifsvx
	private $default;
	
	private $module; # Set to modulename, if a modulevar
	private $plugin; # Set to pluginname, if a plugvar
	
	public function __construct($name, $scope, $priv, $type, $default, $module=NULL, $plugin=NULL)
	{
		$this->name = $name;
		$this->scope = strtolower($scope);
		$this->priv = $priv;
		$this->type = $type;
		$this->default = $default;
		$this->module = $module;
		$this->plugin = $plugin;
	}
	
	public function getName() { return $this->name; }
	public function displayName() { return $this->module.$this->plugin; }
	public function getScope() { return $this->scope; }
	public function getPriv() { return $this->priv; }
	public function getType() { return $this->type; }
	public function getDefault() { return $this->default; }
	public function displayType() { return self::displayTypeS($this->type); }

	public function inScope($scope) { return empty($scope) ? true : $this->scope === $scope; }
	
	public function hasPermission(Dog_Server $server, $channel, Dog_User $user)
	{
		$c = $this->priv;
		switch ($this->scope)
		{
			case 'u':
			case 'g':
			case 's': return Dog_PrivServer::hasPermChar($server, $user, $c);
			case 'c': return $channel === false ? false : Dog_PrivChannel::hasPermChar($channel, $user, $c);
			default: return Dog_Log::critical('Invalid scope in hasPermission()!');
		}
	}
	
	public function getValue()
	{
		$key = $this->name;
		$def = $this->default;
		$sid = Dog::getServer()->getID();
		$c = Dog::getChannel();
		if ($this->module !== NULL)
		{
			$mod = $this->module;
			switch ($this->scope)
			{
				case 'g': return Dog_Conf_Mod::getConf($mod, $key, $def);
				case 's': return Dog_Conf_Mod_Serv::getConf($mod, $sid, $key, $def);
				case 'c': return $c === false ? $def : Dog_Conf_Mod_Chan::getConf($mod, $c->getID(), $key, $def);
				case 'u': return Dog_Conf_Mod_User::getConf($mod, Dog::getUID(), $key, $def);
			}
		}
		elseif ($this->plugin !== NULL)
		{
			$plg = $this->plugin;
			switch ($this->scope)
			{
				case 'g': return Dog_Conf_Plug::getConf($plg, $key, $def);
				case 's': return Dog_Conf_Plug_Serv::getConf($plg, $sid, $key, $def);
				case 'c': return $c === false ? $def : Dog_Conf_Plug_Chan::getConf($plg, $c->getID(), $key, $def);
				case 'u': return Dog_Conf_Plug_User::getConf($plg, Dog::getUID(), $key, $def);
			}
		}
		return $def;
	}
	
	public function setValue($value)
	{
		$key = $this->name;
		$sid = Dog::getServer()->getID();
		$uid = Dog::getUser()->getID();
		$c = Dog::getChannel();
		if ($this->module !== NULL)
		{
			$mod = $this->module;
			switch ($this->scope)
			{
				case 'g': return Dog_Conf_Mod::setConf($mod, $key, $value);
				case 's': return Dog_Conf_Mod_Serv::setConf($mod, $sid, $key, $value);
				case 'c': if ($c !== false) return Dog_Conf_Mod_Chan::setConf($mod, $c->getID(), $key, $value); return false;
				case 'u': return Dog_Conf_Mod_User::setConf($mod, $uid, $key, $value);
			}
		}
		elseif ($this->plugin !== NULL)
		{
			$plg = $this->plugin;
			switch ($this->scope)
			{
				case 'g': return Dog_Conf_Plug::setConf($plg, $key, $value);
				case 's': return Dog_Conf_Plug_Serv::setConf($plg, $sid, $key, $value);
				case 'c': if ($c !== false) Dog_Conf_Plug_Chan::setConf($plg, $c->getID(), $key, $value); return false;
				case 'u': return Dog_Conf_Plug_User::setConf($plg, $uid, $key, $value);
			}
		}
		return false;
	}
	
	##############
	### Static ###
	##############
	
	/**
	 * Parse config vars from a ####conf string.
	 * Returns array of Dog_Var
	 * @param string $string
	 * @return array
	 */
	public static function parseConfigVars($string, $module=NULL, $plugin=NULL)
	{
		$back = array();
		$csv = str_getcsv($string.',,');
		$len = count($csv);
		for ($i = 0; $i < $len;)
		{
			if ('' === ($name = trim($csv[$i++])))
			{
				Dog_Log::critical(sprintf('Empty config name in %s:%s.', $i-1, $string));
				return $back;
			}
			
			$scope = @substr(strtolower(trim($csv[$i++])), 0, 1);
			if (strpos(self::SCOPES, $scope) === false)
			{
				Dog_Log::critical(sprintf('Invalid config scope "%s" in %s:%s.', $scope, $i-1, $string));
				return $back;
			}
			
			$priv = @substr(strtolower(trim($csv[$i++])), 0, 1);
			if (strpos(Dog_IRCPriv::allChars(), $priv) === false)
			{
				Dog_Log::critical(sprintf('Invalid config privilege "%s" in %s:%s.', $priv, $i-1, $string));
				return $back;
			}
			
			$type = @substr(strtolower(trim($csv[$i++])), 0, 1);
			if (strpos(self::TYPES, $type) === false)
			{
				Dog_Log::critical(sprintf('Invalid config type "%s" in %s:%s.', $type, $i-1, $string));
				return $back;
			}
			
			if ('' === ($default = trim($csv[$i++])))
			{
				Dog_Log::critical(sprintf('Empty default value in %s:%s.', $i-1, $string));
				return $back;
			}
			if (!self::isValid($type, $default))
			{
				Dog_Log::critical(sprintf('Invalid default value in %s:%s.', $i-1, $string));
				return $back;
			}
			
			if ( ('' !== ($e1 = $csv[$i++])) || ('' !== ($e1 = $csv[$i++])) )
			{
				Dog_Log::critical('Invalid ####conf format. There have to be three consecutive comma to separate vars.');
				return $back;
			}
			
			# Yay \o/
			$back[] = new self($name, $scope, $priv, $type, $default, $module, $plugin);
		}
		
		return $back;
	}
	
	##################
	### Validation ###
	##################
	public static function isValid($type, $value)
	{
		switch ($type)
		{
			case 'b': return $value === '0' || $value === '1';
			case 'i': return Common::isNumeric($value, false);
			case 'f': return Common::isNumeric($value, true);
			case 's':
			case 'v': return true;
			default: return false;
		}
	}

	public static function parseValue($type, $value)
	{
		switch ($type)
		{
			case 'b': return self::parseBoolean($value);
			case 'i': return (int)$value;
			case 'f': return (float)$value;
			case 's': return $value;
			case 'v': return explode(',', $value);
		}
		return NULL;
	}

	public static function parseBoolean($value)
	{
		return $value === '1';
	}
	
	###############
	### Display ###
	###############
	public static function displayTypeS($type)
	{
		return Dog_Lang::lang("vart_$type");
	}
	
	public static function showVarNames(array $vars, $scope=NULL)
	{
		$serv = Dog::getServer();
		$chan = Dog::getChannel();
		$user = Dog::getUser();
		$back = array();
		foreach ($vars as $var)
		{
			$var instanceof Dog_Var;
			if ($var->inScope($scope) && $var->hasPermission($serv, $chan, $user))
			{
				$back[] = $var->getName();
			}
		}
		
		return count($back) ? implode(', ', $back) : Dog::lang('none');
	}
	
	/**
	 * Fetch var from array.
	 * @param array $vars
	 * @param string $varname
	 * @return Dog_Var
	 */
	public static function getVar(array $vars, $varname, $scope=NULL)
	{
		foreach ($vars as $var)
		{
			$var instanceof Dog_Var;
			if  ( (!strcasecmp($varname, $var->getName()))
				&&($var->inScope($scope)) )
			{
				return $var;
			}
		}
		return false;
	}

	public static function showVar(array $vars, $scope=NULL, $varname, $lang_handler, $help)
	{
		if (false === ($var = self::getVar($vars, $varname, $scope)))
		{
			return Dog::rply('err_unk_var');
		}
		$help = $help === "conf_$varname" ? '??' : $help;
		Dog::rply('msg_showvar', array($lang_handler->getName(), $varname, $help, $var->getValue()));
	}
	
	public static function setVar(array $vars, $scope=NULL, $varname, $value)
	{
		if (false === ($var = self::getVar($vars, $varname, $scope)))
		{
			Dog::rply('err_unk_var');
		}
		elseif (!self::isValid($var->getType(), $value))
		{
			Dog::rply('err_variabl', array($var->displayName(), $varname, $var->displayType()));
		}
		elseif (!$var->hasPermission(Dog::getServer(), Dog::getChannel(), Dog::getUser()))
		{
			Dog::noPermission($var->getPriv());
		}
		elseif (false === ($oldval = $var->getValue()))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!$var->setValue($value))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else
		{
			Dog::rply('msg_set_var', array($var->displayName(), $varname, $oldval, $var->getValue()));
		}
	}
}
?>
