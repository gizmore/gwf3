<?php

final class GWF_Client extends GDO
{
	const TOKEN_LEN = 12;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }	
	public function getTableName() { return GWF_TABLE_PREFIX.'vs_client'; }
	public function getColumnDefines()
	{
		return array(
			'vsc_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL), # userid for quick access
			'vsc_token' => array(GDO::TOKEN|GDO::UNIQUE, GDO::NOT_NULL, self::TOKEN_LEN), # update token
			'vsc_modules' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_I), # purchased modules (Account,Register,..)
			'vsc_designs' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_I), # purchased designs (default,baim,wc,pt,q4blu)
		);
	}

	/**
	 * Get a client by userid.
	 * @param int $userid
	 * @return GWF_Client
	 */
	public static function getByID($userid)
	{
		return self::table(__CLASS__)->getBy('vsc_uid', $userid);
//		$userid = (int) $userid;
//		return self::table(__CLASS__)->selectFirst("vsc_uid=$userid");
	}
	/**
	 * Get a client by token.
	 * @param string $token
	 * @return GWF_Client
	 */
	public static function getByToken($token)
	{
		return self::table(__CLASS__)->getBy('vsc_token', $token);
//		$token = self::escape($token);
//		return self::table(__CLASS__)->selectFirst("vsc_token='$token'");
	}
	
	
	/**
	 * Get a client by userid, or create new client.
	 * @param int $userid
	 * @return GWF_Client
	 */
	public static function getClient($userid)
	{
		if ($userid <= 0) {
			return false;
		}
		
		if (false !== ($client = self::getByID($userid))) {
			return $client;
		}
		
		return self::newClient($userid);
	}
	
	private static function newClient($userid)
	{
		$client = new self(array(
			'vsc_uid' => $userid,
			'vsc_token' => self::generateToken(),
			'vsc_modules' => '',
			'vsc_designs' => '',
		));
		if (false === $client->insert()) {
			return false;
		}
		return $client;
	}
	
	private static function generateToken()
	{
		do
		{
			$token = GWF_Random::randomKey(self::TOKEN_LEN);
		}
		while (false !== self::getByToken($token));
		
		return $token;
	}
	
	#############
	### HREFs ###
	#############
	public function hrefZipper() { return GWF_WEB_ROOT.'index.php?mo=VersionServer&me=Purchase&zipper=true'; }
	
	###########################
	### Modules and Designs ###
	###########################
	public function getModuleNames()
	{
		return explode(',', $this->getVar('vsc_modules'));
	}
	
	public function getDesignNames()
	{
		return explode(',', $this->getVar('vsc_designs'));
	}
	
	public function getModules()
	{
		$mods = GWF_Module::loadModulesFS();
		$back = array();
		foreach ($this->getModuleNames() as $name)
		{
			if (isset($mods[$name]))
			{
				$back[] = $mods[$name];
			}
		}
		return $back;
	}
	
	public function ownsModule($modulename)
	{
		if ($modulename === '') {
			return true;
		}
		else {
			return in_array($modulename, $this->getModuleNames(), true);
		}
	}
	
	public function ownsDesign($designname)
	{
		if ($designname === '' || $designname === 'default') {
			return true;
		} else {
			return in_array($designname, $this->getDesignNames(), true);
		}
	}
	
	public function mergeModules(array $modules)
	{
		$have = $this->getModuleNames();
		foreach ($modules as $modname)
		{
			if (!in_array($modname, $have, true))
			{
				$have[] = $modname;
			}
		}
		
		foreach ($have as $id => $modname)
		{
			if ($modname === ''){
				unset($have[$id]);
			}
		}
		sort($have);
		return $this->saveVar('vsc_modules', implode(',', $have));
	}
	
	public function mergeDesigns(array $designs)
	{
		$have = $this->getDesignNames();
		foreach ($designs as $designame)
		{
			if (!in_array($designame, $have, true))
			{
				$have[] = $designame;
			}
		}
		
		foreach ($have as $id => $designame)
		{
			if ($designame === ''){
				unset($have[$id]);
			}
		}
		sort($have);
		return $this->saveVar('vsc_designs', implode(',', $have));
	}
	
	
}

?>