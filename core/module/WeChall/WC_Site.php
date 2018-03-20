<?php
require 'WC_SiteBase.php';
/**
 * @author gizmore
 * @version 1.0
 */
class WC_Site extends WC_SiteBase
{
	# Options
	const AUTO_UPDATE = 0x01;
	const HIDE_BY_DEFAULT = 0x02;
	const HAS_LOGO = 0x04;
	const ONSITE_RANK = 0x08;
	const NO_URLENCODE = 0x10;
	const NO_V1_SCRIPTS = 0x20;
	const LINK_CASE_S = 0x40;
	const LINEAR = 0x80;
	
	# Site Status
	const UP = 'up'; # Site is scored, up and running.
	const DOWN = 'down'; # Site is scored, but down.
	const DEAD = 'dead'; # Site is forever down.
	const WANTED = 'wanted'; # Site is unknown / not contacted
	const REFUSED = 'refused'; # Site does not want to participate
	const CONTACTED = 'contacted'; # Site got contacted, no response yet.
	const COMING_SOON = 'coming_soon'; # Site is coming soon
	
	public static $STATES = array('up','down','dead','wanted','refused','contacted','coming_soon');

	# Min score for site votes. (thx awe)
	const MIN_VOTE_SCORE = 700;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_site'; }
	public function getOptionsName() { return 'site_options'; }
	public function getColumnDefines()
	{
		return array(
			'site_id' => array(GDO::AUTO_INCREMENT),
			
			'site_status' => array(GDO::ENUM|GDO::INDEX, self::WANTED, self::$STATES),

			'site_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 32),
			'site_classname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 24),
//			'site_description' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 4096),
			'site_logo_v' => array(GDO::UINT, 0),
		
			'site_country' => array(GDO::OBJECT|GDO::INDEX, 0, array('GWF_Country', 'site_country', 'country_id')),
			'site_language' => array(GDO::OBJECT|GDO::INDEX, 0, array('GWF_Language', 'site_language', 'lang_id')),
		
			'site_joindate' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'site_launchdate' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_DAY),
		
			'site_authkey' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
			'site_xauthkey' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
		
			'site_irc' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
		
			'site_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
			'site_url_mail' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
			'site_url_score' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
			'site_url_profile' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
		
			'site_score' => array(GDO::UINT, 0), # calced score
			'site_basescore' => array(GDO::UINT, 10000),
			'site_avg' => array(GDO::DECIMAL, 0.0, array(5,4)), # calculated average
			# Votes
			'site_dif' => array(GDO::DECIMAL, 3.0, array(5,4)),
			'site_fun' => array(GDO::DECIMAL, 3.0, array(5,4)),
//			'site_vote_dif' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'site_vote_dif')), # votes
//			'site_vote_fun' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'site_vote_fun')), # votes
			'site_vote_dif' => array(GDO::UINT, 0),#GDO::NOT_NULL, array('GWF_VoteScore', 'site_vote_dif')), # votes
			'site_vote_fun' => array(GDO::UINT, 0),#OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'site_vote_fun')), # votes
		
			'site_maxscore' => array(GDO::UINT, 0), # OnSiteScore/MaxScore
			'site_challcount' => array(GDO::INT, 0),
			'site_usercount' => array(GDO::INT, 0),
			'site_linkcount' => array(GDO::UINT, 0),
		
			'site_visit_in' => array(GDO::UINT, 0), # How many visitors go that site 
			'site_visit_out' => array(GDO::UINT, 0), # How many visitors come from that site
			'site_options' => array(GDO::UINT|GDO::INDEX, 0),
		
			'site_boardid' => array(GDO::UINT, 0), # Linked Forumboard
			'site_threadid' => array(GDO::UINT, 0), # Linked Mainthread
		
			'site_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I), # Exploit,Crypto,
			'site_tagbits' => array(GDO::UINT|GDO::INDEX, 0), #0x01a204b (Tags as bits)

			'site_color' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 6),
		
			'site_spc' => array(GDO::UINT, 25),
			'site_powarg' => array(GDO::UINT, 100),
		
			'site_descr_lid' => array(GDO::UINT, 1),
				
			# Warbox
// 			'site_warport' => array(GDO::MEDIUM|GDO::UINT, 113),
// 			'site_warhost' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '', 255),
// 			'site_war_rs' => array(GDO::MEDIUM|GDO::UINT, 1),
// 			'site_war_ip' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, '',  63),
// 			'site_war_wl' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
// 			'site_war_bl' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
// 			'site_wargroup' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		
			'description' => array(GDO::JOIN, NULL, array('WC_SiteDescr', 'site_id', 'site_desc_sid')),
		
		);
	}
	
	###################
	### Convinience ###
	###################
	public function getID() { return $this->getVar('site_id'); }
	public function isNoV1() { return $this->isOptionEnabled(self::NO_V1_SCRIPTS); }
	public function isCaseS() { return $this->isOptionEnabled(self::LINK_CASE_S); }
	public function isLinear() { return $this->isOptionEnabled(self::LINEAR); }
// 	public function isWarBox() { return $this->isOptionEnabled(self::IS_WARBOX); }
// 	public function getWarHost() { return $this->getVar('site_warhost'); } # Warbox host. Can override
// 	public function getWarIP() { return $this->getWarIPCached(); } # Warbox IP
// 	public function getWarPort() { return $this->getVar('site_warport'); } # identd port for warbox
// 	public function getWarReduceScore() { return $this->getVar('site_war_rs'); } # Score reduce for warbox
	public function hasAutoUpdate() { return $this->isOptionEnabled(self::AUTO_UPDATE); }
	public function hasOnSiteRank() { return $this->isOptionEnabled(self::ONSITE_RANK); }
	public function isDefaultHidden() { return $this->isOptionEnabled(self::HIDE_BY_DEFAULT); }
	public function isScored() { $s = $this->getVar('site_status'); return $s === self::UP || $s === self::DOWN; }
	public function getURL() { return $this->getVar('site_url'); }
	public function getStatus() { return $this->getVar('site_status'); }
	public function getSitename() { return $this->getVar('site_name'); }
	public function getBoardID() { return Module_WeChall::instance()->cfgSiteBoardID(); }#return $this->getVar('site_boardid'); }
	public function getThreadID() { return $this->getVar('site_threadid'); }
	public function getLangID() { return $this->getLang()->getID(); }
	public function getLangISO() { return $this->getLang()->getISO(); }
	public function getSolved($onsitescore) { $m = $this->getOnsiteScore(); return $m <= 0 ? 0 : $onsitescore / $m; }
	public function getPercent($onsitescore) { return $this->getSolved($onsitescore) * 100; }
	public function useUrlencode() { return $this->isOptionEnabled(self::NO_URLENCODE) === false; }
	public function isValidWarboxLink(GWF_User $user, $onsitename) { return $user->getVar('user_name') === $onsitename; }
	public function getSiteClassName() { return $this->getVar('site_classname'); }

	/**
	 * @return GWF_Language
	 */
	public function getLang() { return $this->getVar('site_language'); }
	public function getCountryID() { return $this->getCountry()->getID(); }
	/**
	 * @return GWF_Country
	 */
	public function getCountry()
	{
		return $this->getVar('site_country');
	}
	public function getScore() { return $this->getVar('site_score'); }
	public function getBasescore() { return $this->getVar('site_basescore'); }
	public function getAverage() { return (float)$this->getVar('site_avg'); }
	public function getUsercount() { return $this->getVar('site_usercount'); }
	public function getChallcount() { return $this->getVar('site_challcount'); }
	public function getLinkcount() { return $this->getVar('site_linkcount'); }
	public function getOnsiteScore() { return $this->getVar('site_maxscore'); }
	public function getAuthKey() { return $this->getVar('site_authkey'); }
	public function getLinkToken($userid, $onsitename) { return GWF_Password::md5(GWF_SECRET_SALT.$this->getAuthKey().$userid.$this->getID().$onsitename.GWF_SECRET_SALT); }
	public function getTags() { return $this->getVar('site_tags'); }
	public function getTagArray() { return explode(',', $this->getVar('site_tags')); }
	public function getTagBits() { return $this->getVar('site_tagbits'); }
	public function getColor() { return $this->getVar('site_color'); }

	public static function getLangs() {  return self::table(__CLASS__)->selectColumn('DISTINCT(site_language)', 'site_language>0'); }
	public static function getLangISOs()
	{
		$back = array();
		foreach (self::getLangs() as $id => $lang)
		{
			$back[] = GWF_Language::getISOByID($id);
		}
		return $back;
	}
	
	public function displayTags($htmlspecial=true)
	{
		if ('' === ($tags = $this->getVar('site_tags'))) {
			return '';
		}
		$tags = explode(',', $tags);
		$back = '';
		foreach ($tags as $tag)
		{
			$href = GWF_WEB_ROOT.'all_sites/1234-'.urlencode($tag).'/by/page-1';
			if ($htmlspecial) {
				$back .= ', '.GWF_HTML::anchor($href, $tag);
			} else {
				$back .= ', '.sprintf('<a href="%s">%s</a>', GWF_HTML::display($href), $tag);
			}
			
		}
		return substr($back, 2);
	}
	
	public function getLink()
	{
		return GWF_HTML::anchor($this->getURL(), $this->getSitename(), WC_HTML::lang('site_'.$this->getStatus()), 'siteanchor');
	}
	
	/**
	 * @param int $siteid
	 * @return WC_Site
	 */
	public static function getByID($siteid)
	{
		static $cache = array();
		
		$siteid = (int) $siteid;
		if (!isset($cache[$siteid]))
		{
			$cache[$siteid] = self::table(__CLASS__)->getRow($siteid);
		}
		
		return $cache[$siteid];
	}
	
	/**
	 * @param string $url
	 * @return WC_Site
	 */
	public static function getByURL($url)
	{
		return self::table(__CLASS__)->getBy('site_url', $url, GDO::ARRAY_O, array('description', 'site_country', 'site_language'));
	}
	
	/**
	 * Query a site and return the derived class instance.
	 * @param int $siteid
	 * @return WC_Site
	 */
	public static function getByID_Class($siteid)
	{
		if (false === ($site = self::getByID($siteid)))
		{
			return false;
		}
		return $site->getSiteClass();
	}
	
	/**
	 * @return WC_Site
	 */
	public static function getWeChall()
	{
		return self::getByID_Class(1);
	}
	
	/**
	 * @return WC_Site
	 */
	public static function getByName($sitename)
	{
		return self::table(__CLASS__)->getBy('site_name', $sitename);
	}
	
	/**
	 * @return WC_Site
	 */
	public static function getByClassName($classname)
	{
		return self::table(__CLASS__)->getBy('site_classname', $classname);
	}
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotesDif()
	{
		return GWF_VoteScore::getByID($this->getVar('site_vote_dif', 0));
	}
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotesFun()
	{
		return GWF_VoteScore::getByID($this->getVar('site_vote_fun', 0));
	}
	
	/**
	 * @return GWF_ForumBoard
	 */
	public function getBoard()
	{
		return GWF_ForumBoard::getBoard($this->getVar('site_boardid'));
	}
	
	/**
	 * @return GWF_ForumThread
	 */
	public function getThread()
	{
		return GDO::table('GWF_ForumThread')->getRow($this->getVar('site_threadid'));
	}

	/**
	 * Status to ?which= param
	 * @return int
	 */
	public function getTypeID()
	{
		switch ($this->getStatus())
		{
			case 'refused': return 4;
			case 'wanted': case 'contacted': case 'coming_soon': return 3;
			case 'dead': return 2;
			case 'up': case 'down': default: return 1;
		}
	}
	
	public function getBoxCount()
	{
		Module_WeChall::instance()->includeClass('WC_Warbox');
		return WC_Warbox::getBoxCount($this);
	}
	
	##############
	### Static ###
	##############
	public static function getActiveSites()
	{
		static $cache = true;
		if ($cache === true)
		{
			$cache = GDO::table('WC_Site')->selectObjects('*', "site_status='up'", 'site_joindate DESC');
		}
		return $cache;
	}
	
	public static function getSites($orderby='site_name ASC') { return self::table(__CLASS__)->selectObjects('*', '', $orderby); }
	
	public static function getSitesRanked($orderby='site_name ASC') { return self::table(__CLASS__)->selectObjects('*', "site_status='up' OR site_status='down'", $orderby); }
	
	/**
	 * Get all sites for a user which are not linked to the user.
	 * @param unknown_type $userid
	 * @return unknown_type
	 */
	public static function getUnlinkedSites($userid)
	{
		$userid = (int) $userid;
		$regat = GDO::table('WC_Regat')->getTableName();
		return GDO::table(__CLASS__)->selectObjects('*', "(IF((SELECT 1 FROM $regat WHERE regat_sid=site_id AND regat_uid=$userid), 0, 1)) AND site_status='up'", "site_name ASC");
	}
	
	public static function getLinkedSites($userid, $orderby='site_name ASC')
	{
		$userid = (int) $userid;
		$regat = GDO::table('WC_Regat')->getTableName();
		return GDO::table(__CLASS__)->selectObjects('*', "(IF((SELECT 1 FROM $regat WHERE regat_sid=site_id AND regat_uid=$userid), 1, 0))", $orderby);
	}
	
	public static function getLinkedSitesVS2($userid1, $userid2)
	{
		$userid1 = (int) $userid1;
		$userid2 = (int) $userid2;
		$regat = GDO::table('WC_Regat')->getTableName();
		return GDO::table(__CLASS__)->selectObjects('*', "(IF((SELECT 1 FROM $regat WHERE regat_sid=site_id AND (regat_uid=$userid1 OR regat_uid=$userid2) ), 1, 0))", "site_name ASC");
	}
	
	public static function getQuickUpdateSites($userid)
	{
		$userid = (int) $userid;
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$au = self::AUTO_UPDATE;
		return GDO::table(__CLASS__)->selectObjects('*', "site_options&$au=0 AND (IF((SELECT 1 FROM $regat WHERE regat_sid=site_id AND regat_uid=$userid), 1, 0))");
	}
	
	public function getSimilarSites($active_only=false)
	{
		$bits = $this->getTagBits();
		$sid = $this->getVar('site_id');
		$activeQuery = $active_only ? "site_status='up' OR site_status='down'" : '1'; 
		return self::table(__CLASS__)->selectObjects('*', "site_tagbits&$bits AND site_id!=$sid AND ($activeQuery)", "site_joindate ASC");
	}
	
	public static function getSimilarSitesS($bits, $active_only=false)
	{
		$bits = (int) $bits;
		$activeQuery = $active_only ? "site_status='up' OR site_status='down'" : '1'; 
		return self::table(__CLASS__)->selectObjects('*', "site_tagbits&$bits AND ($activeQuery)", "site_joindate ASC");
	}
	
	public static function validateSiteID($siteid)
	{
		return false === (self::getByID($siteid)) ? WC_HTML::lang('err_site') : false;
	}
	
	########################
	### Regat Link Count ###
	########################
	private static function getLinkCountQuery()
	{
		$regat = self::table('WC_RegAt')->getTableName();
		return "site_linkcount=(SELECT COUNT(*) FROM $regat WHERE regat_sid=site_id)";
	}
	public function fixLinkCount()
	{
		$this->updateRow(self::getLinkCountQuery());
	}
	public static function fixAllLinkCounts()
	{
		return self::table(__CLASS__)->update(self::getLinkCountQuery());
	}
	
	###############
	### Display ###
	###############
	public function displayScore() { return $this->isScored() ? $this->getVar('site_score') : ''; }
	public function displayIRC()
	{
		GWF_Module::loadModuleDB('Chat', true);
		$back = '';
		foreach (explode(',', $this->getVar('site_irc')) as $url)
		{
			if ('' === ($url = trim($url))) {
				continue;
			}
			$back .= sprintf(', %s%s', $this->displayIRCURL($url), $this->displayMibbitURL($url));
		}
		return $back === '' ? '' : substr($back, 2);
	}
	private function displayIRCURL($url)
	{
		$url = htmlspecialchars($url);
		return sprintf('<a href="%s">%s</a>', $url, $url);
	}
	private function displayMibbitURL($url)
	{
		$href = Module_Chat::getMibbitURL($url);
//		$href = GWF_WEB_ROOT.'index.php?mo=Chat&me=MibbitCustom&url='.urlencode($url);
		return GWF_Button::link($href, 'foo');
	}
	
	public function displayName() { return $this->display('site_name'); }
	public function displayCountry()
	{
		return $this->getCountry()->displayFlag();
	}
	
	public function displayLanguage()
	{
		return $this->getLang()->displayName();
	}

	public function displayLink()
	{
		return $this->getLink();
	}
	
	public function displayVoteValue($value)
	{
		$percent = ($value-1)*25;
		return sprintf('<b style="color:#%s;">%.02f%%</b>', WC_HTML::getColorForPercent($percent), $percent);
	}
	
	public function displayAvg()
	{
		return sprintf('<b>%.02f%%</b>', $this->getVar('site_avg')*100);		
	}
	
	public function displayDif()
	{
		return $this->displayVoteValue($this->getVar('site_dif'));
	}
	
	public function displayFun()
	{
		return $this->displayVoteValue($this->getVar('site_fun'));
	}
	
	public function isSiteAdmin(GWF_User $user)
	{
		return WC_SiteAdmin::isSiteAdmin($user->getVar('user_id'), $this->getID()); 
	}
	
	public function getEditButton(Module_WeChall $module, $user)
	{
		if ($user === false) {
			return '';
		}
		if ($user->isAdmin() || $this->isSiteAdmin($user)) {
			return GWF_Button::edit($this->hrefEdit(), $module->lang('ft_edit_site', array($this->displayName())));
		}
		return '';
	}
	
	public function displaySiteAdmins()
	{
		$back = '';
		$admins = WC_SiteAdmin::getSiteAdmins($this->getID());
		foreach ($admins as $admin)
		{
			$admin = $admin->getUser();
			$back .= ', '.GWF_HTML::anchor($admin->getProfileHREF(), $admin->displayUsername());
		}
		return $back === '' ? $back : substr($back, 2);
	}
	
	
	public function hasLogo()
	{
		return $this->isOptionEnabled(self::HAS_LOGO);
	}
		
	public function displayLogo($size=32, $hovertext=false, $glow=false, $pad=false, $username='[LOGO]')
	{
		if ($glow === true)
		{
			$glow = ' border: 3px groove #FE0;';
			$size -= 6;
		}
		else {
			$glow = '';
		}
		
		if ($pad === false) {
			$pad = '';
		} else {
			$size = $size - ($size%2);
			$padsize = intval( ($pad - $size) / 2 );
			if ($glow !== '') {
				$padsize -= 3;
			}
			$pad = ' padding: '.$padsize.'px;';
		}
		
		$hovertext = $hovertext === false ? $this->displayName() : $hovertext;
		
		return sprintf('<img class="wc_logo" src="%s" title="%s" alt="%s" style="width: %spx; height:%spx;%s%s" />', $this->getLogoHREF(), $hovertext, $username, $size, $size, $glow, $pad);
	}
	
	public function getLogoHREF()
	{
		return GWF_WEB_ROOT.'dbimg/logo/'.$this->getVar('site_id').'?'.$this->getVar('site_logo_v');
	}
	
	/**
	 * Display logo for a user.
	 * @param GWF_User $user
	 * @param unknown_type $solved
	 * @param unknown_type $min
	 * @param unknown_type $max
	 * @param unknown_type $pad
	 * @return unknown_type
	 */
	public function displayLogoU(GWF_User $user, $solved, $min=2, $max=32, $pad=false)
	{
		$username = $user->displayUsername();
		return $this->displayLogoUN($user->displayUsername(), $solved, $min, $max, $pad);
	}
	
	/**
	 * Display logo for a username.
	 * @param unknown_type $username
	 * @param unknown_type $solved
	 * @param unknown_type $min
	 * @param unknown_type $max
	 * @param unknown_type $pad
	 * @return unknown_type
	 */
	public function displayLogoUN($username, $solved, $min=2, $max=32, $pad=false)
	{
		$percent = round($solved*100, 2);
		$text = WC_HTML::lang('logo2_hover', array($username, $percent, $this->displayName()));
		return $this->displayLogoUNT($username, $solved, $min, $max, $pad, $text);
	}

	/**
	 * Display a logo for a username with text.
	 * @param unknown_type $username
	 * @param unknown_type $solved
	 * @param unknown_type $min
	 * @param unknown_type $max
	 * @param unknown_type $pad
	 * @param unknown_type $text
	 * @return unknown_type
	 */
	public function displayLogoUNT($username, $solved, $min=2, $max=32, $pad=false, $text)
	{
		$size = round( (($max-$min)*$solved)+$min );
		return $this->displayLogo($size, $text, $solved>=1.0, $pad===false?false:$max, $username);
	}
	
	public function displayStatus()
	{
		$color = $this->isUp() ? 'green' : 'red';
		$text = WC_HTML::lang('site_dot_'.$color);
		return sprintf('<img src="%stpl/wc4/img/dot_%s.png" alt="%s" title="%s" />', GWF_WEB_ROOT, $color, $text, $text);
	}
	
	/**
	 * Display Icon for 0.0-1.0 solved and a max/minsize
	 * @param float $solved
	 */
	public function displayIcon($solved=1.0, $min=6, $max=24, $glow=false)
	{
		$size = $min + round(($max-$min)*$solved);
		return $this->displayLogo($size, $this->displayName().'&nbsp;Logo', $glow);
	}
	
	public function isUp()
	{
		return $this->getStatus() === 'up';
	}
		
	public function isDown()
	{
		return $this->getStatus() === 'down';
	}
	
	public function displayAutoUpdate()
	{
		return $this->displayYesNo($this->hasAutoUpdate());
	}
	
	public function displayOnSiteRank()
	{
		return $this->displayYesNo($this->hasOnSiteRank());
	}
	
	private function displayYesNo($bool)
	{
		$color = $bool === true ? '090' : 'f00';
		return sprintf('<b style="color:#%s;">%s</b>', $color, WC_HTML::lang(($bool === true ? 'yes' : 'no')));
	}
	
	#############
	### HREFs ###
	#############
	public function hrefGraphScore() { return GWF_WEB_ROOT.'score_graph/for/'.$this->urlencode2('site_name'); }
	public function hrefGraphUsers() { return GWF_WEB_ROOT.'usercount_graph/for/'.$this->urlencode2('site_name'); }
	public function hrefGraphChalls() { return GWF_WEB_ROOT.'challcount_graph/for/'.$this->urlencode2('site_name'); }
	public function hrefDetail() { return GWF_WEB_ROOT.'site/details/'.$this->getVar('site_id').'/'.$this->urlencodeSEO('site_name'); }
	public function hrefRanking() { return GWF_WEB_ROOT.'site/ranking/for/'.$this->getVar('site_id').'/'.$this->urlencodeSEO('site_name'); }
	public function hrefEdit() { return GWF_WEB_ROOT.sprintf('site/edit/%s/%s', $this->getVar('site_id'), $this->urlencodeSEO('site_name')); }
	public function hrefLogo() { return GWF_WEB_ROOT.'dbimg/logo/'.$this->getVar('site_id'); }
	public function hrefHistory() { return GWF_WEB_ROOT.'site/history/'.$this->urlencode2('site_name'); }
	public function hrefWarboxes() { return GWF_WEB_ROOT.sprintf('%s-wargames-on-%s.html', $this->getID(), $this->urlencodeSEO('site_name')); }

	####################################
	### Creation of Votes And Thread ###
	####################################
	public function onCreateSite(Module_WeChall $module, &$back='')
	{
		if (!$this->insert()) {
			$back = GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!self::onCreateVotes()) {
			$back = GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!self::onCreateBoard()) {
			$back = GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!GWF_ForumBoard::init(true, true) || !self::onCreateThread($module)) {
			$back = GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else {
			return true; 
		}
		return false;
	}
	
	public function onCreateVotes()
	{
		$sid = $this->getID();
		
		if (false === ($votes = Module_Votes::installVoteScoreTable('site_dif_'.$sid, 1, 5, false, false, GWF_VoteScore::SHOW_RESULT_ALWAYS))) {
			return false;
		}
		else {
			$this->saveVar('site_vote_dif', $votes->getID());
			$this->setVar('site_vote_dif', $votes);
		}
		
		if (false === ($votes = Module_Votes::installVoteScoreTable('site_fun_'.$sid, 1, 5, false, false, GWF_VoteScore::SHOW_RESULT_ALWAYS))) {
			return false;
		}
		else {
			$this->saveVar('site_vote_fun', $votes->getID());
			$this->setVar('site_vote_fun', $votes);
		}
		return true;
	}
	
	public function onCreateBoard()
	{
		return $this->saveVar('site_boardid', $this->getBoardID());
	}

	public function onCreateThread(Module_WeChall $module)
	{
		if (false !== ($thread = $this->getThread()))
		{
			return true;
		}
		
		$title = 'Comments on '.$this->getSitename();
		$options = GWF_ForumThread::GUEST_VIEW;
		$thread = GWF_ForumThread::fakeThread($module->cfgWeChallUser(), $title, $this->getBoardID(), 0, 0, $options);
		if (false === ($thread->insert())) {
			return false;
		}
		if (false === $this->saveVar('site_threadid', $thread->getID())) {
			return false;
		}
		
		return $thread->onApprove(false, 0);
	}
	
	####################
	### Update Votes ###
	####################
	/**
	 * @param int $vsid
	 * @return WC_Site
	 */
	public static function getByVSID($vsid)
	{
		$vsid = (int)$vsid;
		return self::table(__CLASS__)->selectFirstObject('*', "site_vote_dif=$vsid OR site_vote_fun=$vsid");
	}
	
	private static function getRecalcVoteQuery()
	{
		$votes = GDO::table('GWF_VoteScore')->getTableName();
		return "site_dif=(SELECT vs_avg FROM $votes WHERE vs_id=site_vote_dif), site_fun=(SELECT vs_avg FROM $votes WHERE vs_id=site_vote_fun)";
	}
	
	public function onRecalcVotes()
	{
		$this->deleteInvalidVotes();
		return $this->updateRow(self::getRecalcVoteQuery());
	}
	
	public static function onRecalcAllVotes()
	{
		return GDO::table(__CLASS__)->update(self::getRecalcVoteQuery());
	}

	/**
	 * Delete all votes that have less than 20% solved. (thx awe)
	 */
	private function deleteInvalidVotes()
	{
		$min_score = self::MIN_VOTE_SCORE;
		
		$sid = $this->getID();
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		
		$votes = $this->getVotesDif();
		$vsid = $this->getVar('site_vote_dif');
		GDO::table('GWF_VoteScoreRow')->deleteWhere("vsr_vsid=$vsid AND (SELECT 1 FROM $regat WHERE regat_sid=$sid AND regat_uid=vsr_uid AND regat_score<$min_score)", '', array('users'));
		$votes->refreshCache();
		
		$votes = $this->getVotesFun();
		$vsid = $this->getVar('site_vote_fun');
		GDO::table('GWF_VoteScoreRow')->deleteWhere("vsr_vsid=$vsid AND (SELECT 1 FROM $regat WHERE regat_sid=$sid AND regat_uid=vsr_uid AND regat_score<$min_score)", '', array('users'));
		$votes->refreshCache();
		
		return true;
	}
	
	public function canVote(GWF_User $user)
	{
		if (false === ($regat = WC_RegAt::getRegatRow($user->getID(), $this->getID())))
		{
			return false;
		}
		return $regat->getVar('regat_score') >= self::MIN_VOTE_SCORE;
	}
	
	########################
	### Update / Scoring ###
	########################
// 	/**
// 	 * Override this method for scoring. Returns array($onsitescore, $onsiterank, $challssolved)
// 	 * @param $url
// 	 * @return array
// 	 */
// 	public function parseStats($url)
// 	{
// 		echo WC_HTML::error('err_parse_stub', array(__CLASS__));
// 		return array(0, -1, 0, 0, -1, 0);
// 	}
	
	/**
	 * Update Site Stats.
	 * Create a history event in case something changed.
	 * @param int $maxscore
	 * @param int $usercount
	 * @param int $challcount
	 * @return boolean
	 */
	public function updateSite($maxscore, $usercount, $challcount)
	{
		$maxscore = (int) $maxscore;
		$usercount = (int) $usercount;
		$challcount = (int) $challcount;
		
// 		$maxscore += $this->getWarboxMaxScore();
// 		$challcount += $this->getWarboxChallCount();
		
		if (($this->getOnsiteScore() === $maxscore) && ($this->getUsercount() === $usercount) && ($this->getChallcount() === $challcount))
		{
			return true; # no change
		}
		
		$need_recalc = $this->getOnsiteScore() !== $maxscore;
		
		if (false === $this->saveVars(array(
			'site_maxscore' => $maxscore,
			'site_usercount' => $usercount,
			'site_challcount' => $challcount,
		))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$this->recalcAverage();
		$this->recalcScore();
		WC_RegAt::calcSite($this);
		
		return true;
	}
	
// 	private function getWarboxMaxScore()
// 	{
// 		$boxes = WC_Warbox::getBoxes($this);
// 		foreach ($boxes as $box)
// 		{
// 			$box instanceof WC_Warbox;
// 		}
// 		return 0;
// 	}
	
// 	private function getWarboxChallCount()
// 	{
// 		return 0;
// 	}
	
	/**
	 * Check if EMail+Username exists on the site.
	 * @return boolean
	 */
	public function isAccountValid($onsitename, $onsitemail)
	{
		if ($this->isNoV1())
		{
			return true;
			//$url = $this->getWarboxAccountURL($onsitename, $onsitemail);
		}
		else
		{
			$url = $this->getAccountURL($onsitename, $onsitemail);
		}
		
		$result = GWF_HTTP::getFromURL($url, false);
		$result = str_replace("\xEF\xBB\xBF", '', $result); # BOM
		$result = trim($result);
		
		if (WECHALL_DEBUG_LINKING)
		{
			var_dump('SECRET URL:');
			var_dump($url);
			var_dump('LINK RESULT:');
			var_dump($result);
// 			$len = strlen($result);
// 			for ($i = 0; $i < $len; $i++)
// 			{
// 				echo sprintf(' %02X', ord($result{$i}));
// 			}
		}

		return $result > 0;
	}
	
	public function getScoreURL($onsitename)
	{
// 		$score_part = $this->replaceURL($this->getVar('site_url_score'), urlencode($onsitename));
		$score_part = $this->replaceURL($this->getVar('site_url_score'), $onsitename);
		if (Common::startsWith($score_part, 'http'))
		{
			return $score_part;
		}
		return $this->getVar('site_url').'/'.$score_part;
	}
	
	public function getAccountURL($onsitename, $onsitemail)
	{
// 		$mail_part = $this->replaceURL($this->getVar('site_url_mail'), urlencode($onsitename), urlencode($onsitemail));
		$mail_part = $this->replaceURL($this->getVar('site_url_mail'), $onsitename, $onsitemail);
		if (Common::startsWith($mail_part, 'http'))
		{
			return $mail_part;
		}
		return $this->getVar('site_url').'/'.$mail_part;
	}
	
	public function hasProfileURL()
	{
		return $this->getVar('site_url_profile') !== '';
	}
	
	public function getProfileURL($onsitename)
	{
		$profile_part = $this->replaceURL($this->getVar('site_url_profile'), urlencode($onsitename));
		if (Common::startsWith($profile_part, 'http'))
		{
			return $profile_part;
		}
		return $this->getVar('site_url').'/'.$profile_part;
	}
	
	/**
	 * get replaced URL.
	 * Substituting username, email and authkey.
	 * @param unknown_type $url
	 * @param unknown_type $username
	 * @param unknown_type $email
	 * @return unknown_type
	 */
	private function replaceURL($url, $username, $email='')
	{
		if ($this->useUrlencode())
		{
			$username = urlencode($username);
			$email = urlencode($email);
		}
		return str_replace(array('%USERNAME%', '%EMAIL%', '%AUTHKEY%'), array($username, $email, $this->getVar('site_xauthkey')), $url);
	}
	
	/**
	 * Get the site as derived class (WCSite_TBS for example)
	 * @return WC_Site
	 */
	public function getSiteClass()
	{
		$classname = 'WCSite_'.$this->getVar('site_classname');
		
		$pathes = array('sites', 'sites/english', 'sites/french', 'sites/german', 'sites/korean', 'sites/polish', 'sites/spanish');
		
		foreach ($pathes as $path)
		{
			$path = sprintf(GWF_CORE_PATH.'module/WeChall/%s/%s.php', $path, $classname);
			if (file_exists($path))
			{
				require_once $path;
				if (!class_exists($classname))
				{
					echo GWF_HTML::err('ERR_CLASS_NOT_FOUND', array($classname));
					return false;
				}
				else
				{
					return new $classname($this->getGDOData());
				}
			}
		}

	// 		if ($this->isWarBox())
// 		{
		# New default site, handles warbox, warflags, and the reference implementation of old scorescript.	
		require_once GWF_CORE_PATH.'module/WeChall/sites/warbox/WCSite_WARBOX.php';
		return new WCSite_WARBOX($this->getGDOData());
// 		}
		
// 		echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array($path));
// 		return false;
	}
	
	public function recalcAvg()
	{
		$avg = GDO::table('WC_RegAt')->selectVar('AVG(regat_onsitescore)', 'regat_sid='.$this->getID());
		return $this->saveVar('site_avg', $avg);
	}
	
	/**
	 * Try to update a user for a site.
	 * Seems like we update the response from a site for a regat. 
	 * There is always a text message returned as GWF_Result.
	 * @param GWF_User $user
	 * @param boolean $recalc_scores
	 * @return GWF_Result
	 */
	public function onUpdateUser(GWF_User $user, $recalc_scores=true, $onlink=false)
	{
		require_once 'WC_RegAt.php';
		
		if (!$this->isUp()) {
			return new GWF_Result(WC_HTML::lang('err_site_down', array($this->displayName())), true);
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow($user->getID(), $this->getID()))) {
			return new GWF_Result(WC_HTML::lang('err_notlinkedwc'), false);
		}
		
		if (false === ($site = $this->getSiteClass())) {
			return new GWF_Result(GWF_HTML::lang('ERR_GENERAL', array(__FILE__, __LINE__)), true);
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow($user->getID(), $this->getID()))) {
			return new GWF_Result(WC_HTML::lang('err_not_linked', array($this->displayName())), true);
		}

		# Collect before information for push notification
		if ($onlink)
		{
			$before = NULL;
		} else {
			$before = array(
				'site_challs' => $regat->getVar('regat_challsolved'),
				'site_rank' => $regat->getOnsiteRank(),
				'site_score' => $regat->getOnsiteScore(),
				'wechall_site_rank' => WC_RegAt::calcExactSiteRank($user, $this->getID()),
				# 'wechall_site_score' is calculated in onUpdateUserB
				'wechall_rank' => WC_RegAt::calcExactRank($user),
				'wechall_score' => $user->getVar('user_level'),
				);
		}

		# Get new stats
		$url = $this->getScoreURL($regat->getVar('regat_onsitename'));
		
		if ($this->isNoV1())
		{
			// score, rank, challssolved, maxscore, usercount, challcount
			$stats = array(0, -1, 0, 0, -1, 0);
		}
		else
		{
			if (WECHALL_DEBUG_LINKING)
			{
				var_dump('SECRET URL:');
				var_dump($url);
			}
			$stats = $site->parseStats($url);
		}
		
		if (!is_array($stats))
		{
			return new GWF_Result(WC_HTML::lang('err_site_down', array($this->displayName())), true);
		}
		
		# Sum points from warboxes and warflags
		$this->onUpdateUserWarboxWarflag($user, $stats);

		# Save new base stats
		$this->updateSite($stats[3], $stats[4], $stats[5]);
		
		# OnsiteScore Change
		$new_score = Common::clamp((int)$stats[0], 0, $site->getOnsiteScore());
		$onsiterank = Common::clamp((int)$stats[1], -1);
		$challs_solved = (int) $stats[2];
		
		# Save OSR flag
		$newosr = $onsiterank >= 0;
		$oldosr = $this->isOptionEnabled(self::ONSITE_RANK);
		if ($newosr !== $oldosr) {
			if (WECHALL_DEBUG_LINKING)
			{
				echo GWF_HTML::message('WeChall', sprintf('The onsiterank flag for %s has been changed to %s', $this->displayName(), (int)$newosr));
			}
			$this->saveOption(self::ONSITE_RANK, $newosr);
		}
		
		if ($onsiterank >= 0) {
			if (WECHALL_DEBUG_SCORING)
			{
				echo GWF_HTML::message('WeChall', sprintf('Saving onsiterank %d for %s on %s', $onsiterank, $user->displayUsername(), $this->displayName()));
			}
			$regat->saveVar('regat_onsiterank', $onsiterank);
		}
		
		// if onlink is false and we have a 0 score, do not update further.
		if ( ($new_score != $regat->getOnsiteScore()) || ($onlink === true && $new_score==0 ) ) {
			// do update events...
			return $site->onUpdateUserB($user, $regat, $new_score, $recalc_scores, $onlink, $challs_solved, $before);
		}
		
		return new GWF_Result(WC_HTML::lang('msg_no_change'), false);
	}
	
	/**
	 * Update new scoring shemes. Warboxes and Warflags.
	 * @param GWF_User $user
	 * @param array $stats
	 */
	public function onUpdateUserWarboxWarflag(GWF_User $user, array &$stats)
	{
		Module_WeChall::instance()->includeClass('WC_Warbox');
		
		$boxes = WC_Warbox::getBoxes($this);
		
		if (count($boxes) > 0)
		{
// 			$this->parseMultiStats($user, $stats);
			
			Module_WeChall::instance()->includeClass('WC_Warflag');
			Module_WeChall::instance()->includeClass('WC_Warflags');
			Module_WeChall::instance()->includeClass('sites/warbox/WCSite_WARBOX');
			
			foreach ($boxes as $box)
			{
				$box instanceof WC_Warbox;
				if ($box->isUp())
				{
					$box->parseFlagStats($user, $stats);
// 					$box->parseWarboxStats($user, $stats);
				}
			}
		}
	}
	
	/**
	 * A score change occured for this site/regat,
	 * thus we need to recalc all scores influenced by this site. (or skip that part on DDOS)
	 * @param GWF_User $user
	 * @param WC_RegAt $regat
	 * @param int $new_score
	 * @param boolean $recalc_scores
	 * @param boolean $onlink
	 * @param array $before contains information for push notification; should be NULL iff $onlink
	 * @return GWF_Result
	 */
	public function onUpdateUserB(GWF_User $user, $regat, $new_score, $recalc_scores=true, $onlink=false, $challs_solved=-1, $before=NULL)
	{
		$old_score = $regat->getOnsiteScore();
		$old_totalscore = $this->calcScore($regat);
		$max = $this->getOnsiteScore();
		if ($max <= 0)
		{
			$solved = $old_solved = 0;
		}
		else {
			$solved = $new_score / $max;
			$old_solved = $old_score / $max;
		}
		$regat->saveVars(array(
			'regat_solved' => $solved,
			'regat_onsitescore' => $new_score,
			'regat_lastdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'regat_challsolved' => $challs_solved,
		));
		if ($recalc_scores)
		{
			$this->recalcSite();
		}
		$new_totalscore = $this->calcScore($regat);
		$scoregain = $new_totalscore - $old_totalscore;
		
		# Insert into User History
		$comment = $this->getUserHistComment($old_score, $new_score, $onlink, $scoregain);
		$user = GWF_User::getByID($user->getID());
		require_once 'WC_HistoryUser2.php';
		$type = $this->getUserHistType($old_score, $new_score, $onlink);
		
		if (false === WC_HistoryUser2::insertEntry($user, $this, $type, $new_score, $old_score, $scoregain, $regat->getVar('regat_onsiterank'))) {
			return new GWF_Result(GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__)), true);
		}

		require_once 'WC_SiteMaster.php';
		if ($solved >= 1.0)
		{
			WC_SiteMaster::markSiteMaster($user->getID(), $this->getID());
		}
		elseif ($old_solved >= 1.0)
		{
			WC_SiteMaster::unmarkSiteMaster($user->getID(), $this->getID(), $solved);
		}
		
		# Send push notification
		require_once 'WC_PushNotification.php';
		if (isset($before))
		{
			$before['wechall_site_score'] = $old_totalscore;
		}
		$after = array(
			'site_challs' => $challs_solved,
			'site_rank' => $regat->getOnsiteRank(),
			'site_score' => $new_score,
			'wechall_site_rank' => WC_RegAt::calcExactSiteRank($user, $this->getID()),
			'wechall_site_score' => $new_totalscore,
			'wechall_rank' => WC_RegAt::calcExactRank($user),
			'wechall_score' => $user->getVar('user_level'),
			);
		WC_PushNotification::pushUserSiteUpdate($user, $this, $before, $after);

		return new GWF_Result(GWF_HTML::lang('You').' '.GWF_HTML::display($comment), false);
	}
	
	private function getUserHistType($old_score, $new_score, $onlink)
	{
		if ($onlink === true)
		{
			return 'link';
		}
		return $new_score > $old_score ? 'gain' : 'lost';
	}
	
	/**
	 * Get a user history comment. currently they are english only :(
	 * @param unknown_type $old_score
	 * @param unknown_type $new_score
	 * @param unknown_type $onlink
	 */
	private function getUserHistComment($old_score, $new_score, $onlink=false, $scoregain=0)
	{
		$sitename = $this->getVar('site_name');
		$maxscore = $this->getOnsiteScore();
		
		if ($onlink && $new_score==0)
		{
			return sprintf('linked an account to %s.', $sitename);
		}
		elseif ($onlink)
		{
			$percent = $maxscore == 0 ? 0 : $new_score / $maxscore * 100;
			return sprintf('linked an account to %s with %.02f%% solved (+%d points).', $sitename, $percent, $scoregain);
		}
		else
		{
			$gain = $new_score - $old_score;
			$dir = $gain > 0 ? 'gained' : 'lost';
			$percent = $maxscore == 0 ? 0 : $gain / $maxscore * 100;
			return sprintf('%s %.02f%% (%d points) on %s.', $dir, $percent, $scoregain, $sitename);
		}
	}

	/**
	 * Recalculate and save the average solved.
	 * @return unknown_type
	 */
	private function recalcAverage()
	{
		if (0 >= ($max = $this->getVar('site_maxscore')))
		{
			$avg = 0;
		}
		else
		{
			$sid = $this->getVar('site_id');
			$avg = GDO::table('WC_RegAt')->selectVar('AVG(regat_onsitescore)', "regat_sid=$sid AND regat_onsitescore>0");
			$avg /= $max;
		}

		return $this->saveVar('site_avg', $avg);
	}
	
	/**
	 * Recalc the score for this site.
	 * @return boolean
	 */
	private function recalcScore()
	{
		if ($this->isLinear())
		{
			$wc = Module_WeChall::instance();
			$wc->includeClass('WC_Warbox');
			$wc->includeClass('WC_Warflag');
			$basescore = WC_Warflag::getTotalscoreForSite($this);
			if ($this->isNoV1())
			{
// 				WC_RegAt::calcTotalscores()
			}
		}
		
		else
		{
			$basescore = $this->getBasescore();
			$average = $this->getAverage();
			$challcnt = $this->getChallcount();
			$spc = $this->getVar('site_spc');
			
			$basescore += $spc * $challcnt;
			
			$basescore += $basescore - $average * $basescore;
			
			$basescore = intval(round($basescore));
		}
		
		if ($basescore !== $this->getVar('site_score'))
		{
			require_once 'WC_HistorySite.php';
			if (false === WC_HistorySite::insertEntry($this->getID(), $this->getScore(), $this->getUsercount(), $this->getChallcount()))
			{
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				return false;
			}
			return $this->saveVar('site_score', $basescore);
		}
		return true;
	}
	
	public function onLinkUser(GWF_User $user)
	{
		if (false === ($regat = WC_RegAt::linkUser($user->getID(), $this->getID())))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
	}
	
	###############
	### Scoring ###
	###############
	/**
	 * Calculate the % solved (0-1)
	 * @param WC_Regat $regat
	 * @return double
	 */
	public function calcPercent(WC_Regat $regat)
	{
		if ('0' === ($maxscore = $this->getOnsiteScore()))
		{
			return 0;
		}
		return $regat->getOnsiteScore() / $maxscore;
	}
	
	/**
	 * Calculate the points for a regat entry.
	 * @param WC_RegAt $regat
	 * @return int
	 */
	public function calcScore(WC_RegAt $regat)
	{
		# 0.00 - 1.00
		$solved = $this->calcPercent($regat);

		$fullscore = $this->getScore();
		
		# Exponential adjustment
		# ORIGINAL CODE
		if (!defined('WECHALL_CAESUM_PATCH'))
		{
			$solved = $solved * $solved;
		}
		
		# Strictly Linear CTF
		elseif ($this->isLinear())
		{
			return $regat->getOnsiteScore();
		}
		
		# Caesum Patch
		else
		{
			$challcount = $this->getVar('site_challcount');
			$powarg = $this->getPowArg();
			if ($challcount == 0)
			{
				$solved = 0;
			}
			else
			{
				$solved = Common::pow($solved, (1+($powarg/$challcount)));
			}
		}
				
		return round($fullscore * $solved);
	}
	
	public function getPowArg()
	{
		return $this->getVar('site_powarg');
	}
	
	/**
	 * Recalc and update all scores for this site.
	 * @return void
	 */
	public function recalcSite()
	{
		require_once 'WC_RegAt.php';
		if (WECHALL_DEBUG_SCORING)
		{
			echo WC_HTML::message('msg_site_recalc', array($this->displayName()));
		}
		$this->recalcAverage();
		$this->recalcScore();
		WC_RegAt::calcSite($this);
		WC_RegAt::calcTotalscores();
	}

	public static function recalcAllSites()
	{
//		echo WC_HTML::message('msg_sites_recalc');
		$sites = self::getSites();
		{
			foreach ($sites as $site)
			{
				$site instanceof WC_Site;
				$site->recalcSite();
			}
		}
		
	}

	public function isUserLinked($userid)
	{
		return WC_RegAt::getRegatRow($userid, $this->getID()) !== false;
	}
	
	/**
	 * Get all sites for a language.
	 * @param int $langid
	 * @return array
	 */
	public static function getSitesLang($langid)
	{
		$langid = (int) $langid;
		return self::table(__CLASS__)->selectObjects('*', "site_language=$langid AND (site_status='up' OR site_status='down')", 'site_joindate ASC');
	}
	
	/**
	 * Get all languages that are used by the sites.
	 * @return array
	 */
	public static function getLanguages()
	{
		$db = gdo_db();
		$back = array();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$langs = GWF_TABLE_PREFIX.'language';
		$query = "SELECT DISTINCT $langs.* FROM $sites JOIN $langs ON lang_id=site_language";
		if (false === ($result = $db->queryRead($query))) {
			return $back;
		}
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$back[] = new GWF_Language($row);
		}
		$db->free($result);
		return $back;
	}
	
// 	private function getWarIPCached()
// 	{
// 		$host = $this->getWarHost();
// 		$old = $this->getVar('site_war_ip');
// 		if ( ($host === ($ip = gethostbyname($host))) || ($ip === $old) )
// 		{
// 			return $old;
// 		}
// 		$this->saveVar('site_war_ip', $ip);
// 		return $ip;
// 	}

}
