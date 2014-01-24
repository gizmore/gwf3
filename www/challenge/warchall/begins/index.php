<?php
require_once 'warconfig.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Training: Warchall - The Beginning');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/warchall/begins/index.php', 'bitwarrior,LameStartup,HiddenIsConfig,RepeatingHistory,AndIknowchown,OhRightThePerms');
}
$chall->showHeader();

$score = 0;

$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

if (false === ($user = GWF_Session::getUser()))
{
	echo GWF_HTML::error('Warchall', $chall->lang('err_login'));
}
elseif ($score > ($scre = $user->getLevel()))
{
	echo GWF_HTML::error('Warchall', $chall->lang('err_score', $scre, $score));
}
else
{
	echo warchall1createAccount($chall);
}

formSolutionbox($chall);

echo $chall->copyrightFooter();

require 'challenge/warchall/ads.php';

require_once('challenge/html_foot.php');

final class WCA_FormCreate
{
	public function form(WC_Challenge $chall)
	{
		$data = array(
			'password1' => array(GWF_Form::PASSWORD, '', $chall->lang('th_password')),
			'password2' => array(GWF_Form::PASSWORD, '', $chall->lang('th_password2')),
			'create' => array(GWF_Form::SUBMIT, $chall->lang('btn_submit')),
		
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_password1($chall, $arg)
	{
		return false;
	}

	public function validate_password2($chall, $arg)
	{
		if (Common::getPostString('password1') !== $arg)
		{
			return $chall->lang('err_retype');
		}
		return false;
	}
}

final class WCA_FormSetupMail
{
	public function form(WC_Challenge $chall, $warmail)
	{
		$data = array(
//			'wantmail' => array(GWF_Form::TEXT, $warmail, $chall->lang('th_wantmail')),
			'setmail' => array(GWF_Form::SUBMIT, $chall->lang('btn_setmail')),
		);
		return new GWF_Form($this, $data);
	}
	
//	public function validate_wantmail($chall, $arg)
//	{
//		if ($arg === '')
//		{
//			return false;
//		}
//		if (!GWF_Validator::isValidEmail($email, 255))
//		{
//			return $chall->lang('err_email');
//		}
//		return false;
//	}
}




function warchall1createAccount(WC_Challenge $chall)
{
	if (false === ($user = GWF_Session::getUser()))
	{
		return '';
	}
	$username = strtolower($user->getVar('user_name'));
	if (!preg_match('/^[a-z][a-z0-9_]{2,31}$/D', $username))
	{
		return $chall->lang('err_unix_username');
	}
	$eusername = GDO::escape($username);
	
	# Form1
	$f = new WCA_FormCreate();
	$form = $f->form($chall);
	
	# Form2
	$f2 = new WCA_FormSetupMail();
	if (false === ($db2 = gdo_db_instance(WARGIZ_DB_HOST, WARGIZ_DB_USER, WARGIZ_DB_PASS, WARGIZ_DB_DB)))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	$email = '';
	if (false !== ($result = $db2->queryFirst("SELECT am_email FROM gwf_audit_mails WHERE am_username='$eusername'", true)))
	{
		$email = $result['am_email'];
	}
	$form2 = $f2->form($chall, $email);

	$back = '';
	if (isset($_POST['setmail']))
	{
		if (false !== ($error = $form2->validate($chall)))
		{
			return $error;
		}
		$back .= warchall1createEMailB($chall, $db2, $eusername);
		
	}
	
	if (isset($_POST['create']))
	{
		if (false !== ($error = $form->validate($chall)))
		{
			return $error;
		}
		$back .= warchall1createAccountB($chall);
	}
	
	return
		$back.
		$form2->templateY($chall->lang('ft_setup_email')).
		$form->templateY($chall->lang('ft_create_ssh_account'));
}

function warchall1createAccountB(WC_Challenge $chall)
{
	if (false === ($db = gdo_db_instance(WARBOX_DB_HOST, WARBOX_DB_USER, WARBOX_DB_PASS, WARBOX_DB_DB)))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	$user = GWF_Session::getUser();
	$username = $db->escape(strtolower($user->getVar('user_name')));
	$pass = $db->escape(crypt($_POST['password1']));
	if (false === $db->queryWrite("REPLACE INTO war_audit_add_user VALUES('{$username}', '{$pass}')"))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	return GWF_HTML::message('Let the Warchall begin', $chall->lang('msg_creating_account', $username, $_POST['password1']));
}

function warchall1createEMailB(WC_Challenge $chall, GDO_Database $db2, $eusername)
{
	if (false === ($db2->queryWrite("DELETE FROM gwf_audit_mails WHERE am_username='$eusername'")))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	if ($db2->affectedRows() == 1)
	{
		return GWF_HTML::message('Warchall', $chall->lang('msg_nomails'));
	}

	$user = GWF_Session::getUser();
	if ('' === ($email = $user->getValidMail()))
	{
		return GWF_HTML::error('Warchall', $chall->lang('err_no_mail'));
	}
	$eemail = GDO::escape($email);
	if (false === ($db2->queryWrite("REPLACE INTO gwf_audit_mails VALUES('$eusername', '$eemail')")))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}

	return GWF_HTML::message('Warchall', $chall->lang('msg_mail'));
}
