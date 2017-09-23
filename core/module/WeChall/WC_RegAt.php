<?php
/**
 * Link a user to a site (table).
 * @author gizmore
 */
final class WC_RegAt extends GDO
{
	const HIDE_SITENAME = 0x01;
	const LINKED = 0x02;
	const UNRANKED = 0x04; # thx sabretooth
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_regat'; }
	public function getOptionsName() { return 'regat_options'; }
	public function getColumnDefines()
	{
		return array(
			'regat_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'regat_sid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			
			'regat_onsitename' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
			'regat_onsitescore' => array(GDO::UINT|GDO::INDEX, 0),

			'regat_challcount' => array(GDO::UINT, 0),
			'regat_challsolved' => array(GDO::INT, -1),
			'regat_options' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_lastdate' => array(GDO::DATE|GDO::INDEX, GWF_Date::LEN_SECOND),
			'regat_linkdate' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_DAY),
			
			# Cache Scoring v4, these values have been dropped from WC3, or are completely new.
			# The regat row replaces the langid_totalscore table now.
			'regat_solved' => array(GDO::DECIMAL, 0, array(1,8)),
			'regat_score' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_langid' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_tagbits' => array(GDO::UINT|GDO::INDEX, 0), # Query all overlapping tags very fast.
			
			# v4.2
			'regat_onsiterank' => array(GDO::UINT|GDO::INDEX, 0),
		
		 	# v5.0
		 	'site' => array(GDO::JOIN, NULL, array('WC_Site', 'regat_sid', 'site_id')), 
			'user' => array(GDO::JOIN, NULL, array('GWF_User', 'regat_uid', 'user_id')), 
		);
	}
	
	#####################
	### Static Getter ###
	#####################
	/**
	 * Get RegAt Row for User&Site.
	 * @return WC_RegAt
	 */
	public static function getRegatRow($userid, $siteid)
	{
		return self::table(__CLASS__)->getRow($userid, $siteid);
	}
	
	public static function getRegats($userid, $orderby='')
	{
		$userid = (int) $userid;
		return self::table(__CLASS__)->selectObjects('*', "regat_uid=$userid", $orderby);
	}
	
	public static function countRegats($userid)
	{
		$userid = (int) $userid;
		return self::table(__CLASS__)->countRows("regat_uid=$userid");
	}
	
	/**
	 * Get a regat row by onsitename.
	 * @param int $siteid
	 * @param string $onsitename
	 * @return WC_RegAt
	 */
	public static function getByOnsitename($siteid, $onsitename)
	{
		$siteid = (int)$siteid;
		$onsitename = GDO::escape($onsitename);
		return self::table(__CLASS__)->selectFirstObject('*', "regat_sid=$siteid AND regat_onsitename='$onsitename'");
	}
	
	/**
	 * Get a user for a site by onsitename.
	 * @param string $onsitename
	 * @param int $siteid
	 * @return GWF_User
	 */
	public static function getUserByOnsiteName($onsitename, $siteid)
	{
		$siteid = (int)$siteid;
		$onsitename = self::escape($onsitename);
		if (false === ($userid = self::table(__CLASS__)->selectVar('regat_uid', "regat_sid=$siteid AND regat_onsitename='$onsitename'")))
		{
			return false;
		}
		return GWF_User::getByID($userid);
	}
	
	##############
	### Unlink ###
	##############
	public static function unlink($userid, $siteid)
	{
		$userid = (int) $userid;
		$siteid = (int) $siteid;
		return GDO::table(__CLASS__)->deleteWhere("regat_uid=$userid AND regat_sid=$siteid");
	}
	
	public static function unlinkAll($userid)
	{
		$userid = (int) $userid;
		return GDO::table(__CLASS__)->deleteWhere("regat_uid=$userid");
	}
	
	###################
	### Convinience ###
	###################
	public function getOnsiteScore() { return $this->getVar('regat_onsitescore'); }
	public function getOnsiteRank() { return $this->getVar('regat_onsiterank'); }
	public function isOnsitenameHidden() { return $this->isOptionEnabled(self::HIDE_SITENAME); }
	public function isScored() { return $this->isOptionEnabled(self::UNRANKED); }
	/**
	 * @return GWF_User
	 */
	public function getUser() { return GWF_User::getByID($this->getVar('regat_uid')); }
	/**
	 * @return WC_Site
	 */
	public function getSite() { return WC_Site::getByID($this->getVar('regat_sid')); }
	
	###############
	### Scoring ###
	###############
	private static function calcLinearSite(WC_Site $site)
	{
		$regats = self::table(__CLASS__);
		$warbox = GWF_TABLE_PREFIX.'wc_warbox';
		$warflag = GWF_TABLE_PREFIX.'wc_warflag';
		$warflags = GWF_TABLE_PREFIX.'wc_warflags';

		$siteid = $site->getVar('site_id');
		$joinbox = "JOIN $warbox ON wf_wbid = wb_id";
		$joinflag = "JOIN $warflag ON wf_id = wf_wfid";
		$subquery = "SELECT SUM(wf_score) FROM $warflags $joinflag $joinbox  WHERE wf_uid=regat_uid AND wb_sid=$siteid AND wf_solved_at IS NOT NULL";
		
		if (false === $regats->update("regat_onsitescore = ($subquery)", "regat_sid=$siteid"))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
	}
	/**
	 * Recalculate all scores for one site.
	 * @param WC_Site $site
	 * @return boolean
	 */
	public static function calcSite(WC_Site $site)
	{
		$regats = self::table(__CLASS__);
		$siteid = $site->getVar('site_id');
		$maxscore = $site->getVar('site_maxscore');
		$sitescore = $site->getVar('site_score');
		
		# Clamp to max
// 		$regats->update("regat_onsitescore={$maxscore}", "regat_onsitescore>{$maxscore} and regat_sid={$siteid}");
		
		if ($site->isLinear())
		{
			if ($site->isNoV1())
			{
				self::calcLinearSite($site);
			}

			if (false === $regats->update("regat_solved=regat_onsitescore/$maxscore, regat_score=regat_onsitescore", "regat_sid=$siteid"))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		elseif (defined('WECHALL_CAESUM_PATCH'))
		{
			# Ceasum Patch
			$challcount = $site->getVar('site_challcount');
			$powarg = $site->getPowArg();
			if (false === $regats->update("regat_solved=regat_onsitescore/$maxscore, regat_score=POW((regat_onsitescore/$maxscore),(1+($powarg/$challcount)))*$sitescore ", "regat_sid=$siteid"))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		else
		{
			# Original Code
			if (false === $regats->update("regat_solved=regat_onsitescore/$maxscore, regat_score=(regat_onsitescore/$maxscore)*(regat_onsitescore/$maxscore)*$sitescore ", "regat_sid=$siteid"))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		return false;
	}
	
	/**
	 * Calcs the shared rank. Multiple users can share one rank in theory.
	 * @param GWF_User $user
	 * @return int
	 */
	public static function calcRank(GWF_User $user)
	{
		$score = $user->getInt('user_level');
		return $user->countRows("user_level>$score AND user_options&0x10000000=0") + 1;
	}
	
	/**
	 * Calcs the exact rank. taking into account how many users with same rank are above him.
	 * @param GWF_User $user
	 * @return int
	 */
	public static function calcExactRank(GWF_User $user)
	{
		$rank = self::calcRank($user);
		$score = $user->getInt('user_level');
		$uid = $user->getInt('user_id');
		$rank += $user->countRows("user_level=$score AND user_id<$uid AND user_options&0x10000000=0");
		return $rank;
	}
	
	public static function calcExactSiteRank(GWF_User $user, $siteid)
	{
		$userid = $user->getVar('user_id');
		$siteid = (int)$siteid;
		$table = GDO::table('WC_RegAt');
		if (false === ($myscore = $table->selectVar('regat_solved', "regat_sid=$siteid AND regat_uid=$userid")))
		{
			$myscore = '0';
		}
		return $table->countRows("(regat_options&4=0) AND (regat_sid=$siteid ) AND ( (regat_solved>$myscore) OR (regat_solved=$myscore AND regat_uid<$userid) )") + 1;
	}
	
	
	/**
	 * Calcs the shared country rank. Multiple users can share one rank in theory. Return -1 on no country.
	 * @param GWF_User $user
	 * @return int
	 */
	public static function calcCountryRank(GWF_User $user)
	{
		if ('0' === ($cid = $user->getVar('user_countryid')))
		{
			return -1;
		}
		$deleted = GWF_User::DELETED;
		$score = $user->getVar('user_level');
		return $user->countRows("user_options&0x10000000=0 AND user_options&$deleted=0 AND user_level>$score AND user_countryid=$cid") + 1;
	}
	
	public static function calcExactCountryRank(GWF_User $user)
	{
		if ('0' === ($cid = $user->getVar('user_countryid')))
		{
			return -1;
		}
		$deleted = GWF_User::DELETED;
		$rank = self::calcCountryRank($user);
		$score = $user->getVar('user_level');
		$uid = $user->getVar('user_id');
		$rank += $user->countRows("user_options&0x10000000=0 AND user_options&$deleted=0 AND user_level=$score AND user_countryid=$cid AND user_id<$uid");
		return $rank;
	}
	
	public static function calcTotalscores()
	{
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		return GDO::table('GWF_User')->update("user_level=(SELECT IFNULL(SUM(regat_score), 0) FROM $regat WHERE regat_uid=user_id)");
	}
	
	public static function fixPercent(WC_Site $site)
	{
		return true;
		$siteid = $site->getID();
		$maxscore = $site->getOnsiteScore();
		if (false === GDO::table(__CLASS__)->update("regat_solved=regat_onsitescore/$maxscore WHERE regat_sid=$siteid")) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		return true;
	}
	
	public static function fixAllPercents()
	{
		$sites = WC_Site::getSites();
		foreach ($sites as $site)
		{
			if (false === (self::fixPercent($site)))
			{
				return false;
			}
		}
		return true;
	}
	
	###############
	### Display ###
	###############
	public function displayPercent($maxscore)
	{
		return sprintf('%.02f%%', $this->getPercent($maxscore));
	}
	
	public function getPercent($maxscore)
	{
		if ($maxscore <= 0) {
			return 0;
		}
		return $this->getOnsiteScore() / $maxscore * 100;
	}

	public function displayLastDate()
	{
		return GWF_Time::displayDate($this->getVar('regat_lastdate'));
	}

	public function displayOnsiteName($respect_flags=false)
	{
		if ($respect_flags && $this->isOnsitenameHidden()) {
			return false;
		}
		return $this->display('regat_onsitename');
	}
	
	public function displayOnsiteProfileLink(WC_Site $site)
	{
		if ($this->isOnsitenameHidden()) {
			return '['.GWF_HTML::lang('unknown').']';
		}
		
		$onsitename = $this->getVar('regat_onsitename');
		if (!$site->hasProfileURL()) {
			return $onsitename;
		}
		
		$url = $site->getProfileURL($onsitename);
		return GWF_HTML::anchor($url, $onsitename);
	}
	
	#####################
	### Site Tag Bits ###
	#####################
	/**
	 * Repair the site-tag-bits for all regat rows.
	 * @param WC_Site $site
	 * @param unknown_type $bits
	 * @return unknown_type
	 */
	public static function fixTagBits(WC_Site $site, $bits)
	{
		$bits = (int) $bits;
		$siteid = $site->getID();
		return self::table(__CLASS__)->update("regat_tagbits=$bits", "regat_sid=$siteid");
	}
	
	
	###################
	### Get By Rank ###
	###################
	public static function getUserByGlobalRank($rank, $respect_nonrank=true)
	{
		$rank = intval($rank);
		if ($rank < 1) {
			return false;
		}
		$where = $respect_nonrank ? 'user_options&0x10000000=0' : '';
		$users = GDO::table('GWF_User')->selectObjects("*", $where, 'user_level DESC', 1, $rank-1);
		if (count($users) === 1) {
			return $users[0];
		} else {
			return false;
		}
	}
	
	/**
	 * Get a user for an exact site rank.
	 * @param int $siteid
	 * @param int $rank
	 * @return GWF_User
	 */
	public static function getUserBySiteRank($siteid, $rank)
	{
		$siteid = (int)$siteid;
		
		if (0 >= ($rank = (int)$rank)) {
			return false;
		}
		
		$table = GDO::table('WC_RegAt');
		if (false === ($regats = $table->selectObjects('*', "regat_sid=$siteid AND regat_options&4=0", 'regat_solved DESC, regat_uid ASC', 1, $rank-1))) {
			return false;
		}
		if (count($regats) === 1) {
			$regat = $regats[0];
			return GWF_User::getByID($regat->getVar('regat_uid'));
		}
		else {
			return false;
		}
	}
}

?>