<?php
final class Comments_Reply extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (isset($_POST['reply']))
		{
			unset($_POST['x']);
			unset($_POST['y']);
			return $this->onReply($module);
		}
		
		return $this->templateReply($module);
	}
	
	public function templateReply(Module_Comments $module, $href=NULL)
	{
		$form = $this->formReply($module, $href);
		$action = $href === NULL ? $this->getMethodHREF() : $href;
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_reply'), $action),
		);
		return $module->template('reply.tpl', $tVars);
	}
	
	public function formReply(Module_Comments $module, $href=NULL)
	{
		$user = GWF_Session::getUser();
		$data = array();
		if ($user === false)
		{
			$data['username'] = array(GWF_Form::STRING, '', $module->lang('th_username'));
			$data['email'] = array(GWF_Form::STRING, '', $module->lang('th_email'));
		}
		else
		{
			$data['email'] = array(GWF_Form::STRING, $user->getValidMail(), $module->lang('th_email'));
		}
		$data['www'] = array(GWF_Form::STRING, '', $module->lang('th_www'));
		$data['cmt_id'] = array(GWF_Form::HIDDEN, Common::getRequestString('cmt_id', '0'));
		$data['cmts_id'] = array(GWF_Form::HIDDEN, Common::getRequestString('cmts_id', '0'));
		$data['showmail'] = array(GWF_Form::CHECKBOX, false, $module->lang('th_showmail'));
		$data['message'] = array(GWF_Form::MESSAGE, '', $module->lang('th_message'));
		
		if ($module->cfgCaptcha($user))
		{
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		
		$data['reply'] = array(GWF_Form::SUBMIT, $module->lang('btn_reply'));
		
		return new GWF_Form($this, $data);
	}
	
	public function validate_cmt_id($m, $arg) { return $m->validate_cmt_id($arg); }
	public function validate_cmts_id($m, $arg) { return $m->validate_cmts_id($arg, true); }
	public function validate_message($m, $arg) { return GWF_Validator::validateString($m, 'message', $arg, 8, $m->cfgMaxMsgLen(), false); }
	public function validate_www($m, $arg) { return GWF_Validator::validateURL($m, 'www', $arg, true, false); }
	public function validate_email($m, $arg) { return GWF_Validator::validateEMail($m, 'email', $arg, false, true); }
	public function validate_username($m, $arg) { return GWF_Validator::validateUsername($m, $key, $arg, false); }
	
	public function onReply(Module_Comments $module, $href=NULL)
	{
		$form = $this->formReply($module, $href);
		if (false !== ($error = $form->validate($module)))
		{
			return $this->templateReply($module, $href);
		}
		
		$user = GWF_Session::getUser();
		$uid = $user === false ? '0' : $user->getID();
		
		$options = 0;
		$options |= isset($_POST['showmail']) ? GWF_Comment::SHOW_EMAIL : 0;
//		$options |= $module->cfgModerated() ? 0 : GWF_Comment::VISIBLE;
		
		$comment = new GWF_Comment(array(
			'cmt_id' => 0,
			'cmt_pid' => $_POST['cmt_id'],
			'cmt_cid' => $_POST['cmts_id'],
			'cmt_uid' => $uid,
			'cmt_username' => isset($_POST['username']) ? $_POST['username'] : '',
			'cmt_www' => $_POST['www'],
			'cmt_mail' => $_POST['email'],
			'cmt_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'cmt_message' => $_POST['message'],
			'cmt_options' => $options,
			'cmt_thx' => 0,
			'cmt_up' => 0,
			'cmt_down' => 0,
		));
		
		if (false === $comment->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($module->cfgModerated())
		{
			return $this->onSendModerateMail($module, $user, $comment);
		}
		else
		{
			if (false === $comment->onVisible(true))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $this->onSendCommentedMail($module, $user, $comment);
		}
	}
	
	private function getStaffIDs()
	{
		$staff = GWF_Group::STAFF;
		if (false === ($admin_ids = GDO::table('GWF_UserGroup')->selectColumn('ug_userid', "group_name='$staff'", '', array('group'))))
		{
			return false;
		}
		return $admin_ids;
	}
	
	#######################
	### Moderation Mail ###
	#######################
	private function onSendModerateMail(Module_Comments $module, $user, GWF_Comment $comment)
	{
		foreach ($this->getStaffIDs() as $admin_id)
		{
			if (false !== ($admin = GWF_User::getByID($admin_id)))
			{
				$this->onSendModerateMailB($module, $user, $comment, $admin);
			}
		}
		
		return $module->message('msg_commented_mod');
	}
	
	private function onSendModerateMailB(Module_Comments $module, $user, GWF_Comment $comment, GWF_User $admin)
	{
		if ('' === ($rec = $admin->getValidMail()))
		{
			return;
		}
		
		$username = $user === false ? $_POST['username'] : $user->getVar('user_name');
		$username = htmlspecialchars($username);
		$www = htmlspecialchars(Common::getPostString('www', ''));
		$email = htmlspecialchars(Common::getPostString('email', ''));
		$href_approve = Common::getAbsoluteURL('index.php?mo=Comments&me=Moderate&show='.$comment->getID().'&ctoken='.$comment->getHashcode());
		$href_delete = Common::getAbsoluteURL('index.php?mo=Comments&me=Moderate&delete='.$comment->getID().'&ctoken='.$comment->getHashcode());
		
		$args = array($admin->displayUsername(), $username, $email, $www, $comment->display('cmt_message'), $href_approve, $href_delete);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($module->langUser($admin, 'subj_mod'));
		$mail->setBody($module->langUser($admin, 'body_mod', $args));
		return $mail->sendToUser($admin);
	}
	
	###################
	### Notice Mail ###
	###################
	private function onSendCommentedMail(Module_Comments $module, $user, GWF_Comment $comment)
	{
		foreach ($this->getStaffIDs() as $admin_id)
		{
			if (false !== ($admin = GWF_User::getByID($admin_id)))
			{
				$this->onSendCommentedMailB($module, $user, $comment, $admin);
			}
		}
		
		return $module->message('msg_commented');
	}
	
	private function onSendCommentedMailB(Module_Comments $module, $user, GWF_Comment $comment, GWF_User $admin)
	{
		if ('' === ($rec = $admin->getValidMail()))
		{
			return;
		}
		
		$username = $user === false ? $_POST['username'] : $user->getVar('user_name');
		$username = htmlspecialchars($username);
		$www = htmlspecialchars(Common::getPostString('www', ''));
		$email = htmlspecialchars(Common::getPostString('email', ''));
		$href_delete = Common::getAbsoluteURL('index.php?mo=Comments&me=Moderate&delete='.$comment->getID().'&ctoken='.$comment->getHashcode());
		
		$args = array($admin->displayUsername(), $username, $email, $www, $comment->display('cmt_message'), $href_delete);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($rec);
		$mail->setSubject($module->langUser($admin, 'subj_cmt'));
		$mail->setBody($module->langUser($admin, 'body_cmt', $args));
		$mail->sendToUser($admin);
	}
}
?>