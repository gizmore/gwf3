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
			'regat_options' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_lastdate' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'regat_linkdate' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_DAY),
			
			# Cache Scoring v4, these values have been dropped from WC3, or are completely new.
			# The regat row replaces the langid_totalscore table now.
			'regat_solved' => array(GDO::DECIMAL, 0, array(1,8)),
			'regat_score' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_langid' => array(GDO::UINT|GDO::INDEX, 0),
			'regat_tagbits' => array(GDO::UINT|GDO::INDEX, 0), # Query all overlapping tags very fast.
			
			# v4.2
			'regat_onsiterank' => array(GDO::UINT|GDO::INDEX, 0),
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
		return self::table(__CLASS__)->select("regat_uid=$userid", $orderby);
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
		return self::table(__CLASS__)->selectFirst("regat_sid=$siteid AND regat_onsitename='$onsitename'");
	}
	
	/**
	 * 
	 * @param unknown_type $onsitename
	 * @param unknown_type $siteid
	 * @return GWF_User
	 */
	public static function getUserByOnsiteName($onsitename, $siteid)
	{
		$siteid = (int) $siteid;
		$onsitename = self::escape($onsitename);
		if (false === ($regat = self::table(__CLASS__)->selectFirst("regat_sid=$siteid AND regat_onsitename='$onsitename'"))) {
			return false;
		}
		return GWF_User::getByID($regat->getVar('regat_uid'));
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
		
		
		if (defined('WECHALL_CAESUM_PATCH'))
		{
			# Ceasum Patch
			$challcount = $site->getVar('site_challcount');
			$powarg = $site->getPowArg();
			if (false === $regats->update("regat_solved=regat_onsitescore/$maxscore, regat_score=POW((regat_onsitescore/$maxscore),(1+($powarg/$challcount)))*$sitescore ", "regat_sid=$siteid")) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		else
		{
			# Original Code
			if (false === $regats->update("regat_solved=regat_onsitescore/$maxscore, regat_score=(regat_onsitescore/$maxscore)*(regat_onsitescore/$maxscore)*$sitescore ", "regat_sid=$siteid")) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		
		
		
		return false;
		# VERY OLD CODE
//		if (false === ($result = $regats->queryReadAll("regat_sid=$siteid"))) {
//			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
//		}
//		$db = gdo_db();
//		while (false !== ($row = $db->fetchAssoc($result)))
//		{
//			$regat = new self($row);
//			
//			
//			$percent = $maxscore <= 0 ? 0 : ($regat->getOnsiteScore() / $maxscore);
//			
//			$score = $site->calcScore($regat);
//			
//			if (false === $regat->saveVars(array(
//				'regat_score' => $score,
//				'regat_solved' => $percent,
//			))) {
//				break;
//			}
//			
//		}
//		$db->free($result);
//		
//		return false;
	}
	
	/**
	 * Calcs the shared rank. Multiple users can share one rank in theory.
	 * @param GWF_User $user
	 * @return int
	 */
	public static function calcRank(GWF_User $user)
	{
		$score = $user->getVar('user_level');
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
		$score = $user->getVar('user_level');
		$uid = $user->getVar('user_id');
		$rank += $user->countRows("user_level=$score AND user_id<$uid AND user_options&0x10000000=0");
		return $rank;
	}
	
//	public static function calcSiteRank(GWF_User $user, $siteid)
//	{
//		$table = GDO::table('WC_RegAt');
//		return $table->countRows('regat_score>')
//	}
	
	public static function calcExactSiteRank(GWF_User $user, $siteid)
	{
		$userid = $user->getVar('user_id');
		$siteid = (int)$siteid;
		$table = GDO::table('WC_RegAt');
		$myscore = (int) $table->selectVar('regat_score', "regat_sid=$siteid AND regat_uid=$userid");
		return $table->countRows("regat_options&4=0 AND regat_sid=$siteid AND (regat_score>$myscore) OR (regat_score=$myscore AND regat_uid<$userid)")+1;
	}
	
	
	/**
	 * Calcs the shared country rank. Multiple users can share one rank in theory. Return -1 on no country.
	 * @param GWF_User $user
	 * @return int
	 */
	public static function calcCountryRank(GWF_User $user)
	{
		if ('0' === ($cid = $user->getVar('user_countryid'))) {
			return -1;
		}
		$score = $user->getVar('user_level');
		return $user->countRows("user_options&0x10000000=0 AND user_level>$score AND user_countryid=$cid") + 1;
	}
	
	public static function calcExactCountryRank(GWF_User $user)
	{
		if ('0' === ($cid = $user->getVar('user_countryid'))) {
			return -1;
		}
		$rank = self::calcCountryRank($user);
		$score = $user->getVar('user_level');
		$uid = $user->getVar('user_id');
		$rank += $user->countRows("user_options&0x10000000=0 AND user_level=$score AND user_countryid=$cid AND user_id<$uid");
		return $rank;
	}
	
	public static function calcTotalscores()
	{
//		echo GWF_HTML::message('DEBUG', 'RegAt::calcTotalscores()', false);
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		return GDO::table('GWF_User')->update("user_level=(SELECT IFNULL(SUM(regat_score), 0) FROM $regat WHERE regat_uid=user_id)");
//		$db = gdo_db();
//		$users = GDO::table('GWF_User')->getTableName();
//		if (false === ($result = $db->queryRead("SELECT user_id,user_level FROM $users"))) {
//			return false;
//		}
//		while (false !== ($row = $db->fetchAssoc($result)))
//		{
//			self::calcTotalscore(new GWF_User($row));
//		}
//		$db->free($result);
//		return true;
	}
	
	/**
	 * Calculate the totalscore for a user.
	 * @param GWF_User $user
	 * @return boolean
	 */
//	public static function calcTotalscore(GWF_User $user)
//	{
//		$regat = GWF_TABLE_PREFIX.'wc_regat';
//		$userid = $user->getID();
//		return $user->updateRow("user_level=(SELECT IFNULL(SUM(regat_score), 0) FROM $regat WHERE regat_uid=$userid, 0)");
//		$num_linked = array();
//		$totalscores = array();
//		$totalscore = 0;
//		$userid = $user->getID();
//		$regats = self::getRegats($userid);
//		if (count($regats) > 0)
//		{
//		
//			foreach ($regats as $regat)
//			{
//				$site = $regat->getSite();
//				$langid = $site->getLangID();
//				
//				$score = $site->calcScore($regat);
//				
//				$totalscore += $score;
//				
//				if (!isset($totalscores[$langid])) {
//					$num_linked[$langid] = 1;
//					$totalscores[$langid] = $score;
//				} else {
//					$num_linked[$langid]++;
//					$totalscores[$langid] += $score;
//				}
//			}
//			
//			foreach ($totalscores as $langid => $score)
//			{
//				if (false === WC_Scores::updateScore($userid, $langid, $score, $num_linked[$langid])) {
//					echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
//					return false;
//				}
//			}
//			
//		}
//		
//		if (false === $user->saveVar('user_level', $totalscore)) {
//			echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
//			return false;
//		}
//		
//		return true;
//	}
	
	public static function fixPercent(WC_Site $site)
	{
		return true;
		$siteid = $site->getID();
		$maxscore = $site->getOnsiteScore();
		if (false === GDO::table(__CLASS__)->update("regat_solved=regat_onsitescore/$maxscore WHERE regat_sid=$siteid")) {
			echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
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
	public static function getUserByGlobalRank($rank)
	{
		$rank = intval($rank);
		if ($rank < 1) {
			return false;
		}
		$users = GDO::table('GWF_User')->select("", 'user_level DESC', 1, $rank-1);
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
		if (false === ($regats = $table->select("regat_sid=$siteid", 'regat_score DESC, regat_uid ASC', 1, $rank-1))) {
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