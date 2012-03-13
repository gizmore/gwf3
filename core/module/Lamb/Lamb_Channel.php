<?php
/**
 * An irc channel.
 * @author gizmore
 * @version 3
 */
final class Lamb_Channel extends GDO
{
	private $users = array();
	
	const NO_RESPONSE = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_channel'; }
	public function getOptionsName() { return 'chan_options'; }
	public function getColumnDefines()
	{
		return array(
			'chan_id' => array(GDO::AUTO_INCREMENT),
			'chan_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'chan_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'chan_lang' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'en', 4),
			'chan_maxusers' => array(GDO::UINT, 0),
			'chan_ops' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
			'chan_hops' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
			'chan_voice' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
			'chan_topic' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'chan_options' => array(GDO::UINT, 0),
		);
	}
	
	public function allowsTrigger()
	{
		return !$this->isOptionEnabled(self::NO_RESPONSE);
	}
	
	############
	### Lang ###
	############
	public function getLangClass()
	{
		return (false === ($lang = GWF_Language::getByISO($this->getVar('chan_lang')))) ?
			GWF_Language::getEnglish() : $lang;
	}
	
	public function setupLanguage()
	{
		GWF_Language::setCurrentLanguage($this->getLangClass());
	}
	
	##############
	### Static ###
	##############
	/**
	 * @param int $channel_id
	 * @return Lamb_Channel
	 */
	public static function getByID($channel_id)
	{
		return self::table(__CLASS__)->getRow($channel_id);
	}
	
	/**
	 * @param Lamb_Server $server
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public static function getByName(Lamb_Server $server, $channel_name)
	{
		$sid = $server->getID();
		$channel_name = self::escape($channel_name);
		return self::table(__CLASS__)->selectFirstObject('*', "chan_sid={$sid} AND chan_name='{$channel_name}'");
	}

	/**
	 * Create a new channel.
	 * @param Lamb_Server $server
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public static function createChannel(Lamb_Server $server, $channel_name)
	{
		$channel = new self(array(
			'chan_id' => 0,
			'chan_sid' => $server->getID(),
			'chan_name' => $channel_name,
			'chan_lang' => 'en',
			'chan_maxusers' => 0,
			'chan_ops' => '',
			'chan_hops' => '',
			'chan_voice' => '',
			'chan_topic' => '',
			'chan_options' => 0,
		));
		if (false === ($channel->insert()))
		{
			return false;
		}
		return $channel;
	}
	
	public function getName()
	{
		return $this->getVar('chan_name');
	}
	
	public function getUsers()
	{
		return $this->users;
	}
	
	public function getUserCount()
	{
		return count($this->users);
	}
	
	public function addUser(Lamb_User &$user, $usermode='')
	{
		$u = strtolower($user->getVar('lusr_name'));
		$this->users[$u] = array($user, self::alterUsermode('', $usermode));
	}
	
	/**
	 * Get a user by name for this channel.
	 * @param string $username
	 * @return Lamb_User
	 */
	public function getUserByName($username)
	{
		return $this->users[strtolower($username)][0];
	}
	
	public function isUserInChannel($username)
	{
		return isset($this->users[strtolower($username)]);
	}
	
	public function getModeByName($username)
	{
		$username = strtolower($username);
		return isset($this->users[$username][1]) ? $this->users[$username][1] : '';
	}
	
	public function setUserMode($username, $usermode)
	{
		$u = strtolower($username);
		$oldmode = $this->getModeByName($u);
		$this->users[$u] = array($this->getUserByName($u), self::alterUsermode($oldmode, $usermode));
	}
	
	public function removeUser($username)
	{
		unset($this->users[strtolower($username)]);
	}
	
	public function getTopic()
	{
		return $this->getVar('chan_topic');
	}
	
	public function saveTopic($topic)
	{
		return $this->saveVar('chan_topic', $topic);
	}

	
	##################
	### Bitmapping ###
	##################
	private static $MAP = array(
		'a' => Lamb_User::ADMIN,
		's' => Lamb_User::STAFF,
		'o' => Lamb_User::OPERATOR,
		'h' => Lamb_User::HALFOP,
		'v' => Lamb_User::VOICE,
	);
	
	private static $SYMBOLMAP = array(
		'~' => 'a',
		'&' => 's',
		'@' => 'o',
		'%' => 'h',
		'+' => 'v',
	);
	
	/**
	 * Alter a usermode by another usermode, for example vh, +o as params.
	 * @param string $oldmode
	 * @param string $usermode
	 * @return string the altered usermode
	 */
	public static function alterUsermode($oldmode, $usermode)
	{
		$oldmode = trim($oldmode);
		
		if ($usermode === '')
		{
			$back = $oldmode;
		}
		elseif ($usermode[0] === '+')
		{
			$back = $oldmode.substr($usermode, 1);
		}
		elseif ($usermode[0] === '-')
		{
			$back = preg_replace(sprintf('/[%s]/', substr($usermode, 1)), '', $oldmode);
		}
		else
		{
			$back = $usermode;
		}
		
// 		Lamb_Log::logDebug(sprintf('%s(%s,%s) === %s', __METHOD__, $oldmode, $usermode, $back));
		
		return $back;
	}
	
	/**
	 * Convert usermode symbol to usermode char.
	 * @param string $symbols
	 * @return string usermode equivalent string.
	 */
	public static function symbolsToUsermode($symbols)
	{
		$symbols = trim($symbols);
		
		$back = '';
		$len = strlen($symbols);
		for ($i = 0; $i < $len; $i++)
		{
			if (isset(self::$SYMBOLMAP[$symbols[$i]]))
			{
				$back .= self::$SYMBOLMAP[$symbols[$i]];
			}
		}
		
// 		Lamb_Log::logDebug(sprintf('%s(%s) === %s', __METHOD__, $symbols, $back));
		
		return $back;
	}
	
	/**
	 * Convert usermode flags into lambuser bits.
	 * @param string $usermode
	 * @return int bitfield
	 */
	public static function usermodeToBits($usermode)
	{
		$bit = 0;
		$len = strlen($usermode);
		for ($i = 0; $i < $len; $i++)
		{
			if (isset(self::$MAP[$usermode[$i]]))
			{
				$bit |= self::$MAP[$usermode[$i]];
			}
		}
		
// 		Lamb_Log::logDebug(sprintf('%s(%s) === %s', __METHOD__, $usermode, $bit));
		
		return $bit;
	}
	
	public static function bitsToUsermode($bits)
	{
		$back = '';
		for ($i = 1; $i <= Lamb_User::VOICE; $i *= 2)
		{
			if (($bits & $i) === $i)
			{
				$back .= array_search($i, self::$MAP);
			}
		}
		
// 		Lamb_Log::logDebug(sprintf('%s(%s) === %s', __METHOD__, $bits, $back));
		
		return $back;
	}
}
?>