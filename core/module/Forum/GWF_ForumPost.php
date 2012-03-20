<?php
/**
 * Forum post table and row.
 * @author gizmore
 */
final class GWF_ForumPost extends GDO # implements GDO_Searchable
{
	###################
	### Option Bits ###
	###################
	const MAIL_OUT = 0x01;
	const DISABLE_BB = 0x02;
	const DISABLE_SMILE = 0x04;
	const IN_MODERATION = 0x08;
	const GUEST_VIEW = 0x10;
	const INVISIBLE = 0x20;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumpost'; }
	public function getOptionsName() { return 'post_options'; }
	public function getColumnDefines()
	{
		return array(
			'post_pid' => array(GDO::AUTO_INCREMENT),
			'post_tid' => array(GDO::UINT|GDO::INDEX, true),
			'post_gid' => array(GDO::UINT|GDO::INDEX, true),
			'post_uid' => array(GDO::OBJECT|GDO::INDEX, true, array('GWF_User', 'post_uid', 'user_id')),
		
			# Post
			'post_date' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, true, GWF_Date::LEN_SECOND),
			'post_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'post_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			# Edited
			'post_euid' => array(GDO::UINT, 0),
			'post_eusername' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', GWF_User::USERNAME_LENGTH),
			'post_edate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, '', GWF_Date::LEN_SECOND),
			# Thanks
			'post_thanks' => array(GDO::UINT, 0),
			'post_thanks_by' => array(GDO::BLOB),
			'post_thanks_txt' => array(GDO::BLOB),
			# Votes
			'post_votes_up' => array(GDO::UINT, 0),
			'post_votes_down' => array(GDO::UINT, 0),
			'post_voted_up' => array(GDO::BLOB),
			'post_voted_down' => array(GDO::BLOB),
			# Options
			'post_options' => array(GDO::UINT, 0),
			'post_useropts' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_ForumOptions', 'post_uid', 'fopt_uid')),
			# Attachemnt counter
			'post_attachments' => array(GDO::UINT, 0),
		
		);
	}
	
	##################
	### Convinient ###
	##################
	public function getID() { return $this->getVar('post_pid'); }
	public function getGroupID() { return $this->getVar('post_gid'); }
	public function getThreadID() { return $this->getVar('post_tid'); }
	public function isBBCodeEnabled() { return !$this->isOptionEnabled(self::DISABLE_BB); } 
	public function isSmileyEnabled() { return !$this->isOptionEnabled(self::DISABLE_SMILE); }
	public function isInModeration() { return $this->isOptionEnabled(self::IN_MODERATION); }
	public function getToken() { return GWF_Password::getToken($this->getVar('post_date').$this->getVar('post_title')); }
	public function getPosterID() { return (false === ($user = $this->getVar('post_uid', false))) ? 0 : $user->getID(); }
	public function getPosterName() { return $this->getUser()->getVar('user_name'); }
	public function getDate() { return $this->getVar('post_date'); }
	public function isEdited() { return $this->getVar('euid') !== '0'; }
	public function hasAttachments() { return $this->getVar('post_attachments') !== '0'; }
	public function getAttachments() { return GWF_ForumAttachment::getAttachments($this->getID()); }
	
	/**
	 * 
	 * @return GWF_ForumOptions
	 */
	public function getUserOptions($guest_opts=false)
	{
		if (false === ($user_opts = $this->getVar('post_useropts', false)))
		{
			return $this->getGuestOptions();
		}
		return $user_opts;
	}
	
	/**
	 * @return int
	 */
	public function getUserID($return_guest=true)
	{
		if (false === ($user = $this->getUser($return_guest)))
		{
			return '0';
		}
		return $user->getID();
	}
	
	/**
	 * @return GWF_User
	 */
	public function getUser($return_guest=true)
	{
		if  ( (false === ($user = $this->getVar('post_uid'))) || ($user->getID() == '0') )
		{
			return $return_guest ? GWF_Guest::getGuest() : false;
		}
		return $user;
	}
	
	public function displayTitle() { return $this->display('post_title'); }
	public function displayPostDate() { return GWF_Time::displayDate($this->getVar('post_date')); }
	public function getBoard() { return $this->getThread()->getBoard(); }
	public function getThanksCount() { return $this->getVar('post_thanks'); }
	
	public function displayEditBy(Module_Forum $m)
	{
		if ('' === ($ename = $this->display('post_eusername')))
		{
			return ''; 
		}
		$edate = GWF_Time::displayDate($this->getVar('post_edate'));
		return $m->lang('last_edit_by', array($ename, $edate));
	}

	/**
	 * @return GWF_ForumThread
	 */
	public function getThread() { return GWF_ForumThread::getThread($this->getVar('post_tid')); }
	
	/**
	 * @param $post_id
	 * @return GWF_ForumPost
	 */
	public static function getPost($post_id)
	{
		return GDO::table(__CLASS__)->getRow($post_id); 
	}
	
	public function getMessage($no_check=false)
	{
		if ($no_check===false && $this->isInModeration() && !GWF_User::isInGroupS('moderator'))
		{
			return '[IN MODERATION]';
		}
		return $this->getVar('post_message');
	}
	
//	public function getSignature()
//	{
//		return $this->getVar('fopt_signature');
//	}
	
	public function displayMessage($highlight=array(), $no_check=false)
	{
//		if ($highlight === '') {
//			$highlight = array();
//		}
		$bb = $this->isBBCodeEnabled();
		$smile = $this->isSmileyEnabled();
		$img = false;
		
		return GWF_Message::display($this->getMessage($no_check), $bb, $smile, $img, $highlight);
	}
	
//	public function displaySignature()
//	{
//		return GWF_Message::display($this->getSignature(), false, false, false);
//	}
	
	########################
	### Permission Query ###
	########################
	public static function getPermQuery()
	{
		if ('0' === ($uid = GWF_Session::getUserID()))
		{
			return 'post_gid=0 AND post_options&8=0 AND post_options&'.self::GUEST_VIEW;
		}
		else
		{
			$grp = GWF_TABLE_PREFIX.'usergroup';
			return "post_options&8=0 AND ((post_gid=0) OR (SELECT 1 FROM $grp WHERE ug_userid=$uid AND ug_groupid=post_gid))";
		}
	}
	
	#############
	### Hooks ###
	#############
	public static function hookRenameUser(GWF_User $user, $new_username)
	{
		$uid = $user->getID();
		$posts = new self(false);
		$new_username = $posts->escape($new_username);
		
		if (false === $posts->update("post_eusername='$new_username'", "post_euid=$uid"))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return true;
	}
	
	public static function hookDeleteUser(GWF_User $user)
	{
		$uid = $user->getID();
		$posts = new self(false);
		
		if (false === $posts->update("post_uid=0", "post_uid=$uid"))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === $posts->update("post_eusername='', post_euid=0", "post_euid=$uid"))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return true;
	}
	
	#######################
	### Static Creation ###
	#######################
	/**
	 * Create a temporary post.
	 * This one can be inserted too, but not displayed :/
	 * To make it displayable you have to setVar(post_uid, $GWF_User);
	 * All is crap!
	 * @param GWF_User $user
	 * @param string $title
	 * @param string $message
	 * @param int $options
	 * @param int $threadid
	 * @return GWF_ForumPost
	 */
	public static function fakePost($user, $title, $message, $options=0, $threadid=0, $groupid=0, $date=true, $display_mode=false)
	{
		$userid = $user === false ? '0' : $user->getID();
		
		$date = is_bool($date) ? GWF_Time::getDate(GWF_Date::LEN_SECOND) : $date;
		
		# Useropts structure
		$useropts = $display_mode === true ? GWF_ForumOptions::getUserOptions($user, true) : $userid;
		
		return new self(array(
			'post_pid' => '0',
			'post_tid' => $threadid,
			'post_gid' => $groupid,
			'post_uid' => $display_mode ? $user : $userid,
			'post_date' => $date,
			'post_title' => $title,
			'post_message' => $message,
			'post_euid' => '0',
			'post_eusername' => '',
			'post_edate' => '',
			'post_thanks' => '0',
			'post_thanks_by' => ':',
			'post_thanks_txt' => ':',
			'post_votes_up' => '0',
			'post_votes_down' => '0',
			'post_voted_up' => ':',
			'post_voted_down' => ':',
			'post_options' => $options,
			'post_useropts' => $useropts,
			'post_attachments' => '0',
		));
	}
	
	#########################
	### User`s Post count ###
	#########################
	public function getPostCountForUser()
	{
		return self::getPostCount($this->getUserID());
	}
	
	private static function getPostCount($userid)
	{
		static $cache = array();

		if (0 === ($userid = (int) $userid)) {
			return GWF_HTML::lang('unknown');
		}
		
		if (!isset($cache[$userid]))
		{
			$posts = new self(false);
			$cache[$userid] = $posts->countRows("post_uid=$userid");
		}
		
		return $cache[$userid];
	}
	
	#############
	### HREFs ###
	#############
	public function getTranslateHREF()
	{
		return '#';
//		return sprintf('%sforum/google/translate/post/%s', GWF_WEB_ROOT, $this->getVar('post_pid'));
	}
	
	public function getTranslateOnClick()
	{
//		return '';
		$pid = $this->getID();
		return "gwfForumTrans($pid); return false;";
	}
	
	public function getReplyHREF()
	{
		return sprintf('%sforum/reply/to/post/%s/%s#form', GWF_WEB_ROOT, $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function getQuoteHREF()
	{
		return sprintf('%sforum/quote/post/%s/%s#form', GWF_WEB_ROOT, $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function getShowHREF($term='')
	{
		return $this->getShowHREFThread($term, $this->getThread());
	}
	
	public function getShowHREFThread($term='', $thread)
	{
		$thread instanceof GWF_ForumThread;
		return $thread === false ? '#' : $thread->getPostHREF($this, $term);
	}
	
	public function getEditHREF()
	{
		return sprintf('%sforum/edit/post/%s/%s', GWF_WEB_ROOT, $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function getThanksHREF()
	{
//		return '#';
		return GWF_WEB_ROOT.sprintf('forum/thanks/for/post/%s/%s', $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function getVoteUpHREF()
	{
//		return '#';
		return GWF_WEB_ROOT.sprintf('forum/vote/up/post/%s/%s', $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function getVoteDownHREF()
	{
//		return '#';
		return GWF_WEB_ROOT.sprintf('forum/vote/down/post/%s/%s', $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	public function hrefAddAttach()
	{
		return GWF_WEB_ROOT.sprintf('forum/add/attachment/to/post/%s/%s', $this->getVar('post_pid'), $this->urlencodeSEO('post_title'));
	}
	
	###################
	### Permissions ###
	###################
	public function hasEditPermission()
	{
		if (false === ($user = GWF_Session::getUser()))
		{
			return false;
		}
		
		if ($user->getID() === $this->getUserID())
		{
			return true;
		}
		
		if ($user->isInGroupName('moderator'))
		{
			return true;
		}
		
		$gid = $this->getGroupID();
		if (false === ($ugo = $user->getUserGroupOptions($gid)))
		{
			return false;
		}

		if (($ugo &(GWF_UserGroup::MODERATOR|GWF_UserGroup::CO_LEADER|GWF_UserGroup::LEADER)) > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function hasViewPermission($user)
	{
		# Guest
		if ( ($user === false) || ($user->getID() === '0') )
		{
			return $this->isOptionEnabled(self::GUEST_VIEW);
		}
		
		# No group
		if ('0' === ($gid = $this->getGroupID()))
		{
			return true;
		}
		
		# Check group
		if ($user->isInGroupID($gid))
		{
			return true;
		}
		
		return false;
	}
	
	##############
	### Delete ###
	##############
	public function deletePost()
	{
		if (false === $this->delete())
		{
			return false;
		}
		
		if (!$this->isInModeration())
		{
			$thread = $this->getThread();
			
			$thread->increase('thread_postcount', -1);
			$thread->increase('thread_thanks', -$this->getInt('post_thanks'));
			$thread->increase('thread_votes_up', -$this->getInt('post_votes_up'));
			$thread->increase('thread_votes_down', -$this->getInt('post_votes_down'));
			
			$this->getBoard()->adjustCounters(0, -1);
			
			if ($thread->getPostCount() === '0')
			{
				$thread->deleteThread();
			}
			else
			{
				$thread->updateLastPost();
			}
		}
		
		return true;
	}

	###############
	### Approve ###
	###############
	public function onApprove(Module_Forum $module, $mark_unread=true)
	{
		# Sane?
		if (false === ($thread = $this->getThread()))
		{
			echo $module->error('err_thread');
			return false;
		}
		if (false === ($board = $thread->getBoard()))
		{
			echo $module->error('err_board');
			return false;
		}
		
		# Update Last Poster
		if (false === $thread->updateLastPost())
		{
			return false;
		}
			
		# Increase counters
		if (false === $thread->increase('thread_postcount', 1))
		{
			return false;
		}
		if (false === $board->adjustCounters(0, 1))
		{
			return false;
		}
		
		# Mail us soon
		if (false === $this->saveOption(self::MAIL_OUT, true))
		{
			return false;
		}
		
		if (false === $this->saveOption(self::IN_MODERATION, false))
		{
			return false;
		}
		
		
		if ($mark_unread === true)
		{
			if (false === $this->onMarkUnread((is_object($this->getVar('post_uid')))?$this->getVar('post_uid')->getID():$this->getVar('post_uid'))) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		
		# We got approved
		if (false === $this->saveOption(GWF_ForumPost::IN_MODERATION, false))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		return true;
	}
	
	private function onMarkUnread($userid)
	{
		$this->getThread()->markUnRead($userid);
	}
	
	##############
	### Thanks ###
	##############
	public function hasThanked(GWF_User $user)
	{
		return strpos($this->getVar('post_thanks_by'), sprintf(':%s:',$user->getVar('user_id'))) !== false;
	}
	
	public function getThanksArray()
	{
		return explode(':', trim($this->getVar('post_thanks_by'), ':'));
	}

	public function onThanks(Module_Forum $module, GWF_User $user)
	{
		$data = array(
			'post_thanks_by' => $this->getVar('post_thanks_by').$user->getVar('user_id').':',
			'post_thanks_txt' => $this->getVar('post_thanks_txt').$user->getVar('user_name').':',
			'post_thanks' => $this->getThanksCount() + 1,
		);
		if (false === $this->saveVars($data))
		{ 
			return false; # DB error
		}
		
		if (false === $this->getThread()->increase('thread_thanks', 1))
		{
			return false;
		}
		
		# Increase Users total thanks counter
		if (false !== ($user = $this->getUser(false))) # No guest post
		{
			if (false !== ($options = GWF_ForumOptions::getUserOptions($this->getUser(false))))
			{
				$options->increase('fopt_thanks', 1);
			}
		}
		
		return true;
	}
	
	public function getThanksOnClick()
	{
		return "gwfForumThanks(".$this->getVar('post_pid')."); return false;";
	}
	
	#############
	### Votes ###
	#############
	public function hasVotedUp($userid)
	{
		return strpos($this->getVar('post_voted_up'), ':'.intval($userid).':') !== false;
	}
	
	public function hasVotedDown($userid)
	{
		return strpos($this->getVar('post_voted_down'), ':'.intval($userid).':') !== false;
	}
	
	public function onVoteUp($userid)
	{
		$userid = (int) $userid;
		
		if ($this->hasVotedUp($userid))
		{
			return true;
		}
		elseif ($this->hasVotedDown($userid))
		{
			$this->countDownVote($userid, -1);
			$this->unsetVoted('post_voted_down', $userid);
		}
		
		$this->countUpVote($userid, +1);
		$this->setVoted('post_voted_up', $userid);
		return true;
	}
	
	public function onVoteDown($userid)
	{
		$userid = (int) $userid;
		if ($this->hasVotedDown($userid))
		{
			return true;
		}
		elseif ($this->hasVotedUp($userid))
		{
			$this->countUpVote($userid, -1);
			$this->unsetVoted('post_voted_up', $userid);
		}
		
		$this->countDownVote($userid, +1);
		$this->setVoted('post_voted_down', $userid);
		
		return true;
	}
	
	private function countUpVote($userid, $amount)
	{
		$this->increase('post_votes_up', $amount);
		$this->getThread()->increase('thread_votes_up', $amount);
		
		# Increase Users total vote counter
		if (false !== ($user = $this->getUser(false))) # No guest post
		{
			if (false !== ($options = GWF_ForumOptions::getUserOptions($user)))
			{
				$options->increase('fopt_upvotes', $amount);
			}
		}
	}
	
	private function countDownVote($userid, $amount)
	{
		$this->increase('post_votes_down', $amount);
		$this->getThread()->increase('thread_votes_down', $amount);
		
		# Increase Users total vote counter
		if (false !== ($user = $this->getUser(false))) # No guest post
		{
			if (false !== ($options = GWF_ForumOptions::getUserOptions($user)))
			{
				$options->increase('fopt_downvotes', $amount);
			}
		}
	}
	
	private function setVoted($field, $userid)
	{
		return $this->saveVar($field, $this->getVar($field).$userid.':');
	}
	
	private function unsetVoted($field, $userid)
	{
		return $this->saveVar($field, str_replace(":$userid:", ':', $this->getVar($field)));
	}
	
	public function getVoteUpOnClick()
	{
		return "gwfForumVote(".$this->getVar('post_pid').", 1); return false;";
	}
	
	public function getVoteDownOnClick()
	{
		return "gwfForumVote(".$this->getVar('post_pid').", 0); return false;";
	}
	
	######################
	### GDO_Searchable ###
	######################
	public function getSearchableActions(GWF_User $user) { return array('btn_search_adv_and', 'btn_search_adv_or'); }
	public function getSearchableFields(GWF_User $user) { return array('post_title', 'post_message'); }
	public function getSearchableFormData(GWF_User $user) { return array(); }
}
?>
