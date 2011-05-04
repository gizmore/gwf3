<?php
/**
 * A link and a table - Episode II
 * Link got sticky and moderate. It felt unafiliate with the private and checked down for the dead.
 * @author gizmore
 * @version 2.0
 * @since 2.0
 */
final class GWF_Links extends GDO #implements GDO_Searchable
{
	#################
	### Constants ###
	#################
	const STICKY = 0x01;
	const IN_MODERATION = 0x02;
	const UNAFILIATE = 0x04;
	const MEMBER_LINK = 0x08;
	const ONLY_PRIVATE = 0x10;
	const DOWN = 0x20;
	const DEAD = 0x40;
	
	const DOWNCOUNT_DEAD = 16;
	 
	##########
	## GDO ###
	##########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'links'; }
	public function getOptionsName() { return 'link_options'; }
	public function getColumnDefines()
	{
		return array(
			'link_id' => array(GDO::AUTO_INCREMENT),
			# Access
			'link_user' => array(GDO::OBJECT|GDO::INDEX, GDO::NULL, array('GWF_User', 'link_user', 'user_id')),
			'link_gid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'link_score' => array(GDO::INT, 0),
			# Link Data
			'link_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'link_href' => self::getURLDefine(GDO::NOT_NULL),
			'link_descr' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'link_descr2' => array(GDO::MESSAGE, GDO::NOT_NULL),
			'link_clicks' => array(GDO::UINT, 0),
			'link_favcount' => array(GDO::UINT, 0),
			'link_options' => array(GDO::UINT, 0),
			# Votes
			'link_voteid' => array(GDO::OBJECT, GDO::NULL, array('GWF_VoteScore', 'link_voteid', 'vs_id')),
			# ReadBy
			'link_readby' => array(GDO::BLOB),
			# Tag Cache
			'link_tags' => array(GDO::BLOB),
			'link_popular' => array(GDO::UINT, 0),
			# DownCheck
			'link_lastcheck' => array(GDO::UINT, 0),
			'link_downcount' => array(GDO::UINT, 0),
		);
	}
	
	######################
	### Static Getters ###
	######################
	/**
	 * @param int $vsid
	 * @return GWF_Links
	 */
	public static function getByVSID($vsid)
	{
		return self::table(__CLASS__)->getBy('link_voteid', $vsid, self::ARRAY_O, array('link_voteid'));
	}
	
	######################
	### GDO_Searchable ###
	######################
//	public function getSearchableFields(GWF_User $user)
//	{
//		return array('link_descr', 'link_descr2', 'link_href', 'link_date', 'user_name', 'vs_avg');
//	}
//	
//	public function getSearchableFormData(GWF_User $user)
//	{
//		return array();
//	}
//	
//	public function getSearchableActions(GWF_User $user)
//	{
//		return array('search_adv');
//	}
		
	##################
	### Convinient ###
	##################
	public function getID() { return $this->getVar('link_id'); }
	public function getUser() { return $this->getVar('link_user'); }
	public function getGroupID() { return $this->getVar('link_gid'); }
	public function getScore() { return $this->getVar('link_score'); }
	public function getTags() { return explode(',', $this->getVar('link_tags')); }
	public function isUnafiliated() { return $this->isOptionEnabled(self::UNAFILIATE); }
	public function isMemberLink() { return $this->isOptionEnabled(self::MEMBER_LINK); }
	public function isSticky() { return $this->isOptionEnabled(self::STICKY); }
	public function isPrivate() { return $this->isOptionEnabled(self::ONLY_PRIVATE); }
	public function isInModeration() { return $this->isOptionEnabled(self::IN_MODERATION); }
	public function getVoteID() { if (false === ($vs = $this->getVote())) { return '0'; } else { return $vs->getID(); } }
	public function getToken() { return parent::getHashcode(); }
	public function isDown() { return $this->isOptionEnabled(self::DOWN); }
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVote() { return $this->getVar('link_voteid'); }
	
	#############
	### HREFs ###
	#############
	public function hrefModApprove() { return sprintf('index.php?mo=Links&me=Staff&approve=%s&token=%s', $this->getVar('link_id'), $this->getToken()); }
	public function hrefModDelete() { return sprintf('index.php?mo=Links&me=Staff&disapprove=%s&token=%s', $this->getVar('link_id'), $this->getToken()); }
	
	######################
	### Static Getters ###
	######################
	/**
	 * @param int $id
	 * @return GWF_Links
	 */
	public static function getByID($id) { return self::table(__CLASS__)->getRow($id); }
	
	/**
	 * @param string $href
	 * @return GWF_Links
	 */
	public static function getByHREF($href) { return self::table(__CLASS__)->selectVar('1', "link_href='".self::escape($href)."'"); }
	
	#############
	### HREFs ###
	#############
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Links&me=Edit&lid='.$this->getVar('link_id'); }
	public function hrefRedirect() { return GWF_WEB_ROOT.'links/redirect/'.$this->getVar('link_id').'/'.$this->urlencode('link_descr'); }
	
	
	############
	### Ajax ###
	############
	public function getOnClick()
	{
		return 'return gwfLinksRedirect('.$this->getVar('link_id').');';
	}
	
	###############
	### Display ###
	###############
	public function displayFavCount()
	{
		return $this->getVar('link_favcount');
	}
	
	public function displayClickCount()
	{
		return $this->getVar('link_clicks');
	}
	
	public function displayText($class='')
	{
		$href = $this->getVar('link_href');
		if (Common::startsWith($href, '/')) {
			$href = GWF_WEB_ROOT.substr($href, 1);
		}
		
		$class = $class === '' ? '' : ' class="'.$class.'"';
		
		return sprintf('<a%s href="%s" onclick="%s">%s</a>', $class, GWF_HTML::display($href), $this->getOnClick(), $this->display('link_descr'));
	}
	
	public function displayVoteSum()
	{
		if (false === ($vote = $this->getVote())) {
			return '0';
		}
		return sprintf('%d', $vote->getVar('vs_sum'));
	}
	
	public function displayVoteCount()
	{
		if (false === ($vote = $this->getVote())) {
			return '0';
		}
		return sprintf('%d', $vote->getVar('vs_count'));
	}
	
	public function displayVoteAverage()
	{
		if (false === ($vote = $this->getVote())) {
			return '0.00';
		}
		return sprintf('%0.2d', $vote->getVar('vs_avg'));
	}
	
	public function displayVoteAveragePercent()
	{
		if (false === ($vote = $this->getVote())) {
			return '0.00%';
		}
		return sprintf('%.02f%%', $vote->getAvgPercent());
	}
	
	public function displayVoteButtons()
	{
		if (false === ($vote = $this->getVote())) {
			return '';
		}
		return $vote->displayButtons();
	}
	
	public function displayFavButton($text)
	{
		return GWF_Button::favorite($this->hrefFavorite(true), $text);
	}
	
	public function displayUnFavButton($text)
	{
		return GWF_Button::thumbsDown($this->hrefFavorite(false), $text);
	}
	
	public function hrefFavorite($bool=true)
	{
		return GWF_WEB_ROOT.'index.php?mo=Links&me=Favorite&lid='.$this->getVar('link_id').'&'.($bool?'my':'no').'=favorite';
	}
	
	################
	### Creation ###
	################
	/**
	 * @param unknown_type $user
	 * @param unknown_type $href
	 * @param unknown_type $descr
	 * @param unknown_type $descr2
	 * @param unknown_type $tags
	 * @param unknown_type $score
	 * @param unknown_type $gid
	 * @param unknown_type $sticky
	 * @param unknown_type $in_moderation
	 * @param unknown_type $unafiliate
	 * @param unknown_type $memberlink
	 * @return GWF_Links
	 */
	public static function fakeLink($user, $href, $descr, $descr2, $tags='', $score=0, $gid=0, $sticky=false, $in_moderation=false, $unafiliate=false, $memberlink=false, $private=false)
	{
		$options = 0;
		$options |= $sticky ? self::STICKY : 0;
		$options |= $in_moderation ? self::IN_MODERATION : 0;
		$options |= $unafiliate ? self::UNAFILIATE : 0;
		$options |= $memberlink ? self::MEMBER_LINK : 0;
		$options |= $private ? self::ONLY_PRIVATE : 0;
		
		return new self(array(
			'link_id' => 0,
			'link_user' => $user,
			'link_gid' => $gid,
			'link_score' => $score,
			'link_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'link_href' => $href,
			'link_descr' => $descr,
			'link_descr2' => $descr2,
			'link_clicks' => 0,
			'link_favcount' => 0,
			'link_options' => $options,
			'link_voteid' => 0,
			'link_readby' => $user === false ? ':' : ':'.$user->getVar('user_id').':',
			'link_tags' => $tags,
			'link_popular' => 0,
		));
	}
	
	#############################
	### Count Links Available ###
	#############################
	public function countLinks(Module_Links $module, $user, $tag, $moderated=false)
	{
		$links = self::table(__CLASS__);
		$perm_query = $module->getPermQuery($user);
		$tag_query = $this->getTagQuery($tag);
		$mod_query = $this->getModQuery($user);
		$member_query = $this->getMemberQuery($user);
		return $links->countRows("( ($perm_query) AND ($tag_query) AND ($mod_query) AND ($member_query) )");
	}
	
	####################
	### Query Helper ###
	####################
	public function getTagQuery($tag)
	{
		if (false === ($tag = GWF_LinksTag::getByName($tag))) {
			return '1';
		}
		$ltm = GWF_TABLE_PREFIX.'links_tagmap';
		$tid = $tag->getID();
//		echo "(SELECT 1 FROM $ltm WHERE ltm_lid=link_id AND ltm_tid=$tid)";
		return "SELECT 1 FROM $ltm WHERE ltm_lid=link_id AND ltm_ltid=$tid";
	}
	
	public function getModQuery($user)
	{
		if ($user!==false && $user->isStaff()) {
			return '1';
		}
		$mod = self::IN_MODERATION;
		return "(link_options&$mod=0)";
	}
	
	public function getMemberQuery($user)
	{
		if (is_object($user)) {
			return '1';
		}
		else {
			$member = self::MEMBER_LINK;
			return "(link_options&$member=0)";
		}
	}
	
	public function getPrivateQuery($user)
	{
		$private = self::ONLY_PRIVATE;
		if ($user === false) {
			return "link_options&$private=0";
		}
		$userid = $user->getID();
		return "link_options&$private=0 OR link_user=$userid";
	}
	
	public function getUnaffQuery($user)
	{
		$unaff = self::UNAFILIATE;
		return "link_options&$unaff=0";
	}
	
	###################
	### Permissions ###
	###################
	public function mayView($user)
	{
		if (GWF_User::isAdminS()) {
			return true;
		}
		
		if ($this->isInModeration()) {
			return false;
		}
		
		if (is_object($user)) {
			return $this->mayUserView($user);
		} else {
			return $this->mayGuestView();
		}
	}
	
	public function mayUserView(GWF_User $user)
	{
		if ($this->getScore() > $user->getLevel()) {
			return false;
		}
		if (!$user->isInGroupID($this->getGroupID())) {
			return false;
		}
		return true;
	}
	
	public function mayGuestView()
	{
		if ($this->getScore() > 0) {
			return false;
		}
		if ($this->getGroupID() > 0) {
			return false;
		}
		if ($this->isMemberLink()) {
			return false;
		}
		return true;
	}
	
	public function mayEdit($user)
	{
		if (!(is_object($user))) {
			return false; # Guest
		}
		if ($user->isStaff()) {
			return true;
		}
		return $user->getVar('user_id') === $this->getUser()->getVar('user_id');
	}
	
	public static function mayUserAddLink(Module_Links $module, GWF_User $user)
	{
		$min_level =  $module->cfgMinScore();
		if ($min_level > ($level = $user->getLevel())) {
			return $module->lang('err_score_link', array( $level, $min_level));
		}
		$score_per_link = $module->cfgScorePerLink();
		
		$links = self::table(__CLASS__);
		$uid = $user->getID();
		$nAdded = $links->countRows("link_user=$uid");
		
		$score_used = $min_level + $nAdded * $score_per_link;
		$score_next = $score_used + $score_per_link;
		
		if ($score_next > $level) {
			return $module->lang('err_score_link', array( $level, $score_next));
		}
		return false;
	}

	public static function mayGuestAddLink(Module_Links $module)
	{
		if (false === $module->cfgGuestLinks()) {
			return $module->lang('err_add_perm');
		}
		return false;
	}

	public static function mayUserAddTag(Module_Links $module, GWF_User $user)
	{
		$min_level = $module->cfgMinTagScore();
		if ($min_level > ($level = $user->getLevel())) {
			return $module->error('err_score_tag', $level, $min_level);
		}
		return true;
	}

	public static function mayGuestAddTag(Module_Links $module)
	{
		if (false === $module->cfgGuestLinks()) {
			return $module->error('err_add_tags');
		}
		return false;
	}

	#################
	### Mark Read ###
	#################
	public function hasRead($user) # / Is New
	{
		if (is_object($user))
		{
			return strpos($this->getVar('link_readby'), ':'.$user->getID().':') !== false;
		}
		else
		{
			return !GWF_Time::isToday($this->getVar('link_date'));
		}
	}
	
	public function markRead($user)
	{
		if (is_object($user) && !$this->hasRead($user))
		{
			return $this->saveVar('link_readby', $this->getVar('link_readby').$user->getID().':');
		}
		return true;
	}
	
	public function markUnread($user)
	{
		if (is_object($user) && $this->hasRead($user))
		{
			return $this->saveVar('link_readby', str_replace(sprintf(':%s:', $user->getVar('user_id')), ':', $this->getVar('link_readby')) );
		}
		return true;
	}
	
	##############
	### Insert ###
	##############
	public function insertLink(Module_Links $module, $in_moderation)
	{
		# Insert Link
		if (false === ($this->replace())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		
		# Insert Tags
		if (!$in_moderation)
		{
			if (false !== ($error = $this->insertTags($module))) {
				return $error;
			}
		}
		
		if (false !== ($error = $this->installVotes($module))) {
			return $error;
		}
		
		return false;
	}
	
	public function installVotes(Module_Links $module)
	{
		$link_id = $this->getID();

		$minvote = $module->cfgVoteMin();
		$maxvote = $module->cfgVoteMax();
		$guestvotes = $module->cfgGuestVotes();
		
		if (false === ($vs = Module_Votes::installVoteScoreTable('link_'.$link_id, $minvote, $maxvote, $guestvotes))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $this->saveVar('link_voteid', $vs->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		$this->setVar('link_voteid', $vs);
		
		return false;
	}
	
	############
	### Tags ###
	############
	public function insertTags(Module_Links $module)
	{
		$tags = $this->getTags();
		foreach ($tags as $tag)
		{
			if ('' === ($tag = trim($tag))) {
				continue;
			}
			if (false === GWF_LinksTag::addTag($this, $tag)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			if (false === ($tagc = GWF_LinksTag::getByName($tag))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			if (false === GWF_LinksTagMap::addTag($this->getID(), $tagc->getID())) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		return false;
	}
	
	public function removeTags()
	{
		$tags = $this->getTags();
		foreach ($tags as $tag)
		{
			if (false === GWF_LinksTag::removeTag($this, $tag)) {
//				return false;
			}
		}
		
		return GWF_LinksTagMap::remTags($this->getID());
	}
	
	##############
	### Delete ###
	##############
	public function deleteLink(Module_Links $module)
	{
		if (false === $this->removeTags()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $this->deleteVoteTable($module)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $this->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return false;
	}
	
	public function deleteVoteTable(Module_Links $module)
	{
		if (false === ($vs = $this->getVote())) {
			return true;
		}
		
		if ($vs->getID() > 0) {
			return $vs->onDelete();
		}
		
		return true;
	}
	
	public function setVotesEnabled($bool)
	{
		if (false === ($votes = $this->getVote())) {
			return false;
		}
		return $votes->saveOption(GWF_VoteScore::ENABLED, $bool);
	}
	
	public function toggleModeration(Module_Links $module, $bool)
	{
		if ($bool === ($old = $this->isInModeration())) {
			return true; # nothing changed.
		}
		
		if (false === $this->setVotesEnabled(!$bool)) {
			return false;
		}
		
		if ($bool === true) # Enable
		{
			if (false !== ($error = $this->insertTags($module))) {
				return false;
			}
		}
		else # Disable
		{
			if (false === $this->removeTags()) {
				return false;
			}
		}
		return $this->saveOption(self::IN_MODERATION, $bool);
	}
	
	##################
	### Popularity ###
	##################
	public function onCalcPopularity()
	{
		$votes = $this->getVote();
		$min = $votes->getMin();
		$max = $votes->getMax();
		$avg = $votes->getAvg();
		$middle = $votes->getMiddle();
		$votecount = $votes->getCount();
		
//		$sum = $votes->getSum();
		$clicks = $this->getVar('link_clicks');
		$favcount = $this->getVar('link_favcount');
		$popularity = 0;#round($avg * $clicks + $votecount + $* $avg + $favcount * $max * 2);
		return $this->saveVar('link_popular', $popularity);
	}
	
	#######################
	### Permission Text ###
	#######################
	/**
	 * Check if we have permission to view that link. In case we do, return empty string. else return verbose permission text.
	 * @param Module_Links $module
	 * @param GWF_User $user
	 * @return string
	 */
	public function getPermissionText(Module_Links $module, $user)
	{
		static $text = NULL;
		if ($text === NULL) {
			$text = array(
				$module->lang('permtext_in_mod'),
				$module->lang('permtext_score', array( '%1%')),
				$module->lang('permtext_member'),
				$module->lang('permtext_group', array( '%1%')),
			);
		}
		
		if ($this->isInModeration()) {
			return $text[0];
		}
		
		$score = $user === false ? 0 : $user->getLevel();
		
		# Check score
		$need_score = $this->getVar('link_score');
		if ($score < $need_score) {
			return str_replace('%1%', $need_score, $text[1]);
		}
		
		# Check memberlink
		if ($user === false && $this->isMemberLink()) {
			return $text[2];
		}
		
		# Check group
		$need_gid = $this->getGroupID();
		if ($need_gid > 0)
		{
			if ($user === false || (!$user->isInGroupID($need_gid))) {
				return str_replace('%1%', GWF_Group::getByID($need_gid)->displayName(), $text[3]);
			}
		}
		
		return '';
	}
}

?>