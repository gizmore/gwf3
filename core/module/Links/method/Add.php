<?php
/**
 * Add a link.
 * @author gizmore
 */
final class Links_Add extends GWF_Method
{
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Links&me=Add',
						'page_title' => 'Add Link',
						'page_meta_desc' => 'Add a new link',
				),
		);
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		if (false !== Common::getPost('preview')) {
			return $this->onPreview();
		}
		if (false !== Common::getPost('add')) {
			return $this->onAdd();
		}
		return $this->templateAdd();
	}

	/**
	 * @var GWF_User
	 */
	private $user;
	
	private function sanitize()
	{
		$this->user = GWF_Session::getUser();
		
		if (false !== ($error = GWF_LinksValidator::mayAddLink($this->module, $this->user))) {
			return GWF_HTML::error('Links', $error);
		}
		return false;
	}
	
	private function getForm()
	{
		$tags = Common::getPostString('link_tags', Common::getGet('tag'));
		$data = array(
			'link_lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_LangSelect::TYPE_SUPPORTED, 'link_lang'),  $this->module->lang('th_link_lang')),
			'link_score' => array(GWF_Form::STRING, '0', $this->module->lang('th_link_score'), $this->module->lang('tt_link_score')),
			'link_gid' => array(GWF_Form::SELECT, GWF_GroupSelect::single('link_gid'), $this->module->lang('th_link_gid'), $this->module->lang('tt_link_gid')),
			'tag_info' => array(GWF_Form::HEADLINE, '', $this->module->lang('info_tag')),
			'known_tags' => array(GWF_Form::HEADLINE, '', $this->collectTags()),
			'link_tags' => array(GWF_Form::STRING, $tags, $this->module->lang('th_link_tags')),
			'div1' => array(GWF_Form::DIVIDER),
			'link_href' => array(GWF_Form::STRING, '', $this->module->lang('th_link_href'), $this->module->lang('tt_link_href')),
			'link_descr' => array(GWF_Form::STRING, '', $this->module->lang('th_link_descr')),
		);
		if ($this->module->cfgLongDescription()) {
			$data['link_descr2'] = array(GWF_Form::MESSAGE, '', $this->module->lang('th_link_descr2'));
		}
		$data['link_options&'.GWF_Links::MEMBER_LINK] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]), $this->module->lang('th_link_options&'.GWF_Links::MEMBER_LINK));
		if (GWF_User::isLoggedIn()) {
			$data['link_options&'.GWF_Links::UNAFILIATE] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::UNAFILIATE]), $this->module->lang('th_link_options&'.GWF_Links::UNAFILIATE));
			$data['link_options&'.GWF_Links::ONLY_PRIVATE] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]), $this->module->lang('th_link_options&'.GWF_Links::ONLY_PRIVATE));
		}
		
		if (!GWF_Session::isLoggedIn() && $this->module->cfgGuestCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		
		$data['buttons'] = array(GWF_Form::SUBMITS, array('preview'=>$this->module->lang('btn_preview'),'add'=>$this->module->lang('btn_add')));
		
		return new GWF_Form($this, $data);
	}
	
	private function collectTags()
	{
		$back = array();
		$tags = GWF_LinksTag::getCloud();
		foreach ($tags as $tag)
		{
			$back[] = $tag->display('lt_name');
		}
		return implode(', ', $back);
	}
	
	private function templateAdd()
	{
		GWF_Website::setPageTitle($this->module->lang('ft_add'));
		
		$form = $this->getForm();
		$tVars = array(
			'preview' => '',
			'form' => $form->templateY($this->module->lang('ft_add')),
		);
		return $this->module->templatePHP('add.php', $tVars);
	}
	
	private function onPreview()
	{
		$form = $this->getForm();
		$errors = $form->validate($this->module);
		$user = GWF_Session::getUser();
		$href = $form->getVar('link_href');
		$descr1 = $form->getVar('link_descr');
		$descr2 = $form->getVar('link_descr2');
		$tags = $form->getVar('link_tags');
		$score = $form->getVar('link_score');
		$gid = $form->getVar('link_gid');
		$sticky = false;
		$in_moderation = $user === false && $this->module->cfgGuestModerated();
		$unafiliate = isset($_POST['link_options&'.GWF_Links::UNAFILIATE]);
		$memberlink = isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]);
		$private = isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]);
		$link = GWF_Links::fakeLink($user, $href, $descr1, $descr2, $tags, $score, $gid, $sticky, $in_moderation, $unafiliate, $memberlink, $private);
		$tVars = array(
			'preview' => $this->module->templateLinks(array($link), '', '', '', true, false, false, false),
			'form' => $form->templateY($this->module->lang('ft_add')),
		);
		return $errors.$this->module->templatePHP('add.php', $tVars);
	}
	
	public function validate_link_gid(Module_Links $m, $arg) { return GWF_LinksValidator::validate_gid($this->module, $arg); }
	public function validate_link_score(Module_Links $m, $arg) { return GWF_LinksValidator::validate_score($this->module, $arg); }
	public function validate_link_tags(Module_Links $m, $arg) { return GWF_LinksValidator::validate_tags($this->module, $arg); }
	public function validate_link_href(Module_Links $m, $arg) { return GWF_LinksValidator::validate_href($this->module, $arg, true); }
	public function validate_link_descr(Module_Links $m, $arg) { return GWF_LinksValidator::validate_descr1($this->module, $arg); }
	public function validate_link_descr2(Module_Links $m, $arg) { return GWF_LinksValidator::validate_descr2($this->module, $arg); }
	public function validate_link_lang($m, $arg) { return GWF_LangSelect::isValidLanguage($arg,false,GWF_LangSelect:: TYPE_SUPPORTED);}
	
	private function onAdd()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateAdd();
		}
		
		$user = GWF_Session::getUser();
		$href = $form->getVar('link_href');
		$descr1 = $form->getVar('link_descr');
		$descr2 = $form->getVar('link_descr2');
		$tags = $form->getVar('link_tags');
		$score = $form->getVar('link_score');
		$gid = $form->getVar('link_gid');
		$sticky = false;
		$in_moderation = $user === false && $this->module->cfgGuestModerated();
		$unafiliate = isset($_POST['link_options&'.GWF_Links::UNAFILIATE]);
		$memberlink = isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]);
		
		$link = GWF_Links::fakeLink($user, $href, $descr1, $descr2, $tags, $score, $gid, $sticky, $in_moderation, $unafiliate, $memberlink);
		
		if (false !== ($error = $link->insertLink($this->module, $in_moderation))) {
			return $error.$this->templateAdd();
		}
		
		if ($in_moderation) {
			$link->setVotesEnabled(false);
			$this->sendModMail($link);
		}
		
		return $this->module->message('msg_added'.($in_moderation?'_mod':'')).$this->module->requestMethodB('Overview');
	}
	
	private function sendModMail(GWF_Links $link)
	{
		$link = GWF_Links::getByID($link->getID());
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject($this->module->lang('mail_subj'));
		
		$href = $link->getVar('link_href');
		$descr = $link->display('link_descr');
		$descr2 = $link->display('link_descr2');
		$anchor = GWF_HTML::anchor($href, $href);
		$approve = Common::getAbsoluteURL($link->hrefModApprove());
		$approve = GWF_HTML::anchor($approve, $approve);
		$delete = Common::getAbsoluteURL($link->hrefModDelete());
		$delete = GWF_HTML::anchor($delete, $delete);
		$mail->setBody($this->module->lang('mail_body', array( $descr, $descr2, $anchor, $approve, $delete)));
		$mail->sendAsHTML(GWF_STAFF_EMAILS);
	}
}

?>
