<?php
//require_once 'GWF_News.php';

final class Module_News extends GWF_Module
{
	/**
	 * Session varname for newsletter preview
	 * @var string
	 */
	const SESS_NEWSLETTER = 'GWF_NEWSLETTER_PREVIEW'; 
	
	#################
	### Overrides ###
	#################
	public function getVersion() { return 1.03; }
	public function getAdminSectionURL() { return GWF_WEB_ROOT.'news/admin'; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/news'); }
	public function onCronjob() { require_once 'GWF_NewsCronjob.php'; GWF_NewsCronjob::onCronjob($this); }
	public function getDependencies() { return array('Category' => 1.0, ); }
	
	private static $instance;
	/**
	 * @return Module_News
	 */
	public static function getNewsModule()
	{
		return self::$instance;# GWF_Module::getModule('News');
	}
	
	##################
	### GWF_Module ###
	##################
	public function getClasses() { return array('GWF_News', 'GWF_Newsletter', 'GWF_NewsTranslation'); }
	public function onInclude()
	{
		require_once GWF_CORE_PATH.'module/Category/GWF_Category.php';
		require_once GWF_CORE_PATH.'module/Category/GWF_CategoryTranslation.php';
		parent::onInclude();
	}
	
	public function onInstall($dropTable)
	{
		return
			GWF_ModuleLoader::installVars($this, array(
				'news_per_box' => array('4', 'int', '1', '100'),
				'news_per_page' => array('10', 'int', '1', '100'),
				'news_per_adminpage' => array('20', 'int', '1', '100'),
				'newsletter_guests' => array('NO', 'bool'),
				'newsletter_mail' => array(GWF_SUPPORT_EMAIL, 'text', '6', GWF_User::EMAIL_LENGTH),
				'newsletter_sleep' => array('250', 'int', '0', '2000'),
				'news_per_feed' => array('6', 'int', '1', '10'),
				'news_comments' => array('YES', 'bool'),
//				'news_in_forum' => array('NO', 'bool'),
			));
	}
	public function getNewsPerBox() { return $this->getModuleVarInt('news_per_box', 4); }
	public function getNewsPerPage() { return $this->getModuleVarInt('news_per_page', 10); }
	public function getNewsPerAdminPage() { return $this->getModuleVarInt('news_per_adminpage', 20); }
	public function isNewsletterForGuests() { return $this->getModuleVarBool('newsletter_guests', '0'); }
	public function cfgSender() { return $this->getModuleVar('newsletter_mail', GWF_SUPPORT_EMAIL); }
	public function cfgSleepMillis() { return $this->getModuleVarInt('newsletter_sleep', 250); }
	public function cfgFeedItemcount() { return $this->getModuleVarInt('news_per_feed', 6); }
	public function cfgAllowComments() { return $this->getModuleVarBool('news_comments', '1'); }
//	public function cfgNewsInForum() { return ( (GWF_Module::getModule('Forum')!==false) && ($this->getModuleVar('news_in_forum', '0')) ); }
	
	public function onStartup()
	{
		self::$instance = $this;
//		$this->isMethodSelected('Show');
//		GWF_Hook::add(GWF_Hook::SHOW_COMMENT_ITEM, self::hookShowCommentItem());
	}
	
	public function execute($methodname)
	{
		GWF_Website::addFeed(GWF_WEB_ROOT.'news/feed', $this->lang('rss_title'));
		return parent::execute($methodname);
	}
	
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::INSTALL_MODULE, array(__CLASS__, 'onHookInstallModule'));
		GWF_Hook::add(GWF_Hook::CHANGE_MAIL, array(__CLASS__, 'onHookChangeMail'));
	}
	
//	public function onAddMenu()
//	{
//		if ('0' === ($count = $this->getNewsCount())) {
//			$append = '';
//		} else {
//			$append = sprintf('[%d]', $count);
//		}
//		
//		GWF_TopMenu::addMenu('news', GWF_WEB_ROOT.'news', $append, $this->isSelected());
//	}
	
	/**
	 * a hook that checks if we still have forum after a module install.
	 * @param GWF_User $user
	 * @param GWF_Module $module
	 * @return string error msg or empty string
	 */
	public function onHookInstallModule(GWF_User $user, array $args)
	{
		$module = $args[0];
		$dropTable = $args[1]; // bool
		$module instanceof GWF_Module;

		$name = $module->getName();

		// Forum got wiped?
		if ($name === 'Forum' && $dropTable)
		{
			// Reinstall news in forum.
			return $this->onReinstallForumNews();
		}
		
		return '';
	}
	
	public function onHookChangeMail(GWF_User $user, array $args)
	{
		if (false === GWF_Newsletter::onHookChangeMail($args[0], $args[1]))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}
	
	/**
	 * Reinstall all news in forum.
	 * @return string
	 */
	private function onReinstallForumNews()
	{
		// Get Edit Method
		if (false === ($news_edit = $this->getMethod('Edit'))) {
			return GWF_HTML::err('ERR_METHOD_MISSING', array( 'Edit', 'News')); // return error
//			return ''; // No edit, quit silently?
		} $news_edit instanceof News_Edit;

		// Rebuild forum news
		return $news_edit->rebuildAllThreads($this, $this->cfgNewsInForum());
	}
	
	##################
	### News Count ###
	##################
	public function getNewsCount()
	{
		static $count = true;
		if ($count === true)
		{
			if (false === ($user = GWF_Session::getUser())) {
				$count = '0';
			}
			else {
				$count = $this->getNewsCountB($user);
			}
		}
		return $count;
	}
	
	private function getNewsCountB(GWF_User $user)
	{
		return '0';
	}
	
	######################
	### INLINE DISPLAY ###
	######################
	public static function displayBox($amount=true, $catid=0, $orderby='date', $orderdir='DESC')
	{
		if (false === ($module = self::getNewsModule())) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'NEWS'));
		}

		# Amount
		if (is_bool($amount)) {
			$amount = $module->getNewsPerBox();
		}
		else {
			$amount = Common::clamp($amount, 1);
		}
		
		# Display Template
		return self::displayBoxB(GWF_News::getNews($amount, $catid, 1, $orderby, $orderdir));
	}
	
	public static function displayItem(GWF_News $news)
	{
		return self::displayBoxB(array($news));
	}
	
	public static function displayBoxB(array $news)
	{
		if (false === ($module = self::getNewsModule())) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'News'));
		}
		# Display Template
		$tVars = array(
			'news' => $news,
		);
		return $module->template('box.tpl', $tVars);
	}
	
	###############
	### Preview ###
	###############
	public static function displayPreview(GWF_News $news)
	{
		return self::displayBoxB(array($news));
	}
	
	public static function savePreview(GWF_News $news)
	{
		GWF_Session::set(self::SESS_NEWSLETTER, serialize($news));
	}
	
	public static function getSavedPreview()
	{
		if (false === ($news = GWF_Session::getOrDefault(self::SESS_NEWSLETTER, false))) {
			return false;
		}
		return unserialize($news);
	}
	
	public static function cleanupPreview()
	{
		GWF_Session::remove(self::SESS_NEWSLETTER);
	}

	############
	### URLS ###
	############
	public function hrefAddNews() { return GWF_WEB_ROOT.'news/add'; }
	public function hrefSignNewsletter() { return GWF_WEB_ROOT.'newsletter/subscribe'; }
	
	##################
	### Permission ###
	##################
	public function canSignNewsletter($user)
	{
		return $user === false ? $this->isNewsletterForGuests() : true;
	}
}

?>
