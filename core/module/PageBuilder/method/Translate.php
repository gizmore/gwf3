<?php
/**
 * Translate a page
 * @author gizmore
 */
final class PageBuilder_Translate extends GWF_Method
{
	/**
	 * @var GWF_Page
	 */
	private $page;
	/**
	 * @var GWF_User
	 */
	private $user;
	private $is_author = false;
	private $locked_mode = false;
	
	public function execute()
	{
		if (false === ($this->page = GWF_Page::getByID(Common::getGetString('pageid'))))
		{
			return $this->module->lang('err_page');
		}
		
		if ($this->page->isLocked())
		{
			return $this->module->lang('err_locked');
		}
		
		$this->user = GWF_User::getStaticOrGuest();
		
		if (false === ($this->is_author = $this->module->isAuthor($this->user)))
		{
			if (false === $this->module->cfgLockedPosting())
			{
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
			else
			{
				$this->locked_mode = true;
			}
		}
		
		$back = '';
		if (isset($_POST['translate']))
		{
			$back .= $this->onTranslate($this->page);
		}
		
		elseif (isset($_POST['upload']))
		{
			require_once GWF_CORE_PATH.'module/PageBuilder/PB_Uploader.php';
			$back .= PB_Uploader::onUpload($this->module);
		}
		
		return $back.$this->templateTranslate($this->page);
	}
	
	private function templateTranslate(GWF_Page $page)
	{
		$form = $this->formTranslate($page);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_translate')),
		);
		return $this->module->template('translate.tpl', $tVars);
	}

	/**
	 * Get a langid from possible get parameters. default is browser.
	 * @return string
	 */
	private function getSelectedLangID()
	{
		if ('' !== ($iso = Common::getGetString('to_iso')))
		{
			if (false !== ($id = GWF_Language::getIDByISO($iso)))
			{
				return $id;
			}
		}
		return Common::getGetString('to_lang_id', true);
	}
	
	private function formTranslate(GWF_Page $page)
	{
		$data = array(
			'url' => array(GWF_Form::STRING, $page->getVar('page_url'), $this->module->lang('th_url')),
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang', $this->getSelectedLangID()), $this->module->lang('th_lang')),
			'title' => array(GWF_Form::STRING, $page->getVar('page_title'), $this->module->lang('th_title')),
			'descr' => array(GWF_Form::STRING, $page->getVar('page_meta_desc'), $this->module->lang('th_descr')),
			'tags' => array(GWF_Form::STRING, trim($page->getVar('page_meta_tags'),','), $this->module->lang('th_tags')),
			'file' => array(GWF_Form::FILE_OPT, '', $this->module->lang('th_file')),
			'upload' => array(GWF_Form::SUBMIT, $this->module->lang('btn_upload')),
			'content' => array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_content'), $this->module->lang('th_content')),
			'translate' => array(GWF_Form::SUBMIT, $this->module->lang('btn_translate')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_url(Module_PageBuilder $m, $arg) { return $m->validateURL($arg, false); }
	public function validate_lang($m, $arg)
	{
		if (false !== ($error = GWF_LangSelect::validate_langid($arg, true)))
		{
			return $error;
		}
		
		$lid = (int)$arg;
		$oid = $this->page->getOtherID();
		if (false === GDO::table('GWF_Page')->selectVar('1', "page_otherid={$oid} AND page_lang={$lid}"))
		{
			return false;
		}
		
		return $m->lang('err_dup_lid');
	}
	
	private function onTranslate(GWF_Page $page)
	{
		$form = $this->formTranslate($page);
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$options = 0;
		$options |= GWF_Page::ENABLED;
		$options |= GWF_Page::TRANSLATION;
		$options |= $page->isLoginRequired() ? GWF_Page::LOGIN_REQUIRED : 0;
		$options |= $this->locked_mode ? GWF_Page::LOCKED : 0;
		$options |= $page->getMode();
		$options |= $page->getShowFlags();
		
		$gstring = $page->getVar('page_groups');
		$tags = ','.trim(trim($form->getVar('tags')), ',').',';
		
		$author = GWF_User::getStaticOrGuest();
		$time = time();
		$date = GWF_Time::getDate(GWF_Time::LEN_SECOND, $time);
		
		$newpage = new GWF_Page(array(
			'page_id' => '0',
			'page_otherid' => $page->getID(),
			'page_lang' => $form->getVar('lang'),
			'page_author' => $author->getID(),
			'page_author_name' => $author->getVar('user_name'),
			'page_groups' => $gstring,
			'page_create_date' => $date,
			'page_date' => $date,
			'page_time' => $time,
			'page_url' => $form->getVar('url'),
			'page_title' => $form->getVar('title'),
			'page_cat' => '0',
			'page_meta_tags' => $tags,
			'page_meta_desc' => $form->getVar('descr'),
			'page_content' => $form->getVar('content'),
			'page_views' => '0',
			'page_options' => $options,
			'page_inline_css' => $page->getVar('page_inline_css'),
		));
		
		if (false === $newpage->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
// 		if (false === GWF_PageGID::updateGIDs($newpage, $gstring))
// 		{
// 			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
// 		}
		
		if (false === GWF_PageTags::updateTags($newpage, $tags, $form->getVar('lang')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $this->module->writeHTA())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__,__LINE__));
		}
		
		if ($this->locked_mode)
		{
			$this->module->sendModMails();
			return $this->module->message('msg_added_locked');
		}
		
		if (false === GWF_PageHistory::push($newpage))
		{
			GWF_Error::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		return $this->module->message('msg_trans');
	}
}
?>