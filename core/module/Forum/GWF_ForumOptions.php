<?php
/**
 * Forum Options and a few stats.
 * @author gizmore
 * @version 3.0
 * @since 2.0
 */
final class GWF_ForumOptions extends GDO
{
	###################
	### OPTION BITS ###
	###################
	const SUBSCRIBE_NONE = 'none';
	const SUBSCRIBE_OWN = 'own';
	const SUBSCRIBE_ALL = 'all';
	public static $SUBSCR_MODES = array(self::SUBSCRIBE_NONE, self::SUBSCRIBE_OWN, self::SUBSCRIBE_ALL);
	
	const HIDE_SUBSCR = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumopt'; }
	public function getOptionsName() { return 'fopt_options'; }
	public function getColumnDefines()
	{
		return array(
			'fopt_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'fopt_token' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, true, GWF_Random::TOKEN_LEN),
			'fopt_subscr' => array(GDO::ENUM, self::SUBSCRIBE_NONE, self::$SUBSCR_MODES),
			'fopt_signature' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'fopt_options' => array(GDO::UINT, 0),
			'fopt_thanks' => array(GDO::UINT, 0),
			'fopt_upvotes' => array(GDO::UINT, 0),
			'fopt_downvotes' => array(GDO::UINT, 0),
			'fopt_posts' => array(GDO::UINT, 0),
		);
	}
	
	###################
	### Convinience ###
	###################
	public function isSubscrHidden() { return $this->isOptionEnabled(self::HIDE_SUBSCR); }
	public function isSubscribeAll() { return $this->getVar('fopt_subscr') === self::SUBSCRIBE_ALL; }
	public function isSubscribeOwn() { return $this->getVar('fopt_subscr') === self::SUBSCRIBE_OWN; }
	public function isSubscribeNone() { return $this->getVar('fopt_subscr') === self::SUBSCRIBE_NONE; }
	public static function isValidSubscr($subscr) { return in_array($subscr, self::$SUBSCR_MODES, true); }
	public function getPostCount() { return $this->getVar('fopt_posts'); }
	public function getToken() { return $this->getVar('fopt_token'); }
	public function increasePosts($by=1) { return $this->increase('fopt_posts', $by); }
	public function displaySignature() { return '<div class="gwf_signature">'.GWF_Message::display($this->getVar('fopt_signature'), true, true).'</div>'; }
	public function hasSignature() { $o = $this->getVar('fopt_signature'); return  $o !== '' && $o !== NULL; }
	############################
	### Get Options for User ###
	############################
	/**
	 * Get User Options Row for current user.
	 * This caches the row effectively and is faster than the non-Static version.
	 * @return GWF_ForumOptions
	 */
	public static function getUserOptionsS()
	{
		static $row = true;
		if ($row === true)
		{
			$row = self::getUserOptions(GWF_Session::getUser(), true);
		}
		return $row;
	}
	
	/**
	 * Get User Options Row for a user.
	 * @param GWF_User $user
	 * @return GWF_ForumOptions
	 */
	public static function getUserOptions($user, $return_guest=false)
	{
		if ( ($user === false) || ('0' === ($userid = $user->getID())) || (false === ($row = self::getUserOptionsByID($userid))) ) {
			return $return_guest ? self::getGuestUserOptions() : false;
		}
		return $row;
	}
	
	/**
	 * Get global user options for guests.
	 * @return GWF_ForumOptions
	 */
	public static function getGuestUserOptions()
	{
		return self::getUserOptionsByID('0');
	}
	
	/**
	 * Get a row of forum options
	 * @param int $userid
	 * @return GWF_ForumOptions
	 */
	public static function getUserOptionsByID($userid)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($userid))) {
			return self::createOptions($userid);
		}
		return $row;
	}
	
	/**
	 * Create a new options row.
	 * @param unknown_type $userid
	 * @return GWF_ForumOptions
	 */
	private static function createOptions($userid)
	{
		$row = new self(array(
			'fopt_uid' => $userid,
			'fopt_token' => GWF_Random::randomKey(GWF_Random::TOKEN_LEN),
			'fopt_subscr' => self::SUBSCRIBE_NONE,
			'fopt_signature' => '',
			'fopt_options' => 0,
			'fopt_thanks' => 0,
			'fopt_upvotes' => 0,
			'fopt_downvotes' => 0,
			'fopt_posts' => 0,
		));
		if (false === $row->replace()) {
			return false;
		}
		return $row;
	}
	
	public function saveSubscription($subscription) {
		return $this->saveVar('fopt_subscr', $subscription);
	}
	
	##########################
	### Subsription Select ###
	##########################
	public function getSubscrSelect(Module_Forum $module, $name='subscr')
	{
		$back = sprintf('<select name="%s">', $name);
		$val = $this->getVar('fopt_subscr');
		foreach (self::$SUBSCR_MODES as $opt)
		{
			$sel = GWF_HTML::selected($opt === $val);
			$back .= sprintf('<option value="%s"%s>%s</option>', $opt, $sel, $module->lang('subscr_'.$opt));
		}
		$back .= '</select>';
		return $back;
	}
	
	#####################
	### Guest Options ###
	#####################
	public static function guestOptions()
	{
		return new self(array(
			'fopt_uid' => '0',
			'fopt_token' => '',
			'fopt_subscr' => self::SUBSCRIBE_NONE,
			'fopt_signature' => '',
			'fopt_options' => '0',
			'fopt_thanks' => '0',
			'fopt_upvotes' => '0',
			'fopt_downvotes' => '0',
			'fopt_posts' => '0',
		));
	}
}

?>
