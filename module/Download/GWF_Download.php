<?php
/**
 * @author gizmore
 */
final class GWF_Download extends GDO implements GWF_Orderable #implements GDO_Searchable, GDO_Sortable, GDO_Addable, GDO_Editable
{
	# Options
	const ADULT = 0x01;
	const HIDE_UNAME = 0x02;
	const GUEST_DOWNLOAD = 0x04;
	const GUEST_VISIBLE = 0x08;
	
	# Constants
	const TOKEN_LENGTH = 8;
	
	private $custom_name = '';
	private $custom_path = '';
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'download'; }
	public function getOptionsName() { return 'dl_options'; }
	public function getColumnDefines()
	{
		return array(
			# ID`s
			'dl_id' => array(GDO::AUTO_INCREMENT, GDO::NOT_NULL),
			'dl_uid' => array(GDO::OBJECT|GDO::INDEX, 0, array('GWF_User', 'dl_uid', 'user_id')),
			# Permission
			'dl_gid' => array(GDO::UINT, 0),
			'dl_level' => array(GDO::UINT, 0),
			'dl_token' => array(GDO::TOKEN, GDO::NOT_NULL, self::TOKEN_LENGTH),
			# Data
			'dl_count' => array(GDO::UINT, 0),
			'dl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'dl_filename' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'dl_realname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'dl_descr' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'dl_mime' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
			'dl_price' => array(GDO::DECIMAL, '0.0', array(5,2)),
			'dl_options' => array(GDO::UINT, 0),
			# Votes
			'dl_voteid' => array(GDO::OBJECT, 0, array('GWF_VoteScore', 'dl_voteid', 'vs_id')),
			# Purchases
			'dl_purchases' => array(GDO::UINT, 0),
			'dl_expire' => array(GDO::UINT, 0),
		);
	}
	##################
	### Convinient ###
	##################
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotes() { return $this->getVar('dl_voteid'); }
	
	public function getDownloadPath() { return 'dbimg/dl/'.$this->getVar('dl_id'); }
	public function getCustomDownloadPath() { return $this->custom_path === '' ? $this->getDownloadPath() : $this->custom_path; }
	public function setCustomDownloadPath($path) { $this->custom_path = $path; }
	public function getCustomDownloadName() { return $this->custom_name === '' ? $this->getVar('dl_filename') : $this->custom_name; }
	public function setCustomDownloadName($name) { $this->custom_name = $name; }
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getVar('dl_uid'); }
	
	public function getUserID() { return (false === ($user = $this->getUser())) ? '0' : $user->getID(); }
	
	public function isAdult() { return $this->isOptionEnabled(self::ADULT); }
	
	public function isUsernameHidden() { return $this->isOptionEnabled(self::HIDE_UNAME); }
	
	public function isPaidContent() { return $this->getVar('dl_price') > 0; }
	
	public function displayPrice()
	{
		return Module_Payment::displayPrice($this->getVar('dl_price'));
	}
	
	public function expires() { return $this->getVar('dl_expire') > 0; }
	
	##############
	### Static ###
	##############
	/**
	 * Get a download by ID.
	 * @param int $dl_id
	 * @return GWF_Download
	 */
	public static function getByID($dl_id)
	{
		return self::table(__CLASS__)->getRow($dl_id);
	}
	
	/**
	 * Generate a download token.
	 * @return string
	 */
	public static function generateToken()
	{
		return Common::randomKey(self::TOKEN_LENGTH, Common::ALPHANUMUPLOW);
	}

	/**
	 * Get permission query for a user. (Download)
	 * @param GWF_User $user
	 * @return string
	 */
	public static function getPermissionQuery($user)
	{
		if ($user === false) {
			$guest_dl = GWF_Download::GUEST_DOWNLOAD;
			return "dl_gid=0 AND dl_level=0 AND dl_options&$guest_dl";
		}
		if ($user->isAdmin()) {
			return '';
		}
		$uid = $user->getID();
		$level = $user->getLevel();
		$ug = GWF_TABLE_PREFIX.'usergroup';
		return "( dl_level<=$level AND ((dl_gid=0) OR (SELECT 1 FROM $ug WHERE ug_userid=$uid AND ug_groupid=dl_gid)) )";
	}
	
	/**
	 * Get permission query for a user. (View)
	 * @param GWF_User $user
	 * @return string
	 */
	public static function getPermissionQueryList($user)
	{
		if ($user === false) {
			$guest_view = GWF_Download::GUEST_VISIBLE;
			return "dl_gid=0 AND dl_level=0 AND dl_options&$guest_view";
		}
		if ($user->isAdmin()) {
			return '';
		}
		$uid = $user->getID();
		$level = $user->getLevel();
		$ug = GWF_TABLE_PREFIX.'usergroup';
		return "( dl_level<=$level AND ((dl_gid=0) OR (SELECT 1 FROM $ug WHERE ug_userid=$uid AND ug_groupid=dl_gid)) )";
	}
	
	###############
	### Install ###
	###############
	/**
	 * Create voting table.
	 * @param Module_Download $module
	 * @return boolean
	 */
	public function createVotes(Module_Download $module)
	{
		if (false === ($votes = Module_Votes::installVoteScoreTable('dl_'.$this->getVar('dl_id'), $module->cfgMinVote(), $module->cfgMaxVote(), $module->cfgGuestVote()))) {
			return false;
		}
		$this->saveVar('dl_voteid', $votes->getID());
		$this->setVar('dl_voteid', $votes);
		return true;
	}
	
	############
	### Edit ###
	############
	public function hrefEdit()
	{
		return GWF_WEB_ROOT.'index.php?mo=Download&me=Edit&id='.$this->getVar('dl_id');
	}
	
	public function mayEdit($user)
	{
		if ($user === false) {
			return false;
		}
		elseif ($user->isAdmin()) {
			return true;
		}
		else {
			return $this->getUserID() === $user->getID();
		}
	}
	
	################
	### Download ###
	################
	public function hrefDownload()
	{
		return GWF_WEB_ROOT.'download/'.$this->getVar('dl_id').'/'.$this->urlencodeSEO('dl_filename');
	}
	
	public function hrefDownloadToken($token)
	{
		return GWF_WEB_ROOT.'download/'.$this->getVar('dl_id').'/'.$this->urlencodeSEO('dl_filename').'/'.$token;
	}
	
	
	#################
	### GWF_Order ###
	#################
	public function canOrder(GWF_User $user) { return true; }
	public function canRefund(GWF_User $user) { return false; }
	public function canPayWithGWF(GWF_User $user) { return true; }
	public function canAutomizeExec(GWF_User $user) { return true; }
	public function needsShipping(GWF_User $user) { return false; }
	
	public function getOrderWidth() { return 0.0; }
	public function getOrderHeight() { return 0.0; }
	public function getOrderDepth() { return 0.0; }
	public function getOrderWeight() { return 0.0; }
	
	public function getOrderModuleName() { return 'Download'; }
	public function getOrderPrice(GWF_User $user) { return floatval($this->getVar('dl_price')); }
	public function getOrderItemName(GWF_Module $module, $lang_iso) { return $module->langISO($lang_iso, 'order_title', $this->getVar('dl_filename'), $this->getVar('your_token', 'ERR')); }
	public function getOrderDescr(GWF_Module $module, $lang_iso)
	{
		if ($this->expires()) {
			return $module->langISO($lang_iso, 'order_descr', $this->getVar('dl_filename'), GWF_Time::humanDuration($this->getVar('dl_expire')), $this->getVar('your_token', 'ERR'));
		} else {
			return $module->langISO($lang_iso, 'order_descr2', $this->getVar('dl_filename'), $this->getVar('your_token', 'ERR'));
		}
	}
	public function getOrderStock(GWF_User $user) { return 1; }
	public function getOrderCancelURL(GWF_User $user) { return GWF_WEB_ROOT.'downloads'; }
	public function getOrderSuccessURL(GWF_User $user) { return $this->hrefDownload(); }
	
	public function displayOrder(GWF_Module $module)
	{
		$tVars = array(
			'dl' => $this,
		);
		return $module->templatePHP('order.php', $tVars);
	}
	
	public function executeOrder(GWF_Module $module, GWF_User $user)
	{
		$token = $this->getVar('your_token');
		
		if (false === (GWF_DownloadToken::insertToken($module, $this, $user, $token))) {
			return false;
		}
		
		if (false === $this->increase('dl_purchases', 1)) {
			# Euh nvm
		}
		
		if ($this->expires()) {
			$module->message('msg_purchased', array($token, GWF_Time::humanDuration($this->getVar('dl_expire')), $this->hrefDownload()), true, true);
		} else {
			$module->message('msg_purchased2', array($token, $this->hrefDownload()), true, true);
		}
		
		return true;
	}
	
}

?>