<?php
/**
 * Edit a page.
 * @author gizmore
 */
final class PageBuilder_Edit extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	/**
	 * @var GWF_Page
	 */
	private $page; # this page
	
	/**
	 * @var GWF_User
	 */
	private $user; # session user
	
	private $is_owner = false;  # Owns this page
	private $is_oowner = false; # Owns root page
	private $is_author = false; # Has author privs
	
	public function execute()
	{
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid'))))
		{
			return $this->module->error('err_page');
		}
		
		$user = GWF_User::getStaticOrGuest();
		$this->is_author = $this->module->isAuthor($user);
		$this->is_owner = $this->is_author || $page->isOwner($user);
		
		if (!$this->is_owner && !$this->is_author)
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$this->page = $page;
		$this->user = $user;
		$this->is_oowner = $this->is_author ? true : $page->getOtherPage()->isOwner($user);
		
		$back = '';
		if (isset($_POST['edit']))
		{
			$back .= $this->onEdit();
		}
		elseif (isset($_POST['unlock']))
		{
			return $this->onUnlock().$this->templateEdit();
		}
		elseif (isset($_POST['delete']))
		{
			return $this->onDelete().$this->templateEdit();
		}
		elseif (isset($_POST['translate']))
		{
			GWF_Website::redirect($this->module->getMethodURL('Translate', '&pageid='.$page->getID()));
			die();
		}
		elseif (isset($_POST['upload']))
		{
			require_once GWF_CORE_PATH.'module/PageBuilder/PB_Uploader.php';
			$back .= PB_Uploader::onUpload($this->module).$this->templateEdit();
		}
		
		return $back.$this->templateEdit();
	}
	
	private function templateEdit()
	{
		$form = $this->formEdit();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit')),
		);
		return $this->module->template('edit.tpl', $tVars);
	}

	private function formEdit()
	{
		$mod_cat = GWF_Module::loadModuleDB('Category', true, true);
		
		$page = $this->page;
		$user = $this->user;
		
		$data = array();
		$data['url'] = array(GWF_Form::STRING, $page->getVar('page_url'), $this->module->lang('th_url'));
// 		if ($this->is_author)
// 		{
			$data['type'] = array(GWF_Form::SELECT, GWF_PageType::select($this->module, $page->getMode()), $this->module->lang('th_type'));
// 		}
		if ($this->is_oowner)
		{
			$data['groups'] = array(GWF_Form::SELECT_A, GWF_GroupSelect::multi('groups', $this->getSelectedGroups($page), true, true), $this->module->lang('th_groups'));
		}
		$data['noguests'] = array(GWF_Form::CHECKBOX, $page->isLoginRequired(), $this->module->lang('th_noguests'));
		if ($this->is_author)
		{
			$data['index'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::INDEXED), $this->module->lang('th_index'));
			$data['follow'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::FOLLOW), $this->module->lang('th_follow'));
			$data['sitemap'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::IN_SITEMAP), $this->module->lang('th_in_sitemap'));
		}
		$data['enabled'] = array(GWF_Form::CHECKBOX, $page->isEnabled(), $this->module->lang('th_enabled'));
		$data['title'] = array(GWF_Form::STRING, $page->getVar('page_title'), $this->module->lang('th_title'));
		if ($mod_cat !== false)
		{
			$data['cat'] = array(GWF_Form::SELECT, GWF_CategorySelect::single('cat', Common::getPostString('cat')), $this->module->lang('th_cat'));
		}
		$data['descr'] = array(GWF_Form::STRING, $page->getVar('page_meta_desc'), $this->module->lang('th_descr'));
		$data['tags'] = array(GWF_Form::STRING, trim($page->getVar('page_meta_tags'),','), $this->module->lang('th_tags'));
		$data['show_author'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_AUTHOR), $this->module->lang('th_show_author'));
		$data['show_similar'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_SIMILAR), $this->module->lang('th_show_similar'));
		$data['show_modified'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_MODIFIED), $this->module->lang('th_show_modified'));
		$data['show_trans'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_TRANS), $this->module->lang('th_show_trans'));
		$data['show_comments'] = array(GWF_Form::CHECKBOX, $page->wantComments(), $this->module->lang('th_show_comments'));
		if ($this->is_author)
		{
			$data['home_page'] = array(GWF_Form::CHECKBOX, ($this->module->cfgHomePage() === $page->getOtherID()), $this->module->lang('th_home_page'));
		}
		$data['file'] = array(GWF_Form::FILE_OPT, '', $this->module->lang('th_file'));
		$data['upload'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_upload'));
		if ($this->is_author)
		{
			$data['inline_css'] = array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_inline_css'), $this->module->lang('th_inline_css'));
		}
		if($page->getMode() === GWF_Page::BBCODE)
		{
			$data['content'] = array(GWF_Form::MESSAGE, $page->getVar('page_content'), $this->module->lang('th_content'));
		}
		else
		{
			$data['content'] = array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_content'), $this->module->lang('th_content'));
 		}
 		
 		
 		$buttons = array(
			'edit' => $this->module->lang('btn_edit'),
 			'translate'=> $this->module->lang('btn_translate'),
 		);
 		if ($this->is_author && $page->isLocked())
 		{
 			$buttons['unlock'] = $this->module->lang('btn_unlock');
 		}
 		$buttons['delete'] = $this->module->lang('btn_delete');
		$data['buttons'] = array(GWF_Form::SUBMITS, $buttons);
		
 		return new GWF_Form($this, $data);
	}
	
	private function onEdit()
	{
		$form = $this->formEdit();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$page = $this->page;
		
		$gstring = $this->buildGroupString();
		$tags = ','.trim(trim($form->getVar('tags')), ',').',';
		
		$data = array();
		if ($page->getVar('page_url') !== ($url = $form->getVar('url')))
		{
			$data['page_url'] = $url;
		}
		if ($page->getVar('page_title') !== ($title = $form->getVar('title')))
		{
			$data['page_title'] = $title;
		}
		if ($page->getVar('page_meta_tags') !== $tags)
		{
			$data['page_meta_tags'] = $tags;
		}
		if ($page->getVar('page_meta_desc') !== ($descr = $form->getVar('descr')))
		{
			$data['page_meta_desc'] = $descr;
		}
		if ($page->getVar('page_content') !== ($content = $form->getVar('content')))
		{
			$data['page_content'] = $content;
		}
		
		if ($this->is_author)
		{
			if ($page->getVar('page_inline_css') !== ($css = $form->getVar('inline_css')))
			{
				$data['page_inline_css'] = $css;
			}
		}
		$content_changed = count($data) > 0;
		if ($content_changed)
		{
			$time = time();
			$data['page_time'] = $time;
			$data['page_date'] = GWF_Time::getDate(GWF_Time::LEN_SECOND, $time);
			if (false === ($page->saveVars($data)))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		if (isset($_POST['home_page']) && $this->is_author)
		{
			$this->module->setHomePage($page->getOtherID());
		}
		
		if ($this->is_author)
		{
			if (false === ($this->setAuthorOptions($page)))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		if ($this->is_oowner)
		{
			if (false === ($this->setRootOptions($page, $gstring)))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
					
			if ($gstring !== $page->getVar('page_groups'))
			{
				if (false === GWF_PageGID::updateGIDs($page, $gstring))
				{
					return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
				}
			}
		}
		
		if ($this->is_owner)
		{
			if (false === ($this->setOwnerOptions($page)))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		if (false === GWF_PageTags::updateTags($page, $tags, $page->getVar('page_lang')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $this->module->writeHTA())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__,__LINE__));
		}
		
		
		# No content change
		if (!$content_changed)
		{
			return $this->module->message('msg_edited', array(GWF_WEB_ROOT.$page->display('page_url'), $page->display('page_title')));
		}
		
		# Content changed!
		echo GWF_Error::message('PageBuilder', 'Content changed!');
				
		# If author mode we directly push
		if ($this->is_author)
		{
			if (false === GWF_PageHistory::push($page))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
			}
			return $this->module->message('msg_edited', array(GWF_WEB_ROOT.$page->getVar('page_url'), $page->getVar('page_title')));
		}
		
		# Else we gonna send moderation mails
		if (false === $page->saveOption(GWF_Page::LOCKED, true))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		$this->module->sendModMails($page);
		return $this->module->message('msg_edit_locked');
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_inline_css($m, $arg) { return false; }
	public function validate_url(Module_PageBuilder $m, $arg)
	{
		# Allow duplicate URL when it's still the same
		$allow_dups = $this->page->getVar('page_url') === $arg;
		return $m->validateURL($arg, $allow_dups);
	}
	public function validate_type($m, $arg) { return GWF_PageType::validateType($m, $arg, !$this->is_author); }
	public function validate_cat($m, $arg) { return GWF_CategorySelect::validateCat($arg, true); }
	public function validate_groups($m, $arg)
	{
		if ($arg === false)
		{
			return false;
		}
		if (!is_array($arg))
		{
			return $m->lang('err_groups');
		}
		$user = GWF_Session::getUser();
		foreach ($arg as $gid)
		{
			if (!$user->isInGroupID($gid))
			{
				return $m->lang('err_groups');
			}
		}
		return false;
	}
	
	private function buildGroupString()
	{
		if (!isset($_POST['groups']))
		{
			return '';
		}
		$back = '';
		foreach ($_POST['groups'] as $gid)
		{
			if ($gid > 0)
			{
				$back .= ','.$gid;
			}
		}
		return $back === '' ? $back : substr($back, 1);
	}
	
	private function getSelectedGroups(GWF_Page $page)
	{
		return explode(',', $page->getVar('page_groups'));
	}
	
	/**
	 * Set option bits that may only be set by authors.
	 * @param GWF_Page $page
	 */
	private function setAuthorOptions(GWF_Page $page)
	{
		$pages = GDO::table('GWF_Page');
		$bits = GWF_Page::INDEXED|GWF_Page::FOLLOW|GWF_Page::IN_SITEMAP;
		$page->setOption($bits, false);
		$otherid = $page->getOtherID();
		# Kill all bits.
		$bits = ~$bits;
		if (false === $pages->update("page_options=page_options&$bits", "page_otherid={$otherid}"))
		{
			return false;
		}
		
		# Set the new bits.
		$bits = 0;
		$bits |= isset($_POST['index']) ? GWF_Page::INDEXED : 0;
		$bits |= isset($_POST['follow']) ? GWF_Page::FOLLOW : 0;
		$bits |= isset($_POST['sitemap']) ? GWF_Page::IN_SITEMAP : 0;
		
		$page->setOption($bits, true);
		
		# Fire the sql
		return GDO::table('GWF_Page')->update("page_options=page_options|{$bits}", "page_otherid={$otherid}");
	}
	
	/**
	 * Set options that may be set by the owner of the root page, like group and stuff.
	 * @param GWF_Page $page
	 * @param string $gstring
	 * @return boolean
	 */
	private function setRootOptions(GWF_Page $page, $gstring)
	{
		$pages = GDO::table('GWF_Page');
		$bits = GWF_Page::LOGIN_REQUIRED|GWF_Page::SHOW_TRANS|GWF_Page::SHOW_SIMILAR|GWF_Page::SHOW_MODIFIED;
		$page->setOption($bits, false);
		$otherid = $page->getOtherID();
		# Kill all bits.
		$bits = ~$bits;
		if (false === $pages->update("page_options=page_options&$bits", "page_otherid={$otherid}"))
		{
			return false;
		}
		
		# Set the new bits.
		$bits = 0;
		$bits |= isset($_POST['noguests']) ? GWF_Page::LOGIN_REQUIRED : 0;
		$bits |= isset($_POST['show_similar']) ? GWF_Page::SHOW_SIMILAR : 0;
		$bits |= isset($_POST['show_modified']) ? GWF_Page::SHOW_MODIFIED : 0;
		$bits |= isset($_POST['show_trans']) ? GWF_Page::SHOW_TRANS : 0;
		
		$page->setOption($bits, true);
		
		$page->setVar('page_groups', $gstring);
		$gstring = GDO::escape($gstring);
		
		# Fire the sql
		return GDO::table('GWF_Page')->update("page_groups='{$gstring}', page_options=page_options|{$bits}", "page_otherid={$otherid}");
	}
	
	/**
	 * Set bits the owner is allowed to set.
	 * @param GWF_Page $page
	 */
	private function setOwnerOptions(GWF_Page $page)
	{
		$pages = GDO::table('GWF_Page');
		$bits = GWF_Page::SHOW_AUTHOR|GWF_Page::MODES|GWF_Page::COMMENTS|GWF_Page::ENABLED;
		$page->setOption($bits, false);
		$otherid = $page->getOtherID();
		# Kill all bits.
		$bits = ~$bits;
		if (false === $pages->update("page_options=page_options&$bits", "page_otherid={$otherid}"))
		{
			return false;
		}
		
		$bits = 0;
		$bits |= $_POST['type'];
		$bits |= isset($_POST['show_author']) ? GWF_Page::SHOW_AUTHOR : 0;
		$bits |= isset($_POST['show_comments']) ? GWF_Page::COMMENTS : 0;
		$bits |= isset($_POST['enabled']) ? GWF_Page::ENABLED : 0;
		
		return $page->saveOption($bits, true);
	}

	private function onDelete()
	{
		if (!$this->is_oowner)
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		$href_delete = GWF_WEB_ROOT.sprintf('index.php?mo=PageBuilder&me=Moderate&token=%s&pageid=%s&action=delete', $this->page->getHashcode(), $this->page->getID());
		return $this->module->message('msg_del_confirm', array($href_delete));
	}
	
	private function onUnlock()
	{
		if (!$this->is_author)
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		$href_unlock = GWF_WEB_ROOT.sprintf('index.php?mo=PageBuilder&me=Moderate&token=%s&pageid=%s&action=unlock', $this->page->getHashcode(), $this->page->getID());
		return $this->module->message('msg_unlock_confirm', array($href_unlock));
	}
}
?>
