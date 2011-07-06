<?php
/**
 * Add a link.
 * @author gizmore
 */
final class Links_Add extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		if (false !== Common::getPost('preview')) {
			return $this->onPreview($module);
		}
		if (false !== Common::getPost('add')) {
			return $this->onAdd($module);
		}
		return $this->templateAdd($module);
	}

	/**
	 * @var GWF_User
	 */
	private $user;
	
	private function sanitize(Module_Links $module)
	{
		$this->user = GWF_Session::getUser();
		
		if (false !== ($error = GWF_LinksValidator::mayAddLink($module, $this->user))) {
			return GWF_HTML::error('Links', $error);
		}
		return false;
	}
	
	private function getForm(Module_Links $module)
	{
		$tags = Common::getPostString('link_tags', Common::getGet('tag'));
		$data = array(
			'link_score' => array(GWF_Form::STRING, '0', $module->lang('th_link_score'), $module->lang('tt_link_score')),
			'link_gid' => array(GWF_Form::SELECT, GWF_GroupSelect::single('link_gid'), $module->lang('th_link_gid'), $module->lang('tt_link_gid')),
			'tag_info' => array(GWF_Form::HEADLINE, '', $module->lang('info_tag')),
			'known_tags' => array(GWF_Form::HEADLINE, '', $this->collectTags($module)),
			'link_tags' => array(GWF_Form::STRING, $tags, $module->lang('th_link_tags')),
			'div1' => array(GWF_Form::DIVIDER),
			'link_href' => array(GWF_Form::STRING, '', $module->lang('th_link_href'), $module->lang('tt_link_href')),
			'link_descr' => array(GWF_Form::STRING, '', $module->lang('th_link_descr')),
		);
		if ($module->cfgLongDescription()) {
			$data['link_descr2'] = array(GWF_Form::MESSAGE, '', $module->lang('th_link_descr2'));
		}
		$data['link_options&'.GWF_Links::MEMBER_LINK] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]), $module->lang('th_link_options&'.GWF_Links::MEMBER_LINK));
		if (GWF_User::isLoggedIn()) {
			$data['link_options&'.GWF_Links::UNAFILIATE] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::UNAFILIATE]), $module->lang('th_link_options&'.GWF_Links::UNAFILIATE));
			$data['link_options&'.GWF_Links::ONLY_PRIVATE] = array(GWF_Form::CHECKBOX, isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]), $module->lang('th_link_options&'.GWF_Links::ONLY_PRIVATE));
		}
		
		if (!GWF_Session::isLoggedIn() && $module->cfgGuestCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		
		$data['buttons'] = array(GWF_Form::SUBMITS, array('preview'=>$module->lang('btn_preview'),'add'=>$module->lang('btn_add')));
		
		return new GWF_Form($this, $data);
	}
	
	private function collectTags(Module_Links $module)
	{
		$back = array();
		$tags = GWF_LinksTag::getCloud();
		foreach ($tags as $tag)
		{
			$back[] = $tag->display('lt_name');
		}
		return implode(', ', $back);
	}
	
	private function templateAdd(Module_Links $module)
	{
		GWF_Website::setPageTitle($module->lang('ft_add'));
		
		$form = $this->getForm($module);
		$tVars = array(
			'preview' => '',
			'form' => $form->templateY($module->lang('ft_add')),
		);
		return $module->templatePHP('add.php', $tVars);
	}
	
	private function onPreview(Module_Links $module)
	{
		$form = $this->getForm($module);
		$errors = $form->validate($module);
		$user = GWF_Session::getUser();
		$href = $form->getVar('link_href');
		$descr1 = $form->getVar('link_descr');
		$descr2 = $form->getVar('link_descr2');
		$tags = $form->getVar('link_tags');
		$score = $form->getVar('link_score');
		$gid = $form->getVar('link_gid');
		$sticky = false;
		$in_moderation = $user === false && $module->cfgGuestModerated();
		$unafiliate = isset($_POST['link_options&'.GWF_Links::UNAFILIATE]);
		$memberlink = isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]);
		$private = isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]);
		$link = GWF_Links::fakeLink($user, $href, $descr1, $descr2, $tags, $score, $gid, $sticky, $in_moderation, $unafiliate, $memberlink, $private);
		$tVars = array(
			'preview' => $module->templateLinks(array($link), '', '', '', true, false, false, false),
			'form' => $form->templateY($module->lang('ft_add')),
		);
		return $errors.$module->templatePHP('add.php', $tVars);
	}
	
	public function validate_link_gid(Module_Links $module, $arg) { return GWF_LinksValidator::validate_gid($module, $arg); }
	public function validate_link_score(Module_Links $module, $arg) { return GWF_LinksValidator::validate_score($module, $arg); }
	public function validate_link_tags(Module_Links $module, $arg) { return GWF_LinksValidator::validate_tags($module, $arg); }
	public function validate_link_href(Module_Links $module, $arg) { return GWF_LinksValidator::validate_href($module, $arg, true); }
	public function validate_link_descr(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr1($module, $arg); }
	public function validate_link_descr2(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr2($module, $arg); }
	
	private function onAdd(Module_Links $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateAdd($module);
		}
		
		$user = GWF_Session::getUser();
		$href = $form->getVar('link_href');
		$descr1 = $form->getVar('link_descr');
		$descr2 = $form->getVar('link_descr2');
		$tags = $form->getVar('link_tags');
		$score = $form->getVar('link_score');
		$gid = $form->getVar('link_gid');
		$sticky = false;
		$in_moderation = $user === false && $module->cfgGuestModerated();
		$unafiliate = isset($_POST['link_options&'.GWF_Links::UNAFILIATE]);
		$memberlink = isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]);
		
		$link = GWF_Links::fakeLink($user, $href, $descr1, $descr2, $tags, $score, $gid, $sticky, $in_moderation, $unafiliate, $memberlink);
		
		if (false !== ($error = $link->insertLink($module, $in_moderation))) {
			return $error.$this->templateAdd($module);
		}
		
		if ($in_moderation) {
			$link->setVotesEnabled(false);
			$this->sendModMail($module, $link);
		}
		
		return $module->message('msg_added'.($in_moderation?'_mod':'')).$module->requestMethodB('Overview');
	}
	
	private function sendModMail(Module_Links $module, GWF_Links $link)
	{
		$link = GWF_Links::getByID($link->getID());
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject($module->lang('mail_subj'));
		
		$href = $link->getVar('link_href');
		$descr = $link->display('link_descr');
		$descr2 = $link->display('link_descr2');
		$anchor = GWF_HTML::anchor($href, $href);
		$approve = Common::getAbsoluteURL($link->hrefModApprove());
		$approve = GWF_HTML::anchor($approve, $approve);
		$delete = Common::getAbsoluteURL($link->hrefModDelete());
		$delete = GWF_HTML::anchor($delete, $delete);
		$mail->setBody($module->lang('mail_body', array( $descr, $descr2, $anchor, $approve, $delete)));
		$mail->sendAsHTML(GWF_STAFF_EMAILS);
	}
}

?>